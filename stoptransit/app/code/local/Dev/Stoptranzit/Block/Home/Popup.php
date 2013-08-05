<?php
class Dev_Stoptranzit_Block_Home_Popup extends Mage_Core_Block_Abstract
{
    const BLOCK_ID = 'homepage_popap';

    public function _toHtml()
    {
        if (Mage::helper('dev_stoptranzit')->canDisplayHomePopup()) {
            $block = Mage::getModel('cms/block')
                ->load(self::BLOCK_ID, 'identifier');
            if ($block->getIsActive()) {
                /* @var $helper Mage_Cms_Helper_Data */
                $helper = Mage::helper('cms');
                $processor = $helper->getBlockTemplateProcessor();
                return $processor->filter($block->getContent());
            }
        }
    }
}