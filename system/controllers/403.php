<?
class error403_cont
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
	public function out()
		{
		$pagetitle = '403 Error';
		$current_razdel="403";
		//include (HOME_DIR.'/template/main/403.html');
		}
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	}
?>