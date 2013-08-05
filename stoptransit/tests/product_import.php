<?php

ini_set('display_errors', 1);
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '18000');

$cwd = getcwd();
chdir('../');

require 'app/Mage.php';

if (!Mage::isInstalled()) {
    echo 'Application is not installed yet, please complete install wizard first.';
    exit;
}
Mage::setIsDeveloperMode(true);
Mage::app('admin')->setUseSessionInUrl(false);
Mage::app()->setCurrentStore('admin');

if (isset($_GET['profiler']) && $_GET['profiler'] == '1') {
    Varien_Profiler::enable();
}

try {
    /** @var $import ISM_IntersolveGiftcard_Model_Export */
    $import = Mage::getModel('import_product/handler');
    $import->import();
} catch (Exception $e) {
    Mage::printException($e);
}

if (isset($_GET['profiler']) && $_GET['profiler'] == '1') {
    echo __Profiler::getTimers();
}
