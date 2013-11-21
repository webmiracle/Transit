<?php
class Import_Product_Model_Handler extends Import_Product_Model_Abstract
{
    /**
     * @var All stock items import to Magento.
     */
    protected $_stockItems = array();

    /**
     * @var All magento products.
     */
    protected $_magentoProducts = array();

    /**
     * @var All lines from file.
     */
    protected $_lines = array();

    /**
     * @var string $_logFile Log file for import process.
     */
    protected static $_logFile = 'import_product_process.log';

    protected $_logSuccessProduct = '';
    protected $_logFailedProduct = '';

    /**
     * @var files for import.
     */
    protected $_importFiles = array();

    /**
     * @var array Mapping for Magento fields.
     */
    protected $_mapToMagento = array(
        'sku' => '',
        'price' => '',
        'special_group_price' => '',
 	'special_group_price_1' => '',
        'qty' => ''
    );

    /**
     * General processes for import stock.
     *
     * @throws Exception ISM Store stock exception.
     *
     * @return void
     */
    public function import()
    {
        Varien_Profiler::start('IMPORT_STOCK: ' . __METHOD__);

        $this->setWorkingDir('import_product');
        $result = 'Import product can\'t start, not needed files at working directory or file is not valid.';

        self::log('Import product was started');
        if ($this->canStart()) {
            try {
                $this->initLogFiles();
                $this->_loadMagentoProducts();
                $this->_collectData();
                if (count($this->_stockItems) > 0) {
                    $this->_updateStock();
                    $this->_updatePrice();
                }
                $this->_writeLogFiles();
                $result = 'Import stock was finished. ';


                if (count($this->_stockItems) <= 0) {
                    $result = 'Import stock finished. Magento stock was not updated ';
                    $this->fail($this->_importFiles);
                } else {
                    $this->success($this->_importFiles);
                }
                unset($this->_stockItems);
                unset($this->_magentoProducts);

                $this->_reindexAndCleanCache();
            } catch (Exception $e) {
                $this->fail($this->_importFiles);
                self::log($e->getMessage());
                self::log("Import stock was finished \r\n");
                Varien_Profiler::stop('IMPORT_STOCK: ' . __METHOD__);
            }
        }

        self::log("Import stock was finished \r\n");
        Varien_Profiler::stop('IMPORT_STOCK: ' . __METHOD__);

        echo $result;
    }

    public function _updatePrice()
    {
        self::log('Start upadate magento price');
        /* @var $resource Mage_Core_Model_Resource */
        $resource = Mage::getSingleton('core/resource');
        $tableName = $resource->getTableName('catalog/product_attribute_group_price');

        /** @var $collection Mage_Catalog_Model_Resource_Product_Collection */
        $collection = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToSelect(array('price', 'group_price'))
            ->addIdFilter(array_keys($this->_stockItems));

        $insertData = array();
        foreach ($collection as $product) {
            if ($this->_stockItems[$product->getId()]) {
                $data['entity_id'] = $this->_stockItems[$product->getId()]['product_id'];
                $data['customer_group_id'] = 2;
                $data['website_id'] = 0;
                $data['all_groups'] = 0;
                $data['value'] = $this->_stockItems[$product->getId()]['special_group_price'];
                $product->setPrice($this->_stockItems[$product->getId()]['price']);
                $this->_stockItems[$product->getId()]['website_id'] = 0;
                $insertData[] = $data;
                unset($data);
            }
        }
        $collection->save();
        $resource->getConnection('core_write')->insertOnDuplicate($tableName, $insertData);
        self::log('End upadate magento price');
        unset($collection);
    }


    public function _writeLogFiles()
    {

        $itemsWhichNotExist = $this->_getNonExistStockItems();

        if (count($itemsWhichNotExist) > 0) {
            Mage::log(implode(PHP_EOL, array_keys($itemsWhichNotExist)), null, $this->_logFailedProduct);
        }

        $updateItem = array_intersect_key(array_flip($this->_magentoProducts), $this->_stockItems);
        if (count($this->_stockItems) > 0 && count($updateItem) > 0) {
            Mage::log(implode(PHP_EOL, $updateItem), null, $this->_logSuccessProduct);
        }

    }

    public function initLogFiles()
    {
        $this->_logFailedProduct = date('Y-m-d') . '_' . date('H:i:s') . '_' . 'failed.log';
        $this->_logSuccessProduct = date('Y-m-d') . '_' . date('H:i:s') . '_' . 'success.log';
    }

    /**
     * Load file to system and explode per line.
     *
     * @return void
     */

    protected function _loadFile()
    {
        Varien_Profiler::start('PREPARE FILE ' . __METHOD__);

        foreach ($this->_importFiles as $file) {
            $this->_lines[basename($file)] = explode(
                "\r\n",
                file_get_contents($file)
            );
        }

        Varien_Profiler::stop('PREPARE FILE ' . __METHOD__);
    }

    /**
     * Collect data from import file to our custom table.
     *
     * @return void
     */

    protected function _collectData()
    {
        Varien_Profiler::start('IMPORT_STOCK: ' . __METHOD__ . '::COLLECT_DATA');
        self::log('Start collect data from import file');

        $rowIndex = 0;
        $this->_loadFile();

        foreach ($this->_lines as $key => $line) {
            $insertData = array();
            foreach ($line as $row) {
                $rowIndex++;
                if (($data = $this->_map($row)) == false) {
                    self::log('Some fields are empty in file ' . $key . ' on line ' . $rowIndex);
                    continue;
                }

                $productId = isset($this->_magentoProducts[$data['sku']]) ? $this->_magentoProducts[$data['sku']] : false;
                if (!$productId) {
                    self::log('Product with SKU [' . $data['sku'] . '] does not exist, in file ' . $key . ' on line ' . $rowIndex);
                    continue;
                }

                if (strpos($data['price'], ',') !== false) {
                    $data['price'] = str_replace(',', '.', $data['price']);
                }

                if (strpos($data['special_group_price'], ',') !== false) {
                    $data['special_group_price'] = str_replace(',', '.', $data['special_group_price']);
                }

                $this->_stockItems[$productId] = array(
                    'product_id' => $productId,
                    'qty' => $data['qty'],
                    'price' => (double)$data['price'],
                    'special_group_price' => (double)$data['special_group_price'],
                );
            }

//            unset($insertData);
        }

        unset($this->_lines);
        self::log('End collect data from import file');
        Varien_Profiler::stop('IMPORT_STOCK: ' . __METHOD__ . '::COLLECT_DATA');
    }

    /**
     * Returns a list of products that do not exist in importing file.
     *
     * @return array
     */
    protected function &_getNonExistStockItems()
    {
        $nonExistStockItems = $nonExistStockItems = array_diff($this->_magentoProducts, array_keys($this->_stockItems));

        return $nonExistStockItems;
    }

    /**
     * Update Magento stock item.
     *
     * @return void
     */
    protected function _updateStock()
    {
        Varien_Profiler::start('IMPORT_STOCK: ' . __METHOD__);
        self::log('Start upadate magento stock');

        $stockItemCollection = Mage::getResourceModel('cataloginventory/stock_item_collection')
            ->addProductsFilter(array_keys($this->_stockItems))
            ->load();

        $this->_updateMagentoStock($stockItemCollection);

        unset($stockItemCollection);

        Mage::getResourceSingleton('cataloginventory/stock')->updateSetOutOfStock();
        Mage::getResourceSingleton('cataloginventory/stock')->updateSetInStock();
        Mage::getResourceSingleton('cataloginventory/stock')->updateLowStockDate();

        self::log('End upadate magento stock');
        Varien_Profiler::stop('IMPORT_STOCK: ' . __METHOD__);
    }

    /**
     * Updates Magento stock.
     *
     * @param object &$stockItemCollection Stock items collection.
     *
     * @return void
     */

    protected function _updateMagentoStock(&$stockItemCollection)
    {
        foreach ($stockItemCollection as $stockItem) {
            $productId = $stockItem->getProductId();
            $qty = $this->_stockItems[$productId]['qty'];

            ($qty <= 0) ? $stockItem->setQty(0)->setIsInStock(0) : $stockItem->setQty($qty)->setIsInStock(1);
            $stockItem->setStockStatusChangedAutomaticallyFlag(1);
            $stockItem->setProcessIndexEvents(false);
            $stockItem->save();
        }
    }

    /**
     * Return Magento simple products.
     *
     * @return void
     */

    protected function _loadMagentoProducts()
    {
        Varien_Profiler::start('IMPORT_STOCK: ' . __METHOD__);
        self::log('Start load product from magento');

        $collection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect('sku');
        foreach ($collection->getData() as $product) {
            $this->_magentoProducts[$product['sku']] = $product['entity_id'];
        }

        self::log('End load product from magento');
        Varien_Profiler::stop('IMPORT_STOCK: ' . __METHOD__);
    }

    /**
     * Map data to specified values.
     *
     * @param string $row Data per line.
     *
     * @return array|boolean
     */

    protected function _map($row)
    {
        return @array_combine(array_keys($this->_mapToMagento), explode(';', $row));
    }

    /**
     * Reindex price and products attributes.
     *
     * @return void
     */

    protected function _reindexAndCleanCache()
    {
        Varien_Profiler::start('IMPORT_STOCK: ' . __METHOD__ . '::REINDEX_AND_CLEAN_CACHE');
        self::log('Start reindex and clean cache');

//        Mage::getSingleton('index/indexer')->getProcessByCode('catalog_product_price')->reindexEverything();
//        // refresh cache
        Mage::app()->cleanCache();
        $resource = Mage::getResourceSingleton('catalogrule/rule');
        $resource->applyAllRulesForDateRange($resource->formatDate(mktime(0,0,0)));


        self::log('End reindex and clean cache');
        Varien_Profiler::stop('IMPORT_STOCK: ' . __METHOD__ . '::REINDEX_AND_CLEAN_CACHE');
    }
}
