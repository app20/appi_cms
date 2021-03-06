<?php
class script_migrate_cont
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
		if (@$this->cms->argv[2] == "new")
			{
			$this->new_migrate();
			}
		/*elseif (@$this->cms->argb[2] == "last")
			{
			$this->new_migrate();
			}*/
		else
			{
			$this->migrate();
			}
		
		}
	/*===========================================================================================*/
	
	public function migrate()
		{
		//get last migrate date
		$time = 0;
		$lastdate = 0;
		$sql = "SELECT `date` FROM {{migration}} WHERE `id`='1';";
		$getlasttime_q = $this->db->query($sql);
		if ($getlasttime_f = $this->db->fetch_assoc($getlasttime_q))
			{
			$lastdate = $getlasttime_f['date'];
			}
		$getlasttime_q = null;
		
		
		function cmp_migrate($a,$b)
			{
			if ($a['time'] == $b['time']) 
				{return 0;}
			return ($a['time'] < $b['time']) ? -1 : 1;
			}
		
		$file_list = array();
		$f = scandir(HOME_DIR."/system/migration");
		foreach ($f as $file)
			{
			if (preg_match("/\.(php)/", $file))
				{
				$f_ar  = explode(".",$file);
				if ($f_ar[count($f_ar)-2] > $lastdate) //если дата в файле указана раньше - то добавляем
					{
					$file_list[] = array('time'=>$f_ar[count($f_ar)-2],'name'=>$f_ar[count($f_ar)-3]);
					if ($f_ar[count($f_ar)-2] > $time) {$time = $f_ar[count($f_ar)-2];}
					}
				}
			}
		usort($file_list,"cmp_migrate");
		$run_count=0;
		for ($i=0; $i<count($file_list); $i++)
			{
			$filen = (HOME_DIR."/system/migration/".$file_list[$i]['name'].".".$file_list[$i]['time'].".php");
			if (file_exists($filen)) //если есть такой файл в миграции, то запускаем
				{
				include_once ($filen);
				$migration_name = "migrate_".$file_list[$i]['time'];
				$migration_class = new $migration_name($this->db);
				$migration_class->run();
				}
			$run_count++;
			}
		
		$sql = "UPDATE {{migration}} SET `date`='".$time."' AND ``='".CMS_VERSION."' WHERE `id`='1';";
		$this->db->query($sql);
		
		echo "migrate complite. run ".$run_count." files";
		}
	/*===========================================================================================*/
	public function new_migrate()
		{
		if ($this->cms->argv[3])
			{
			$time = time();
			$filename = ($this->cms->argv[3]).".".$time.".php";
$text = 
"
<?
class migrate_".$time."
	{
	public \$db;
	/*===========================================================================================*/
	public function __construct(\$db_in)
    	{				
		\$this->db = & \$db_in;
		}
	/*===========================================================================================*/
	public function __destruct()
    	{	
		}	
	/*===========================================================================================*/
	public function run()
		{
		//table 
		\$sql = \"\";
		//\$this->db->query(\$sql);		
		}
	/*===========================================================================================*/
	}
?>
";
			file_put_contents((HOME_DIR."/system/migration/".$filename),$text);
			echo $filename." success created\n\r";
			}
		else
			{
			echo "enter migrate name \n\r";
			}
		}
	/*===========================================================================================*/
	/*===========================================================================================*/
	}
?>