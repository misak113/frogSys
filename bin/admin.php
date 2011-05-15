<?php
	header("Content-Type: text/html; charset=utf-8");
	header("Pragma: no-cache");
	header("Cache-Control: no-cache,must-revalidate,max_age=0");
	header("Expires: 0");
	Header("WWW-Authenticate: Basic realm=\"Administrace\"");
	
	$user = $_SERVER["PHP_AUTH_USER"];
	$pass = $_SERVER["PHP_AUTH_PW"];
	require_once "../../config/database.php";
	
	$sql = "SELECT * FROM `admin` WHERE `auth` = 1";
	$q = mysql_query($sql);
	if (!($res = mysql_fetch_array($q))) {
		$sql = "INSERT INTO `admin` VALUES(NULL, 'root', 'root', 1)";
		$q = mysql_query($sql);
	}
	
	$spravne = true;
	$sql = "SELECT * FROM `admin` WHERE `user` = '".$user."' LIMIT 1";
	$q = mysql_query($sql);
	if ($res = mysql_fetch_array($q)) {
		if ($pass == $res['pass']) {
			session_start();
			$_SESSION['auth'] = $res['auth'];
			$_SESSION['user'] = $res['user'];
			Header('Location: '.URL);
		} else {
			echo "Zadáno špatné heslo!";
			$spravne = false;
		}
	} else {
		echo "Takový uživatel neexistuje!";
		$spravne = false;
	}

	if ($spravne == false) {
 		//Header("HTTP/1.0 401 unauthorized");
		echo "Přístup byl odepřen!";
		exit;
	}
	
?>
<?php mysql_close(); ?>