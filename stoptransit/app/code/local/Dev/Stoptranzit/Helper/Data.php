<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Admin
 * Date: 02.06.13
 * Time: 13:24
 * To change this template use File | Settings | File Templates.
 */ 
class Dev_Stoptranzit_Helper_Data extends Mage_Core_Helper_Abstract
{


    public function canDisplayHomePopup()
    {
        if (!Mage::getBlockSingleton('page/html_header')->getIsHomePage()) {
            return false;
        }

        if (Mage::getModel('core/cookie')->get('show_popup') OR Mage::getModel('core/cookie')->get('show_popup') == 1) {
            return false;
        }


        return true;
        
    }

}