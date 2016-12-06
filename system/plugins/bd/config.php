<?
require_once "bd.class.mysqli.php";
$db = new DB(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$db->query("SET NAMES utf8");
$db->query("SET CHARACTER SET 'utf8'");
?>
