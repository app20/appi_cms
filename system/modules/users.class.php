<?
class users_class extends cms_class
	{
	public $db;
	private $cms;
	public $UID=0;
	public $email;
	public $name;
	public $level;
	public $vals; //extra val
	private $salt = "asdqa;'wq!53";
	/*===========================================================================================*/
	public function __construct($db_in, $cms)
    	{				
		$this->db = & $db_in;
		$this->cms = & $cms;
		$this->vals = array();
		
		$this->check_login();
		}
	/*===========================================================================================*/
	public function __destruct()
    	{
		}	
	/*===========================================================================================*/	
	private function check_login()
		{
		$this->UID = $this->cms->sessions->get_session_UID();
		if ($this->UID > 0)
			{
			if ($userinfo = $this->getuserinfo($this->UID))
				{
				$this->email = $userinfo['email'];
				$this->name = $userinfo['name'];
				$this->level = $userinfo['level'];
				}
			else
				{
				$this->UID=0;
				$this->cms->sessions->set_session_UID(0);
				}
			}
		//сделать загрузку доп полей
		}
	/*===========================================================================================*/	
	public function getuserinfo($uid)
		{
		$res = false;
		$sql = "SELECT `id`, `name`, `pass`, `email`, `level`, `email_true`, `ip_last`, `ip_reg`, `date_reg`, `date_last` FROM `{{users}}` WHERE `id`='".$this->db->escape($uid)."';";
		$getuinfo_q = $this->db->query($sql);
		if ($getuinfo_f=$this->db->fetch_assoc($getuinfo_q))
			{
			$res = $getuinfo_f;
			}
		$getuinfo_q = null;
		return $res;
		}
	/*===========================================================================================*/	
	public function getuserlist($order_by="id",$filter=array())
		{
		$res = array();
		//фильтры не реализованы
		$filter_sql = "";
		
		if ($order_by == "id") {$order_sql = "`id`";}
		else {$order_sql = "`id`";};
		
		$sql = "SELECT `id`, `name`, `email`, `level`, `email_true`, `ip_last`, `ip_reg`, `date_reg`, `date_last` FROM `{{users}}` WHERE 1=1 ".$filter_sql." ORDER BY ".$order_sql.";";
		$getuserlist_q = $this->db->query($sql);
		while ($getuserlist_f = $this->db->fetch_assoc($getuserlist_q))
			{
			$res[] = $getuserlist_f;
			}
		$getuserlist_q = null;
		return $res;
		}
	/*===========================================================================================*/	
	public function email_check($email)
		{
		$res = false;
		$sql= "SELECT COUNT(`id`) AS 'ccc' FROM `{{users}}` WHERE `email`='".$this->db->escape($email)."';";
		$checkinfo_q = $this->db->query($sql);
		$checkinfo_f = $this->db->fetch_assoc($checkinfo_q);
		if ($checkinfo_f['ccc'] > 0) {$res = true;}
		$checkinfo_q = null;
		return $res;
		}
	/*===========================================================================================*/	
	public function validateEMAIL($email)
		{
		return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
		}
	/*===========================================================================================*/	
	public function pass_hash($pass)
		{
		return md5(md5($pass).md5($this->salt));
		}
	/*===========================================================================================*/
	public function new_user($email,$pass,$name)
		{
		$res = false;
		$sql = "INSERT INTO `{{users}}` (`name`, `pass`, `email`, `level`, `email_true`, `ip_last`, `ip_reg`, `date_reg`, `date_last`) VALUES (
			'".$this->db->escape($name)."',
			'".$this->pass_hash($pass)."',
			'".$this->db->escape($email)."',
			'1',
			'0',
			'".$this->db->escape($_SERVER['REMOTE_ADDR'])."',
			'".$this->db->escape($_SERVER['REMOTE_ADDR'])."',
			'".time()."',
			'".time()."'
			);";
		$this->db->query($sql);
		$res = $this->getUID_by_email($email);
		return $res;
		}
	/*===========================================================================================*/
	public function getUID_by_email($email)
		{
		$res = false;
		$sql = "SELECT `id` FROM `{{users}}` WHERE `email`='".$this->db->escape($email)."';";
		$checkuser_q = $this->db->query($sql);
		if ($checkuser_f = $this->db->fetch_assoc($checkuser_q))
			{
			$res  = $checkuser_f['id'];
			}
		$checkuser_q = null;
		return $res;
		}
	/*===========================================================================================*/
	public function getname_by_UID($UID)
		{
		$res = false;
		$sql = "SELECT `name` FROM `{{users}}` WHERE `id`='".$this->db->escape($UID)."';";
		$checkuser_q = $this->db->query($sql);
		if ($checkuser_f = $this->db->fetch_assoc($checkuser_q))
			{
			$res  = $checkuser_f['name'];
			}
		$checkuser_q = null;
		return $res;
		}
	/*===========================================================================================*/
	public function getemail_by_UID($UID)
		{
		$res = false;
		$sql = "SELECT `email` FROM `{{users}}` WHERE `id`='".$this->db->escape($UID)."';";
		$checkuser_q = $this->db->query($sql);
		if ($checkuser_f = $this->db->fetch_assoc($checkuser_q))
			{
			$res  = $checkuser_f['email'];
			}
		$checkuser_q = null;
		return $res;
		}
	/*===========================================================================================*/
	public function getUID_by_name($name)
		{
		$res = false;
		$sql = "SELECT `id` FROM `{{users}}` WHERE `name`='".$this->db->escape($name)."';";
		$checkuser_q = $this->db->query($sql);
		if ($checkuser_f = $this->db->fetch_assoc($checkuser_q))
			{
			$res  = $checkuser_f['id'];
			}
		$checkuser_q = null;
		return $res;
		}
	/*===========================================================================================*/
	public function getUID($email,$pass)
		{
		$res = false;
		$sql = "SELECT `id` FROM `{{users}}` WHERE `email`='".$this->db->escape($email)."' AND `pass`='".$this->pass_hash($pass)."';";
		$checkuser_q = $this->db->query($sql);
		if ($checkuser_f = $this->db->fetch_assoc($checkuser_q))
			{
			$res = $checkuser_f['id'];
			}
		$checkuser_q = null;
		return $res;
		}
	/*===========================================================================================*/	
	public function change_userpass($UID,$newpass)
		{
		$sql = "UPDATE `{{users}}` SET `pass`='".$this->pass_hash($newpass)."' WHERE `id`='".$this->db->escape($UID)."';";		
		$this->db->query($sql);
		return true;
		}
	/*===========================================================================================*/	
	public function change_username($UID,$newname)
		{
		$sql = "UPDATE `{{users}}` SET `name`='".$this->db->escape($newname)."' WHERE `id`='".$this->db->escape($UID)."';";		
		$this->db->query($sql);
		return true;
		}
	/*===========================================================================================*/	
	public function set_level($UID,$newlevel)
		{
		$sql = "UPDATE `{{users}}` SET `level`='".$this->db->escape($newlevel)."' WHERE `id`='".$this->db->escape($UID)."';";		
		$this->db->query($sql);
		return true;
		}
	/*===========================================================================================*/
	/*public function create_passreset($email)
		{
		$newcod = mb_substr(md5(md5($email.time()).md5(rand(0,100))),0,30,"utf-8");
		$sql = "INSERT INTO `".DB_PREFIX."users_resetpass` (`UID`, `cod`, `date`) VALUES ('".$this->getUID_by_email($this->db->escape($email))."','".$newcod."','".time()."')";
		$this->db->query($sql);
		return $newcod;
		}*/
	/*===========================================================================================*/
	/*public function check_passreset($cod)
		{
		$res = false;
		$sql= "SELECT COUNT(`id`) AS 'ccc' FROM `".DB_PREFIX."users_resetpass` WHERE `cod`='".$this->db->escape($cod)."';";
		$checkinfo_q = $this->db->query($sql);
		$checkinfo_f = $this->db->fetch_assoc($checkinfo_q);
		if ($checkinfo_f['ccc'] == 1) {$res = true;}
		$checkinfo_q = null;
		return $res;
		}*/
	/*===========================================================================================*/
	/*public function getUID_passreset($cod)
		{
		$res = false;
		$sql= "SELECT `UID` FROM `".DB_PREFIX."users_resetpass` WHERE `cod`='".$this->db->escape($cod)."';";
		$checkinfo_q = $this->db->query($sql);		
		if ($checkuser_f = $this->db->fetch_assoc($checkinfo_q))
			{
			$res = $checkuser_f['UID'];
			}
		$checkinfo_q = null;
		return $res;
		}*/
	/*===========================================================================================*/
	/*public function delete_passreset($cod)
		{
		$sql = "DELETE FROM `".DB_PREFIX."users_resetpass` WHERE `cod`='".$this->db->escape($cod)."';";
		$this->db->query($sql);
		return true;
		}*/
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	/*===========================================================================================*/
	/*===========================================================================================*/
	/*===========================================================================================*/	
	}
?>