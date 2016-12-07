<?php
/*
app_cms by app20
v 0.92.10
min PHP version 5.6
*/
define("CMS_VERSION","0.92.16");

//подключаем плагины
include_once (HOME_DIR.'/system/plugins/bd/bd.class.mysqli.php');
//подключаем основные модули
$f = scandir(HOME_DIR."/system/modules");
foreach ($f as $file)
	{
	if (preg_match("/\.(php)/", $file))
		{
		include_once (HOME_DIR."/system/modules/".$file);
		}
	}
//подключаем дополнительные модули
$f = scandir(HOME_DIR."/system/modules_extra");
foreach ($f as $file)
	{
	if (preg_match("/\.(php)/", $file))
		{
		include_once (HOME_DIR."/system/modules_extra/".$file);
		}
	}



class cms_class
	{
	private $db;
	public $q; //query in url
	public $sessions;
	public $users;
	public $email;
	public $info;	
	public $m; //modules
	public $argv; //arguments
	public $timebelt=5; //time belt
	private $debug_html="";	
	/*===========================================================================================*/
	public function __construct($console=null,$argv=null)
    	{
		if ($argv!==null) {$this->argv = $argv;}
		//создаем хэндл базы данных
		$this->db = new DB(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		$this->db->query("SET NAMES utf8");		
		$this->db->query("SET CHARACTER SET 'utf8'");
		
		//создаем хэндлы основных модулей
		$this->sessions = new sessions_class($this->db, $this);
		$this->users = new users_class($this->db, $this);
		$this->email = new email_class($this->db, $this);		
		$this->info = new info_class($this->db, $this);
		//создаем хэндлы доп модулей
		$this->m = array();
		$f = scandir(HOME_DIR."/system/modules_extra");
		foreach ($f as $file)
			{
			if (preg_match("/\.(php)/", $file))
				{
				$m_name = basename($file);
				$m_class = $m_name."_class";
				$this->m[$m_name] = new $m_class($this->db, $this);
				}
			}
		}
	/*===========================================================================================*/
	public function __destruct()
    	{
		unset($this->db);
		unset($this->sessions);
		unset($this->users);
		unset($this->email);
		unset($this->info);
		foreach ($this->m as $one_module_name=>$one_module)
			{
			unset($this->$one_module_name);
			}
		}
	/*===========================================================================================*/
	public function userauth()
		{
		$res = false;
		/*if ((@$_COOKIE['coin_login'] == USERNAME) && (@$_COOKIE['coin_pass'] == PASSWORD))
			{
			return true;
			}		*/
		return $res;
		}
	/*===========================================================================================*/		
	public function razbit($q)	
		{
		$res = array();
		$ar = explode('/',$q);
		if (count($ar) == 1)
			{
			$res[0] = $q;
			}
		else
			{
			$res = $ar;
			}
		return $res;
		}
		
	/*===========================================================================================*/
	public function show()
		{		
		$this->q = $this->razbit(@$_GET['q']);
				
		$aliace_list = $this->info->getAliaceArray(false);
		
		if (($this->q[0] == 'ajax') && ($this->q[1]))  //показываем ajax если есть
			{
			if (file_exists(HOME_DIR."/system/controllers/AJAX_".$this->q[1].".php"))
				{
				include_once (HOME_DIR."/system/controllers/AJAX_".$this->q[1].".php");
				$controller_name = 'ajax_'.$this->q[1]."_cont";
				$controller_class = new $controller_name($this->db, $this);
				$controller_class->out();
				}
			else
				{
				echo "error";
				}
			}
		elseif(in_array($this->q[0],$aliace_list))  //база алиасов с информацией и показываем страницу если есть
			{
			include_once (HOME_DIR."/system/controllers/info.php");
			$controller_class = new info_cont($this->db, $this);
			$controller_class->out();
			}
		elseif (file_exists(HOME_DIR."/system/controllers/".$this->q[0].".php")) //загружаем контроллер если есть
			{
			include_once (HOME_DIR."/system/controllers/".$this->q[0].".php");
			$controller_name = $this->q[0]."_cont";
			$controller_class = new $controller_name($this->db, $this);
			$controller_class->out();
			}		
		elseif(($this->q[0] == "") || (!$this->q[0])) //домашняя страница
			{
			include_once (HOME_DIR."/system/controllers/home.php");
			$controller_class = new home_cont($this->db, $this);
			$controller_class->out();
			}
		else
			{
			$this->out404();
			}
		}
	/*===========================================================================================*/
	public function admin()
		{
		$this->q = $this->razbit(@$_GET['q']);		
		
		
		if (($this->users->UID > 0) && ($this->users->level >= 10))
			{
			if (($this->q[0] == 'ajax') && ($this->q[1]))  //показываем ajax если есть
				{
				if (file_exists(HOME_DIR."/system/controllersAdmin/AJAX_".$this->q[1].".php"))
					{
					include_once (HOME_DIR."/system/controllersAdmin/AJAX_".$this->q[1].".php");
					$controller_name = 'ajax_'.$this->q[1]."_cont";
					$controller_class = new $controller_name($this->db, $this);
					$controller_class->out();
					}
				else
					{
					echo "error";
					}
				}
			elseif (file_exists(HOME_DIR."/system/controllersAdmin/".$this->q[0].".php")) //загружаем контроллер если есть
				{
				include_once (HOME_DIR."/system/controllersAdmin/".$this->q[0].".php");
				$controller_name = "admin_".$this->q[0]."_cont";
				$controller_class = new $controller_name($this->db, $this);
				$controller_class->out();
				}		
			elseif(($this->q[0] == "") || (!$this->q[0])) //домашняя страница админки
				{
				include_once (HOME_DIR."/system/controllersAdmin/home.php");
				$controller_class = new admin_home_cont($this->db, $this);
				$controller_class->out();
				}
			else
				{
				$this->out404();
				}
			}
		elseif ((@$this->q[0] == 'ajax') && ($this->q[1] == 'login'))
			{
			include_once (HOME_DIR."/system/controllersAdmin/AJAX_".$this->q[1].".php");
			$controller_name = "ajax_login_cont";
			$controller_class = new $controller_name($this->db, $this);
			$controller_class->out();
			}
		else
			{
			include_once (HOME_DIR."/system/controllersAdmin/login.php");
			$controller_class = new admin_login_cont($this->db, $this);
			$controller_class->out();
			}
		
		}
	/*===========================================================================================*/
	public function script()
		{
		$filen = (HOME_DIR."/system/scripts/".$this->argv[1].".php");
		if (file_exists($filen)) //если есть такой файл в скриптах, то запускаем
			{
			require_once ($filen);
			$scripts_name = "script_".$this->argv[1]."_cont";
			$scripts_class = new $scripts_name($this->db, $this);
			$scripts_class->run();
			}
		}
	/*===========================================================================================*/
	public function out404()
		{
		include_once (HOME_DIR."/system/lib/404.php");
		$controller_class = new error404_cont($this->db, $this);
		$controller_class->out();
		}
	/*===========================================================================================*/
	public function out403()
		{
		include_once (HOME_DIR."/system/lib/403.php");
		$controller_class = new error403_cont($this->db, $this);
		$controller_class->out();
		}
	/*===========================================================================================*/
	public function debug($str="",&$el=false)
		{
		if (!TEST_MODE) {return false;}
		if ($str != "")
			{
			
			$debug_backtrace = debug_backtrace();			
			$l = 0;
			foreach ($debug_backtrace as $debug_level)
				{
				$this->debug_html .= "from[".$l."]: ".@$debug_level['file']." (".@$debug_level['line'].")&nbsp&nbsp&nbspclass: '".@$debug_level['class']."'
					&nbsp&nbsp&nbspfunction: '".@$debug_level['function']."'<br />";
				$l++;
				}
			$this->debug_html .= "<br /><br />";
			$this->debug_html .= $str;
			$this->debug_html .= "<hr style=\"border-top: 1px solid #fb0101;\" />";
			//$this->debug_html .= "<pre>".print_r(debug_backtrace(),true)."</pre>";
			return true;
			}
		else
			{
			if (($this->users->UID) && ($this->users->level > 10))
				{
				$end_info = "";	
				$end_info .= "mysqli query count = ".$this->db->numquerys."<br />";
				$end_info .= "time = ".(microtime(true) - START_TIME)." с.<br />";
				return $this->debug_html."<br />".$end_info;
				}
			else
				{return false;}
			}
		}
	/*===========================================================================================*/
	public function gettrueTime($time)
		{
		$offset = timezone_offset_get( new DateTimeZone(date_default_timezone_get()), new DateTime());
		$time = $time - $offset + (3600*$this->timebelt);
		
		
		$date = date('d/m/Y', $time);
		if($date == date('d/m/Y'))
			{
			return "Сегодня ".date('H:i',$time);
			}
		else if($date == date('d/m/Y',$time - (24 * 60 * 60)))
			{
			return "Вчера ".date('H:i',$time);
			}
		else if($date == date('d/m/Y',$time + (24 * 60 * 60)))
			{
			return "Завтра ".date('H:i',$time);
			}
		else if($date == date('d/m/Y',$time - (24 * 60 * 60)))
			{
			return date('j.m.Y H:i',$time);
			}
		
		
		return date('d.m.Y H:i',$time);
		}
	/*===========================================================================================*/
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	}


?>