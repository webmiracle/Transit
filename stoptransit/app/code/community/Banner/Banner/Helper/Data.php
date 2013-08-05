<?php
class Banner_Banner_Helper_Data extends Mage_Core_Helper_Data
{


    public function getRandoBannerById($bannerTypeId, $limit = 2)
    {
        $collection = Mage::getModel('banner_banner/banner')->getCollection()
            ->addFieldToFilter('block_baner', $bannerTypeId);
        $collection->getSelect()->order(new Zend_Db_Expr('RAND()'));
        $collection->getSelect()->limit($limit);

        return ($collection->getSize() > 0) ? $collection : false;
    }

    public function getImageTypes()
    {
        return array('jpg','gif','png');
    }
    public function deleteBanner($id)
    {
        Mage::getModel('banner_banner/banner')->delete($id);
    }



}
