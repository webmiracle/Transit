<?php
class Banner_Content_Model_Resource_Content extends Mage_Core_Model_Resource_Db_Abstract {

    protected function _construct()
    {
        $this->_init('banner_content/content', 'id_news');
    }

}