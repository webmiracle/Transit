<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$indentifier = 'top_menu_block';

Mage::getModel('cms/block')->load($indentifier, 'identifier')->delete();

Mage::getModel('cms/block')
    ->setIdentifier($indentifier)
    ->setIsActive(1)
    ->setTitle('top_menu_block')
    ->setContent('
<div id="top_menu_block">
        <ul class="top_menu_block">
        <li class="level0 level-top"><a class="level-top" href="{{base url="avtohimiya-kosmetika"}}"><img src="{{skin url="images/top_menu/autokosmetika-raznoe.png"}}" alt="" /></a></li>
        <li class="level0 level-top"><a class="level-top" href="{{base url="akkymylyatoru"}}"><img src="{{skin url="images/top_menu/akumulyator.png"}}" alt="" /></a></li>
        <li class="level0 level-top"><a class="level-top" href="{{base url="aksessyaru"}}"><img src="{{skin url="images/top_menu/acsesuary.png"}}" alt="" /></a></li>
        <li class="level0 level-top"><a class="level-top" href="{{base url="instrymentu"}}"><img src="{{skin url="images/top_menu/instrument.png"}}" alt="" /></a></li>
        <li class="level0 level-top"><a class="level-top" href="{{base url="d-d-d-n"}}"><img src="{{skin url="images/top_menu/kuzov.png"}}" alt="" /></a></li>
        <li class="level0 level-top"><a class="level-top" href="{{base url="malyarnue-materialu"}}"><img src="{{skin url="images/top_menu/maliar_mat.png"}}" alt="" /></a></li>
        <li class="level0 level-top"><a class="level-top" href="{{base url="masla"}}"><img src="{{skin url="images/top_menu/maslo.png"}}" alt="" /></a></li>
        <li class="level0 level-top"><a class="level-top" href="{{base url="tehnicheskie-zhudkosti"}}"><img src="{{skin url="images/top_menu/teh.png"}}" alt="" /></a></li>
        <li class="level0 level-top"><a class="level-top" href="{{base url="filtra"}}"><img src="{{skin url="images/top_menu/filtr.png"}}" alt="" /></a></li>
        <li class="level0 level-top"><a class="level-top" href="{{base url="shunu-diski"}}"><img src="{{skin url="images/top_menu/shina_disk.png"}}" alt="" /></a></li>
        <li class="level0 level-top"><a class="level-top" href="{{base url="elektronika"}}"><img src="{{skin url="images/top_menu/elektr.png"}}" alt="" /></a></li>
        <li class="level0 level-top"><a class="level-top" href="{{base url="zapasnue-chasti"}}"><img src="{{skin url="images/top_menu/zapchasti.png"}}" alt="" /></a></li>
        </ul>
</div>
')
    ->save();
