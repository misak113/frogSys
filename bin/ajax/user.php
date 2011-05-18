<?php
	require_once "../../../config/database.php";
	include "../../bin/scripts.php";

if ($_POST['predmet'] == "kontakt") {
	if ($_POST['action'] == "send") {
		//$headers = get_mail_header("Dotaz ze stránky ".PAGE_NAME, $_POST['jmeno'], $_POST['email']);

		/*imap_mail("".ADMIN_MAIL."",
			"",
			$_POST['text'].
			"\n\ntelefon: ".$_POST['tel'],
			$headers
			);*/
                $text = $_POST['text'].
			"\n\ntelefon: ".$_POST['tel'];
                 $message = Swift_Message::newInstance()
                            //Give the message a subject
                            ->setSubject("Dotaz ze stránky ".PAGE_NAME)
                            //Set the From address with an associative array
                            ->setFrom(array($_POST['email'] => $_POST['jmeno']))
                            //Set the To addresses with an associative array
                            ->setTo(array(ADMIN_MAIL))
                            //Give it a body
                            //->setBody('Here is the message itself')
                            //And optionally an alternative body
                            ->addPart($text, 'text/html')
                            //Optionally add any attachments
                            //->attach(Swift_Attachment::fromPath('my-document.pdf'))
                    ;
		echo "Zpráva byla odeslána.";
	}
}
if (isset($_POST['add_product'])) {
	if (isset($_POST['pocet'])) {
		$pocet = $_POST['pocet'];
	} else {
		$pocet = 1;
	}
	$sql = "SELECT * FROM `shop_kosik` WHERE `user` = ".USER_ID." AND `id_produkt` = ".$_POST['add_product']."";
	$q = mysql_query($sql);
	if ($res = mysql_fetch_array($q)) {
		$sql = "UPDATE `shop_kosik` SET `pocet` = `pocet`+$pocet WHERE `id` = ".$res['id']."";
		$q = mysql_query($sql);
	} else {
		$sql = "INSERT INTO `shop_kosik` VALUES(NULL, ".$_POST['add_product'].", $pocet, ".USER_ID.")";
		$q = mysql_query($sql);
	}
	$url = $_POST['url_back'];
	//header("Location: $url?add_product=1");
        echo '<script type="text/javascript">document.location.href="'.$url.'?add_product=1";</script>
            <a href="'.$url.'?add_product=1">Pokračujte zde</a>';
}
if ($_POST['predmet'] == "diskuse") {
    if ($_POST['action'] == "add_prispevek") {
        $text = substr(str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['text']), 0, 2000);
	$user = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['user']);
        $sql = "SELECT * FROM `users` WHERE `id` = ".USER_ID."";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            if ($res['jmeno'] == "" && $res['prijmeni'] == "") {
                $jm = explode(" ", $user);
                $sql = "UPDATE `users` SET `jmeno` = '".$jm[0]."', `prijmeni` = '".@$jm[1]."' WHERE `id` = ".USER_ID."";
                mysql_query($sql);
            }
        }
        $user = substr($user, 0, 15);
	$sql = "INSERT INTO `diskuse` VALUES(NULL, '".$text."', ".$_POST['page_part'].", '$user <span class=\"diskuse_ip\">(".$_SERVER['REMOTE_ADDR'].")</span>', NOW())";
        mysql_query($sql);
    }

}


?>
<?php mysql_close(); ?>