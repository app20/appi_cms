<?php
define("START_TIME",microtime(true));
define("HOME_DIR",dirname(dirname(__FILE__)));
define("ADMIN_DIR",dirname(__FILE__));
$admindirname=explode("/",ADMIN_DIR);
define("ADMIN_DIRNAME",$admindirname[count($admindirname)-1]);
define("DB_HOSTNAME","localhost");
define("DB_USERNAME","geteasyjob_wfood");
define("DB_PASSWORD","4AeMRS;mVv8NILEiL");
define("DB_DATABASE","geteasyjob_wfood");
define("DB_PREFIX","wf_");


define('TEST_MODE', true);

if(TEST_MODE) {error_reporting(E_ALL & ~E_NOTICE);} else {error_reporting(0);}
include_once(HOME_DIR."/system/bd/config.php");
include_once(HOME_DIR."/system/cms.class.php");

$cms = new cms_class($db);

$cms->admin();
unset($cms);
include_once(HOME_DIR."/system/bd/end_conf.php");
?>