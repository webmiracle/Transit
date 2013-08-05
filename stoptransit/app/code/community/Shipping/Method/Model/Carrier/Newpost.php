<?php
class Shipping_Method_Model_Carrier_Newpost extends Mage_Shipping_Model_Carrier_Abstract
{
    protected $_code = 'new_post';
    protected $_methodCode = 'new_post_method';
    protected  $_busAttributeSetId = '100';
    protected  $_disksAttributeSetId = '87';

    /**
     * Collect rates for this shipping method based on information in $request.
     *
     * @param Mage_Shipping_Model_Rate_Request $data Request model.
     *
     * @return object
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        if (!Mage::getStoreConfig('carriers/' . $this->_code . '/active')) {
            return false;
        }

        $busProduct = false;
        $result = Mage::getModel('shipping/rate_result');

        if (!($priceRange = Mage::getStoreConfig('carriers/' . $this->_code . '/total_for_free'))) {
            $priceRange = 0;
        }
        foreach ($request->getAllItems() as $items) {
            $attributeSetModel = Mage::getModel("eav/entity_attribute_set");
            $attributeSetModel->load($items->getProduct()->getAttributeSetId());

            if ($attributeSetModel->getId() && ($attributeSetModel->getId() == $this->_busAttributeSetId
                || $this->_disksAttributeSetId == $attributeSetModel->getId())) {
                $busProduct = true;
            }

        }
        $title = Mage::getStoreConfig('carriers/' . $this->_code . '/title');

        $method = Mage::getModel('shipping/rate_result_method');

        $method->setCarrier($this->_code);
//        $method->setCarrierTitle($title);

        $method->setMethod($this->_methodCode);
        $method->setMethodTitle($title);
        $method->setMethodDescription($this->getPayDescription());

        if ($request->getBaseSubtotalInclTax() > $priceRange and !$busProduct) {
            $method->setMethodDescription($this->getFreeDescription());
        }

        $result->append($method);

        return $result;
    }

    public function getPayDescription()
    {
        $html = Mage::helper('core/data')->__('Доставка будет осуществляются согласно с тарифами ');
        $html .= '<a href="http://novaposhta.ua/frontend/calculator/ua" target="_blank">' . Mage::helper('core/data')->__('новой почты') . ',&nbsp</a>';
        $html .= '&nbsp'. Mage::helper('core/data')->__('доставку оплачиваете вы.');

        return $html;
    }

    public function getFreeDescription()
    {
        return Mage::helper('core/data')->__('Доставка за счет магазина Стоп-Транзит.');
    }
}
