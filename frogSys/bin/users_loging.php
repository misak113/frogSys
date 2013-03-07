<?php
	if (isset($_COOKIE['user_hash'])) {
		$hash = $_COOKIE['user_hash'];
		$sql = "SELECT * FROM `users` WHERE `hash` = '".$hash."'";
		$q = mysql_query($sql);
		if ($res = mysql_fetch_array($q)) {
			$sql = "UPDATE `users` SET `last` = NOW(), `ip` = '".$_SERVER['REMOTE_ADDR']."' WHERE `hash` = '".$hash."'";
			$q = mysql_query($sql);
		} else {
			$sql = "INSERT INTO `users` VALUES(NULL, '$hash', '', '', '', '', '', '', '', '', NOW(), '".$_SERVER['HTTP_USER_AGENT']."', '".$_SERVER['REMOTE_ADDR']."', NULL)";
			$q = mysql_query($sql);
		}
	} else {
		$hash = hash("md5", mt_rand(1000000000, 9999999999));
		$sql = "INSERT INTO `users` VALUES(NULL, '$hash', '', '', '', '', '', '', '', '', NOW(), '".$_SERVER['HTTP_USER_AGENT']."', '".$_SERVER['REMOTE_ADDR']."', NULL)";
		$q = mysql_query($sql);
		setcookie("user_hash", $hash, time()+60*60*24*365*10, '/');
	}
	$sql = "SELECT `id` FROM `users` WHERE `hash` = '$hash'";
	$q = mysql_query($sql);
	if ($res = mysql_fetch_array($q)) {
		define("USER_ID", $res['id']);
	} else {
            define("USER_ID", mt_rand(100000000, 999999999));
        }

        if (!isset($_COOKIE['vysledky_sezona'])) {
            define("VYSL_SEZONA", date("Y"));
        } else {
            define("VYSL_SEZONA", $_COOKIE['vysledky_sezona']);
        }
        setCookie("vysledky_sezona", VYSL_SEZONA, time()+60*60*2, '/');
        
?>
