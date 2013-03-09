<?php

function writeShop_kosik() {


    $sql = "SELECT * FROM `page_parts` WHERE `type` = 'SHOP'";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        
            $sql = "SELECT * FROM `menu` WHERE `link` = 'kosik' AND `parent` = -1";
            $q = mysql_query($sql);
            if (!($res = mysql_fetch_array($q))) {
                $sql = "INSERT INTO `menu` VALUES(NULL, 'Košík', -1, 0, 'kosik', 0)";
                $q = mysql_query($sql);
                $sql = "SELECT * FROM `menu` WHERE `link` = 'kosik' AND `parent` = -1";
                $q = mysql_query($sql);
                if ($res = mysql_fetch_array($q)) {
                    $sql = "INSERT INTO `page_parts` VALUES(NULL, 'KOSI')";
                    $q = mysql_query($sql);
                    $sql = "SELECT * FROM `page_parts` WHERE `type` = 'KOSI'";
                    $q = mysql_query($sql);
                    if ($res2 = mysql_fetch_array($q)) {
                        $sql = "INSERT INTO `page` VALUES(NULL, " . $res2['id'] . ", 100, " . $res['id'] . ", 1)";
                        $q = mysql_query($sql);
                    }
                }
            }
        


        $pocet = 0;
        $cena = 0;
        $sql = "SELECT * FROM `shop_kosik` WHERE `user` = " . USER_ID . "";
        $q = mysql_query($sql);
        while ($res = mysql_fetch_array($q)) {
            $pocet += $res['pocet'];
            $sql = "SELECT * FROM `shop` WHERE `id` = " . $res['id_produkt'] . "";
            $q2 = mysql_query($sql);
            if ($res2 = mysql_fetch_array($q2)) {
                $cena += $res2['cena'] * $res['pocet'] * (1 + $res2['dph'] / 100);
            }
        }
        echo '
				<div id="shop_kosik">
					<img src="' . URL . 'frogSys/images/modules/SHOP/kosik.png" alt="Košík" />
					<div class="text">
						V košíku máte ' . $pocet . '&nbsp;' . ($pocet < 5 ? ($pocet > 1 ? "položky" : "položku") : "položek") . ' za ' . round($cena) . '&nbsp;Kč
					</div>
					<a href="' . URL . 'kosik/">
						<img src="' . URL . 'frogSys/images/modules/SHOP/button_go_eshop.png" alt="jdi do košíku" class="go_eshop" />
					</a>
				</div>
			';
    }
}

function writeShop_obsah_kosiku($page_part) {
    global $_SETING;
    if (@$_GET['krok'] == 2) {
        echo '
				<img src="' . URL . 'frogSys/images/modules/SHOP/shop_faze_2.png" alt="fáze 2" />
				<hr />';
        echo '<form action="?krok=3" name="formular" method="post" onsubmit="return zkontrolujDoprava();">';
        echo '
				<h1>Způsob dopravy a platby:</h1>
				<p>
				<input type="radio" name="doprava" value="Osobní odběr, platba v hotovosti" /> <label>Osobní odběr, platba v hotovosti</label><br />
				<input type="radio" name="doprava" value="Dobírka" /> <label>Dobírka ('.$_SETING['postovne'].')</label><br />
				</p>
			';
        echo '
				<hr />
					<div class="right_kosik_tlacitko">
					<input type="image" src="' . URL . 'frogSys/images/modules/SHOP/btn-pokracovat2.png" name="pokracovat" value="Pokračovat" class="shop_right_button" />
					</div>
				</form>
				<form action="?krok=1" method="post">
					<div class="left_kosik_tlacitko">
					<input type="image" src="' . URL . 'frogSys/images/modules/SHOP/btn-zpet.png" name="zpet" value="Zpět" class="shop_left_button" />
					</div>
				</form>
				<hr />
			';
    } else if (@$_GET['krok'] == 3) {
        echo '
				<img src="' . URL . 'frogSys/images/modules/SHOP/shop_faze_3.png" alt="fáze 3" />
				<hr />';
        echo '<form action="?krok=4" name="formular" method="post" onsubmit="return zkontrolujOsobni();">';
        $sql = "SELECT * FROM `users` WHERE `id` = " . USER_ID . "";
        $q = mysql_query($sql);
        $res = mysql_fetch_array($q);
        echo '
				<p>
				<input type="hidden" name="doprava" value="' . @$_POST['doprava'] . '" />
				</p>
				<h1>Zaslat na adresu:</h1>
				<h2>Kontaktní údaje</h2>
				<table>
				<tr><td>Jméno: </td><td><input type="text" name="jmeno" value="' . $res['jmeno'] . '" /></td></tr>
				<tr><td>Příjmení: </td><td><input type="text" name="prijmeni" value="' . $res['prijmeni'] . '" /></td></tr>
				<tr><td>E-mail: </td><td><input type="text" name="email" value="' . $res['mail'] . '" /></td></tr>
				<tr><td>Telefon: </td><td><input type="text" name="telefon" value="' . $res['telefon'] . '" /></td></tr>
				</table>
				<h2>Adresa:</h2>
				<table>
				<tr><td>Ulice: </td><td><input type="text" name="ulice" value="' . $res['ulice'] . '" /></td></tr>
				<tr><td>Obec: </td><td><input type="text" name="obec" value="' . $res['obec'] . '" /></td></tr>
				<tr><td>PSČ: </td><td><input type="text" name="psc" value="' . $res['psc'] . '" /></td></tr>
				<tr><td>Stát: </td><td><input type="text" name="stat" value="' . $res['stat'] . '" /></td></tr>
				</table>
				<h2>Nepovinné údaje:</h2>
				<table>
				<tr><td>Poznámka: </td><td><textarea name="poznamka" rows="3" cols="50">' . @$_POST['poznamka'] . '</textarea></td></tr>
				</table>

			';
        echo '
				<hr />
					<div class="right_kosik_tlacitko">
					<input type="image" src="' . URL . 'frogSys/images/modules/SHOP/btn-pokracovat2.png" name="pokracovat" value="Pokračovat" class="shop_right_button" />
					</div>
				</form>
				<form action="?krok=2" method="post">
					<div class="left_kosik_tlacitko">
					<input type="image" src="' . URL . 'frogSys/images/modules/SHOP/btn-zpet.png" name="zpet" value="Zpět" class="shop_left_button" />
					</div>
				</form>
				<hr />
			';
    } else if (@$_GET['krok'] == 4) {
        $sql = "UPDATE `users` SET `jmeno` = '" . $_POST['jmeno'] . "', `prijmeni` = '" . $_POST['prijmeni'] . "', `mail` = '" . $_POST['email'] . "', `telefon` = '" . $_POST['telefon'] . "', `ulice` = '" . $_POST['ulice'] . "', `obec` = '" . $_POST['obec'] . "', `psc` = '" . $_POST['psc'] . "', `stat` = '" . $_POST['stat'] . "' WHERE `id` = " . USER_ID . "";
        $q = mysql_query($sql);
        echo '
				<img src="' . URL . 'frogSys/images/modules/SHOP/shop_faze_4.png" alt="fáze 4" />
				<hr />';
        echo '<form action="?krok=5" method="post">';
        $pocet = 0;
        $cena = 0;
        $cenabezdph = 0;
        $sql = "SELECT * FROM `shop_kosik` WHERE `user` = " . USER_ID . "";
        $q = mysql_query($sql);
        while ($res = mysql_fetch_array($q)) {
            $pocet += $res['pocet'];
            $sql = "SELECT * FROM `shop` WHERE `id` = " . $res['id_produkt'] . "";
            $q2 = mysql_query($sql);
            if ($res2 = mysql_fetch_array($q2)) {
                $cenabezdph += $res2['cena'] * $res['pocet'];
                $cena += $res2['cena'] * $res['pocet'] * (1 + $res2['dph'] / 100);
            }
        }

        $postovne = 0;
        if ($_POST['doprava'] == "Dobírka") {
            $postovne = $_SETING['postovne'];
        }

        echo '
				<p>
				<input type="hidden" name="doprava" value="' . $_POST['doprava'] . '" />
				<input type="hidden" name="jmeno" value="' . $_POST['jmeno'] . '" />
				<input type="hidden" name="prijmeni" value="' . $_POST['prijmeni'] . '" />
				<input type="hidden" name="email" value="' . $_POST['email'] . '" />
				<input type="hidden" name="telefon" value="' . $_POST['telefon'] . '" />
				<input type="hidden" name="ulice" value="' . $_POST['ulice'] . '" />
				<input type="hidden" name="obec" value="' . $_POST['obec'] . '" />
				<input type="hidden" name="psc" value="' . $_POST['psc'] . '" />
				<input type="hidden" name="stat" value="' . $_POST['stat'] . '" />
				<input type="hidden" name="poznamka" value="' . $_POST['poznamka'] . '" />
				<input type="hidden" name="cenabezdph" value="' . round($cenabezdph + $postovne) . '" />
				<input type="hidden" name="cenasdph" value="' . round($cena + $postovne * (1 + $_SETING['DPH'] / 100)) . '" />
				</p>
				<h1>Rekapitulace objednávky:</h1>
					<table class="kosik-summ">
				<tr><th colspan="3"><h2>Nákup</h2></th></tr>
				<tr><th>Cena</th><th>Cena bez DPH</th><th>Cena s DPH</th></tr>
				<tr><td>Cena položek:</td><td>' . round($cenabezdph) . '&nbsp;Kč</td><td>' . round($cena) . '&nbsp;Kč</td></tr>
				<tr><td>Cena poštovné a balné:</td><td>' . $postovne . '&nbsp;Kč</td><td>' . round($postovne * (1 + $_SETING['DPH'] / 100)) . '&nbsp;Kč</td></tr>
				<tr><td>Cena celkem:</td><td>' . round($cenabezdph + $postovne) . '&nbsp;Kč</td><td>' . round($cena + $postovne * (1 + $_SETING['DPH'] / 100)) . '&nbsp;Kč</td></tr>
				<tr><th colspan="3"><h3>Způsob dopravy a platby</h3></th></tr>
				<tr><td colspan="3">' . $_POST['doprava'] . '</td></tr>
				<tr><th colspan="3"><h3>Kontaktní údaje</h3></th></tr>
				<tr><td>Jméno:</td><td colspan="2">' . $_POST['jmeno'] . '</td></tr>
				<tr><td>Příjmení:</td><td colspan="2">' . $_POST['prijmeni'] . '</td></tr>
				<tr><td>E-mail:</td><td colspan="2">' . $_POST['email'] . '</td></tr>
				<tr><td>Telefon:</td><td colspan="2">' . $_POST['telefon'] . '</td></tr>
				<tr><th colspan="3">Adresa</th></tr>
				<tr><td>Ulice:</td><td colspan="2">' . $_POST['ulice'] . '</td></tr>
				<tr><td>Obec:</td><td colspan="2">' . $_POST['obec'] . '</td></tr>
				<tr><td>PSČ:</td><td colspan="2">' . $_POST['psc'] . '</td></tr>
				<tr><td>Stát:</td><td colspan="2">' . $_POST['stat'] . '</td></tr>
				<tr><th colspan="3">Poznámka</th></tr>
				<tr><td colspan="3">' . $_POST['poznamka'] . '</td></tr>
				</table>';

        echo '
				<hr />
					<div class="right_kosik_tlacitko">
					<input type="image" src="' . URL . 'frogSys/images/modules/SHOP/btn-zavazne-objednat.png" name="pokracovat" value="Pokračovat" class="shop_right_button" />
					</div>
				</form>
				<form action="?krok=3" method="post">
					<div class="left_kosik_tlacitko">
					<input type="hidden" name="doprava" value="' . $_POST['doprava'] . '" />
					<input type="hidden" name="poznamka" value="' . $_POST['poznamka'] . '" />
					<input type="image" src="' . URL . 'frogSys/images/modules/SHOP/btn-zpet.png" name="zpet" value="Zpět" class="shop_left_button" />
					</div>
				</form>
				<hr />
			';
    } else if (@$_GET['krok'] == 5) {
        $date = date("Ymd");
        $sql = "SELECT `cislo` AS cis FROM `shop_objednavky` WHERE `cislo` LIKE '$date%' ORDER BY `cislo` DESC";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $cislo = $res['cis'] + 1;
        } else {
            $cislo = $date . "01";
        }
        $sql = "INSERT INTO `shop_objednavky` VALUES(NULL, '" . $cislo . "', '" . $_POST['jmeno'] . "', '" . $_POST['prijmeni'] . "', '" . $_POST['email'] . "', '" . $_POST['telefon'] . "', '" . $_POST['ulice'] . "', '" . $_POST['obec'] . "', '" . $_POST['psc'] . "', '" . $_POST['stat'] . "', '" . $_POST['poznamka'] . "', '" . $_POST['doprava'] . "', '" . $_POST['cenabezdph'] . "', '" . $_POST['cenasdph'] . "', NOW(), 0, 0)";
        $q = mysql_query($sql);
        $sql = "SELECT * FROM `shop_objednavky` WHERE `cislo` = '" . $cislo . "'";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $id_obednavky = $res['id'];
            $sql = "UPDATE `shop_kosik` SET `user` = -" . $id_obednavky . " WHERE `user` = " . USER_ID . "";
            $q = mysql_query($sql);
        }

        $pocet = 0;
        $cena = 0;
        $cenabezdph = 0;
        $sql = "SELECT * FROM `shop_kosik` WHERE `user` = -" . $id_obednavky . "";
        $q = mysql_query($sql);
        while ($res = mysql_fetch_array($q)) {
            $pocet += $res['pocet'];
            $sql = "SELECT * FROM `shop` WHERE `id` = " . $res['id_produkt'] . "";
            $q2 = mysql_query($sql);
            if ($res2 = mysql_fetch_array($q2)) {
                $cenabezdph += $res2['cena'] * $res['pocet'];
                $cena += $res2['cena'] * $res['pocet'] * (1 + $res2['dph'] / 100);
            }
        }

        $postovne = 0;
        if ($_POST['doprava'] == "Dobírka") {
            $postovne = $_SETING['postovne'];
        }

        $texth = '
				<html>
					<head>
						<META http-equiv=3D"Content-Type" content=3D"text/html;chars=et=3Dutf-8">
					</head>
					<body>';
			$text = '<p>Dobrý den ' . $_POST['jmeno'] . ' ' . $_POST['prijmeni'] . ',</p>
					<p>Vaše objednávka byla zařazena do zpracování. </p>';
                        $text_admin = '<p>Byla zaznamenána objednávka. Detajl níže:</p>';
			$textp = '<h1>Číslo objednávky: ' . $cislo . '</h1>
				<h2>Shrnutí informací:</h2>
				<table class="kosik-summ">
				<tr><th colspan="3"><h2>Nákup</h2></th></tr>
				<tr><th>Cena</th><th><h3>Cena bez DPH</h3></th><th>Cena s DPH</th></tr>
				<tr><td>Cena položek:</td><td>' . round($cenabezdph) . '&nbsp;Kč</td><td>' . round($cena) . '&nbsp;Kč</td></tr>
				<tr><td>Cena poštovné a balné:</td><td>' . $postovne . '&nbsp;Kč</td><td>' . round($postovne * (1 + $_SETING['DPH'] / 100)) . '&nbsp;Kč</td></tr>
				<tr><td>Cena celkem:</td><td>' . round($cenabezdph + $postovne) . '&nbsp;Kč</td><td>' . round($cena + $postovne * (1 + $_SETING['DPH'] / 100)) . '&nbsp;Kč</td></tr>
				<tr><th colspan="3"><h3>Způsob dopravy a platby</h3></th></tr>
				<tr><td colspan="3">' . $_POST['doprava'] . '</td></tr>
				<tr><th colspan="3"><h3>Kontaktní údaje</h3></th></tr>
				<tr><td>Jméno:</td><td colspan="2">' . $_POST['jmeno'] . '</td></tr>
				<tr><td>Příjmení:</td><td colspan="2">' . $_POST['prijmeni'] . '</td></tr>
				<tr><td>E-mail:</td><td colspan="2">' . $_POST['email'] . '</td></tr>
				<tr><td>Telefon:</td><td colspan="2">' . $_POST['telefon'] . '</td></tr>
				<tr><th colspan="3">Adresa</th></tr>
				<tr><td>Ulice:</td><td colspan="2">' . $_POST['ulice'] . '</td></tr>
				<tr><td>Obec:</td><td colspan="2">' . $_POST['obec'] . '</td></tr>
				<tr><td>PSČ:</td><td colspan="2">' . $_POST['psc'] . '</td></tr>
				<tr><td>Stát:</td><td colspan="2">' . $_POST['stat'] . '</td></tr>
				<tr><th colspan="3">Poznámka</th></tr>
				<tr><td colspan="3">' . $_POST['poznamka'] . '</td></tr>
				</table>';

        $textp .= '<h1>Zakoupené produkty</h1>
				<table class="shop_kosik_table">
				<tr><th>Název</th>
				<th>Počet</th><th>Cena bez DPH</th>
				<th>Cena s DPH</th></tr>';
        $sql = "SELECT * FROM `shop_kosik` WHERE `user` = -" . $id_obednavky . "";
        $q = mysql_query($sql);
        $prazdny = true;
        $celkem = 0;
        $celkemsdph = 0;
        while ($res = mysql_fetch_array($q)) {
            $prazdny = false;
            $textp .= '<tr>';
            $dir = dir(PATH . "/userfiles/shop/");
            
            $sql = "SELECT * FROM `shop` WHERE `id` = " . $res['id_produkt'] . "";
            $q2 = mysql_query($sql);
            if ($res2 = mysql_fetch_array($q2)) {
                $sql = "SELECT `parent` FROM `shop_menu` WHERE `id` = " . $res2['parent'] . "";
                $q3 = mysql_query($sql);
                if ($res3 = mysql_fetch_array($q3)) {
                    $menulink = getMenuLink($res3['parent']);
                }
                $textp .= '<td><a href="' . URL . $menulink . "/" . $res2['link'] . '/">' . $res2['nazev'] . '</a><br />' . $res2['code'] . '</td>';
                $textp .= '<td>' . $res['pocet'] . '&nbsp;ks</td>';
                $celkem += $res['pocet'] * $res2['cena'];
                $textp .= '<td>' . round($res['pocet'] * $res2['cena']) . '&nbsp;Kč</td>';
                $celkemsdph += $res['pocet'] * $res2['cena'] * (1 + $res2['dph'] / 100);
                $textp .= '<td>' . round($res['pocet'] * $res2['cena'] * (1 + $res2['dph'] / 100)) . '&nbsp;Kč</td>';
            }

            $textp .= '</tr>';
        }
        if ($prazdny == true) {
            $textp .= '<tr><td colspan="6">Košík je prázdný</td></tr>';
        }
        $textp .= '<tr><td colspan="2"><strong>Celková cena položek:</strong></td><td><strong>' . round($celkem) . '&nbsp;Kč</strong></td><td><strong>' . round($celkemsdph) . '&nbsp;Kč</strong></td></tr>';
        $textp .= '</table>';

        $textk = '<p>S pozdravem Náš tým</p>
					</body>
				</html>
			';

        $text = $texth.$text.$textp.$textk;
        $text_admin = $texth.$text_admin.$textp.$textk;

        global $mailer;
            $message = Swift_Message::newInstance()
                            //Give the message a subject
                            ->setSubject("Potvrzení přijetí objednávky - číslo: $cislo")
                            //Set the From address with an associative array
                            ->setFrom(array(ADMIN_MAIL => "Info " . PAGE_NAME))
                            //Set the To addresses with an associative array
                            ->setTo(array($_POST['email']))
                            //Give it a body
                            //->setBody('Here is the message itself')
                            //And optionally an alternative body
                            ->addPart($text, 'text/html')
                            //Optionally add any attachments
                            //->attach(Swift_Attachment::fromPath('my-document.pdf'))
                    ;
            $result = $mailer->send($message);
            $message = Swift_Message::newInstance()
                            //Give the message a subject
                            ->setSubject("Potvrzení přijetí objednávky - číslo: $cislo")
                            //Set the From address with an associative array
                            ->setFrom(array(ADMIN_MAIL => "Info " . PAGE_NAME))
                            //Set the To addresses with an associative array
                            ->setTo(array(ADMIN_MAIL))
                            //Give it a body
                            //->setBody('Here is the message itself')
                            //And optionally an alternative body
                            ->addPart($text_admin, 'text/html')
                            //Optionally add any attachments
                            //->attach(Swift_Attachment::fromPath('my-document.pdf'))
                    ;
            $result = $mailer->send($message);
            
        echo '
				<img src="' . URL . 'frogSys/images/modules/SHOP/shop_faze_5.png" alt="fáze 5" />
				<hr />';
        echo '
				<h1>Objednávka úspěšně dokončena.</h1>
				<p>Na váš e-mail vám dorazí informace o objednávce.</p>
			';
    } else {
        echo '
		<img src="' . URL . 'frogSys/images/modules/SHOP/shop_faze_1.png" alt="fáze 1" />
		<hr />';
        if (isset($_GET['prepocitat'])) {
            foreach ($_POST['pocet'] as $id => $pocet) {
                if ($pocet == 0) {
                    $sql = "DELETE FROM `shop_kosik` WHERE `id` = " . $id . "";
                    $q = mysql_query($sql);
                } else {
                    $sql = "UPDATE `shop_kosik` SET `pocet` = " . $pocet . " WHERE `id` = " . $id . "";
                    $q = mysql_query($sql);
                }
            }
            echo '<p>Košík přepočítán</p><hr />';
        }
        echo '<form name="prepocitani" action="?prepocitat" method="post">
		<table class="shop_kosik_table"><tr><th>Obrázek</th><th>Název</th><th>Počet</th><th>Cena bez DPH</th><th>Cena s DPH</th><th>Odstranit</th></tr>';
        $sql = "SELECT * FROM `shop_kosik` WHERE `user` = " . USER_ID . "";
        $q = mysql_query($sql);
        $prazdny = true;
        $celkem = 0;
        $celkemsdph = 0;
        while ($res = mysql_fetch_array($q)) {
            $prazdny = false;
            echo '<tr><td>';
            $dir = dir(PATH . "/userfiles/shop/");
            while ($file1 = $dir->read()) {
                $find = preg_replace('/' . $res['id_produkt'] . '\.0\.(png|jpg|gif)/', '$founded$', $file1);
                if (strstr($find, '$founded$')) {
                    echo "<img src=\"" . URL . "userfiles/shop/" . $file1 . "\" class=\"image\" alt=\"obrázek produktu\" />";
                    break;
                }
            }
            echo '</td>';
            $sql = "SELECT * FROM `shop` WHERE `id` = " . $res['id_produkt'] . "";
            $q2 = mysql_query($sql);
            if ($res2 = mysql_fetch_array($q2)) {
                $sql = "SELECT `parent` FROM `shop_menu` WHERE `id` = " . $res2['parent'] . "";
                $q3 = mysql_query($sql);
                if ($res3 = mysql_fetch_array($q3)) {
                    $menulink = getMenuLink($res3['parent']);
                }
                echo '<td><a href="' . URL . $menulink . "/" . $res2['link'] . '/">' . $res2['nazev'] . '</a><br />' . $res2['code'] . '</td>';
                echo '<td><input name="pocet[' . $res['id'] . ']" value="' . $res['pocet'] . '" />&nbsp;ks</td>';
                $celkem += $res['pocet'] * $res2['cena'];
                echo '<td>' . round($res['pocet'] * $res2['cena']) . '&nbsp;Kč</td>';
                $celkemsdph += $res['pocet'] * $res2['cena'] * (1 + $res2['dph'] / 100);
                echo '<td>' . round($res['pocet'] * $res2['cena'] * (1 + $res2['dph'] / 100)) . '&nbsp;Kč</td>';
                echo '<td><a href="javascript: smazZKosiku(' . $res['id'] . ');"><img src="' . URL . 'frogSys/images/icons/delete.png" alt="odstranit" /></a></td>';
            }

            echo '</tr>';
        }
        if ($prazdny == true) {
            echo '<tr><td colspan="6">Košík je prázdný</td></tr>';
        }
        echo '<tr><td colspan="3"><strong>Celková cena položek:</strong></td><td><strong>' . round($celkem) . '&nbsp;Kč</strong></td><td><strong>' . round($celkemsdph) . '&nbsp;Kč</strong></td></tr>';
        echo '</table>
		<hr />';
        if ($prazdny == false) {
            echo '
				<div class="left_kosik_tlacitko">
					<input type="image" src="' . URL . 'frogSys/images/modules/SHOP/btn-prepocitat.png" name="prepocitat" value="přepočítat" class="shop_left_button" />
                                        <a href="javascript: history.go(-1);"><img src="' . URL . 'frogSys/images/modules/SHOP/btn-forgot.png" alt="na něco jste zapoměl(a)?"></a>
				</div>
			</form>
			<form name="objednat" action="?krok=2" method="post">
				<div class="right_kosik_tlacitko">
					<input type="image" src="' . URL . 'frogSys/images/modules/SHOP/btn-pokracovat.png" name="objednat" value="Objednat" class="shop_right_button" />
				</div>
			</form>
			<hr />
			';
        } else {
            echo '</form>';
        }
    }
}
