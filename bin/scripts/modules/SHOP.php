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
				include PATH."/frogSys/bin/load_pages_id.php";
				if (@$shop_produkt_id > 0) {
					writeShopProdukt($shop_produkt_id);
				} else {
					writeShopProdukty($page_part, @$shop_id);
				}
			?>
		</div>
		<?php
		/*if (@$_SESSION['auth'] > 0) {
			if ($isEmpty) {
				//writeZmenaTypu($page_part);
			}
		} */
	}

	function writeShopProdukty($page_part, $shop_id) {
		$menulink = getMenuLink($page_part);
		if ($shop_id > 0) {
			$sql = "SELECT * FROM `shop_menu` WHERE `id` = ".$shop_id."";
			$q = mysql_query($sql);
			if ($res = mysql_fetch_array($q)) {
				echo "<h1>".$res['nazev']."</h1>";
			}
		} else {

                        $sql = "SELECT `parent` FROM `page` WHERE `first` = ".$page_part."";
                        $q = mysql_query($sql);
                        if ($res = mysql_fetch_array($q)) {
                            $sql = "SELECT `name` FROM `menu` WHERE `id` = ".$res['parent']."";
                            $q = mysql_query($sql);
                            if ($res = mysql_fetch_array($q)) {
                                echo "<h1>".$res['name']."</h1>";
                            }

                        }

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
						$style = " style=\"background-color: #D3D3D3;\"";
					}
					echo "<div class=\"shop_item\"$style>";
					if (@$_SESSION['auth'] > 0) {
						writeEditPane("Shop_produkt", $page_part.", ".(0+$shop_id).", ".$res['id'], "D");
					}
					$dir = dir(PATH."/userfiles/shop/");
					while ($file1 = $dir->read()) {
						$find = preg_replace('/'.$res['id'].'\.0\.jpg/', '$founded$', $file1);
						if (strstr($find, '$founded$')) {
                                                        if (@$_SESSION['auth'] > 0) {
                                                            echo "<a href=\"javascript: loadShopProdukt(".$page_part.", ".$res['id'].");\">";
                                                        } else {
                                                            echo "<a href=\"".URL.$menulink."/".$res['link']."/\">";
                                                        }
                                                        echo "<img src=\"".URL."userfiles/shop/".$file1."?rand=".mt_rand(1000,9999)."\" class=\"image\" alt=\"".$res['nazev']."\" title=\"".$res['nazev']."\" />";
                                                        echo "</a>";
							break;
						}
					}
					echo "<div class=\"nazev\">";
					if (@$_SESSION['auth'] > 0) {
						echo "<a href=\"javascript: loadShopProdukt(".$page_part.", ".$res['id'].", '".$menulink."/".$res['link']."');\">";
					} else {
						echo "<a href=\"".URL.$menulink."/".$res['link']."/\">";
					}
					echo "".$res['nazev']."</a></div><div class=\"popis\">".$res['popis']."</div><div class=\"cena\">".round($res['cena']*(1+$res['dph']/100))." Kč <span class=\"sdph\">s DPH</span></div><div class=\"vyrobce\">".$res['vyrobce']."</div>";
					?>
					<form action="<?php echo URL; ?>frogSys/bin/ajax/user.php" method="post">
					<p>
						<input type="hidden" name="url_back" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
						<input type="hidden" name="add_product" value="<?php echo $res['id']; ?>" />
						<input type="image" name="pridat" value="Přidat" src="<?php echo URL; ?>frogSys/images/modules/SHOP/add_kosik.png" alt="přidat do košíku" class="add_kosik" />
					</p>
					</form>
					<?php
					echo "</div>";
				}
			}
			if (@$_SESSION['auth'] > 0) {
				if (!$shop_id) {
					$shop_id = 0;
				}
			?>
				<a href="javascript: addShop_produkt(<?php echo $page_part; ?>, <?php echo $shop_id; ?>);"><img src="<?php echo URL; ?>frogSys/images/modules/SHOP/add_produkt.png" alt="add" class="add_shop_produkt"></a>
			<?php
			}
	}

	function writeShopMenu($page_part) {
			$menulink = getMenuLink($page_part);
			echo "<div class=\"shop_menu_item\">";
			if (@$_SESSION['auth'] > 0) {
				echo "<span class=\"btn-left\"></span><span class=\"btn-right\"><a href=\"javascript: loadShopCategory(".$page_part.", 0);\">";
			} else {
				echo "<span class=\"btn-left\"></span><span class=\"btn-right\"><a href=\"".URL.$menulink."/\">";
			}
			echo "Všechny typy</a></span></div>";
			$sql = "SELECT * FROM `shop_menu` WHERE `parent` = ".$page_part." ORDER BY `nazev`";
			$q = mysql_query($sql);
			$isEmpty = true;
			while ($res = mysql_fetch_array($q)) {
				$isEmpty = false;
				echo "<div class=\"shop_menu_item\">";
				if (@$_SESSION['auth'] > 0) {
					writeEditPane("Shop_menu", $res['id'], "DE");
					echo "<span class=\"btn-left\"></span><span class=\"btn-right\"><a href=\"javascript: loadShopCategory(".$page_part.", ".$res['id'].", '".$menulink."/".$res['link']."');\">";
				} else {
					echo "<span class=\"btn-left\"></span><span class=\"btn-right\"><a href=\"".URL.$menulink."/".$res['link']."/\">";
				}
				echo $res['nazev']."</a></span></div>";
			}
			if (@$_SESSION['auth'] > 0) {
			?>
				<a href="javascript: addShop_menu(<?php echo $page_part; ?>);"><img src="<?php echo URL; ?>frogSys/images/icons/add.png" alt="add" class="add_shop_menu" /></a>
			<?php
			}
	}


	function writeShopProdukt($id) {
			$sql = "SELECT * FROM `shop` WHERE `id` = ".$id."";
			if ($q = mysql_query($sql)) {
				if ($res = mysql_fetch_array($q)) {
                                    $shop_id = $parent1 = $res['parent'];
                                    $sql = "SELECT `parent` FROM `shop_menu` WHERE `id` = ".$parent1."";
                                    $q2 = mysql_query($sql);
                                    if ($res2 = mysql_fetch_array($q2)) {
                                        $page_part = $parent2 = $res2['parent'];
                                    }
					echo "<div class=\"shop_produkt\">";

					echo "<div class=\"nazev\" id=\"nazev_".$res['id']."\">";
					if (@$_SESSION['auth'] > 0) {
						writeEditPane("Shop_produkt_nazev", $res['id'], "E");
					}
					echo "<h1 id=\"nazev_text_".$res['id']."\">".$res['nazev']."</h1></div>";
					if (@$_SESSION['auth'] > 0) {
						echo "<div id=\"link_".$res['id']."\">Link: <span id=\"link_text_".$res['id']."\">".$res['link']."</span></div>";
					}
					echo "<div class=\"ceny\" id=\"shop_ceny_".$res['id']."\">";
					if (@$_SESSION['auth'] > 0) {
						writeEditPane("Shop_produkt_cena", $res['id'], "E");
					}
					echo "<div class=\"cena_bez\"><span id=\"shop_cena_".$res['id']."\">".round($res['cena'])."</span> Kč <span class=\"sdph\">bez DPH</span></div>";
					echo "<div class=\"cena\">".round($res['cena']*(1+$res['dph']/100))." Kč <span class=\"sdph\">s DPH</span></div>";
					echo "<div class=\"cena_dph\"><span id=\"shop_dph_".$res['id']."\">".$res['dph']."</span> % <span class=\"sdph\">DPH</span></div>";

					?>
					<form action="<?php echo URL; ?>frogSys/bin/ajax/user.php" method="post">
					<p>
						<input type="hidden" name="url_back" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
						<input type="hidden" name="add_product" value="<?php echo $res['id']; ?>" />
						<span class="form-kosik"><input type="text" name="pocet" value="1" />    </span>
						<input type="image" name="pridat" value="Přidat" src="<?php echo URL; ?>frogSys/images/modules/SHOP/add_kosik.png" alt="přidat do košíku" class="add_kosik" />
					</p>
					</form>
					<?php
					echo "</div>";
					echo "<div class=\"skladem\">";
					if (@$_SESSION['auth'] > 0) {
						writeEditPane("Shop_produkt_skladem", $res['id'], "E");
					}
					echo "Skladem: ";
                                        $img = "ixko.png";
                                        $alt = "NO";
                                        if ($res['skladem'] > 0) {
                                            $img = "check.png";
                                            $alt = "YES";
                                        }
                                        echo '<img src="'.URL.'frogSys/images/icons/'.$img.'" class="skladem_img" alt="'.$alt.'" title="'.$res['skladem'].'" />';
                                        //echo "<span class=\"normal\" id=\"shop_skladem_".$res['id']."\">".$res['skladem']."</span></div>";
					$dir = dir(PATH."/userfiles/shop/");
					while ($file1 = $dir->read()) {
						$find = preg_replace('/'.$res['id'].'\.0\.jpg/', '$founded$', $file1);
						if (strstr($find, '$founded$')) {
							echo "<div class=\"main-img-product\">";
							echo "<a href=\"".URL."userfiles/shop/".$file1."?rand=".mt_rand(1000,9999)."\" rel=\"lightbox[roadtrip]\" title=\"".$res['nazev']."\">";
							echo "<img src=\"".URL."userfiles/shop/".$file1."?rand=".mt_rand(1000,9999)."\" class=\"image\" alt=\"".$res['nazev']."\" title=\"".$res['nazev']."\" /></a></div>";
							break;
						}
					}
					if (@$_SESSION['auth'] > 0) {
						echo "<hr />";
					}

					echo "<div class=\"popis\" id=\"popis_".$res['id']."\">";
					if (@$_SESSION['auth'] > 0) {
						writeEditPane("Shop_produkt_popis", $res['id'], "E");
					}
					echo "".$res['popis']."</div>";
					if (@$_SESSION['auth'] > 0) {
						echo "<hr />";
					}

					echo "<div class=\"vyrobce\" id=\"vyrobce_".$res['id']."\">";
					if (@$_SESSION['auth'] > 0) {
						writeEditPane("Shop_produkt_vyrobce", $res['id'], "E");
					}
					echo "Výrobce: <span class=\"underline\" id=\"shop_vyrobce_".$res['id']."\">".$res['vyrobce']."</span></div>";
					if (@$_SESSION['auth'] > 0) {
						echo "<hr />";
					}

					echo "<div class=\"code\">";
					if (@$_SESSION['auth'] > 0) {
						writeEditPane("Shop_produkt_code", $res['id'], "E");
					}

					echo "kód: <span class=\"normal\" id=\"shop_code_".$res['id']."\">".$res['code']."</span></div>";

					if (@$_SESSION['auth'] > 0) {
						//writeEditPane("Shop_produkt", $res['id'], "D");
					}

					if (@$_SESSION['auth'] > 0) {
						echo "<hr />";
					}

					echo "<div class=\"dalsi_obrazky\">Další obrázky:</div>";

					echo "<div class=\"next_images\">";
					// Pridelat do scriptaculous
					$dir = dir(PATH."/userfiles/shop/");
					while ($file = $dir->read()) {
						$find = preg_replace('/'.$res['id'].'\.([1-9][0-9]*)\.jpg/', '$founded$', $file);
						if (strstr($find, '$founded$')) {
							echo "<div class=\"image_a_href\">";
							if (@$_SESSION['auth'] > 0) {
								writeEditPane("Shop_image", "'".$file."'", "DR");
							}
							echo "<a href=\"".URL."userfiles/shop/".$file."?rand=".mt_rand(1000,9999)."\" rel=\"lightbox[roadtrip]\" title=\"Obrázek produktu\">";
							echo "<img src=\"".URL."userfiles/shop/".$file."?rand=".mt_rand(1000,9999)."\" class=\"image_next\" alt=\"".$res['nazev']."\" title=\"".$res['nazev']."\" /></a></div>";
						}
					}
					if (@$_SESSION['auth'] > 0) {
                                            echo '
			<a href="javascript: addShop_image('.$page_part.', '.$id.');">
				<img src="'.URL.'frogSys/images/icons/addImages.png" alt="Vložit obrázky" />
			</a>
			<applet id="jumpLoaderApplet_SHOP" name="jumpLoaderApplet_SHOP"
					code="jmaster.jumploader.app.JumpLoaderApplet.class"
					archive="'.URL.'frogSys/java/jump_loader/mediautil_z.jar,/frogSys/java/jump_loader/sanselan_z.jar,/frogSys/java/jump_loader/jumploader_z.jar"
					width="0"
					height="0"
					mayscript>

			    	<param name="uc_sendImageMetadata" value="true"/>
			    	<param name="uc_imageEditorEnabled" value="true"/>
			        <param name="uc_useLosslessJpegTransformations" value="true"/>
					<param name="uc_uploadUrl" value="'.URL.'frogSys/bin/ajax/edit/modules/SHOP.php?predmet=shop&action=add_images&produkt='.$id.'"/>
    			    <param name="uc_uploadScaledImages" value="true"/>
        			<param name="uc_scaledInstanceNames" value="small,large"/>
       				<param name="uc_scaledInstanceDimensions" value="640x480,800x600"/>
       				<param name="uc_scaledInstanceQualityFactors" value="800,800"/>
        			<param name="ac_fireUploaderFileAdded" value="true"/>
					<param name="ac_fireUploaderFileStatusChanged" value="true"/>
        			<param name="ac_fireUploaderStatusChanged" value="true"/>
					<param name="uc_fileNamePattern" value="^.+\.(?i)((jpg)|(jpe)|(jpeg)|(gif)|(png)|(tif)|(tiff))$"/>
        			<param name="vc_fileNamePattern" value="^.+\.(?i)((jpg)|(jpe)|(jpeg)|(gif)|(png)|(tif)|(tiff))$"/>
        			<param name="vc_disableLocalFileSystem" value="false"/>
        			<param name="vc_mainViewFileTreeViewVisible" value="true"/>
        			<param name="vc_mainViewFileListViewVisible" value="true"/>
        			<param name="uc_imageRotateEnabled" value="true"/>
        			<param name="uc_scaledInstancePreserveMetadata" value="true"/>
        			<param name="uc_deleteTempFilesOnRemove" value="true"/>
				</applet>
				<hr />
                                            ';
					}
					echo "</div>";
					if (@$_SESSION['auth'] > 0) {
						echo "<hr />";
					}

					if (@$_SESSION['auth'] > 0) {
						echo "<div class=\"je_videt\">Je vidět: <input type=\"checkbox\" onchange=\"setShowProdukt(".$res['id'].", this);\"";
						if ($res['show'] == 1) {
							echo " checked";
						}
						echo "></div>";
						if (@$_SESSION['auth'] > 0) {
							echo "<hr />";
						}

						echo "<div class=\"doporucujeme\">Doporučujeme: <input type=\"checkbox\" onchange=\"setDoporucujemeProdukt(".$res['id'].", this);\"";
						if ($res['doporucujeme'] == 1) {
							echo " checked";
						}
						echo "></div>";


						if (@$_SESSION['auth'] > 0) {
							echo "<hr />";
						}

						echo "<div class=\"kategorie\">Kategorie: <span class=\"normal\">";

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

					if (@$_SESSION['auth'] > 0) {
						echo "<hr />";

						echo '
						<form action="javascript: ;">
							<div class="right_kosik_tlacitko">
								<input type="image" src="'.URL.'frogSys/images/modules/SHOP/btn-novy.png" name="pokracovat" onclick="addShop_produkt('.$parent2.', '.$parent1.')" value="Nový produkt" />
							</div>
							<div class="left_kosik_tlacitko">
								<input type="image" src="'.URL.'frogSys/images/modules/SHOP/btn-zpet.png" name="zpet" onclick="history.go(-1);" value="Zpět na výpis produktů" />
							</div>
							<hr />
						</form>
						';
					}
				}
			}
	}




?>