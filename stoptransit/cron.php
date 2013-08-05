<?php
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
$dbhost = "89.184.73.125";
$dbname = "stoptran";
$dbuser = "u_pol";
$dbpass = "tg8xFNoA"; 
     
$db = mysql_connect($dbhost,$dbuser,$dbpass) or die(mysql_error());
mysql_query ("SET CHARACTER SET 'cp1251'", $db);
mysql_query ("set character_set_client='cp1251'");
mysql_query ("set character_set_results='cp1251'");
mysql_query ("set collation_connection='cp1251_general_ci'");
mysql_query ("SET NAMES cp1251");
mysql_select_db($dbname,$db) or die("Could not find db");

$sql="SELECT * FROM cms_content WHERE category_id=104 OR category_id=99 OR category_id=103 ORDER BY pubdate DESC";
$sql=mysql_query($sql) or die(mysql_error());
$n=0;
while($r=mysql_fetch_array($sql)){
	$n=$n+1;
	$enddate[$n]=$r['enddate'];
	$seolink[$n]=$r['seolink'];
	$id[$n]=$r['id'];
	$title[$n]=strip_tags($r['title']);
	$description[$n]=strip_tags($r['description']);
	$content[$n]=strip_tags($r['content']);
	$category_id=104;
}

$dbhost = "localhost";
$dbname = "magento";
$dbuser = "magento";
$dbpass = "2eSu2Ege";
     
$db = mysql_connect($dbhost,$dbuser,$dbpass) or die(mysql_error());
mysql_query ("SET CHARACTER SET 'cp1251'", $db);
mysql_query ("set character_set_client='cp1251'");
mysql_query ("set character_set_results='cp1251'");
mysql_query ("set collation_connection='cp1251_general_ci'");
mysql_query ("SET NAMES cp1251");
mysql_select_db($dbname,$db) or die("Could not find db");
for($i=1;$i<=$n;$i++){
	$f=0;
	$sql="SELECT * FROM cms_content WHERE id='".$id[$i]."'";
	$sql=mysql_query($sql);
	while($r=mysql_fetch_array($sql)){
		$f=1;
		if(($enddate[$i]!=$r['enddate'])||($seolink[$i]!=$r['seolink'])||($title[$i]!=$r['title'])||($description[$i]!=$r['description'])||($content[$i]!=$r['content'])){
			$sql1="UPDATE cms_content SET enddate='".$enddate[$i]."',seolink='".$seolink[$i]."',title='".$title[$i]."',description='".$description[$i]."',content='".$content[$i]."' WHERE id_news=".$r['id_news'];
			$sql1=mysql_query($sql1) or die(mysql_error());
		}
	}
	if($f==0){
		$sql1="INSERT INTO cms_content(id,category_id,enddate,seolink,title,description,content) VALUES('".$id[$i]."','104','".$enddate[$i]."','".$seolink[$i]."','".$title[$i]."','".$description[$i]."','".$content[$i]."')";
		$sql1=mysql_query($sql1);
	}
}
	
require 'app/Mage.php';

if (!Mage::isInstalled()) {
    echo "Application is not installed yet, please complete install wizard first.";
    exit;
}

// Only for urls
// Don't remove this
$_SERVER['SCRIPT_NAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_NAME']);
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_FILENAME']);

Mage::app('admin')->setUseSessionInUrl(false);

umask(0);

try {
    Mage::getConfig()->init()->loadEventObservers('crontab');
    Mage::app()->addEventArea('crontab');
    Mage::dispatchEvent('default');
} catch (Exception $e) {
    Mage::printException($e);
}
