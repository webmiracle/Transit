<?php
class Banner_Producer_Model_Resource_Producer extends Mage_Core_Model_Resource_Db_Abstract {

    protected function _construct()
    {
        $this->_init('banner_producer/producer', 'id');
    }

}