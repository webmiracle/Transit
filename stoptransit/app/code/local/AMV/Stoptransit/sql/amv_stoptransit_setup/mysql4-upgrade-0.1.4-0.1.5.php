<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$blocks = array(
    array(
        'id' => 'submenu_avtohimiya-kosmetika',
        'title' => 'Подменю Автохимия Косметика',
        'content' => <<<HTML
            <div class="sub-menu">
                <div class="sub-menu-col">
                    <ul>
                        <li><a class="sub-menu-title" href="#">Заголовок</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                    </ul>
                </div>
                <div class="sub-menu-col">
                    <ul>
                        <li><a class="sub-menu-title" href="#">Заголовок</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                    </ul>
                </div>
                            <div class="sub-menu-col">
                    <ul>
                        <li><a class="sub-menu-title" href="#">Заголовок</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                    </ul>
                </div>
                <div class="sub-menu-col">
                    <ul>
                        <li><a class="sub-menu-title" href="#">Заголовок</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                    </ul>
                </div>
                <div class="sub-menu-col">
                    <ul>
                        <li><a class="sub-menu-title" href="#">Заголовок</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                    </ul>
                </div>
                <div class="sub-menu-col">
                    <ul>
                        <li><a class="sub-menu-title" href="#">Заголовок</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                        <li><a href="#">Пункт меню</a></li>
                    </ul>
                </div>
            </div>
HTML

    ),
    array(
        'id' => 'submenu_akkymylyatoru',
        'title' => 'Подменю Аккумуляторы',
        'content' => '<div></div>'
    ),
    array(
        'id' => 'submenu_aksessyaru',
        'title' => 'Подменю Аксессуары',
        'content' => '<div></div>'
    ),
    array(
        'id' => 'submenu_instrymentu',
        'title' => 'Подменю Инструменты',
        'content' => '<div></div>'
    ),
    array(
        'id' => 'submenu_d-d-d-n',
        'title' => 'Подменю Кузов',
        'content' => '<div></div>'
    ),
    array(
        'id' => 'submenu_malyarnue-materialu',
        'title' => 'Подменю Малярные материалы',
        'content' => '<div></div>'
    ),
    array(
        'id' => 'submenu_masla',
        'title' => 'Подменю Масла',
        'content' => '<div></div>'
    ),
    array(
        'id' => 'submenu_tehnicheskie-zhudkosti',
        'title' => 'Подменю Технические жидкости',
        'content' => '<div></div>'
    ),
    array(
        'id' => 'submenu_filtra',
        'title' => 'Подменю Фильтра',
        'content' => '<div></div>'
    ),
    array(
        'id' => 'submenu_shunu-diski',
        'title' => 'Подменю Шины Диски',
        'content' => '<div></div>'
    ),
    array(
        'id' => 'submenu_elektronika',
        'title' => 'Подменю Электроника',
        'content' => '<div></div>'
    ),
    array(
        'id' => 'submenu_zapasnue-chasti',
        'title' => 'Подменю Запасные часи',
        'content' => '<div></div>'
    )
);

foreach($blocks as $key => $value){
    Mage::getModel('cms/block')->load($value['id'], 'identifier')->delete();

    Mage::getModel('cms/block')
        ->setIdentifier($value['id'])
        ->setIsActive(1)
        ->setTitle($value['title'])
        ->setContent($value['content'])
        ->setStores(0)
        ->save();
}


