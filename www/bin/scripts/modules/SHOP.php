<?php
	function writeShop($page_part) {
		?>
		<div class="shop_menu" id="shop_menu_<?php echo $page_part; ?>">
		<?php
			writeShopMenu($page_part);
		?>
		</div>
		<div class="shop" id="shop_<?php echo $page_part; ?>">
			<?php
				include PATH."/bin/load_pages_id.php";
				if ($shop_produkt_id > 0) {
					writeShopProdukt($shop_produkt_id);
				} else {
					writeShopProdukty($page_part, $shop_id);
				}
			?>
		</div>
		<?php
		/*if (@$_SESSION['auth'] > 0) {
			if ($isEmpty) {
				writeZmenaTypu($page_part);
			}
		} */
	}
	
	function writeShopProdukty($page_part, $shop_id) {
		if (isset($_POST['add_product'])) {
			$sql = "INSERT INTO `shop_kosik` VALUES(NULL, ".$_POST['add_product'].", 1, ".USER_ID.")";
			$q = mysql_query($sql);
		}
		$menulink = getMenuLink($page_part);
		if ($shop_id > 0) {
			$sql = "SELECT * FROM `shop_menu` WHERE `id` = ".$shop_id."";
			$q = mysql_query($sql);
			if ($res = mysql_fetch_array($q)) {
				echo "<h1>".$res['nazev']."</h1>";
			}
		} else {
			echo "<h1>Všechny typy</h1>";
		}
		if ($shop_id == 0) {
				$sql = "SELECT `id` FROM `shop_menu` WHERE `parent` = $page_part";
				$q = mysql_query($sql);
				$filter = "";
				while ($res = mysql_fetch_array($q)) {
					$filter .= "`parent` = ".$res['id']." OR ";
				}
				$filter = substr($filter, 0, -4);
			} else {
				$filter = "`parent` = $shop_id";
			}
			$filter = "(".$filter.")";
			if (!(@$_SESSION['auth'] > 0)) {
				$filter .= " AND `show` = 1";
			}              
			$sql = "SELECT * FROM `shop` WHERE $filter ORDER BY `nazev`";
			if ($q = mysql_query($sql)) {
				while ($res = mysql_fetch_array($q)) {
					$style = "";
					if ($res['show'] == 0) {
						$style = " style=\"background-color: lightgrey;\"";
					}
					echo "<div class=\"shop_item\"$style>";
					if (@$_SESSION['auth'] > 0) {
						writeEditPane("Shop_produkt", $page_part.", ".(0+$shop_id).", ".$res['id'], "D");
					}
					$dir = dir(PATH."/userfiles/shop/");
					while ($file1 = $dir->read()) {    
						$find = preg_replace('/'.$res['id'].'\.0\.(png|jpg|gif)/', '$founded$', $file1);    
						if (strstr($find, '$founded$')) {
							echo "<img src=\"/userfiles/shop/".$file1."\" class=\"image\" alt=\"obrázek produktu\" />";
							break;
						}
					}
					echo "<div class=\"nazev\">";
					if (@$_SESSION['auth'] > 0) {
						echo "<a href=\"javascript: loadShopProdukt(".$page_part.", ".$res['id'].");\">";
					} else {
						echo "<a href=\"/".$menulink."/".$res['code']."/\">";
					}
					echo "".$res['nazev']."</a></div><div class=\"popis\">".$res['popis']."</div><div class=\"cena\">".round($res['cena']*(1+$res['dph']/100))." Kč <span class=\"sdph\">s DPH</span></div><div class=\"vyrobce\">".$res['vyrobce']."</div>";
					?>
					<form action="" method="post">
					<p>	
						<input type="hidden" name="add_product" value="<?php echo $res['id']; ?>" />
						<input type="image" name="pridat" value="Přidat" src="/images/icons/add_kosik.png" alt="přidat do košíku" class="add_kosik" />
					</p>
					</form>
					<?php
					echo "</div>";
				}
			}
			if (@$_SESSION['auth'] > 0) {
			?>
				<a href="javascript: addShop_produkt(<?php echo $page_part; ?>, <?php echo $shop_id; ?>);"><img src="/images/design/add_produkt.png" alt="add" class="add_shop_produkt"></a>
			<?php
			}
	}

	function writeShopMenu($page_part) {
			$menulink = getMenuLink($page_part);
			echo "<div class=\"shop_menu_item\">";
			if (@$_SESSION['auth'] > 0) {
				echo "<a href=\"javascript: loadShopCategory(".$page_part.", 0);\">";
			} else {
				echo "<a href=\"/".$menulink."/\">";
			} 
			echo "Všechny typy</a></div>";
			$sql = "SELECT * FROM `shop_menu` WHERE `parent` = ".$page_part." ORDER BY `nazev`";
			$q = mysql_query($sql);
			$isEmpty = true;
			while ($res = mysql_fetch_array($q)) {
				$isEmpty = false;
				echo "<div class=\"shop_menu_item\">";
				if (@$_SESSION['auth'] > 0) {
					writeEditPane("Shop_menu", $res['id'], "DE");
					echo "<a href=\"javascript: loadShopCategory(".$page_part.", ".$res['id'].");\">";
				} else {
					echo "<a href=\"/".$menulink."/".$res['link']."/\">";
				}
				echo $res['nazev']."</a></div>";
			}
			if (@$_SESSION['auth'] > 0) {
			?>
				<a href="javascript: addShop_menu(<?php echo $page_part; ?>);"><img src="/images/icons/add.png" alt="add" class="add_shop_menu" /></a>
			<?php
			}
	}
	
	
	function writeShopProdukt($id) {
		if (isset($_POST['add_product'])) {
			$sql = "INSERT INTO `shop_kosik` VALUES(NULL, ".$_POST['add_product'].", 1, ".USER_ID.")";
			$q = mysql_query($sql);
		}
			$sql = "SELECT * FROM `shop` WHERE `id` = ".$id."";
			if ($q = mysql_query($sql)) {
				if ($res = mysql_fetch_array($q)) {
					echo "<div class=\"shop_produkt\">";
					
					echo "<div class=\"nazev\" id=\"nazev_".$res['id']."\">";
					if (@$_SESSION['auth'] > 0) {
						writeEditPane("Shop_produkt_nazev", $res['id'], "E");
					}
					echo "<span id=\"nazev_text_".$res['id']."\">".$res['nazev']."</span></div>";
					
					echo "<div class=\"ceny\" id=\"shop_ceny_".$res['id']."\">";
					if (@$_SESSION['auth'] > 0) {
						writeEditPane("Shop_produkt_cena", $res['id'], "E");
					}
					echo "<div class=\"cena_bez\"><span id=\"shop_cena_".$res['id']."\">".round($res['cena'])."</span> Kč <span class=\"sdph\">bez DPH</span></div>";
					echo "<div class=\"cena\">".round($res['cena']*(1+$res['dph']/100))." Kč <span class=\"sdph\">s DPH</span></div>";
					echo "<div class=\"cena_dph\"><span id=\"shop_dph_".$res['id']."\">".$res['dph']."</span> % <span class=\"sdph\">DPH</span></div>";
					
					?>
					<form action="" method="post">
					<p>
						<input type="hidden" name="add_product" value="<?php echo $res['id']; ?>" />
						<input type="image" name="pridat" value="Přidat" src="/images/icons/add_kosik.png" alt="přidat do košíku" class="add_kosik" />
					</p>
					</form>
					<?php
					echo "</div>";
					
					echo "<div class=\"skladem\">";
					if (@$_SESSION['auth'] > 0) {
						writeEditPane("Shop_produkt_skladem", $res['id'], "E");
					}
					echo "Skladem: <span class=\"normal\" id=\"shop_skladem_".$res['id']."\">".$res['skladem']."</span></div>";
					$dir = dir(PATH."/userfiles/shop/");
					while ($file1 = $dir->read()) {    
						$find = preg_replace('/'.$res['id'].'\.0\.(png|jpg|gif)/', '$founded$', $file1);    
						if (strstr($find, '$founded$')) {
							echo "<img src=\"/userfiles/shop/".$file1."\" class=\"image\" alt=\"obrázek produktu\" />";
							break;
						}
					}
					echo "<div class=\"popis\" id=\"popis_".$res['id']."\">";
					if (@$_SESSION['auth'] > 0) {
						writeEditPane("Shop_produkt_popis", $res['id'], "E");
					}
					echo "".$res['popis']."</div>";
					
					echo "<div class=\"vyrobce\" id=\"vyrobce_".$res['id']."\">";
					if (@$_SESSION['auth'] > 0) {
						writeEditPane("Shop_produkt_vyrobce", $res['id'], "E");
					}
					echo "Výrobce: <span class=\"underline\" id=\"shop_vyrobce_".$res['id']."\">".$res['vyrobce']."</span><div id=\"naseptavac\"></div></div>";
					echo "<div class=\"code\">";
					if (@$_SESSION['auth'] > 0) {
						writeEditPane("Shop_produkt_code", $res['id'], "E");
					}
					
					echo "kód: <span class=\"normal\" id=\"shop_code_".$res['id']."\">".$res['code']."</span></div>";

					if (@$_SESSION['auth'] > 0) {
						//writeEditPane("Shop_produkt", $res['id'], "D");
					}
					
					
					echo "<div class=\"dalsi_obrazky\">Další obrázky:</div>";
					
					echo "<div class=\"next_images\">";
					// Pridelat do scriptaculous
					$dir = dir(PATH."/userfiles/shop/");
					while ($file = $dir->read()) {        
						$find = preg_replace('/'.$res['id'].'\.[0-9]+\.(png|jpg|gif)/', '$founded$', $file);    
						if (strstr($find, '$founded$')) {
							echo "<div class=\"image_a_href\">";
							if (@$_SESSION['auth'] > 0) {
								writeEditPane("Shop_image", "'".$file."'", "DR");
							}
							echo "<a href=\"/userfiles/shop/".$file."\" rel=\"lightbox[roadtrip]\" title=\"Obrázek produktu\">";
							echo "<img src=\"/userfiles/shop/".$file."\" class=\"image_next\" alt=\"obrázek produktu\" /></a></div>";
						}
					}
					if (@$_SESSION['auth'] > 0) {
						?>
						<a href="javascript: addShop_image(<?php echo $res['id']; ?>);"><img src="/images/icons/add.png" alt="add" class="add_shop_image"></a>
						<input id="fileToUpload" type="file" name="fileToUpload" class="input">
						<?php
					}
					echo "</div>";
					if (@$_SESSION['auth'] > 0) {
						echo "<div class=\"je_videt\">Je vidět: <input type=\"checkbox\" onchange=\"setShowProdukt(".$res['id'].", this);\"";
						if ($res['show'] == 1) {
							echo " checked";
						}
						echo "></div>";
						
						echo "<div class=\"doporucujeme\">Doporučujeme: <input type=\"checkbox\" onchange=\"setDoporucujemeProdukt(".$res['id'].", this);\"";
						if ($res['doporucujeme'] == 1) {
							echo " checked";
						}
						echo "></div>";
						
						
						
						echo "<div class=\"kategorie\">Kategorie: <span class=\"normal\">";
						$parent1 = $res['parent'];
						$sql = "SELECT `parent` FROM `shop_menu` WHERE `id` = ".$parent1."";
						$q2 = mysql_query($sql);
						if ($res2 = mysql_fetch_array($q2)) {
							$parent2 = $res2['parent'];
						}
						echo "<select id=\"shop_modul_parent_".$res['id']."\" onchange=\"shop_change_category(".$res['id'].");\">";
						echo "<option value=\"0\">-</option>";
						$sql = "SELECT * FROM `page_parts` WHERE `type` = 'SHOP'";
						$q3 = mysql_query($sql);
						while ($res3 = mysql_fetch_array($q3)) {
							$sql = "SELECT `parent` FROM `page` WHERE `first` = ".$res3['id']."";
							$q4 = mysql_query($sql);
							if ($res4 = mysql_fetch_array($q4)) {
								$sql = "SELECT `name` FROM `menu` WHERE `id` = ".$res4['parent']."";
								$q5 = mysql_query($sql);
								if ($res5 = mysql_fetch_array($q5)) {
									$nazev = $res5['name'];
								}
							}
							$sel = "";
							if ($res3['id'] == $parent2) {
								$sel = " selected";
							}
							echo "<option value=\"".$res3['id']."\"".$sel.">".$nazev."</option>";
						}
						echo "</select>";
						echo "<select id=\"shop_menu_parent_".$res['id']."\" onchange=\"shop_set_category(".$res['id'].");\">";
						echo "<option value=\"0\">-</option>";
						$sql = "SELECT * FROM `shop_menu` WHERE `parent` = ".$parent2."";
						$q3 = mysql_query($sql);
						while ($res3 = mysql_fetch_array($q3)) {
							$sel = "";
							if ($res3['id'] == $parent1) {
								$sel = " selected";
							}
							echo "<option value=\"".$res3['id']."\"".$sel.">".$res3['nazev']."</option>";
						}
						echo "</select>";
						
					}
					
					echo "</div>";
					
				}
			}
	}
	
	


?>