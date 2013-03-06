<?php
			if ($_POST['action'] == "add_part") {
				$pocet = 0;
				$sql = "SELECT COUNT(*) AS pocet FROM `page` WHERE `parent` = ".$_POST['parent']."";
				$q = mysql_query($sql);
				if ($res = mysql_fetch_array($q)) {
					$pocet = $res['pocet'];
					$sql = "UPDATE `page` SET `width` = `width`*".(1-1/($pocet+1))." WHERE `parent` = ".$_POST['parent']."";
					$q = mysql_query($sql);
					$width = 0;
					$maxOrder = 0;
					$sql = "SELECT * FROM `page` WHERE `parent` = ".$_POST['parent']."";
					$q = mysql_query($sql);
					while($res = mysql_fetch_array($q)) {
						$width += $res['width'];
						if ($res['order'] > $maxOrder) {
							$maxOrder = $res['order'];
						}
					}
					$rand = mt_rand(1000, 9999);
					$sql = "INSERT INTO `page_parts` VALUES(NULL, '".$rand."')";
					$q = mysql_query($sql);
					$sql = "SELECT * FROM `page_parts` WHERE `type` = '".$rand."'";
					$q = mysql_query($sql);
					if ($res = mysql_fetch_array($q)) {
						$sql = "INSERT INTO `page` VALUES(NULL, ".$res['id'].", ".(100-$width).", ".$_POST['parent'].", ".($maxOrder+1).")";
						$q = mysql_query($sql);
						echo "Nový sloupec byl vložen vpravo.";
					}
				}
			}
			if ($_POST['action'] == "delete_part") {
				$sql = "SELECT * FROM `page` WHERE `id` = ".$_POST['id']." LIMIT 1";
				$q = mysql_query($sql);
				if ($res = mysql_fetch_array($q)) {
					$sql = "SELECT * FROM `page_parts` WHERE `id` = ".$res['first']."";
					$q2 = mysql_query($sql);
					$res2 = mysql_fetch_array($q2);
					deletePageIfEmpty($res2['type'], $res2['id']);
					$sql2 = "SELECT COUNT(*) AS pocet FROM `page` WHERE `parent` = ".$res['parent']."";
					$q2 = mysql_query($sql2);
					$res2 = mysql_fetch_array($q2);
					$pocet = $res2['pocet']-1;
					if ($pocet != 0) {
						$sql3 = "UPDATE `page` SET `width` = `width`+".($res['width']/$pocet)." WHERE `parent` = ".$res['parent']."";
						$q3 = mysql_query($sql3);
						$sql4 = "UPDATE `page` SET `order` = `order`-1 WHERE `parent` = ".$res['parent']." AND `order` > ".$res['order']."";
						$q4 = mysql_query($sql4);
					}
					$sql5 = "DELETE FROM `page` WHERE `id` = ".$_POST['id']."";
					if ($q5 = mysql_query($sql5)) {
						$width = 0;
						$maxOrder = 0;
						$sql6 = "SELECT * FROM `page` WHERE `parent` = ".$res['parent']." ORDER BY `order` DESC";
						$q6 = mysql_query($sql6);
						$xx = false;
						while($res6 = mysql_fetch_array($q6)) {
							if ($xx == true) {
								$width += $res6['width'];
							}
							$xx = true;
							if ($res6['order'] > $maxOrder) {
								$maxOrder = $res6['order'];
							}
						}
						$sql = "UPDATE `page` SET `width` = ".(100-$width)." WHERE `parent` = ".$res['parent']." AND `order` = ".$maxOrder."";
						$q = mysql_query($sql);
						echo "Sloupec byl smazán.";
					} else {
						echo "Při mazání sloupce došlo k chybě!";
					}
				} else {
					echo "Při mazání sloupce došlo k chybě!";
				}
			}
			if ($_POST['action'] == "change_type_form") {
				?>
				<table class="edit_table">
					<tr>
						<th>Změna typu stránky</th>
					</tr>
					<tr>
						<td>Vyberte typ stránky kliknutím na něj a klikněte na uložit</td>
					</tr>
					<tr>
						<?php 
							$sql = "SELECT * FROM `page_parts` WHERE `id` = ".$_POST['id']."";
							$q = mysql_query($sql);
							if ($res = mysql_fetch_array($q)) {
						?>
						<td>
							<input type="hidden" id="page_type" value="<?php echo $res['type']; ?>" class="table_input">
							<a href="javascript: nastavType('HTML', 'page_html'); saveTypeChange(<?php echo $res['id']; ?>);">
								<img src="/images/modules/HTML.png" alt="HTML stránka" class="page_typy" id="page_html" width="80" height="50">
							</a>
							<a href="javascript: nastavType('MENU', 'page_menu_in'); saveTypeChange(<?php echo $res['id']; ?>);">
								<img src="/images/modules/MENU.png" alt="interní menu" class="page_typy" id="page_menu_in" width="80" height="50">
							</a>
							<a href="javascript: nastavType('SMAP', 'page_sitemap'); saveTypeChange(<?php echo $res['id']; ?>);">
								<img src="/images/modules/SMAP.png" alt="mapa webu" class="page_typy" id="page_sitemap" width="80" height="50">
							</a>
							<a href="javascript: nastavType('PLAK', 'page_plan_akci'); saveTypeChange(<?php echo $res['id']; ?>);">
								<img src="/images/modules/PLAK.png" alt="plán akcí" class="page_typy" id="page_plan_akci" width="80" height="50">
							</a>
							<a href="javascript: nastavType('SHOP', 'page_shop'); saveTypeChange(<?php echo $res['id']; ?>);">
								<img src="/images/modules/SHOP.png" alt="E-shop" class="page_typy" id="page_shop" width="80" height="50">
							</a>
							<a href="javascript: nastavType('KOSI', 'page_kosi'); saveTypeChange(<?php echo $res['id']; ?>);">
								<img src="/images/modules/KOSI.png" alt="Košík" class="page_typy" id="page_kosi" width="80" height="50">
							</a>
							<a href="javascript: nastavType('GALE', 'page_gale'); saveTypeChange(<?php echo $res['id']; ?>);">
								<img src="/images/modules/GALE.png" alt="Galerie" class="page_typy" id="page_gale" width="80" height="50">
							</a>
                                                        <a href="javascript: nastavType('HREF', 'page_href'); saveTypeChange(<?php echo $res['id']; ?>);">
								<img src="/images/modules/HREF.png" alt="Odkazy" class="page_typy" id="page_href" width="80" height="50">
							</a>
						</td>
					</tr>
					<tr>
						<td>
						
						<?php 
							} else {
								echo "Problémy s databází.";
							}
						?>
						</td>
					</tr>
					
				</table>
				<?php
			}
			if ($_POST['action'] == "change_type") {
				$sql = "UPDATE `page_parts` SET `type` = '".$_POST['type']."' WHERE `id` = ".$_POST['id']."";
				if ($q = mysql_query($sql)) {
					echo "Typ stránky byl změněn.";
				}
			}
			if ($_POST['action'] == "sort") {
				$sql = "SELECT `parent` FROM `page` WHERE `id` = ".$_POST['id']." LIMIT 1";
				$q = mysql_query($sql);
				$res = mysql_fetch_array($q);
				$sql = "SELECT `order` AS target FROM `page` WHERE `id` = ".$_POST['change_with']." LIMIT 1";
				if ($_POST['change_with'] == "") {
					$sql = "SELECT (MAX(`order`)+1) AS target FROM `page` WHERE `parent` = ".$res['parent']." LIMIT 1";
				}
				$q = mysql_query($sql);
				if ($res = mysql_fetch_array($q)) {
					$target = $res['target']-1;
					$sql = "SELECT * FROM `page` WHERE `id` = '".$_POST['id']."' LIMIT 1";
					$q = mysql_query($sql);
					if ($res = mysql_fetch_array($q)) {
						$from = $res['order'];
						if ($target > $from) {
							$sql = "UPDATE `page` SET `order` = `order`-1 WHERE `order` >= $from AND `order` <= $target AND `parent` = ".$res['parent']."";
							$q = mysql_query($sql);
							$sql = "UPDATE `page` SET `order` = ".$target." WHERE `id` = ".$_POST['id']."";
							$q = mysql_query($sql);
							echo "Úspěšně přesunut sloupec.";
						}
						if ($target < $from) {
							$sql = "UPDATE `page` SET `order` = `order`+1 WHERE `order` >= ".($target+1)." AND `order` <= $from AND `parent` = ".$res['parent']."";
							$q = mysql_query($sql);
							$sql = "UPDATE `page` SET `order` = ".($target+1)." WHERE `id` = ".$_POST['id']."";
							$q = mysql_query($sql);
							echo "Úspěšně přesunut sloupec";
						}
						if ($target == $from) {
							echo "Sloupec nebyl přesunuty.";
						}
					} else {
						echo "Nastala chyba při přemisťování sloupce!";
					}
				} else {
					echo "Nastala chyba při přemisťování sloupce!";
				}
			}
			if ($_POST['action'] == "resize") {
				$sql = "SELECT SUM(`width`) AS wid FROM `page` WHERE `id` = ".$_POST['left']." OR `id` = ".$_POST['right']."";
				$q = mysql_query($sql);
				$res = mysql_fetch_array($q);
				$wid = $res['wid'];
				$leftWid = round($_POST['left_width']/SIRKA_PAGE*100);
				$sql = "UPDATE `page` SET `width` = ".$leftWid." WHERE `id` = ".$_POST['left']."";
				$q = mysql_query($sql);
				$sql = "UPDATE `page` SET `width` = ".($wid-$leftWid)." WHERE `id` = ".$_POST['right']."";
				$q = mysql_query($sql);
				echo "Šířka stránky změněna.";
			}
?>
