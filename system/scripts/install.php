<?
class script_install_cont
	{
	public $db;
	private $cms;
	/*===========================================================================================*/
	public function __construct($db_in, $cms)
    	{				
		$this->db = & $db_in;
		$this->cms = & $cms;
		}
	/*===========================================================================================*/
	public function __destruct()
    	{	
		}	
	/*===========================================================================================*/
	public function run()
		{
		//table sessions
		$sql = "CREATE TABLE IF NOT EXISTS `{{sessions}}` (
			  `id` bigint(20) NOT NULL AUTO_INCREMENT,
			  `SID` varchar(33) NOT NULL,
			  `UID` int(11) NOT NULL DEFAULT '0',
			  `hash` varchar(32) NOT NULL,
			  `count_page` int(11) NOT NULL DEFAULT '1',
			  `count_try` int(11) NOT NULL DEFAULT '0' COMMENT 'количество попыток входа',
			  `ip` varchar(15) NOT NULL,
			  `reffer` varchar(50) NOT NULL,
			  `date_mysql` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `SID` (`SID`),
			  KEY `ip` (`ip`,`date_mysql`),
			  KEY `count_page` (`count_page`),
			  KEY `UID` (`UID`),
			  KEY `hash` (`hash`),
			  KEY `count_try` (`count_try`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
		$this->db->query($sql);
		//table users
		$sql = "CREATE TABLE IF NOT EXISTS `{{users}}` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(50) NOT NULL,
			  `pass` varchar(32) NOT NULL,
			  `email` varchar(100) NOT NULL,
			  `level` tinyint(4) NOT NULL,
			  `email_true` varchar(1) NOT NULL,
			  `ip_last` varchar(20) NOT NULL,
			  `ip_reg` varchar(20) NOT NULL,
			  `date_reg` varchar(11) NOT NULL,
			  `date_last` varchar(11) NOT NULL,
			  `date_mysql` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`),
			  KEY `name` (`name`,`pass`,`email`,`level`,`email_true`,`date_reg`,`date_last`,`date_mysql`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
		$this->db->query($sql);
		//table info_pages
		$sql = "CREATE TABLE IF NOT EXISTS `{{info_pages}}` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `name` varchar(100) NOT NULL,
			  `aliace` varchar(100) NOT NULL DEFAULT '',
			  `pagetitle` varchar(255) NOT NULL,
			  `description` varchar(255) NOT NULL,
			  `keywords` varchar(255) NOT NULL,
			  `text` text NOT NULL,
			  `user` int(11) NOT NULL,
			  `date` varchar(11) NOT NULL,
			  `date_mysql` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`),
			  KEY `name` (`name`),
			  KEY `aliace` (`aliace`),
			  KEY `pagetitle` (`pagetitle`),
			  KEY `description` (`description`),
			  KEY `keywords` (`keywords`),
			  KEY `user` (`user`),
			  KEY `date` (`date`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
		$this->db->query($sql);
		//table migration
		$sql = "CREATE TABLE IF NOT EXISTS `{{migration}}` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `tek_version` varchar(20) NOT NULL,
			  `date` varchar(11) NOT NULL DEFAULT '0',
			  `mysql_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
		$this->db->query($sql);
		//table migration add line
		$sql = "INSERT INTO `{{migration}}` (`id`, `tek_version`, `date`) VALUES ('1', '".CMS_VERSION."', '".time()."');";
		$this->db->query($sql);
		$userid = $this->cms->users->new_user("admin","admin","admin");
		$this->cms->users->set_level($userid,100);
		echo "install complete\n\r";
		}
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	}
?>