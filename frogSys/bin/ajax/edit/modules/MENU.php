<?php
			if ($_POST['action'] == "add") {
				$sql = "SELECT MAX(`order`) AS ord FROM `menu_in` WHERE `parent` = ".$_POST['parent']."";
				$q = mysql_query($sql);
				if ($res = mysql_fetch_array($q)) {
					$novyOrder = $res['ord'];
					$rand = mt_rand(1000, 9999);
					$sql = "INSERT INTO `page_parts` VALUES(NULL, '".$rand."')";
					$q2 = mysql_query($sql);
					$sql = "SELECT * FROM `page_parts` WHERE `type` = '".$rand."'";
					$q2 = mysql_query($sql);
					if ($res2 = mysql_fetch_array($q2)) {
						$href = $res2['id'];
					}
					$sql = "SELECT * FROM `page` WHERE `first` = '".$_POST['parent']."'";
					$q3 = mysql_query($sql);
					$res3 = mysql_fetch_array($q3);
                                        if ($res3) {
                                            $paree = $res3['parent'];
                                            $sql = "SELECT * FROM `page` WHERE `first` <> '".$_POST['parent']."' AND `parent` = ".$paree."";
                                            $q4 = mysql_query($sql);
                                            if ($res4 = mysql_fetch_array($q4)) {
                                                    $targ = $res4['id'];
                                            } else {
                                                    $targ = $res3['id'];
                                            }
                                        } else {
                                            $sql = "SELECT * FROM `menu_in` WHERE `href` = '".$_POST['parent']."'";
                                            $q3 = mysql_query($sql);
                                            if ($res3 = mysql_fetch_array($q3)) {
                                                $targ = $res3['target'];
                                            }
                                        }
					
					$sql = "INSERT INTO `menu_in` VALUES(NULL, 'Nová položka', ".$targ.", ".$href.", ".$_POST['parent'].", ".($novyOrder+1).", 'polozka-menu-$rand')";
					$q = mysql_query($sql);
					$sql = "SELECT * FROM `menu_in` WHERE `link` = 'polozka-menu-$rand' AND `parent` = ".$_POST['parent']."";
					$q = mysql_query($sql);
					if ($res = mysql_fetch_array($q)) {
							echo $res['id'];
					}
				}
			}
			if ($_POST['action'] == "delete") {
				$sql = "SELECT * FROM `menu_in` WHERE `id` = ".$_POST['id']."";
				$q = mysql_query($sql);
				if ($res = mysql_fetch_array($q)) {
					$sql = "SELECT * FROM `page_parts` WHERE `id` = ".$res['href']."";
					$q2 = mysql_query($sql);
					$res2 = mysql_fetch_array($q2);
					deletePageIfEmpty($res2['type'], $res2['id']);
				}
				$sql = "DELETE FROM `menu_in` WHERE `id` = ".$_POST['id']."";
				if ($q = mysql_query($sql)) {
					echo "Položka menu byla smazána.";
				} else {
					echo "Při mazání položky došlo k chybě!";
				}
				
			}
			if ($_POST['action'] == "edit_form") {
				$sql = "SELECT * FROM `menu_in` WHERE `id` = ".$_POST['id']." LIMIT 1";
				$q = mysql_query($sql);
				if ($res = mysql_fetch_array($q)) {
				?>
				<table class="edit_table">
					<tr>
						<th colspan="2">Editační formulář menu</th>
					</tr>
					<tr>
						<td>název:</td>
						<td><input type="text" id="menu_in_nazev_<?php echo $res['id']; ?>" value="<?php echo $res['name']; ?>" onkeyup="generujLink('menu_in', <?php echo $res['id']; ?>)" class="table_input"></td>
					</tr>
					<tr>
						<td>odkaz <img src="<?php echo URL; ?>frogSys/images/icons/info.png" width="10" height="10" alt="info" onmouseout="hideInfo();" onmouseover="showInfo(event, 'Ve většině případů neuvádějte. Generuje se sám (např.: nazev-stranky). Název důležitý pro stromovou struktůru v odkazu stránky (www.web.cz/polozka-menu/polozka-vevnitr/)');">:</td>
						<td><input type="text" id="menu_in_odkaz_<?php echo $res['id']; ?>" value="<?php echo $res['link']; ?>" class="table_input"></td>
					</tr>
					<tr>
						<td>Cíl odkazu:</td>
						<td>
							pro změnu sloupce, ve kterém se bude stránka zobrazovat, klikněte na záhlaví onoho sloupce.
						</td>
					</tr>
					<tr>
						<td>Odkazovaná stránka:</td>
						<td>
							<input type="button" value="změnit" onclick="hrefingMenu_in(<?php echo $res['id']; ?>);" />
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="button" value="uložit" onclick="saveMenu_in(<?php echo $res['id']; ?>);" class="window_buton"></td>
					</tr>
				</table>
				<input type="hidden" id="menu_in_target_<?php echo $res['id']; ?>" value="<?php echo $res['target']; ?>">
				<input type="hidden" id="menu_in_href_<?php echo $res['id']; ?>" value="<?php echo $res['href']; ?>">
				<?php
				} else {
					echo "Taková položka menu neexistuje!";
				}
			}
			if ($_POST['action'] == "edit") {
				$sql = "SELECT * FROM `menu_in` WHERE `id` = ".$_POST['id']."";
				$q = mysql_query($sql);
				$res = mysql_fetch_array($q);
				if ($_POST['href'] != $res['href']) {
					$sql = "SELECT * FROM `page_parts` WHERE `id` = ".$res['href']."";
					$q = mysql_query($sql);
					$res = mysql_fetch_array($q);
					deletePageIfEmpty($res['type'], $res['id']);
				}
				$name = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['name']);
				$link = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['link']);

                                $sql = "SELECT * FROM `menu_in` WHERE `id` = ".$_POST['id']."";
                                $q = mysql_query($sql);
                                if ($res = mysql_fetch_array($q)) {
                                    $sql = "SELECT * FROM `menu_in` WHERE `parent` = ".$res['parent']." AND `link` = '".$link."' AND `id` <> ".$_POST['id']."";
                                    $q = mysql_query($sql);
                                    if ($res = mysql_fetch_array($q)) {
                                        $link = $link."-".$_POST['id'];
                                        $relink = "<br>Byl zjištěn duplicitní 'link', proto byl nahrazen za '".$link."'";
                                    }
                                }

				$sql = "UPDATE `menu_in` SET `name` = '".$name."', `link` = '".$link."', `href` = '".$_POST['href']."', `target` = '".$_POST['target']."' WHERE `id` = ".$_POST['id']."";
				if ($q = mysql_query($sql)) {
					echo "Položka menu byla úspěšně uložena. ".$relink;
				} else {
					echo "Nastala chyba při ukládání položky menu!";
				}
			}
			
			if ($_POST['action'] == "sort") {
				$sql = "SELECT `parent` FROM `menu_in` WHERE `id` = '".$_POST['id']."' LIMIT 1";
				$q = mysql_query($sql);
				$res = mysql_fetch_array($q);
				$parent = $res['parent'];
				$sql = "SELECT `order` AS target FROM `menu_in` WHERE `id` = '".$_POST['change_with']."' LIMIT 1";
				if ($_POST['change_with'] == "") {
					$sql = "SELECT (MAX(`order`)+1) AS target FROM `menu_in` WHERE `parent` = ".$parent." LIMIT 1";
				}
				$q = mysql_query($sql);
				if ($res = mysql_fetch_array($q)) {
					$target = $res['target']-1;
					$sql = "SELECT * FROM `menu_in` WHERE `id` = '".$_POST['id']."' LIMIT 1";
					$q = mysql_query($sql);
					if ($res = mysql_fetch_array($q)) {
						$from = $res['order'];
						if ($target > $from) {
							$sql = "UPDATE `menu_in` SET `order` = `order`-1 WHERE `order` >= $from AND `order` <= $target AND `parent` = $parent";
							$q = mysql_query($sql);
							$sql = "UPDATE `menu_in` SET `order` = ".$target." WHERE `id` = ".$_POST['id']."";
							$q = mysql_query($sql);
							echo "Úspěšně přesunuta položka menu.";
						}
						if ($target < $from) {
							$sql = "UPDATE `menu_in` SET `order` = `order`+1 WHERE `order` >= ".($target+1)." AND `order` <= $from AND `parent` = $parent";
							$q = mysql_query($sql);
							$sql = "UPDATE `menu_in` SET `order` = ".($target+1)." WHERE `id` = ".$_POST['id']."";
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
?>
