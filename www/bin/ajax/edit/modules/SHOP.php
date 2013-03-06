<?php
		if ($_POST['action'] == "edit_menu_form") {
			$sql = "SELECT * FROM `shop_menu` WHERE `id` = ".$_POST['id']." LIMIT 1";
			$q = mysql_query($sql);
			if ($res = mysql_fetch_array($q)) {  
			?>
			<table class="edit_table">
				<tr>
					<th colspan="2">Editační formulář menu E-shopu</th>
				</tr>
				<tr>
					<td>název:</td>
					<td><input type="text" id="shop_menu_nazev_<?php echo $res['id']; ?>" value="<?php echo $res['nazev']; ?>" onkeyup="generujLink('shop_menu', <?php echo $res['id']; ?>)" class="table_input"></td>
				</tr>
				<tr>
					<td>odkaz <img src="/images/icons/info.png" width="10" height="10" alt="info" onmouseout="hideInfo();" onmouseover="showInfo(event, 'název důležitý pro stromovou struktůru v odkazu stránky (www.web.cz/polozka-menu/polozka-vevnitr/)');"> :</td>
					<td><input type="text" id="shop_menu_odkaz_<?php echo $res['id']; ?>" value="<?php echo $res['link']; ?>" class="table_input"></td>
				</tr>
				<tr>
					<td colspan="2"><input type="button" value="uložit" onclick="saveShop_menu(<?php echo $res['id']; ?>);" class="window_buton"></td>
				</tr>
			</table>
			<?php
			} else {
				echo "Taková položka kategorie E-shopu neexistuje!";
			}
		}
		if ($_POST['action'] == "edit_menu") {
			$nazev = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['nazev']);
			$link = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['link']);
			$sql = "UPDATE `shop_menu` SET `nazev` = '".$nazev."', `link` = '".$link."' WHERE `id` = ".$_POST['id']."";
			if ($q = mysql_query($sql)) {
				echo "Položka kategorie E-shopu byla úspěšně uložena.";
			} else {
				echo "Nastala chyba při ukládání položky kategorie E-shopu!";
			}
		}
		if ($_POST['action'] == "delete_menu") {
			$sql = "DELETE FROM `shop_menu` WHERE `id` = ".$_POST['id']."";
			if ($q = mysql_query($sql)) {
				echo "Položka menu e-shopu byla smazána.";
			}
		}
		if ($_POST['action'] == "add_menu") {
			$rand = mt_rand(1000, 9999);
			$sql = "INSERT INTO `shop_menu` VALUES(NULL, 'Nová kategorie', 'nova-kategorie-".$rand."', ".$_POST['parent'].")";
			if ($q = mysql_query($sql)) {
				$sql = "SELECT `id` FROM `shop_menu` WHERE `link` = 'nova-kategorie-".$rand."'";
				$q = mysql_query($sql);
				if ($res = mysql_fetch_array($q)) {
					echo $res['id'];
				}
			}
		}
		if ($_POST['action'] == "get_parent") {
			$sql = "SELECT `parent` FROM `shop_menu` WHERE `id` = ".$_POST['id']."";
			if ($q = mysql_query($sql)) {
				if ($res = mysql_fetch_array($q)) {
					echo $res['parent'];
				}
			}
		}
		if ($_POST['action'] == "save_produkt_popis") {
			$sql = "UPDATE `shop` SET `popis` = '".$_POST['text']."' WHERE `id` = ".$_POST['id']."";
			if ($q = mysql_query($sql)) {
				echo "Popis byl uložen.";
			}
		}
		if ($_POST['action'] == "set_produkt_show") {
			$sql = "UPDATE `shop` SET `show` = '".$_POST['show']."' WHERE `id` = ".$_POST['id']."";
			if ($q = mysql_query($sql)) {
				echo "Zobrazení bylo změněno.";
			}
		}
		if ($_POST['action'] == "set_produkt_doporucujeme") {
			$sql = "UPDATE `shop` SET `doporucujeme` = '".$_POST['doporucujeme']."' WHERE `id` = ".$_POST['id']."";
			if ($q = mysql_query($sql)) {
				echo "Doporučení bylo změněno.";
			}
		}
		if ($_POST['action'] == "set_produkt_nazev") {
			$text = $_POST['nazev'];
			$text = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $text);
			$sql = "UPDATE `shop` SET `nazev` = '".$text."' WHERE `id` = ".$_POST['id']."";
			if ($q = mysql_query($sql)) {
				echo "Název byl změněn.";
			}
		}
		if ($_POST['action'] == "set_produkt_cena") {
			$cena = $_POST['cena'];
			$dph = $_POST['dph'];
			$sql = "UPDATE `shop` SET `cena` = '".$cena."', `dph` = '".$dph."' WHERE `id` = ".$_POST['id']."";
			if ($q = mysql_query($sql)) {
				echo "Cena a DPH byly změněny.";
			}
		}
		if ($_POST['action'] == "set_produkt_skladem") {
			$skladem = $_POST['skladem'];
			$sql = "UPDATE `shop` SET `skladem` = '".$skladem."' WHERE `id` = ".$_POST['id']."";
			if ($q = mysql_query($sql)) {
				echo "Počet produktů skladem změněn.";
			}
		}
		if ($_POST['action'] == "set_produkt_vyrobce") {
			$text = $_POST['vyrobce'];
			$sql = "UPDATE `shop` SET `vyrobce` = '".$text."' WHERE `id` = ".$_POST['id']."";
			if ($q = mysql_query($sql)) {
				echo "Výrobce byl změněn.";
			}
		}
		if ($_POST['action'] == "naseptavac_vyrobce") {
			$sql = "SELECT DISTINCT `vyrobce` FROM `shop` WHERE `vyrobce` LIKE '".$_POST['vyrobce']."%' AND `vyrobce` != '".$_POST['vyrobce']."'";
			$q = mysql_query($sql);
			$text = "";
			while ($res = mysql_fetch_array($q)) {
				$text .= $res['vyrobce']."Đ";
			}
			echo $text;
		}
		if ($_POST['action'] == "set_produkt_code") {
			$text = $_POST['code'];
			$sql = "UPDATE `shop` SET `code` = '".$text."' WHERE `id` = ".$_POST['id']."";
			if ($q = mysql_query($sql)) {
				
				echo "Kód produktu byl změněn.";
			} else {
				echo "Takový kód již některý produkt má.";
			}
		}
		if ($_POST['action'] == "control_produkt_code") {
			$sql = "SELECT * FROM `shop` WHERE `code` = '".$_POST['code']."' AND `id` != ".$_POST['id']."";
			$q = mysql_query($sql);
			if ($res = mysql_fetch_array($q)) {
				echo "false";
			}
			echo $text;
		}
		if ($_POST['action'] == "get_categories") {
			echo "<option value=\"0\" selected>-</option>";
			$sql = "SELECT * FROM `shop_menu` WHERE `parent` = ".$_POST['parent']."";
			$q3 = mysql_query($sql);
			while ($res3 = mysql_fetch_array($q3)) {
				echo "<option value=\"".$res3['id']."\"".$sel.">".$res3['nazev']."</option>";
			}
		}
		if ($_POST['action'] == "set_produkt_category") {
			$text = $_POST['category'];
			$sql = "UPDATE `shop` SET `parent` = '".$text."' WHERE `id` = ".$_POST['id']."";
			if ($q = mysql_query($sql)) {
				echo "Kategorie byla změněna.";
			}
		}
		if ($_POST['action'] == "add_produkt") {
			$sql = "SELECT `code` FROM `shop`";
			$q = mysql_query($sql);
			$lastcode = 0;
			while ($res = mysql_fetch_array($q)) {
				$code = $res['code'];
				if ($code > $lastcode) {
					$lastcode = $code;
				}
			}
			$code = $lastcode + 1;
			$sql = "INSERT INTO `shop` VALUES(NULL, 'Nový produkt', '', 0, 19, 0, ".$_POST['parent'].", '".$code."', '', 0, 0)";
			$q = mysql_query($sql);
			$sql = "SELECT `id` FROM `shop` WHERE `code` = '".$code."'";
			$q = mysql_query($sql);
			if ($res = mysql_fetch_array($q)) {
				echo $res['id'];
			}
		}
		if ($_POST['action'] == "delete_produkt") {
			$sql = "DELETE FROM `shop` WHERE `id` = ".$_POST['id']."";
			if ($q = mysql_query($sql)) {
				echo "Produkt byl smazán.";
			}
		}
		if ($_POST['action'] == "delete_image") {
			$file = $_POST['file'];
			$fil = explode(".", $file);
			$id = $fil[0];
			$type = $fil[2];
			$poradi = $fil[1];
			unlink(PATH."/userfiles/shop/".$file);
			if ($poradi == 0) {
				$dir = dir(PATH."/userfiles/shop/");
				while ($file1 = $dir->read()) {    
					$find = preg_replace('/'.$id.'\.[0-9]+\.(png|jpg|gif)/', '$founded$', $file1);    
					if (strstr($find, '$founded$')) {
						$fil1 = explode(".", $file1);
						$type1 = $fil1[2];
						rename(PATH."/userfiles/shop/".$file1, PATH."/userfiles/shop/".$id.".0.".$type1);
						break;
					}
				}
			}
			echo "Obrázek byl smazán.";
		}
		if ($_POST['action'] == "set_head_image") {
			$file = $_POST['file'];
			$fil = explode(".", $file);
			$id = $fil[0];
			$type = $fil[2];
			$poradi = $fil[1];
			rename(PATH."/userfiles/shop/".$file, PATH."/userfiles/shop/temp");
			$dir = dir(PATH."/userfiles/shop/");
				while ($file1 = $dir->read()) {    
					$find = preg_replace('/'.$id.'\.0\.(png|jpg|gif)/', '$founded$', $file1);    
					if (strstr($find, '$founded$')) {
						$fil1 = explode(".", $file1);
						$type1 = $fil1[2];
						rename(PATH."/userfiles/shop/".$file1, PATH."/userfiles/shop/".$id.".".$poradi.".".$type1);
						break;
					}
				}
			rename(PATH."/userfiles/shop/temp", PATH."/userfiles/shop/".$id.".0.".$type);
			echo "Obrázek nastaven jako hlavní.";
		}
?>      
