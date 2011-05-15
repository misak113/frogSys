<?php
if ($_POST['action'] == "edit_menu_form") {
    $sql = "SELECT * FROM `shop_menu` WHERE `id` = " . $_POST['id'] . " LIMIT 1";
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
                <td>odkaz <img src="<?php echo URL; ?>frogSys/images/icons/info.png" width="10" height="10" alt="info" onmouseout="hideInfo();" onmouseover="showInfo(event, 'název důležitý pro stromovou struktůru v odkazu stránky (www.web.cz/polozka-menu/polozka-vevnitr/)');"> :</td>
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

    $sql = "SELECT * FROM `shop_menu` WHERE `id` = " . $_POST['id'] . "";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $sql = "SELECT * FROM `shop_menu` WHERE `parent` = " . $res['parent'] . " AND `link` = '" . $link . "' AND `id` <> " . $_POST['id'] . "";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $link = $link . "-" . $_POST['id'];
            $relink = "<br>Byl zjištěn duplicitní 'link', proto byl nahrazen za '" . $link . "'";
        }
    }

    $sql = "UPDATE `shop_menu` SET `nazev` = '" . $nazev . "', `link` = '" . $link . "' WHERE `id` = " . $_POST['id'] . "";
    if ($q = mysql_query($sql)) {
        echo "Položka kategorie E-shopu byla úspěšně uložena." . $relink;
    } else {
        echo "Nastala chyba při ukládání položky kategorie E-shopu!";
    }
}
if ($_POST['action'] == "delete_menu") {
    $sql = "DELETE FROM `shop_menu` WHERE `id` = " . $_POST['id'] . "";
    if ($q = mysql_query($sql)) {
        echo "Položka menu e-shopu byla smazána.";
    }
}
if ($_POST['action'] == "add_menu") {
    $sql = "SELECT max(order) AS order FROM shop_menu";
    $q = mysql_query($sql);
    $res = mysql_fetch_array($q);
    $rand = mt_rand(1000, 9999);
    $sql = "INSERT INTO `shop_menu` VALUES(NULL, 'Nová kategorie', 'nova-kategorie-" . $rand . "', " . $_POST['parent'] . ", ".($res['order']+1).")";
    if ($q = mysql_query($sql)) {
        $sql = "SELECT `id` FROM `shop_menu` WHERE `link` = 'nova-kategorie-" . $rand . "'";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            echo $res['id'];
        }
    }
}
if ($_POST['action'] == "get_parent") {
    $sql = "SELECT `parent` FROM `shop_menu` WHERE `id` = " . $_POST['id'] . "";
    if ($q = mysql_query($sql)) {
        if ($res = mysql_fetch_array($q)) {
            echo $res['parent'];
        }
    }
}
if ($_POST['action'] == "save_produkt_popis") {
    $sql = "UPDATE `shop` SET `popis` = '" . $_POST['text'] . "' WHERE `id` = " . $_POST['id'] . "";
    if ($q = mysql_query($sql)) {
        echo "Popis byl uložen.";
    }
}
if ($_POST['action'] == "save_produkt_anotace") {
    $sql = "UPDATE `shop` SET `anot` = '" . $_POST['text'] . "' WHERE `id` = " . $_POST['id'] . "";
    if ($q = mysql_query($sql)) {
        echo "Anotace byla uložena.";
    }
}
if ($_POST['action'] == "set_produkt_show") {
    $sql = "UPDATE `shop` SET `show` = '" . $_POST['show'] . "' WHERE `id` = " . $_POST['id'] . "";
    if ($q = mysql_query($sql)) {
        echo "Zobrazení bylo změněno.";
    }
}
if ($_POST['action'] == "set_produkt_doporucujeme") {
    $sql = "UPDATE `shop` SET `doporucujeme` = '" . $_POST['doporucujeme'] . "' WHERE `id` = " . $_POST['id'] . "";
    if ($q = mysql_query($sql)) {
        echo "Doporučení bylo změněno.";
    }
}
if ($_POST['action'] == "set_produkt_nazev") {
    $text = $_POST['nazev'];
    $text = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $text);
    $link = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['link']);


    $sql = "SELECT * FROM `shop` WHERE `link` = '" . $link . "' AND `id` <> " . $_POST['id'] . "";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $link = $link . "-" . $_POST['id'];
        $relink = "<br>Byl zjištěn duplicitní 'link', proto byl nahrazen za '" . $link . "'";
    }



    $sql = "UPDATE `shop` SET `nazev` = '" . $text . "', `link` = '" . $link . "' WHERE `id` = " . $_POST['id'] . "";
    if ($q = mysql_query($sql)) {
        echo "Název byl změněn." . $relink;
    }
}
if ($_POST['action'] == "set_produkt_cena") {
    $cena = $_POST['cena'];
    $dph = $_POST['dph'];
    $sql = "UPDATE `shop` SET `cena` = '" . $cena . "', `dph` = '" . $dph . "' WHERE `id` = " . $_POST['id'] . "";
    if ($q = mysql_query($sql)) {
        echo "Cena a DPH byly změněny.";
    }
}
if ($_POST['action'] == "set_produkt_skladem") {
    $skladem = $_POST['skladem'];
    $sql = "UPDATE `shop` SET `skladem` = '" . $skladem . "' WHERE `id` = " . $_POST['id'] . "";
    if ($q = mysql_query($sql)) {
        echo "Počet produktů skladem změněn.";
    }
}
if ($_POST['action'] == "set_produkt_vyrobce") {
    $text = $_POST['vyrobce'];
    $sql = "UPDATE `shop` SET `vyrobce` = '" . $text . "' WHERE `id` = " . $_POST['id'] . "";
    if ($q = mysql_query($sql)) {
        echo "Výrobce byl změněn.";
    }
}
if ($_POST['action'] == "naseptavac_vyrobce") {
    $sql = "SELECT DISTINCT `vyrobce` FROM `shop` WHERE `vyrobce` LIKE '" . $_POST['vyrobce'] . "%' AND `vyrobce` != '" . $_POST['vyrobce'] . "'";
    $q = mysql_query($sql);
    $text = "";
    while ($res = mysql_fetch_array($q)) {
        $text .= $res['vyrobce'] . "Đ";
    }
    echo $text;
}
if ($_POST['action'] == "set_produkt_code") {
    $text = $_POST['code'];
    $sql = "UPDATE `shop` SET `code` = '" . $text . "' WHERE `id` = " . $_POST['id'] . "";
    if ($q = mysql_query($sql)) {

        echo "Kód produktu byl změněn.";
    } else {
        echo "Takový kód již některý produkt má.";
    }
}
if ($_POST['action'] == "control_produkt_code") {
    $sql = "SELECT * FROM `shop` WHERE `code` = '" . $_POST['code'] . "' AND `id` != " . $_POST['id'] . "";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        echo "false";
    }
    echo $text;
}
if ($_POST['action'] == "get_categories") {
    echo "<option value=\"0\" selected>-</option>";
    $sql = "SELECT * FROM `shop_menu` WHERE `parent` = " . $_POST['parent'] . "";
    $q3 = mysql_query($sql);
    while ($res3 = mysql_fetch_array($q3)) {
        echo "<option value=\"" . $res3['id'] . "\"" . $sel . ">" . $res3['nazev'] . "</option>";
    }
}
if ($_POST['action'] == "set_produkt_category") {
    $text = $_POST['category'];
    $sql = "UPDATE `shop` SET `parent` = '" . $text . "' WHERE `id` = " . $_POST['id'] . "";
    if ($q = mysql_query($sql)) {
        echo "Kategorie byla změněna.";
    }
}
if ($_POST['action'] == "add_produkt") {
    $parento = $_POST['parent'];
    if ($_POST['parent'] == 0) {
        $sql = "SELECT * FROM `shop_menu` WHERE `parent` = " . $_POST['page_part'] . " ORDER BY `nazev` LIMIT 1";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $parento = $res['id'];
        } else {
            $rand = mt_rand(1000, 9999);
            $sql = "INSERT INTO `shop_menu` VALUES(NULL, 'Nová kategorie', 'nova-kategorie-" . $rand . "', " . $_POST['page_part'] . ")";
            if ($q = mysql_query($sql)) {
                $sql = "SELECT `id` FROM `shop_menu` WHERE `link` = 'nova-kategorie-" . $rand . "'";
                $q = mysql_query($sql);
                if ($res = mysql_fetch_array($q)) {
                    $parento = $res['id'];
                }
            }
        }
    }
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
    $sql = "SELECT max(order) AS order FROM shop WHERE parent = $parento";
    $q = mysql_query($sql);
    $res = mysql_fetch_array($q);
    $next_order = $res['order']+1;
    $sql = "INSERT INTO `shop` VALUES(NULL, 'Nový produkt', 'Dlouhý popis', 'Krátký popis', 0, " . $_SETING['DPH'] . ", 0, " . $parento . ", '" . $code . "', '', 0, 0, 'novy-produkt', $next_order)";
    $q = mysql_query($sql);
    $sql = "SELECT `id` FROM `shop` WHERE `code` = '" . $code . "'";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        echo $res['id'];
    }
}
if ($_POST['action'] == "delete_produkt") {
    $sql = "DELETE FROM `shop` WHERE `id` = " . $_POST['id'] . "";
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
    unlink(PATH . "/userfiles/shop/" . $file);
    if ($poradi == 0) {
        $dir = dir(PATH . "/userfiles/shop/");
        while ($file1 = $dir->read()) {
            $find = preg_replace('/' . $id . '\.[0-9]+\.jpg/', '$founded$', $file1);
            if (strstr($find, '$founded$')) {
                $fil1 = explode(".", $file1);
                $type1 = $fil1[2];
                rename(PATH . "/userfiles/shop/" . $file1, PATH . "/userfiles/shop/" . $id . ".0." . $type1);
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
    rename(PATH . "/userfiles/shop/" . $file, PATH . "/userfiles/shop/temp.jpg");
    $dir = dir(PATH . "/userfiles/shop/");
    while ($file1 = $dir->read()) {
        $find = preg_replace('/' . $id . '\.0\.jpg/', '$founded$', $file1);
        if (strstr($find, '$founded$')) {
            rename(PATH . "/userfiles/shop/" . $file1, PATH . "/userfiles/shop/" . $file);
            break;
        }
    }
    rename(PATH . "/userfiles/shop/temp.jpg", PATH . "/userfiles/shop/" . $file1);
    echo "Obrázek nastaven jako hlavní.";
}

if ($_POST['action'] == "objednavky") {
    echo '
                        <table id="shop_objednavky">
                            <tr>
                                <th>Vyřízena</th>
                                <th>Číslo objednávky</th>
                                <th>Jméno a příjmení</th>
                                <th>Cena bez DPH</th>
                                <th>Cena s DPH</th>
                            </tr>
                    ';
    $sql = "SELECT * FROM `shop_objednavky` ORDER BY `vyrizeno`, `datetime`";
    $q = mysql_query($sql);
    while ($res = mysql_fetch_array($q)) {
        echo '
                            <tr class="objednavka_item">
                                <td>
                                    ';
        if ($res['vyrizeno'] == 1) {
            echo "<a href=\"javascript: shopObjednavkaSetNevyrizeno(" . $res['id'] . ");\"><img src=\"" . URL . "frogSys/images/icons/ok.png\" alt=\"OK\" id=\"shop_vyrizeno_" . $res['id'] . "\" /></a>";
        } else {
            echo "<a href=\"javascript: shopObjednavkaSetVyrizeno(" . $res['id'] . ");\"><img src=\"" . URL . "frogSys/images/icons/no.png\" alt=\"NO\" id=\"shop_vyrizeno_" . $res['id'] . "\" /></a>";
        }
        if ($res['sended'] == 1) {
            echo "<a href=\"javascript: shopObjednavkaSendMail(" . $res['id'] . ");\"><img src=\"" . URL . "frogSys/images/icons/messagesend.png\" alt=\"Odeslán\" id=\"shop_send_" . $res['id'] . "\" /></a>";
        } else {
            echo "<a href=\"javascript: shopObjednavkaSendMail(" . $res['id'] . ");\"><img src=\"" . URL . "frogSys/images/icons/messageunsend.png\" alt=\"neodeslán\" id=\"shop_send_" . $res['id'] . "\" /></a>";
        }
        echo '
                                </td>
                                <td>
                                    <a href="javascript: showObjednavka(' . $res['id'] . ');">' . $res['cislo'] . '</a>
                                </td>
                                <td>
                                    ' . $res['jmeno'] . ' ' . $res['prijmeni'] . '
                                </td>
                                <td>
                                    ' . $res['cena_bez_dph'] . ' Kč
                                </td>
                                <td>
                                    ' . $res['cena_s_dph'] . ' Kč
                                </td>
                            </tr>
                        ';
    }
    echo '</table>';
    echo '<div id="shop_nastaveni">';
    $sql = "SELECT * FROM `seting` WHERE `name` = 'postovne'";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $postovne = $res['value'];
    } else {
        $sql = "INSERT INTO `seting` VALUES(NULL, 'postovne', '100')";
        mysql_query($sql);
        $postovne = 100;
    }
    echo '<div>Poštovné: <input value="'.$postovne.'" id="shop_postovne" onkeyup="save_postovne();" /> Kč</div>';
    $sql = "SELECT * FROM `seting` WHERE `name` = 'DPH'";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $dph = $res['value'];
    } else {
        $sql = "INSERT INTO `seting` VALUES(NULL, 'DPH', '19')";
        mysql_query($sql);
        $dph = 19;
    }
    echo '<div>DPH: <input value="'.$dph.'" id="shop_dph" onkeyup="save_dph();" /> %</div>';
    echo '</div>';
}
if ($_POST['action'] == "set_vyrizeno") {
    $sql = "UPDATE `shop_objednavky` SET `vyrizeno` = " . $_POST['vyrizeno'] . " WHERE `id` = " . $_POST['id'];
    $q = mysql_query($sql);
    echo "Status vyřízení nastaven.";
}
if ($_POST['action'] == "send_mail") {
    $sql = "UPDATE `shop_objednavky` SET `sended` = 1 WHERE `id` = " . $_POST['id'];
    $q = mysql_query($sql);

    $sql = "SELECT * FROM `shop_objednavky` WHERE `id` = " . $_POST['id'] . "";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $headers = get_mail_header("Informace o objednáce", "Info " . PAGE_NAME, ADMIN_MAIL);

        imap_mail("" . $res['mail'] . ", " . ADMIN_MAIL . "",
                "",
                $_POST['text'],
                $headers
        );
        echo "Email o vyřízení odeslán.";
    }
}
if ($_POST['action'] == "send_mail_table") {
    $sql = "SELECT * FROM `shop_objednavky` WHERE `id` = " . $_POST['id'] . "";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        echo '
                        <table>
                            <tr>
                                <td>
                                <textarea id="shop_mail_text" style="width: 400px; height: 300px;">Dobrý den ' . $res['jmeno'] . ' ' . $res['prijmeni'] . ',
Vaše objednávka číslo ' . $res['cislo'] . ' byla úspěšně vyřízena a odeslána na vaši adresu.

S pozdravem náš tým.</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="button" value="Odeslat" onclick="shopObjednavkaSendMail2(' . $_POST['id'] . ')" />
                                </td>
                            </tr>
                        </table>

                    ';
    }
}
if ($_POST['action'] == "show_objednavka") {
    $sql = "SELECT * FROM `shop_objednavky` WHERE `id` = " . $_POST['id'] . "";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $text = '
				<html>
					<head>
						<META http-equiv=3D"Content-Type" content=3D"text/html;chars=et=3Dutf-8">
					</head>
					<body>
					<h1>Číslo objednávky: ' . $res['cislo'] . '</h1>
				<h2>Shrnutí informací:</h2>
				<table class="kosik-summ">
				<tr><th colspan="3"><h2>Nákup</h2></th></tr>
				<tr><th>Jméno a příjmení:</th><td colspan="2">' . $res['jmeno'] . ' ' . $res['prijmeni'] . '</td></tr>
                                <tr><th>Cena</th><th><h3>Cena bez DPH</h3></th><th>Cena s DPH</th></tr>
				<tr><td>Cena celkem:</td><td>' . $res['cena_bez_dph'] . '&nbsp;Kč</td><td>' . $res['cena_s_dph'] . '&nbsp;Kč</td></tr>
				<tr><td>Doprava:</td><td colspan="2">' . $res['doprava'] . '</td></tr>
				<tr><th colspan="3"><h3>Kontaktní údaje</h3></th></tr>
				<tr><td>Jméno:</td><td colspan="2">' . $res['jmeno'] . '</td></tr>
				<tr><td>Příjmení:</td><td colspan="2">' . $res['prijmeni'] . '</td></tr>
				<tr><td>E-mail:</td><td colspan="2">' . $res['mail'] . '</td></tr>
				<tr><td>Telefon:</td><td colspan="2">' . $res['telefon'] . '</td></tr>
				<tr><th colspan="3">Adresa</th></tr>
				<tr><td>Ulice:</td><td colspan="2">' . $res['ulice'] . '</td></tr>
				<tr><td>Obec:</td><td colspan="2">' . $res['obec'] . '</td></tr>
				<tr><td>PSČ:</td><td colspan="2">' . $res['psc'] . '</td></tr>
				<tr><td>Stát:</td><td colspan="2">' . $res['stat'] . '</td></tr>
				<tr><th colspan="3">Poznámka</th></tr>
				<tr><td colspan="3">' . $res['poznamka'] . '</td></tr>
				</table>';

        $text .= '<h1>Zakoupené produkty</h1>
				<table class="shop_kosik_table">
				<tr><th>Obrázek</th><th>Název</th>
				<th>Počet</th><th>Cena bez DPH</th>
				<th>Cena s DPH</th><th>Odstranit</th></tr>';
        $sql = "SELECT * FROM `shop_kosik` WHERE `user` = -" . $_POST['id'] . "";
        $q = mysql_query($sql);
        $prazdny = true;
        while ($res = mysql_fetch_array($q)) {
            $prazdny = false;
            $text .= '<tr><td>';
            $dir = dir(PATH . "/userfiles/shop/");
            while ($file1 = $dir->read()) {
                $find = preg_replace('/' . $res['id_produkt'] . '\.0\.(png|jpg|gif)/', '$founded$', $file1);
                if (strstr($find, '$founded$')) {
                    $text .= "<img src=\"" . URL . "/userfiles/shop/" . $file1 . "\" height=\"30\" class=\"image\" alt=\"obrázek produktu\" />";
                    break;
                }
            }
            $text .= '</td>';
            $sql = "SELECT * FROM `shop` WHERE `id` = " . $res['id_produkt'] . "";
            $q2 = mysql_query($sql);
            if ($res2 = mysql_fetch_array($q2)) {
                $sql = "SELECT `parent` FROM `shop_menu` WHERE `id` = " . $res2['parent'] . "";
                $q3 = mysql_query($sql);
                if ($res3 = mysql_fetch_array($q3)) {
                    $menulink = getMenuLink($res3['parent']);
                }
                $text .= '<td><a target=\"_blank\" href="' . URL . $menulink . "/" . $res2['link'] . '/">' . $res2['nazev'] . '</a><br />' . $res2['code'] . '</td>';
                $text .= '<td>' . $res['pocet'] . '&nbsp;ks</td>';
                $celkem += $res['pocet'] * $res2['cena'];
                $text .= '<td>' . round($res['pocet'] * $res2['cena']) . '&nbsp;Kč</td>';
                $celkemsdph += $res['pocet'] * $res2['cena'] * (1 + $res2['dph'] / 100);
                $text .= '<td>' . round($res['pocet'] * $res2['cena'] * (1 + $res2['dph'] / 100)) . '&nbsp;Kč</td>';
            }

            $text .= '</tr>';
        }
        if ($prazdny == true) {
            $text .= '<tr><td colspan="6">Objednávka je prázdná!</td></tr>';
        }
        $text .= '<tr><td colspan="3"><strong>Celková cena položek:</strong></td><td><strong>' . round($celkem) . '&nbsp;Kč</strong></td><td><strong>' . round($celkemsdph) . '&nbsp;Kč</strong></td></tr>';
        $text .= '</table>';

        $text .= '
					</body>
				</html>
			';

        echo $text;
    }
}


if ($_POST['action'] == "sort_menu") {
    $sql = "SELECT `parent` FROM `shop_menu` WHERE `id` = '" . $_POST['id'] . "' LIMIT 1";
    $q = mysql_query($sql);
    $res = mysql_fetch_array($q);
    $parent = $res['parent'];
    $sql = "SELECT `sort` AS target FROM `shop_menu` WHERE `id` = '" . $_POST['change_with'] . "' LIMIT 1";
    if ($_POST['change_with'] == "") {
        $sql = "SELECT (MAX(`sort`)+1) AS target FROM `shop_menu` WHERE `parent` = " . $parent . " LIMIT 1";
    }
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $target = $res['target'] - 1;
        $sql = "SELECT * FROM `shop_menu` WHERE `id` = '" . $_POST['id'] . "' LIMIT 1";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $from = $res['sort'];
            if ($target > $from) {
                $sql = "UPDATE `shop_menu` SET `sort` = `sort`-1 WHERE `sort` >= $from AND `sort` <= $target AND `parent` = $parent";
                $q = mysql_query($sql);
                $sql = "UPDATE `shop_menu` SET `sort` = " . $target . " WHERE `id` = " . $_POST['id'] . "";
                $q = mysql_query($sql);
                echo "Úspěšně přesunuta položka menu.";
            }
            if ($target < $from) {
                $sql = "UPDATE `shop_menu` SET `sort` = `sort`+1 WHERE `sort` >= " . ($target + 1) . " AND `sort` <= $from AND `parent` = $parent";
                $q = mysql_query($sql);
                $sql = "UPDATE `shop_menu` SET `sort` = " . ($target + 1) . " WHERE `id` = " . $_POST['id'] . "";
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

if ($_POST['action'] == "sort_produkt") {
    $sql = "SELECT `parent` FROM `shop` WHERE `id` = '" . $_POST['id'] . "' LIMIT 1";
    $q = mysql_query($sql);
    $res = mysql_fetch_array($q);
    $parent = $res['parent'];
    $sql = "SELECT `order` AS target FROM `shop` WHERE `id` = '" . $_POST['change_with'] . "' LIMIT 1";
    if ($_POST['change_with'] == "") {
        $sql = "SELECT (MAX(`order`)+1) AS target FROM `shop` WHERE `parent` = " . $parent . " LIMIT 1";
    }
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $target = $res['target'] - 1;
        $sql = "SELECT * FROM `shop` WHERE `id` = '" . $_POST['id'] . "' LIMIT 1";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $from = $res['order'];
            if ($target > $from) {
                $sql = "UPDATE `shop` SET `order` = `order`-1 WHERE `order` >= $from AND `order` <= $target AND `parent` = $parent";
                $q = mysql_query($sql);
                $sql = "UPDATE `shop` SET `order` = " . $target . " WHERE `id` = " . $_POST['id'] . "";
                $q = mysql_query($sql);
                echo "Úspěšně přesunuta položka.";
            }
            if ($target < $from) {
                $sql = "UPDATE `shop` SET `order` = `order`+1 WHERE `order` >= " . ($target + 1) . " AND `order` <= $from AND `parent` = $parent";
                $q = mysql_query($sql);
                $sql = "UPDATE `shop` SET `order` = " . ($target + 1) . " WHERE `id` = " . $_POST['id'] . "";
                $q = mysql_query($sql);
                echo "Úspěšně přesunuta položka.";
            }
            if ($target == $from) {
                echo "Položky nebyly přesunuty.";
            }
        } else {
            echo "Nastala chyba při přemisťování položky!";
        }
    } else {
        echo "Nastala chyba při přemisťování položky!";
    }
}

if ($_POST['action'] == "set_postovne") {
    $post = (0 + $_POST['postovne']);
    if ($post == 0) {
        die("Poštovné musí být číslo větší jak 0!");
    }
    $sql = "UPDATE seting SET `value` = '".$post."' WHERE `name` = 'postovne'";
    mysql_query($sql);
    echo "Poštovné nastaveno na ".$post." Kč";
}

if ($_POST['action'] == "set_dph") {
    $dph = 0+$_POST['dph'];
    if ($dph == 0) {
        die("DPH musí být číslo větší jak 0!");
    }
    $sql = "UPDATE seting SET `value` = '".$dph."' WHERE `name` = 'DPH'";
    mysql_query($sql);
    echo "DPH nastaveno na ".$dph." %";
}







if (@$_GET['action'] == "add_images") {
    require_once "../../../../../config/database.php";
    include "../../../../bin/scripts.php";
    if (@$_SESSION['auth'] > 0) {
        //
        //	specify file parameter name
        $file_param_name = 'file';

        //
        //	retrieve uploaded file name
        $file_name = $_FILES[$file_param_name]['name'];

        //
        //	retrieve uploaded file path (temporary stored by php engine)
        $source_file_path = $_FILES[$file_param_name]['tmp_name'];

        //
        //	construct target file path (desired location of uploaded file) -
        //	here we put to the web server document root (i.e. '/home/wwwroot')
        //	using user supplied file name
        $target_file_path = PATH . "/userfiles/shop/temp/" . $file_name;

        unzip($source_file_path, $target_file_path);

        $file_num = -1;
        $dir = dir(PATH . "/userfiles/shop/");
        while ($file = $dir->read()) {
            $find = preg_replace('/' . $_GET['produkt'] . '\.([0-9]+)\.jpg/', '$founded$', $file);
            echo $file . " / ";
            if (strstr($find, '$founded$')) {
                $file_exp = explode(".", $file);
                echo $file_exp[1] . " . ";
                if ($file_exp[1] > $file_num) {
                    $file_num = $file_exp[1];
                }
            }
        }

        $new_fil = PATH . "/userfiles/shop/" . $_GET['produkt'] . "." . ($file_num + 1) . ".jpg";
        copy(PATH . "/userfiles/shop/temp/" . $file_name . "small.jpg", $new_fil);
        chmod($new_fil, 0666);
        unlink(PATH . "/userfiles/shop/temp/" . $file_name . "small.jpg");
        unlink(PATH . "/userfiles/shop/temp/" . $file_name . "large.jpg");
    }
    mysql_close();
}
?>