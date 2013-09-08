<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$indentifier = 'left_menu_block';

Mage::getModel('cms/block')->load($indentifier, 'identifier')->delete();

Mage::getModel('cms/block')
    ->setIdentifier($indentifier)
    ->setIsActive(1)
    ->setTitle('left_menu_block')
    ->setContent('
        <ul id="nav">
<li class="level0 level-top first parent"><a class="level-top" href="http://tranzit.com.ua/"><img src="{{skin url="images/left_menu/visitka.png"}}" alt="" /></a></li>
<li class="level0 level-top first parent"><a class="level-top" href="http://stoptransit.com.ua/"><img src="{{skin url="images/left_menu/portal.png"}}" alt="" /></a></li>
<li class="level0 level-top first parent"><a class="level-top" href="http://sto-shin.com/"><img src="{{skin url="images/left_menu/sto.png"}}" alt="" /></a></li>
<li class="level0 level-top first parent"><a class="level-top" href="#"><img src="{{skin url="images/left_menu/opt.png"}}" alt="" /></a></li>
<li class="level0 level-top first parent"><a class="level-top" href="#"><img src="{{skin url="images/left_menu/corp.png"}}" alt="" /></a></li>
</ul>
')->setStores(0)
    ->save();
