<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Admin
 * Date: 27.07.13
 * Time: 11:41
 * To change this template use File | Settings | File Templates.
 */ 
class Dev_Callback_Helper_Data extends Mage_Core_Helper_Data {



    public function getCallbackPostUrl()
    {
         return $this->_getUrl('callback/index/sent/', array('is_ajax'=>1));
    }


}