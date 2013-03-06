<?php

	function writeShop_kosik() {
		
		
		$sql = "SELECT * FROM `page_parts` WHERE `type` = 'SHOP'";
		$q = mysql_query($sql);
		if ($res = mysql_fetch_array($q)) {
		
			$pocet = 0;
			$cena = 0;
			$sql = "SELECT * FROM `shop_kosik` WHERE `user` = ".USER_ID."";
			$q = mysql_query($sql);
			while ($res = mysql_fetch_array($q)) {
				$pocet += $res['pocet'];
				$sql = "SELECT * FROM `shop` WHERE `id` = ".$res['id_produkt']."";
				$q2 = mysql_query($sql);
				if ($res2 = mysql_fetch_array($q2)) {
					$cena += $res2['cena']*$res['pocet']*(1+$res2['dph']/100);
				}
			}
			echo '
				<div id="shop_kosik">
					<img src="/images/design/kosik.png" alt="Košík" />
					<div class="text">
						V košíku máte '.$pocet.'&nbsp;'.($pocet<5?($pocet>1?"položky":"položku"):"položek").' za '.round($cena).'&nbsp;Kč
					</div>
					<a href="/kosik/">
						<img src="/images/design/button_go_eshop.png" alt="jdi do košíku" class="go_eshop" />
					</a>
				</div>
			';
		}
	}

	function writeShop_obsah_kosiku($page_part) {
		if ($_GET['krok'] == 2) {
			echo '
				<img src="/images/design/shop_faze_2.png" alt="fáze 2" />
				<hr />';
			echo '<form action="?krok=3" name="formular" method="post" onsubmit="return zkontrolujDoprava();">';
			echo '
				<h1>Způsob dopravy a platby:</h1>
				<p>
				<input type="radio" name="doprava" value="Osobní odběr, platba v hotovosti" /> <label>Osobní odběr, platba v hotovosti</label><br />
				<input type="radio" name="doprava" value="Dobírka" /> <label>Dobírka</label><br />
				</p>
			';
			echo '
				<hr />
					<p>
					<input type="image" src="/images/design/button_pokracovat.png" name="pokracovat" value="Pokračovat" class="shop_right_button" />
					</p>
				</form>
				<form action="?krok=1" method="post">
					<p>
					<input type="image" src="/images/design/button_zpet.png" name="zpet" value="Zpět" class="shop_left_button" />
					</p>
				</form>
				<hr />
			';
		} else if ($_GET['krok'] == 3) {
			echo '
				<img src="/images/design/shop_faze_3.png" alt="fáze 3" />
				<hr />';
			echo '<form action="?krok=4" name="formular" method="post" onsubmit="return zkontrolujOsobni();">';
			$sql = "SELECT * FROM `users` WHERE `id` = ".USER_ID."";
			$q = mysql_query($sql);
			$res = mysql_fetch_array($q);
			echo '
				<p>
				<input type="hidden" name="doprava" value="'.$_POST['doprava'].'" />
				</p>
				<h1>Informace o vás:</h1>
				<h2>Kontaktní údaje</h2>
				<table>
				<tr><td>Jméno: </td><td><input type="text" name="jmeno" value="'.$res['jmeno'].'" /></td></tr>
				<tr><td>Příjmení: </td><td><input type="text" name="prijmeni" value="'.$res['prijmeni'].'" /></td></tr>
				<tr><td>E-mail: </td><td><input type="text" name="email" value="'.$res['mail'].'" /></td></tr>
				<tr><td>Telefon: </td><td><input type="text" name="telefon" value="'.$res['telefon'].'" /></td></tr>
				</table>
				<h2>Adresa:</h2>
				<table>
				<tr><td>Ulice: </td><td><input type="text" name="ulice" value="'.$res['ulice'].'" /></td></tr>
				<tr><td>Obec: </td><td><input type="text" name="obec" value="'.$res['obec'].'" /></td></tr>
				<tr><td>PSČ: </td><td><input type="text" name="psc" value="'.$res['psc'].'" /></td></tr>
				<tr><td>Stát: </td><td><input type="text" name="stat" value="'.$res['stat'].'" /></td></tr>
				</table>
				<h2>Nepovinné údaje:</h2>
				<table>
				<tr><td>Poznámka: </td><td><textarea name="poznamka" rows="3" cols="50">'.$_POST['poznamka'].'</textarea></td></tr>
				</table>
				
			';
			echo '
				<hr />
					<p>
					<input type="image" src="/images/design/button_pokracovat.png" name="pokracovat" value="Pokračovat" class="shop_right_button" />
					</p>
				</form>
				<form action="?krok=2" method="post">
					<p>
					<input type="image" src="/images/design/button_zpet.png" name="zpet" value="Zpět" class="shop_left_button" />
					</p>
				</form>
				<hr />
			';
		} else if ($_GET['krok'] == 4) {
			$sql = "UPDATE `users` SET `jmeno` = '".$_POST['jmeno']."', `prijmeni` = '".$_POST['prijmeni']."', `mail` = '".$_POST['email']."', `telefon` = '".$_POST['telefon']."', `ulice` = '".$_POST['ulice']."', `obec` = '".$_POST['obec']."', `psc` = '".$_POST['psc']."', `stat` = '".$_POST['stat']."' WHERE `id` = ".USER_ID."";
			$q = mysql_query($sql);
			echo '
				<img src="/images/design/shop_faze_4.png" alt="fáze 4" />
				<hr />';
			echo '<form action="?krok=5" method="post">';
			$pocet = 0;
			$cena = 0;
			$cenabezdph = 0;
			$sql = "SELECT * FROM `shop_kosik` WHERE `user` = ".USER_ID."";
			$q = mysql_query($sql);
			while ($res = mysql_fetch_array($q)) {
				$pocet += $res['pocet'];
				$sql = "SELECT * FROM `shop` WHERE `id` = ".$res['id_produkt']."";
				$q2 = mysql_query($sql);
				if ($res2 = mysql_fetch_array($q2)) {
					$cenabezdph += $res2['cena']*$res['pocet'];
					$cena += $res2['cena']*$res['pocet']*(1+$res2['dph']/100);
				}
			}
			
			$postovne = 0;
			if ($_POST['doprava'] == "Dobírka") {
				$postovne = 80;
			}
			
			echo '
				<p>
				<input type="hidden" name="doprava" value="'.$_POST['doprava'].'" />
				<input type="hidden" name="jmeno" value="'.$_POST['jmeno'].'" />
				<input type="hidden" name="prijmeni" value="'.$_POST['prijmeni'].'" />
				<input type="hidden" name="email" value="'.$_POST['email'].'" />
				<input type="hidden" name="telefon" value="'.$_POST['telefon'].'" />
				<input type="hidden" name="ulice" value="'.$_POST['ulice'].'" />
				<input type="hidden" name="obec" value="'.$_POST['obec'].'" />
				<input type="hidden" name="psc" value="'.$_POST['psc'].'" />
				<input type="hidden" name="stat" value="'.$_POST['stat'].'" />
				<input type="hidden" name="poznamka" value="'.$_POST['poznamka'].'" />
				<input type="hidden" name="cenabezdph" value="'.round($cenabezdph+$postovne).'" />
				<input type="hidden" name="cenasdph" value="'.round($cena+$postovne*1.19).'" />
				</p>
				<h1>Shrnutí informací:</h1>
				<table>
				<tr><th colspan="3">Nákup</th></tr>
				<tr><th></th><th>Cena bez DPH</th><th>Cena s DPH</th></tr>
				<tr><td>Cena položek:</td><td>'.round($cenabezdph).'&nbsp;Kč</td><td>'.round($cena).'&nbsp;Kč</td></tr>
				<tr><td>Cena poštovné a balné:</td><td>'.$postovne.'&nbsp;Kč</td><td>'.round($postovne*1.19).'&nbsp;Kč</td></tr>
				<tr><td>Cena celkem:</td><td>'.round($cenabezdph+$postovne).'&nbsp;Kč</td><td>'.round($cena+$postovne*1.19).'&nbsp;Kč</td></tr>
				<tr><th colspan="3">Způsob dopravy a platby</th></tr>
				<tr><td colspan="3">'.$_POST['doprava'].'</td></tr>
				<tr><th colspan="3">Kontaktní údaje</th></tr>
				<tr><td>Jméno:</td><td colspan="2">'.$_POST['jmeno'].'</td></tr>
				<tr><td>Příjmení:</td><td colspan="2">'.$_POST['prijmeni'].'</td></tr>
				<tr><td>E-mail:</td><td colspan="2">'.$_POST['email'].'</td></tr>
				<tr><td>Telefon:</td><td colspan="2">'.$_POST['telefon'].'</td></tr>
				<tr><th colspan="3">Adresa</th></tr>
				<tr><td>Ulice:</td><td colspan="2">'.$_POST['ulice'].'</td></tr>
				<tr><td>Obec:</td><td colspan="2">'.$_POST['obec'].'</td></tr>
				<tr><td>PSČ:</td><td colspan="2">'.$_POST['psc'].'</td></tr>
				<tr><td>Stát:</td><td colspan="2">'.$_POST['stat'].'</td></tr>
				<tr><th colspan="3">Poznámka</th></tr>
				<tr><td colspan="3">'.$_POST['poznamka'].'</td></tr>
				
				</table>
			';
			echo '
				<hr />
					<p>
					<input type="image" src="/images/design/button_dokoncit.png" name="pokracovat" value="Pokračovat" class="shop_right_button" />
					</p>
				</form>
				<form action="?krok=3" method="post">
					<p>
					<input type="hidden" name="doprava" value="'.$_POST['doprava'].'" />
					<input type="hidden" name="poznamka" value="'.$_POST['poznamka'].'" />
					<input type="image" src="/images/design/button_zpet.png" name="zpet" value="Zpět" class="shop_left_button" />
					</p>
				</form>
				<hr />
			';
		} else if ($_GET['krok'] == 5) {
			$date = date("Ymd");
			$sql = "SELECT `cislo` AS cis FROM `shop_objednavky` WHERE `cislo` LIKE '$date%' ORDER BY `cislo` DESC";
			$q = mysql_query($sql);
			if ($res = mysql_fetch_array($q)) {
				$cislo = $res['cis']+1;
			} else {
				$cislo = $date."01";
			}
			$sql = "INSERT INTO `shop_objednavky` VALUES(NULL, '".$cislo."', '".$_POST['jmeno']."', '".$_POST['prijmeni']."', '".$_POST['email']."', '".$_POST['telefon']."', '".$_POST['ulice']."', '".$_POST['obec']."', '".$_POST['psc']."', '".$_POST['stat']."', '".$_POST['poznamka']."', '".$_POST['doprava']."', '".$_POST['cenabezdph']."', '".$_POST['cenasdph']."')";
			$q = mysql_query($sql);
			$sql = "SELECT * FROM `shop_objednavky` WHERE `cislo` = '".$cislo."'";
			$q = mysql_query($sql);
			if ($res = mysql_fetch_array($q)) {
				$sql = "UPDATE `shop_kosik` SET `user` = -".$res['id']." WHERE `user` = ".USER_ID."";
				$q = mysql_query($sql);
			}
			echo '
				<img src="/images/design/shop_faze_5.png" alt="fáze 5" />
				<hr />';
			echo '
				<h1>Objednávka úspěšně dokončena.</h1>
				<p>Na váš e-mail vám dorazí informace o objednávce.</p>
			';
		} else {
		echo '
		<img src="/images/design/shop_faze_1.png" alt="fáze 1" />
		<hr />';
		if (isset($_GET['prepocitat'])) {
			foreach ($_POST['pocet'] as $id => $pocet) {
				if ($pocet == 0) {
					$sql = "DELETE FROM `shop_kosik` WHERE `id` = ".$id."";
					$q = mysql_query($sql);
				} else {
					$sql = "UPDATE `shop_kosik` SET `pocet` = ".$pocet." WHERE `id` = ".$id."";
					$q = mysql_query($sql);
				}
			}
			echo '<p>Košík přepočítán</p><hr />';
		}
		echo '<form name="prepocitani" action="?prepocitat" method="post">
		<table class="shop_kosik_table"><tr><th>Obrázek</th><th>Název</th><th>Počet</th><th>Cena bez DPH</th><th>Cena s DPH</th><th>Odstranit</th></tr>';
		$sql = "SELECT * FROM `shop_kosik` WHERE `user` = ".USER_ID."";
		$q = mysql_query($sql);
		$prazdny = true;
		while ($res = mysql_fetch_array($q)) {
			$prazdny = false;
			echo '<tr><td>';
			$dir = dir(PATH."/userfiles/shop/");
			while ($file1 = $dir->read()) {    
				$find = preg_replace('/'.$res['id_produkt'].'\.0\.(png|jpg|gif)/', '$founded$', $file1);    
				if (strstr($find, '$founded$')) {
					echo "<img src=\"/userfiles/shop/".$file1."\" class=\"image\" alt=\"obrázek produktu\" />";
					break;
				}
			}
			echo '</td>';
			$sql = "SELECT * FROM `shop` WHERE `id` = ".$res['id_produkt']."";
			$q2 = mysql_query($sql);
			if ($res2 = mysql_fetch_array($q2)) {
				$sql = "SELECT `parent` FROM `shop_menu` WHERE `id` = ".$res2['parent']."";
				$q3 = mysql_query($sql);
				if ($res3 = mysql_fetch_array($q3)) {
					$menulink = getMenuLink($res3['parent']);
				}
				echo '<td><a href="/'.$menulink."/".$res2['code'].'/">'.$res2['nazev'].'</a><br />'.$res2['code'].'</td>';
				echo '<td><input name="pocet['.$res['id'].']" value="'.$res['pocet'].'" />&nbsp;ks</td>';
				$celkem += $res['pocet']*$res2['cena'];
				echo '<td>'.round($res['pocet']*$res2['cena']).'&nbsp;Kč</td>';
				$celkemsdph += $res['pocet']*$res2['cena']*(1+$res2['dph']/100);
				echo '<td>'.round($res['pocet']*$res2['cena']*(1+$res2['dph']/100)).'&nbsp;Kč</td>';
				echo '<td><a href="javascript: smazZKosiku('.$res['id'].');"><img src="/images/icons/delete.png" alt="odstranit" /></a></td>';
			}
			
			echo '</tr>';
		}
		if ($prazdny == true) {
			echo '<tr><td colspan="6">Košík je prázdný</td></tr>';
		}
		echo '<tr><td colspan="3"><strong>Celková cena položek:</strong></td><td><strong>'.round($celkem).'&nbsp;Kč</strong></td><td><strong>'.round($celkemsdph).'&nbsp;Kč</strong></td></tr>';
		echo '</table>
		<hr />';
		if ($prazdny == false) {
			echo '
				<p>
					<input type="image" src="/images/design/button_prepocitat.png" name="prepocitat" value="přepočítat" class="shop_left_button" />
				</p>
			</form>
			<form name="objednat" action="?krok=2" method="post">
				<p>
					<input type="image" src="/images/design/button_objednat.png" name="objednat" value="Objednat" class="shop_right_button" />
				</p>
			</form>
			<hr />
			';
		}
		}
	}

?>