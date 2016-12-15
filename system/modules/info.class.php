<?
class info_class extends cms_class
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
	public function getAliaceArray($need_id)
		{
		$res = array();
		$sql = "SELECT ";
		if ($need_id) {$sql .= "`id`,";}
		$sql .= "`aliace` FROM `{{info_pages}}` WHERE 1=1 ORDER BY `id`;";
		$getinfo_q = $this->db->query($sql);
		while ($getinfo_f = $this->db->fetch_assoc($getinfo_q))
			{
			if ($need_id)
				{
				$res[]=$getinfo_f;
				}
			else
				{
				$res[]=$getinfo_f['aliace'];	
				}
			}
		$getinfo_q = null;
		return $res;
		}
	/*===========================================================================================*/	
	public function getInfoByAliace($aliace)
		{
		$res = false;
		$sql = "SELECT `id`, `name`, `aliace`, `pagetitle`, `description`, `keywords`, `text`, `user`, `date` FROM `{{info_pages}}` WHERE `aliace`='".$this->db->escape($aliace)."';";
		$getinfo_q  = $this->db->query($sql);
		if ($getinfo_f = $this->db->fetch_assoc($getinfo_q))
			{
			$res = $getinfo_f;
			}
		return $res;
		}
	/*===========================================================================================*/
	public function getInfoById($id)
		{
		$res = false;
		$sql = "SELECT `id`, `name`, `aliace`, `pagetitle`, `description`, `keywords`, `text`, `user`, `date` FROM `{{info_pages}}` WHERE `id`='".$this->db->escape($id)."';";
		$getinfo_q  = $this->db->query($sql);
		if ($getinfo_f = $this->db->fetch_assoc($getinfo_q))
			{
			$res = $getinfo_f;
			}
		return $res;
		}
	/*===========================================================================================*/
	public function new_info($args)
		{
		$res = false;
		$sql = "INSERT INTO {{info_pages}} (`name`, `aliace`, `pagetitle`, `description`, `keywords`, `text`, `vis`, `user`, `date`) VALUES 
			(
			'".$this->db->escape($args['name'])."',
			'".$this->db->escape($args['aliace'])."',
			'".$this->db->escape($args['pagetitle'])."',
			'".$this->db->escape($args['description'])."',
			'".$this->db->escape($args['keywords'])."',
			'".$this->db->escape($args['text'])."',
			'".$this->db->escape($args['vis'])."',
			'".$this->cms->users->UID."',
			'".time()."'
			);";
		$this->db->query($sql);
		if ($info = $this->getInfoByAliace($args['aliace']))
			{
			$res = $info['id'];
			$this->cms->adminlog->new_log("info",$res,"Создана новая страница");
			}
		return $res;
		}
	/*===========================================================================================*/
	/*===========================================================================================*/	
	}
?>