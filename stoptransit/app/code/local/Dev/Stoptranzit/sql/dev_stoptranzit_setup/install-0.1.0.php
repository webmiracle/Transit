<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$indentifier = 'homepage_popap';

Mage::getModel('cms/block')->load($indentifier, 'identifier')->delete();

Mage::getModel('cms/block')
    ->setIdentifier($indentifier)
    ->setIsActive(1)
    ->setTitle('homepage popap')
    ->setContent('
<div class="homepagePopup" style="display: none;"><span class="hP-title">Зарегистрируйтесь</span> и получите <span class="hP-super">суперскидку</span> на весь <br /> ассортимент <br />магазина
<div class="hP-links"><a href="{{store url="customer/account/create"}}">Регистрация</a> | <a href="{{store url="customer/account/login"}}">Войти</a></div>
</div>
    ')
    ->save();
