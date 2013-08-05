<?php
class Banner_Content_Helper_Data extends Mage_Core_Helper_Data
{

    protected $_days = array(
        1 => 'Января',
        2 => 'Февраля',
        3 => 'Марта',
        4 => 'Апреля',
        5 => 'Мая',
        6 => 'Июня',
        7 => 'Июля',
        8 => 'Августа',
        9 => 'Сентября',
        10 => 'Октября',
        11 => 'Ноября',
        12 => 'Декабря'
    );

    public function getDays()
    {
        return $this->_days;
    }

    public function getNewsContent()
    {
        $collection = Mage::getModel('banner_content/content')->getCollection();
        $collection->getSelect()->order('enddate ' . Zend_Db_Select::SQL_DESC);
        $collection->getSelect()->limit(30);

        return ($collection->getSize() > 0) ? $collection : false;
    }

    public function getTruncateNews($news)
    {
        $content =  $news->getDescription();
        if (empty($description)) {
            $content = $news->getContent();
        }

        if (strlen($content) > 200) {
            $content  = Mage::helper('core/string')->truncate($content, 200);
        }

        return $content;
    }

}
