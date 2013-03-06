<?php
	include "../../config/database.php";
	include "../../bin/scripts.php";

if ($_POST['predmet'] == "kontakt") {
	if ($_POST['action'] == "send") {
		// hlavičky správys
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-Type: text/plain; charset=utf-8\r\n";
		$headers .= "From: =?iso-8859-2?B?".base64_encode($_POST['jmeno'])."?= <".$_POST['email'].">\n"; 
		//$headers .= "To: ".ADMIN_MAIL."\n"; 
		$headers .= "Subject: =?iso-8859-2?B?".base64_encode("Dotaz ze stránky ".PAGE_NAME)."?=\n";
		//$headers .= "Date: ".Time()."\r\n";
		$headers .= "Reply-To: =?iso-8859-2?B?".base64_encode($_POST['jmeno'])."?= <".$_POST['email'].">\n";
		$headers .= "Return-Path: =?iso-8859-2?B?".base64_encode($_POST['jmeno'])."?= <".$_POST['email'].">\r\n"; 
		$headers .= "X-Priority: 2\n"; 
		$headers .= "X-MSMail-Priority: Normal\n";
		$headers .= "X-Mailer: PHP/".phpversion()."\n";
		$headers .= "Content-Transfer-Encoding: 8bit\r\n";
	    
		imap_mail("".ADMIN_MAIL."",
			"",
			$_POST['text'].
			"\n\ntelefon: ".$_POST['tel'],
			$headers
			);
		echo "Zpráva byla odeslána.";
	}
}
?>
<?php mysql_close(); ?>