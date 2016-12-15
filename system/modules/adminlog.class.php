<?
class adminlog_class extends cms_class
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
	public function get_typeid_by_code($code)
		{
		$res = false;
		$sql = "SELECT `id` FROM `{{adminlog_types}}` WHERE `code`='".$this->db->escape($code)."';";
		$getres_q = $this->db->query($sql);
		if ($getres_f = $this->db->fetch_assoc($getres_q))
			{
			$res  = $getres_f['id'];
			}
		$getres_q = null;
		return $res;
		}
	/*===========================================================================================*/
	public function new_log($code,$guid,$desc)
		{
		$res = false;
		if ($typeid=$this->get_typeid_by_code($code))
			{
			$sql = "INSERT INTO `{{adminlog}}` (`guid`, `type`, `UID`, `description`, `ip`, `date`) VALUES 
				(
				'".$this->db->escape($guid)."',
				'".$typeid."',
				'".$this->cms->users->UID."',
				'".$this->db->escape($_SERVER['REMOTE_ADDR'])."',
				'".$this->db->escape($desc)."',
				'".time()."'
				)";
			$this->db->query($sql);
			}
		return $res;
		}
	/*===========================================================================================*/
	/*===========================================================================================*/
	/*===========================================================================================*/
	}
?>