<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Мирослав
 * Date: 5/19/13
 * Time: 7:31 PM
 * To change this template use File | Settings | File Templates.
 */ 
class AMV_Stoptransit_Block_Checkout_Links extends Mage_Checkout_Block_Links {
    public function addCartLink()
    {
        $parentBlock = $this->getParentBlock();
        if ($parentBlock && Mage::helper('core')->isModuleOutputEnabled('Mage_Checkout')) {
            $count = $this->getSummaryQty() ? $this->getSummaryQty()
                : $this->helper('checkout/cart')->getSummaryCount();
//            if ($count == 1) {
//                $text = $this->__('My Cart (%s item)', $count);
//            } elseif ($count > 0) {
//                $text = $this->__('My Cart (%s items)', $count);
//            } else {
//                $text = $this->__('My Cart');
//            }
//
            $text = $this->__('My Cart')."<span>".$count."</span>";

            $parentBlock->removeLinkByUrl($this->getUrl('checkout/cart'));
            $parentBlock->addLink($text, 'checkout/cart', $text, true, array(), 50, null, 'class="top-link-cart"');
        }
        return $this;
    }

}