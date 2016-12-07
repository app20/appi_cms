<?
include_once("./system/config.php");
include_once(HOME_DIR."/system/cms.class.php");
if(TEST_MODE) {error_reporting(E_ALL & ~E_NOTICE);} else {error_reporting(0);}

$cms = new cms_class();

$cms->show();

unset($cms);
?>