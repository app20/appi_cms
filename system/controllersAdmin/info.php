<?
class admin_info_cont
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
		$pagetitle = 'Страницы информации - Панель администрации';
		$current_razdel="admin_info";
		include (ADMIN_DIR.'/template/main/header.html');
		include (ADMIN_DIR.'/template/main/header_html.html');
		if ($this->cms->q[1] && (@$this->cms->q[1] == 'add'))
			{
			$h1title="Создать новую страницу";
			$inf = array (
					"id" 			=> "-1",
					"name" 			=> "",
					"aliace"		=> "",
					"pagetitle"		=> "",
					"description"	=> "",
					"keywords" 		=> "",
					"aliace"		=> "",
					"text"			=> "" 
					);
			include (ADMIN_DIR.'/template/info/edit.html');
			}
		elseif ($this->cms->q[1] && (@$this->cms->q[1] == 'edit'))
			{
			if ($inf = $this->cms->info->getInfoById(@$this->cms->q[2]))
				{
				$h1title="Редактировать страницу: ".$inf['name'];
				include (ADMIN_DIR.'/template/info/edit.html');
				}
			else
				{
				include (ADMIN_DIR.'/template/info/list.html');
				}
			}
		else
			{				
			include (ADMIN_DIR.'/template/info/list.html');
			}
		include (ADMIN_DIR.'/template/main/footer.html');
		}
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	}
?>