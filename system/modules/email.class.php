<?
class email_class extends cms_class
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
	public function send($fromname,$fromemail,$to,$subject,$text)
    	{
    	$headers  = "Content-type: text/html; charset=utf-8 \r\n";
		$headers .= "From: ".$fromname." <".$fromemail.">\r\n";
		$headers .= "Bcc: ".$fromemail."\r\n";
		$headers .= "X-Mailer: PHPmailer\r\n";
		


		$res = mail($to,$subject,$text,$headers);
		return $res;
    	}
	/*===========================================================================================*/
	/*public function get_pop3($email,$server,$port=110,$name,$pass,$filter=array())
    	{
		//if ($filter['from']) {}
		$res = false;
		
		$pop_conn = fsockopen($server, $port,$errno, $errstr, 10);
		$data = fgets($pop_conn,1024);
		$this->cms->debug($data,$this);
		if (preg_match("/\+OK/", $data))
			{
			//авторизация
			fputs($pop_conn,"USER ".$name."\r\n");
			$this->cms->debug($data,$this);
			$data = fgets($pop_conn,1024);
			if (preg_match("/\+OK/", $data))
				{
				//вводим пасс
				fputs($pop_conn,"PASS ".$pass."\r\n");
				$this->cms->debug($data,$this);
				$data = fgets($pop_conn,1024);
				if (preg_match("/\+OK/", $data))
					{
					
					}
				}
			}
		
		
		
		return $res;
		}*/
	/*===========================================================================================*/
	/*private function get_data($pop_conn)
		{
		$data="";
		while (!feof($pop_conn))
			{
			$buffer = chop(fgets($pop_conn,1024));
			$data .= "$buffer\r\n";
			if(trim($buffer) == ".") break;
			}
		return $data;
		}*/
	/*===========================================================================================*/
	/*===========================================================================================*/
	/*===========================================================================================*/
	/*===========================================================================================*/
	}
?>