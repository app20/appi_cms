<?sfasafssfa
echo 0.5;
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
		echo 1;
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
		}
	/*===========================================================================================*/
	public function new_migrate()
		{
		if ($this->cms->argv[3])
			{
			$time = time();
			$filename = ($this->cms->argv[3]).".".$time.".php"
			
			file_put_contents((HOME_DIR."/system/migration/".$filename),$text);
			echo $filename." success created\n\r";
			}
		else
			{
			echo "enter migrate name \n\r";
			}
		}
	/*===========================================================================================*/
	public function migrate()
		{
		}
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	}
?>