<?php
	include "../../config/database.php";
	include "../../bin/scripts.php";

	if (@$_SESSION['auth'] == 1 || @$_SESSION['auth'] == 2) {
		if ($_POST['predmet'] == "odhlasit") {
			if ($_POST['action'] == "otazka") {
				?>
				Opravdu chcete odhlásit?<br>
				Jediné bezpečné odhlášení je zavření prohlížeče!
				<?php
			}
			if ($_POST['action'] == "odhlasit") {
				$_SESSION['auth'] = null;
				$_SESSION['user'] = null;
			}
		}
		if ($_POST['predmet'] == "admins") {
			if ($_POST['action'] == "edit_form") {
				echo "<table>";
				$sql = "SELECT * FROM `admin` ORDER BY `auth`";
				$q = mysql_query($sql);
				while ($res = mysql_fetch_array($q)) {
					echo "<tr>";
						if (@$_SESSION['auth'] == 1) {
							echo "<td>";
							if ($res['auth'] > 1) {
								echo "<a href=\"javascript: deleteAdmin(".$res['id'].");\"><img src=\"/images/icons/delete.png\" alt=\"delete\" class=\"delete\" /></a>";
							}
							echo "</td>";
						}
					echo "<td><a href=\"javascript: editAdmin(".$res['id'].");\">".$res['user']."</a></td>";
					echo "</tr>";
				}
				if (@$_SESSION['auth'] == 1) {
					echo "<tr><td><a href=\"javascript: addAdmin();\"><img src=\"/images/icons/add.png\" alt=\"add\" class=\"add\" /></a></td></tr>";
				}
				echo "</table>";
			}
			if ($_POST['action'] == "add") {
				if (@$_SESSION['auth'] == 1) {
					$rand = mt_rand(1000, 9999);
					$pass = mt_rand(10000, 99999);
					$sql = "INSERT INTO `admin` VALUES(NULL, 'user$rand', '$pass', 2)";
					$q = mysql_query($sql);
					$sql = "SELECT * FROM `admin` WHERE `user` = 'user$rand'";
					$q = mysql_query($sql);
					$res = mysql_fetch_array($q);
					echo $res['id'];
				}
			}
			if ($_POST['action'] == "delete") {
				$sql = "DELETE FROM `admin` WHERE `id` = ".$_POST['id']."";
				$q = mysql_query($sql);
				echo "Administrátor smazán!";
			}
			if ($_POST['action'] == "edit") {
				if (@$_SESSION['auth'] == 1) {
					$sql = "SELECT * FROM `admin` WHERE `id` = ".$_POST['id']."";
					$q = mysql_query($sql);
					if ($res = mysql_fetch_array($q)) {
						?>
						<table>
							<tr>
								<td>
									username:
								</td>
								<td>
									<input type="text" value="<?php echo $res['user']; ?>" id="username_<?php echo $res['id']; ?>">
								</td>
							</tr>
							<tr>
								<td>
									password:
								</td>
								<td>
									<input type="text" value="<?php echo $res['pass']; ?>" id="password_<?php echo $res['id']; ?>">
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input type="button" value="uložit" onclick="saveAdmin(<?php echo $res['id']; ?>)">
								</td>
							</tr>
						</table>
						<?php
					}
				} else {
					echo "Nemáte právo editovat administrátory!";
				}
			}
			if ($_POST['action'] == "edited") {
				if (@$_SESSION['auth'] == 1) {
					$sql = "UPDATE `admin` SET `user` = '".$_POST['user']."', `pass` = '".$_POST['pass']."' WHERE `id` = ".$_POST['id']."";
					$q = mysql_query($sql);
					echo "Přihlašovací údaje byly změněny.";
				}
				
			}
		}
		if ($_POST['predmet'] == "pages") {
			if ($_POST['action'] == "get_names") {
				$sql = "SELECT * FROM `menu` WHERE `id` = ".$_POST['page']."";
				$q = mysql_query($sql);
				$res = mysql_fetch_array($q);
				$sql = "SELECT * FROM `menu_in` WHERE `href` = ".$_POST['sub_page']."";
				$q2 = mysql_query($sql);
				$res2 = @mysql_fetch_array($q2);
				echo @$res['name']." &gt; ".@$res2['name'];
			}
		}
		if ($_POST['predmet'] == "titulek") {
			if ($_POST['action'] == "save") {
				$text = $_POST['text'];
				$text = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $text);
				$sql = "UPDATE `html` SET `content` = '".$text."' WHERE `parent` = -3";
				if ($q = mysql_query($sql)) {
					echo "Titulek stránky změněn.";
				}
			}
		}
	} else {
		echo "Nemáte právo pro administraci!";
	}
?>
<?php mysql_close(); ?>