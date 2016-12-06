<?php
class ajax_login_cont
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
		if ($_POST['act'] == 'dologin')
			{
			$res = "no";
			$errors_html = "";
			if ($_POST['g-recaptcha-response'] == "") 
				{$errors_html .= "Введите каптчу<br />";} 
			else 
				{
				$res = "no";
				$errors_html = "";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
				curl_setopt ($ch, CURLOPT_HEADER, 0);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
				curl_setopt($ch, CURLOPT_REFERER, "http://gos-poshlina.ru/");
				curl_setopt( $ch, CURLOPT_ENCODING, "UTF-8" );
				curl_setopt ($ch, CURLOPT_POST, true);
				curl_setopt ($ch, CURLOPT_POSTFIELDS, "secret=6LfAsCkTAAAAAKsJpDOyt-tsMrFrYV6Gf4bNTm9J&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
				$checkcaptcha = curl_exec($ch);
				curl_close($ch);
				$ccheck = json_decode($checkcaptcha,true);
				if ($ccheck['success'] !== true) {$errors_html .= "Проверьте каптчу<br />";}
				}
			if ($errors_html == "")
				{
				if (!($UID = $this->cms->users->getUID($_POST['useremail'],$_POST['userpass'])))
					{
					$errors_html = "Ошибка авторизации";
					}
				}
			if ($errors_html == "")
				{
				$this->cms->sessions->set_session_UID($UID);
				$res = "yes";
				$out = array("ok"=>"yes");
				}
			else
				{
				$out = array("ok"=>"no","errors"=>$errors_html);
				}
			echo json_encode($out);				
			}
		elseif ($_POST['act'] == 'dologout')
			{
			$this->cms->sessions->set_session_UID(0);
			}
		}
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	
	/*===========================================================================================*/
	}
?>
