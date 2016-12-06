<?
class sessions_class extends cms_class
	{
	public $db;
	private $cms;
	public $_SID;
	private $salt = "asf456aw";
	/*===========================================================================================*/
	public function __construct($db_in, $cms)
    	{				
		$this->db = & $db_in;
		$this->cms = & $cms;
		$this->sessions_check();
		}
	/*===========================================================================================*/
	public function __destruct()
    	{
		}	
	/*===========================================================================================*/	
	private function sessions_check()
		{
		if (isset($_COOKIE['_SID']))
			{
			$sql = "SELECT `id` FROM `{{sessions}}` WHERE `SID`='".$this->db->escape($_COOKIE['_SID'])."' AND `ip`='".$this->db->escape($_SERVER['REMOTE_ADDR'])."' AND `hash`='".$this->hash_generate()."';";
			$getsesinfo_q = $this->db->query($sql);
			if ($getsesinfo_f = $this->db->fetch_assoc($getsesinfo_q))
				{
				$this->_SID = $this->db->escape($_COOKIE['_SID']);
				$this->updatesession($this->_SID);
				}
			else
				{
				$this->createnewsession();
				}
			$getsesinfo_q = null;
			}
		else
			{
			$this->createnewsession();
			}
		}
	/*===========================================================================================*/	
	private function createnewsession()
		{
		$new_sid = md5(time().$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].rand(0,1000).$this->salt).rand(0,9);
		$sql = "INSERT INTO `{{sessions}}` ( `SID`,`hash`, `ip`, `reffer`) VALUES ('".$new_sid."','".$this->hash_generate()."','".$this->db->escape($_SERVER['REMOTE_ADDR'])."','".$this->db->escape($_SERVER['HTTP_REFERER'])."')";
		$this->db->query($sql);
		setcookie("_SID",$new_sid,time()+(14*3600*24),"/");
		}
	/*===========================================================================================*/
	private function updatesession($_sid)
		{
		$sql = "UPDATE `{{sessions}}` SET `count_page`=`count_page`+1, `date_mysql`=FROM_UNIXTIME('".time()."')  WHERE `SID`='".$this->db->escape($_sid)."';";
		$this->db->query($sql);
		}
	/*===========================================================================================*/	
	public function hash_generate()
		{
		return md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].'1');
		}
	/*===========================================================================================*/	
	public function set_session_UID($uid)
		{
		$sql = "UPDATE `{{sessions}}` SET `UID` = '".$uid."' WHERE `SID`='".$this->_SID."';";
		$this->db->query($sql);
		}
	/*===========================================================================================*/
	public function get_session_UID()
		{
		$res = false;
		$sql = "SELECT `UID` FROM `{{sessions}}` WHERE `SID`='".$this->_SID."';";
		$getuid_q = $this->db->query($sql);
		if ($getuid_f = $this->db->fetch_assoc($getuid_q))
			{
			$res = $getuid_f['UID'];
			}
		$getuid_q = null;
		return $res;
		}
	}
?>