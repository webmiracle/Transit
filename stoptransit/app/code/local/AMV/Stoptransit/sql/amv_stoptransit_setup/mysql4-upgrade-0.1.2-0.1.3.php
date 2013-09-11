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
        <li class="level0 level-top"><a class="level-top" href="/default/avtohimiya-kosmetika.html"><img src="{{skin url="images/top_menu/autokosmetika-raznoe.png"}}" alt="" /></a>
            {{block type="cms/block" block_id="submenu_avtohimiya-kosmetika"}}
        </li>
        <li class="level0 level-top"><a class="level-top" href="/default/akkymylyatoru.html"><img src="{{skin url="images/top_menu/akumulyator.png"}}" alt="" /></a>
            {{block type="cms/block" block_id="submenu_akkymylyatoru"}}
        </li>
        <li class="level0 level-top"><a class="level-top" href="/default/aksessyaru.html"><img src="{{skin url="images/top_menu/acsesuary.png"}}" alt="" /></a>
            {{block type="cms/block" block_id="submenu_aksessyaru"}}
        </li>
        <li class="level0 level-top"><a class="level-top" href="/default/instrymentu.html"><img src="{{skin url="images/top_menu/instrument.png"}}" alt="" /></a>
            {{block type="cms/block" block_id="submenu_instrymentu"}}
        </li>
        <li class="level0 level-top"><a class="level-top" href="/default/d-d-d-n.html"><img src="{{skin url="images/top_menu/kuzov.png"}}" alt="" /></a>
            {{block type="cms/block" block_id="submenu_d-d-d-n"}}
        </li>
        <li class="level0 level-top"><a class="level-top" href="/default/malyarnue-materialu.html"><img src="{{skin url="images/top_menu/maliar_mat.png"}}" alt="" /></a>
            {{block type="cms/block" block_id="submenu_malyarnue-materialu"}}
        </li>
        <li class="level0 level-top"><a class="level-top" href="/default/masla.html"><img src="{{skin url="images/top_menu/maslo.png"}}" alt="" /></a>
            {{block type="cms/block" block_id="submenu_masla"}}
        </li>
        <li class="level0 level-top"><a class="level-top" href="/default/tehnicheskie-zhudkosti.html"><img src="{{skin url="images/top_menu/teh.png"}}" alt="" /></a>
            {{block type="cms/block" block_id="submenu_tehnicheskie-zhudkosti"}}
        </li>
        <li class="level0 level-top"><a class="level-top" href="/default/filtra.html"><img src="{{skin url="images/top_menu/filtr.png"}}" alt="" /></a>
            {{block type="cms/block" block_id="submenu_filtra"}}
        </li>
        <li class="level0 level-top"><a class="level-top" href="/default/shunu-diski.html"><img src="{{skin url="images/top_menu/shina_disk.png"}}" alt="" /></a>
            {{block type="cms/block" block_id="submenu_shunu-diski"}}
        </li>
        <li class="level0 level-top"><a class="level-top" href="/default/elektronika.html"><img src="{{skin url="images/top_menu/elektr.png"}}" alt="" /></a>
            {{block type="cms/block" block_id="submenu_elektronika"}}
        </li>
        <li class="level0 level-top"><a class="level-top" href="/default/zapasnue-chasti.html"><img src="{{skin url="images/top_menu/zapchasti.png"}}" alt="" /></a>
            {{block type="cms/block" block_id="submenu_zapasnue-chasti"}}
        </li>
        </ul>
</div>
')->setStores(0)
    ->save();
