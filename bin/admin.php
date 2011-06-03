<?php
<<<<<<< HEAD
header("Content-Type: text/html; charset=utf-8");
header("Pragma: no-cache");
header("Cache-Control: no-cache,must-revalidate,max_age=0");
header("Expires: 0");

require_once "../../config/database.php";
require_once PATH . '/frogSys/bin/scripts.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="Přihlašovací stránka administrační části frogSys" />
        <meta name="keywords" content="frogSys, Administrace" />
        <meta name="copyright" content="2011, Avantcore media" />
        <meta name="author" content="Michael Žabka" />
        <meta name="robots" content="index, follow" />
        <meta name="RS" content="frogSys" />
        <meta name="version" content="<?php include PATH . "/frogSys/version.txt"; ?>" />
        <title>frogSys - Administrační část</title>
        <link rel="shortcut icon" href="<?php echo URL; ?>favicon.ico" />
        <link rel="icon" href="<?php echo URL; ?>favicon.ico" type="image/vnd.microsoft.icon" />

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript">
            jQuery.noConflict();
        </script>

        <script src="<?php echo URL; ?>frogSys/js/functions.js" type="text/javascript"></script>
        <script src="<?php echo URL; ?>frogSys/js/IAWindows.js" type="text/javascript"></script>
        <link rel="stylesheet" href="<?php echo URL; ?>frogSys/css/window.css" type="text/css" />

        <link rel="stylesheet" href="<?php echo URL; ?>frogSys/css/admin.css" type="text/css" />

        <script type="text/javascript">
            jQuery("body").ready(function () {
                jQuery("body").css("background-image", "url('<?php echo URL; ?>frogSys/images/rs/auth_bg"+Math.ceil(Math.random()*3)+".jpg')");
            });
        </script>

    </head>
    <body>

        <div id="login">
        <?php
        $sql = "SELECT * FROM `admin` WHERE `auth` = 1";
        $q = mysql_query($sql);
        if (!($res = mysql_fetch_array($q))) {
            $sql = "INSERT INTO `admin` VALUES(NULL, 'root', 'root', 1)";
            $q = mysql_query($sql);
        }

        if (isset($_POST['login'])) {
            $sql = "SELECT * FROM `admin` WHERE `user` = '" . $_POST['username'] . "' LIMIT 1";
            $q = mysql_query($sql);
            if ($res = mysql_fetch_array($q)) {
                if ($_POST['password'] == $res['pass']) {
                    //session_start();
                    $_SESSION['auth'] = $res['auth'];
                    $_SESSION['user'] = $res['user'];
                    //Header('Location: '.URL);
                    echo '<script type="text/javascript">document.location.href = "' . URL . '";</script>';
                } else {
                    echo "<div class=\"message\">Zadáno špatné heslo!</div>";
                }
            } else {
                echo "<div class=\"message\">Takový uživatel neexistuje!</div>";
            }
        }


        echo '<form action="' . URL . 'admin" method="post">
            <table>';
        echo '<tr><td class="label">Uživatelské jméno:</td><td><input class="text" type="text" name="username" /></td></tr>';
        echo '<tr><td class="label">Heslo:</td><td><input class="text" type="password" name="password" /></td></tr>';
        echo '<tr><td colspan="2"><input type="submit" name="login" value="Přihlásit" /></td></tr>';

        echo '</table>
            </form>';
        ?>
        
            <div id="frogSys">
                <img src="<?php echo URL; ?>frogSys/images/rs/logo_frogSys.png" alt="frogSys" /><br />
                <p>version: <?php include PATH."/frogSys/version.txt"; ?></p>
            </div>
        </div>
    </body>
</html>

=======
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
>>>>>>> a206266de26ca4d13d6c2fc157715fc98aa0e227
<?php mysql_close(); ?>