<?php
			if ($_POST['action'] == "delete") {
				$sql = "DELETE FROM `menu` WHERE `id` = ".$_POST['id']."";
				if ($q = mysql_query($sql)) {
					$sql = "SELECT * FROM `page` WHERE `parent` = ".$_POST['id']."";
					$q = mysql_query($sql);
					while ($res = mysql_fetch_array($q)) {
						$sql = "SELECT * FROM `page_parts` WHERE `id` = ".$res['first']." LIMIT 1";
						$q2 = mysql_query($sql);
						$res2 = mysql_fetch_array($q2);
						//deletePageIfEmpty($res2['type'], $res2['id']);
					}
					$sql = "DELETE FROM `page` WHERE `parent` = ".$_POST['id']."";
					mysql_query($sql);
					echo "Položka menu byla smazána.";
				} else {
					echo "Při mazání položky došlo k chybě!";
				}
			}
			if ($_POST['action'] == "edit_form") {
				$sql = "SELECT * FROM `menu` WHERE `id` = ".$_POST['id']." LIMIT 1";
				$q = mysql_query($sql);
				if ($res = mysql_fetch_array($q)) {
				?>
				<table class="edit_table">
					<tr>
						<th colspan="2">Editační formulář menu</th>
					</tr>
					<tr>
						<td>název:</td>
						<td>
							<textarea id="menu_nazev_<?php echo $res['id']; ?>" onkeyup="generujLink('menu', <?php echo $res['id']; ?>)" class="table_input"><?php echo $res['name']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td>odkaz <img src="<?php echo URL; ?>frogSys/images/icons/info.png" width="10" height="10" alt="info" onmouseout="hideInfo();" onmouseover="showInfo(event, 'Ve většině případů neuvádějte. Generuje se sám (např.: nazev-stranky). Název důležitý pro stromovou struktůru v odkazu stránky (www.web.cz/polozka-menu/polozka-vevnitr/)');">:</td>
						<td><input type="text" id="menu_odkaz_<?php echo $res['id']; ?>" value="<?php echo $res['link']; ?>" class="table_input"></td>
					</tr>
					<tr>
						<td>schovaný:</td>
						<td><input type="checkbox" id="menu_hide_<?php echo $res['id']; ?>"<?php
							if ($res['visible'] == 0) {
								echo "checked";
							}
						?>></td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="uložit" onclick="saveMenu(<?php echo $res['id']; ?>);" class="window_buton"></td>
					</tr>
				</table>
				<?php
				} else {
					echo "Taková položka menu neexistuje!";
				}
			}
			if ($_POST['action'] == "edit") {
                                $link = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['link']);
				$name = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['name']);
				$sql = "SELECT * FROM `menu` WHERE `id` = ".$_POST['id']."";
                                $q = mysql_query($sql);
                                $relink = "";
                                if ($res = mysql_fetch_array($q)) {
                                    $sql = "SELECT * FROM `menu` WHERE `parent` = ".$res['parent']." AND `link` = '".$link."' AND `id` <> ".$_POST['id']."";
                                    $q = mysql_query($sql);
                                    if ($res = mysql_fetch_array($q)) {
                                        $link = $link."-".$_POST['id'];
                                        $relink = "<br>Byl zjištěn duplicitní 'link', proto byl nahrazen za '".$link."'";
                                    }
                                }

				$sql = "UPDATE `menu` SET `name` = '".$name."', `link` = '".$link."', `visible` = '".$_POST['visible']."' WHERE `id` = ".$_POST['id']."";
				if ($q = mysql_query($sql)) {
					echo "Položka menu byla úspěšně uložena. ".$relink;
				} else {
					echo "Nastala chyba při ukládání položky menu!";
				}
			}
			if ($_POST['action'] == "sort") {
				$sql = "SELECT `parent` FROM `menu` WHERE `id` = '".$_POST['id']."' LIMIT 1";
				$q = mysql_query($sql);
				$res = mysql_fetch_array($q);
				$parent = $res['parent'];
				$sql = "SELECT `order` AS target, `parent` FROM `menu` WHERE `id` = '".$_POST['change_with']."' LIMIT 1";
				if ($_POST['change_with'] == "") {
					$sql = "SELECT (MAX(`order`)+1) AS target FROM `menu` WHERE `parent` = ".$parent." LIMIT 1";
				}
				$q = mysql_query($sql);
				if ($res = mysql_fetch_array($q)) {
					$target = $res['target']-1;
					$sql = "SELECT * FROM `menu` WHERE `id` = '".$_POST['id']."' LIMIT 1";
					$q = mysql_query($sql);
					if ($res = mysql_fetch_array($q)) {
						$from = $res['order'];
						if ($target > $from) {
							$sql = "UPDATE `menu` SET `order` = `order`-1 WHERE `order` >= $from AND `order` <= $target AND `parent` = ".$parent."";
							$q = mysql_query($sql);
							$sql = "UPDATE `menu` SET `order` = ".$target." WHERE `id` = ".$_POST['id']."";
							$q = mysql_query($sql);
							echo "Úspěšně přesunuta položka menu.";
						}
						if ($target < $from) {
							$sql = "UPDATE `menu` SET `order` = `order`+1 WHERE `order` >= ".($target+1)." AND `order` <= $from AND `parent` = ".$parent."";
							$q = mysql_query($sql);
							$sql = "UPDATE `menu` SET `order` = ".($target+1)." WHERE `id` = ".$_POST['id']."";
							$q = mysql_query($sql);
							echo "Úspěšně přesunuta položka menu.";
						}
						if ($target == $from) {
							echo "Položky menu nebyly přesunuty.";
						}
					} else {
						echo "Nastala chyba při přemisťování položky menu!";
					}
				} else {
					echo "Nastala chyba při přemisťování položky menu!";
				}
			}
			if ($_POST['action'] == "add") {
				$sql = "SELECT MAX(`order`) AS ord FROM `menu` WHERE `parent` = ".$_POST['id']."";
				$q = mysql_query($sql);
				if ($res = mysql_fetch_array($q)) {
					$rand = mt_rand(1000, 9999);
					$novyOrder = $res['ord'];
					$sql = "INSERT INTO `menu` VALUES(NULL, 'Nová položka', ".$_POST['id'].", ".($novyOrder+1).", 'polozka-menu-$rand', 1)";
					$q = mysql_query($sql);
					$sql = "SELECT * FROM `menu` WHERE `link` = 'polozka-menu-$rand'";
					$q = mysql_query($sql);
					if ($res = mysql_fetch_array($q)) {
						$menu_id = $res['id'];
						echo $res['id'];
					}
				
				
				
				
					$rand = mt_rand(1000, 9999);
					$sql = "INSERT INTO `page_parts` VALUES(NULL, '".$rand."')";
					$q = mysql_query($sql);
					$sql = "SELECT * FROM `page_parts` WHERE `type` = '".$rand."'";
					$q = mysql_query($sql);
					if ($res = mysql_fetch_array($q)) {
						$sql = "INSERT INTO `page` VALUES(NULL, ".$res['id'].", 100, ".$menu_id.", 1)";
						$q = mysql_query($sql);
						$sql = "UPDATE `page_parts` SET `type` = 'HTML' WHERE `id` = ".$res['id']."";
						$q = mysql_query($sql);
						$sql = "INSERT INTO `html` VALUES(NULL, '<p>Obsah stránky</p>', ".$res['id'].", 1, 1)";
						$q = mysql_query($sql);
					}
				}
				
				
			}
?>
