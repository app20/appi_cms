<?
class admin_home_cont
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
		$pagetitle = 'Панель администратора';
		$current_razdel="admin_home";
		include (ADMIN_DIR.'/template/main/header.html');
		include (ADMIN_DIR.'/template/main/header_html.html');
		include (ADMIN_DIR.'/template/home/home.html');
		include (ADMIN_DIR.'/template/main/footer.html');
		}
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	}
?>