<?
include_once("../system/config.php");
define("ADMIN_DIR",dirname(__FILE__));
$admindirname=explode("/",ADMIN_DIR);
define("ADMIN_DIRNAME",$admindirname[count($admindirname)-1]);
include_once(HOME_DIR."/system/cms.class.php");
if(TEST_MODE) {error_reporting(E_ALL & ~E_NOTICE);} else {error_reporting(0);}

$cms = new cms_class($db);

$cms->admin();

unset($cms);
?>