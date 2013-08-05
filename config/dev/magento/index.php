
<?php

//подключение
$db_host="localhost";
$db_user="magento";
$db_pass="2eSu2Ege";
$db="magento";
mysql_connect($db_host,$db_user,$db_pass)or die(mysql_error());
mysql_select_db($db)or die(mysql_error());
//добавление или изменения производителя;
if(isset($_POST['select_proizvoditel'])){
    $option_proizv=$_POST['select_proizvoditel'];
    $f=0;
    $sql="SELECT * FROM proizv WHERE option_proizv='".$option_proizv."'";
    $sql=mysql_query($sql);
    while($r=mysql_fetch_array($sql)){
        $f=1;
    }
    if($f==0){
        $img_proizv=$_FILES['img_proizv']['name'];
        if (!empty($img_proizv)) {
            if($_POST['desc_proizv']!=''){
                $img=rand().$img_proizv;
                $target=$_SERVER['DOCUMENT_ROOT']."/img/".$img;
                move_uploaded_file($_FILES['img_proizv']['tmp_name'], $target);
                $sql="INSERT INTO proizv(img_proizv,desc_proizv,option_proizv,name_proizv) VALUES('".$img."','".$_POST['desc_proizv']."','".$option_proizv."','".$_POST['name_proizv']."')";
                $sql=mysql_query($sql) or die(mysql_error());
                setcookie("baner", 'Производитель был добавлен!');
            }else{
                setcookie("baner", 'Производитель не был добавлен из-за пустого поля описания!');
            }
        }else{
            setcookie("baner", 'Вы не указали иконку производителя!');
        }
    }else{
        $img_proizv=$_FILES['img_proizv']['name'];
        if (!empty($img_proizv)) {
            $img=rand().$img_proizv;
            $target=$_SERVER['DOCUMENT_ROOT']."/img/".$img;
            move_uploaded_file($_FILES['img_proizv']['tmp_name'], $target);
            $sql="UPDATE proizv SET img_proizv='".$img."' WHERE option_proizv='".$option_proizv."'";
            $sql=mysql_query($sql) or die(mysql_error());
        }
        setcookie("baner", 'Производитель успешно изменен!');

        $sql="UPDATE proizv SET desc_proizv='".$_POST['desc_proizv']."' WHERE option_proizv='".$option_proizv."'";
        $sql=mysql_query($sql) or die(mysql_error());

        $sql="UPDATE proizv SET name_proizv='".$_POST['name_proizv']."' WHERE option_proizv='".$option_proizv."'";
        $sql=mysql_query($sql) or die(mysql_error());
    }
}

//удаление производителя
if(isset($_POST['hide_proizvod'])){
    setcookie("baner", 'Производитель успешно очищен!');
    $sql="DELETE FROM proizv WHERE option_proizv='".$_POST['hide_proizvod']."'";
    $sql=mysql_query($sql) or die(mysql_error());
    unset($_POST['hide_proizvod']);

}



//добавление банера
if(isset($_POST['add_url_baner'])){
    $add_img_baner=$_FILES['add_img_baner']['name'];
    if (!empty($add_img_baner)) {
        if($_POST['add_url_baner']!=''){
            $img=rand().$add_img_baner;
            $target=$_SERVER['DOCUMENT_ROOT']."/img/".$img;
            move_uploaded_file($_FILES['add_img_baner']['tmp_name'], $target);
            $sql="INSERT INTO baners(img_baner,url_baner,block_baner) VALUES('".$img."','".$_POST['add_url_baner']."',".$_POST['add_block_baner'].")";
            $sql=mysql_query($sql) or die(mysql_error());
            setcookie("baner", 'Банер добавлен!');
        }else{
            setcookie("baner", 'Банер не был добавлен из-за пустого поля ссылки!');
        }
    }else{
        setcookie("baner", 'Вы не указали объект банера!');
    }

    unset($_POST['add_img_baner']);
    unset($_POST['add_url_baner']);
    unset($_POST['add_block_baner']);
}

//редактирование банера
if(isset($_POST['edit_id_baner'])){
    $edit_img_baner=$_FILES['edit_img_baner']['name'];
    if (!empty($edit_img_baner)) {
        $img=rand().$edit_img_baner;
        $target=$_SERVER['DOCUMENT_ROOT']."/img/".$img;
        move_uploaded_file($_FILES['edit_img_baner']['tmp_name'], $target);
        $sql="UPDATE baners SET img_baner='".$img."' WHERE id_baner=".$_POST['edit_id_baner'];
        $sql=mysql_query($sql) or die(mysql_error());
    }
    setcookie("baner", 'Банер успешно изменен!');

    $sql="UPDATE baners SET url_baner='".$_POST['edit_url_baner']."',block_baner=".$_POST['edit_block_baner']." WHERE id_baner=".$_POST['edit_id_baner'];
    $sql=mysql_query($sql) or die(mysqrl_error());

    unset($_POST['edit_id_baner']);
    unset($_POST['edit_url_baner']);
    unset($_POST['edit_block_baner']);
    unset($_POST['edit_img_baner']);
}


//удаление банера
if(isset($_POST['del_id_baner'])){
    setcookie("baner", 'Банер успешно удален!');
    $sql="DELETE FROM baners WHERE id_baner=".$_POST['del_id_baner'];
    $sql=mysql_query($sql) or die(mysql_error());
    unset($_POST['del_id_baner']);

}







/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

if (version_compare(phpversion(), '5.2.0', '<')===true) {
    echo  '<div style="font:12px/1.35em arial, helvetica, sans-serif;">
<div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;">
<h3 style="margin:0; font-size:1.7em; font-weight:normal; text-transform:none; text-align:left; color:#2f2f2f;">
Whoops, it looks like you have an invalid PHP version.</h3></div><p>Magento supports PHP 5.2.0 or newer.
<a href="http://www.magentocommerce.com/install" target="">Find out</a> how to install</a>
 Magento using PHP-CGI as a work-around.</p></div>';
    exit;
}

/**
 * Error reporting
 */
error_reporting(E_ALL | E_STRICT);

/**
 * Compilation includes configuration file
 */
define('MAGENTO_ROOT', getcwd());

$compilerConfig = MAGENTO_ROOT . '/includes/config.php';
if (file_exists($compilerConfig)) {
    include $compilerConfig;
}

$mageFilename = MAGENTO_ROOT . '/app/Mage.php';
$maintenanceFile = 'maintenance.flag';

if (!file_exists($mageFilename)) {
    if (is_dir('downloader')) {
        header("Location: downloader");
    } else {
        echo $mageFilename." was not found";
    }
    exit;
}

if (file_exists($maintenanceFile)) {
    include_once dirname(__FILE__) . '/errors/503.php';
    exit;
}

require_once $mageFilename;

#Varien_Profiler::enable();

#Mage::setIsDeveloperMode(true);

#ini_set('display_errors', 1);
umask(0);

/* Store or website code */
$mageRunCode = isset($_SERVER['MAGE_RUN_CODE']) ? $_SERVER['MAGE_RUN_CODE'] : '';

/* Run store or run website */
$mageRunType = isset($_SERVER['MAGE_RUN_TYPE']) ? $_SERVER['MAGE_RUN_TYPE'] : 'store';

Mage::run($mageRunCode, $mageRunType);

?>


