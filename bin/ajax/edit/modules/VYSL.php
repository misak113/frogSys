<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_POST['action'] == "add_soutez") {
    $rand = mt_rand(10000, 99999);
    $sql = "INSERT INTO `vysledky_soutez` VALUES(NULL, 'Nová soutěž ".$rand."')";
    mysql_query($sql);
    $sql = "SELECT * from `vysledky_soutez` WHERE `nazev` = 'Nová soutěž ".$rand."'";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $id_souteze = $res['id_souteze'];
    }
    $sql = "SELECT * FROM `vysledky` WHERE `parent` = ".$_POST['parent'];
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $sql = "UPDATE `vysledky` SET `soutez` = ".$id_souteze." WHERE `parent` = ".$_POST['parent'];
    } else {
        $sql = "INSERT INTO `vysledky` VALUES(NULL, ".$_POST['parent'].", ".$id_souteze.")";
    }
    mysql_query($sql);

    echo "Soutěž byla přidána.";
}

if ($_POST['action'] == "set_soutez") {
    $sql = "SELECT * FROM `vysledky` WHERE `parent` = ".$_POST['parent'];
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $sql = "UPDATE `vysledky` SET `soutez` = ".$_POST['soutez']." WHERE `parent` = ".$_POST['parent'];
    } else {
        $sql = "INSERT INTO `vysledky` VALUES(NULL, ".$_POST['parent'].", ".$_POST['soutez'].")";
    }
    mysql_query($sql);

    echo "Soutěž byla nastavena.";
}

if ($_POST['action'] == "save_soutez") {
    $sql = "UPDATE `vysledky_soutez` SET `nazev` = '".$_POST['nazev']."' WHERE `id_souteze` = ".$_POST['id'];
    mysql_query($sql);
    echo "Název soutěže byl nastaven na ".$_POST['nazev'];
}

if ($_POST['action'] == "delete_soutez") {
    $sql = "DELETE FROM `vysledky_soutez` WHERE `id_souteze` = ".$_POST['id'];
    mysql_query($sql);
    echo "Soutěž byla smazána.";
}

if ($_POST['action'] == "edit_utkani_table") {

    if ($_POST['id'] == "new") {
        $res['id_utkani'] = "new";
        $res['datetime'] = date("Y-n-d G:j:s");
    } else {
        $sql = "SELECT * FROM `vysledky_utkani` WHERE `id_utkani` = ".$_POST['id'];
        $q = mysql_query($sql);
        $res = mysql_fetch_array($q);
    }
    if ($res) {
    ?>
<table>
    <tr>
        <td>Datum:</td>
        <td>
        <?php
        $datetime = $res['datetime'];
        $dt = explode(" ", $datetime);
        $date = $dt[0];
        $t = explode(":", $dt[1]);
        $time = $t[0].":".$t[1];
                                        $k_id = "ids_datum_".$res['id_utkani'];
					$k_start = $date;
					$k_stop = $date;
					$k_mesic = 0;
					$k_rok = 0;
					$k_editable = "true";
					echo '<div id="kalendar_'.$k_id.'" style="border: 1px black solid; position: relative; background-color: white;  display: block;">';
					include PATH."/frogSys/bin/plugins/kalendar.php";
                                        writeKalendar($k_id, $k_start, $k_stop, $k_mesic, $k_rok, $k_editable);
					echo '</div>';
        ?>
            <input type="hidden" id="plan_akci_kdy_ids_datum_<?php echo $res['id_utkani']; ?>" value="<?php echo $date; ?>" />
            <input type="hidden" id="plan_akci_do_ids_datum_<?php echo $res['id_utkani']; ?>" value="<?php echo $date; ?>" />
            <input type="text" id="cas_<?php echo $res['id_utkani']; ?>" value="<?php echo $time; ?>" />
        </td>
    </tr>
    <tr>
        <td>Domácí:</td>
        <td>
            <?php
                $sql = "SELECT * FROM `vysledky_tym`";
                $q2 = mysql_query($sql);
                $tymy = "";
                while ($res2 = mysql_fetch_array($q2)) {
                    $tymy .= $res2['nazev']."Đ";
                }
                $sql = "SELECT * FROM `vysledky_tym` WHERE `id_tymu` = ".@$res['id_domaci'];
                $q2 = mysql_query($sql);
                $res2 = @mysql_fetch_array($q2);
            ?>
            <input type="text" id="domaci_<?php echo $res['id_utkani']; ?>" value="<?php echo @$res2['nazev']; ?>" onkeyup="changeNazevUtkani(this, '<?php echo $tymy; ?>');" />
            <input type="hidden" id="ids_domaci_<?php echo $res['id_utkani']; ?>" value="<?php echo @$res['id_domaci']; ?>" /></td>
    </tr>
    <tr>
        <td>Hosté:</td>
        <td>
            <?php
                $sql = "SELECT * FROM `vysledky_tym` WHERE `id_tymu` = ".@$res['id_host'];
                $q2 = mysql_query($sql);
                $res2 = @mysql_fetch_array($q2);
            ?>
            <input type="text" id="hoste_<?php echo $res['id_utkani']; ?>" value="<?php echo @$res2['nazev']; ?>" onkeyup="changeNazevUtkani(this, '<?php echo $tymy; ?>');" />
            <input type="hidden" id="ids_hoste_<?php echo $res['id_utkani']; ?>" value="<?php echo @$res['id_host']; ?>" /></td>
    </tr>
    <tr>
        <td>Rozhodčí:</td>
        
        <td><?php
            $sql = "SELECT * FROM `vysledky_hrac` WHERE `rozhodci` = 1";
                $q2 = mysql_query($sql);
                $rzh = "";
                while ($res2 = mysql_fetch_array($q2)) {
                    $rzh .= $res2['jmeno']."Đ";
                }

        $sql = "SELECT * FROM `vysledky_rozhodci` JOIN `vysledky_hrac` USING (`id_hrace`) WHERE `id_utkani` = ".$_POST['id'];
        $q2 = mysql_query($sql);
        $rozhodci = "";
        $i=0;
        while ($res2 = @mysql_fetch_array($q2)) {
            $i++;
            $rozhodci += $res2['id_hrace'].",";
            ?>
            <input type="text" name="<?php echo $res2['id_hrace']; ?>" class="rozhodci_<?php echo $res['id_utkani']; ?>" value="<?php echo @$res2['jmeno']; ?>" onkeyup="changeRozhodciUtkani(this, '<?php echo $rzh; ?>');" />
            <br />
            <?php
        }
        if ($i == 0) {
            ?>
            <input type="text" name="" class="rozhodci_<?php echo $res['id_utkani']; ?>" value="" onkeyup="changeRozhodciUtkani(this, '<?php echo $rzh; ?>');" />
            <?php
        }
            ?>
            <img src="<?php echo URL; ?>frogSys/images/icons/plus.png" alt="přidat rozhodčího" 
                 onmouseover="showInfo(event, 'Přidat rozhodčího utkání', this)"
                 onclick="addRozhodci(this, <?php echo $res['id_utkani']; ?>)" />
            <input type="hidden" id="ids_rozhodci_<?php echo $res['id_utkani']; ?>" value="<?php echo @$rozhodci; ?>" /></td>
    </tr>
    <tr>
        <td>Hřiště:</td>
        <td><?php
                $sql = "SELECT * FROM `vysledky_hriste`";
                $q2 = mysql_query($sql);
                $hriste = "";
                while ($res2 = mysql_fetch_array($q2)) {
                    $hriste .= $res2['nazev']."Đ";
                }
                $sql = "SELECT * FROM `vysledky_hriste` WHERE `id_hriste` = ".@$res['id_hriste'];
                $q2 = mysql_query($sql);
                $res2 = @mysql_fetch_array($q2);
            ?>
            <input type="text" id="hriste_<?php echo $res['id_utkani']; ?>" value="<?php echo @$res2['nazev']; ?>" onkeyup="changeHristeUtkani(this, '<?php echo $hriste; ?>');" />
            <input type="hidden" id="ids_hriste_<?php echo $res['id_utkani']; ?>" value="<?php echo @$res['id_hriste']; ?>" /></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="button" value="Uložit" onclick="ulozitUtkani('<?php echo $res['id_utkani']; ?>');" /></td>
    </tr>
</table>
<?php
    }
}

if ($_POST['action'] == "get_id_tymu") {
    $sql = "SELECT `id_tymu` FROM `vysledky_tym` WHERE `nazev` = '".$_POST['nazev']."'";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        echo $res['id_tymu'];
    } else {
        echo "false";
    }

}

if ($_POST['action'] == "get_id_hriste") {
    $sql = "SELECT `id_hriste` FROM `vysledky_hriste` WHERE `nazev` = '".$_POST['nazev']."'";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        echo $res['id_hriste'];
    } else {
        echo "false";
    }

}

if ($_POST['action'] == "get_id_rozhodci") {
    $sql = "SELECT `id_hrace` FROM `vysledky_hrac` WHERE `rozhodci` = 1 AND `jmeno` = '".$_POST['nazev']."'";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        echo $res['id_hrace'];
    } else {
        echo "false";
    }

}

if ($_POST['action'] == "save_utkani") {
    $id_domaci = @$_POST['domaci_id'];
    $id_host = @$_POST['hoste_id'];
    $id_hriste = @$_POST['hriste_id'];

    if (isset($_POST['domaci_nazev'])) {
        $link = createLink($_POST['domaci_nazev']);
        $sql = "INSERT INTO `vysledky_tym` VALUES(NULL, '".$_POST['domaci_nazev']."', '', NULL, NULL, '".$link."')";
        mysql_query($sql);
        $sql = "SELECT * FROM `vysledky_tym` WHERE `nazev` = '".$_POST['domaci_nazev']."'";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $id_domaci = $res['id_tymu'];
        }
    }

    if (isset($_POST['hoste_nazev'])) {
        $link = createLink($_POST['hoste_nazev']);
        $sql = "INSERT INTO `vysledky_tym` VALUES(NULL, '".$_POST['hoste_nazev']."', '', NULL, NULL, '".$link."')";
        mysql_query($sql);
        $sql = "SELECT * FROM `vysledky_tym` WHERE `nazev` = '".$_POST['hoste_nazev']."'";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $id_host = $res['id_tymu'];
        }
    }

    $id_hriste = "NULL";
    if (isset($_POST['hriste_nazev'])) {
        $link = createLink($_POST['hriste_nazev']);
        $sql = "INSERT INTO `vysledky_hriste` VALUES(NULL, '".$_POST['hriste_nazev']."', '', NULL, NULL, '".$link."')";
        mysql_query($sql);
        $sql = "SELECT * FROM `vysledky_hriste` WHERE `nazev` = '".$_POST['hriste_nazev']."'";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $id_hriste = $res['id_hriste'];
        }
    }
    
    $sql = "DELETE FROM `vysledky_rozhodci` WHERE `id_utkani` = ".$_POST['id'];
    mysql_query($sql);
    $rozhodci = $_POST['rozhodci'];
    $exroz = explode(",", $rozhodci);
    foreach ($exroz as $roz) {
        $sql = "INSERT INTO `vysledky_rozhodci` VALUES(".$_POST['id'].", ".$roz.")";
        mysql_query($sql);
    }


    if (@$_POST['id'] == "new") {
        $sql = "INSERT INTO `vysledky_utkani` VALUES(NULL, ".$_POST['kolo'].", ".$id_host.", ".$id_hriste.", ".$id_domaci.", '".$_POST['date']." ".$_POST['time'].":00', NULL, 0, 0)";
    } else {
        $sql = "UPDATE `vysledky_utkani` SET `id_host` = ".$id_host.", `id_hriste` = ".$id_hriste.", `id_domaci` = ".$id_domaci.", `datetime` = '".$_POST['date']." ".$_POST['time'].":00' WHERE `id_utkani` = ".$_POST['id'];
    }
    mysql_query($sql);
    echo "Utkání bylo uloženo.";
}






if ($_POST['action'] == "edit_kolo_table") {

    if ($_POST['id'] == "new") {
        $res['id_kola'] = "new";
        $res['datetime'] = date("Y-n-d 00:00:00");
    } else {
        $sql = "SELECT * FROM `vysledky_kolo` WHERE `id_kola` = ".$_POST['id'];
        $q = mysql_query($sql);
        $res = mysql_fetch_array($q);
    }
    if ($res) {
    ?>
<table>
    <tr>
        <td>Datum:</td>
        <td>
        <?php
        $datetime = $res['datetime'];
        $dt = explode(" ", $datetime);
        $date = $dt[0];
                                        $k_id = "ids_kolo_datum_".$res['id_kola'];
					$k_start = $date;
					$k_stop = $date;
					$k_mesic = 0;
					$k_rok = 0;
					$k_editable = "true";
					echo '<div id="kalendar_'.$k_id.'" style="border: 1px black solid; position: relative; background-color: white;  display: block;">';
					include PATH."/frogSys/bin/plugins/kalendar.php";
                                        writeKalendar($k_id, $k_start, $k_stop, $k_mesic, $k_rok, $k_editable);
					echo '</div>';
        ?>
            <input type="hidden" id="plan_akci_kdy_ids_kolo_datum_<?php echo $res['id_kola']; ?>" value="<?php echo $date; ?>" />
            <input type="hidden" id="plan_akci_do_ids_kolo_datum_<?php echo $res['id_kola']; ?>" value="<?php echo $date; ?>" />
        </td>
    </tr>
    <tr>
        <?php
        if ($res['id_kola'] == "new") {
            $sql = "SELECT MAX(`poradi`) AS poradi FROM `vysledky_kolo` WHERE `id_souteze` = ".@$_POST['id_souteze']." AND `sezona` = '".VYSL_SEZONA."'";
            $q2 = mysql_query($sql);
            if ($res2 = mysql_fetch_array($q2)) {
                $res['poradi'] = $res2['poradi']+1;
            }
        }
        ?>
        <td>Pořadí:</td>
        <td><input type="text" id="poradi_kolo_<?php echo $res['id_kola']; ?>" value="<?php echo @$res['poradi']; ?>" /></td>
    </tr>
    <tr>
        <td>Název:</td>
        <td><input type="text" id="nazev_k_kolo_<?php echo $res['id_kola']; ?>" value="<?php echo @$res['nazev']; ?>" /></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="button" value="Uložit" onclick="ulozitKolo('<?php echo $res['id_kola']; ?>');" /></td>
    </tr>
</table>
<?php
    }
}



if ($_POST['action'] == "save_kolo") {

    if (@$_POST['id'] == "new") {
        $sql = "INSERT INTO `vysledky_kolo` VALUES(NULL, ".$_POST['id_souteze'].", ".$_POST['poradi'].", '".$_POST['nazev']."', '".$_POST['date']." 00:00:00', '".VYSL_SEZONA."')";
    } else {
        $sql = "UPDATE `vysledky_kolo` SET `poradi` = ".$_POST['poradi'].", `nazev` = '".$_POST['nazev']."', `datetime` = '".$_POST['date']." 00:00:00' WHERE `id_kola` = ".$_POST['id'];
    }
    mysql_query($sql);
    echo "Kolo bylo uloženo.";
}


if ($_POST['action'] == "delete_kolo") {
    $sql = "DELETE FROM `vysledky_kolo` WHERE `id_kola` = ".$_POST['id'];
    mysql_query($sql);
    echo "Kolo bylo smazáno.";
}

if ($_POST['action'] == "delete_utkani") {
    $sql = "DELETE FROM `vysledky_utkani` WHERE `id_utkani` = ".$_POST['id'];
    mysql_query($sql);
    echo "Utkání bylo smazáno.";
}

if ($_POST['action'] == "delete_zapas") {
    $sql = "DELETE FROM `vysledky_zapas` WHERE `id_zapasu` = ".$_POST['id'];
    mysql_query($sql);
    echo "Zápas byl smazán.";
}


if ($_POST['action'] == "set_utkani_overeno") {
    $sql = "UPDATE `vysledky_utkani` SET `overeno` = ".$_POST['overeno']." WHERE `id_utkani` = ".$_POST['id'];
    mysql_query($sql);
    echo "Ověření výsledků utkání bylo změněno.";
}


if ($_POST['action'] == "add_zapasy") {
    if (0 + $_POST['utkani'] == 0) {
        die("Špatný dotaz!");
    }
    for ($i = 0; $i < $_POST['pocet']; $i++) {
        $sql = "INSERT INTO `vysledky_zapas` VALUES(NULL, " . $_POST['utkani'] . ", '')";
        mysql_query($sql);
    }
    echo "Bylo přidáno " . $_POST['pocet'] . " zápasů.";
    
}



if ($_POST['action'] == "save_zapasy") {
    if (0 + $_POST['utkani'] == 0) {
        die("Špatný dotaz!");
    }
    $sql = "SELECT * FROM `vysledky_utkani` WHERE `id_utkani` = " . $_POST['utkani'];
    $q = mysql_query($sql);
    if ($utkani = mysql_fetch_array($q)) {
            $typy = $_POST['typ'];
            $vysledky = $_POST['vysledek'];
<<<<<<< HEAD
            $dom_hrac = $_POST['dom_hrac'];
            $hos_hrac = $_POST['hos_hrac'];
=======
>>>>>>> a206266de26ca4d13d6c2fc157715fc98aa0e227
            if ($typy) {
            foreach ($typy as $zapas => $typ) {
                if (0 + $zapas == 0) {
                    die("Špatný dotaz!");
                }
                $sql = "UPDATE `vysledky_zapas` SET `typ` = '" . $typ . "'  WHERE `id_zapasu` = " . $zapas . "";
                mysql_query($sql);

                foreach ($vysledky[$zapas] as $vysledek => $skore) {
                    if (0 + $vysledek == 0) {
                        die("Špatný dotaz!");
                    }
                    if ($vysledek > 0) {
                        if (($skore[0] === "" || $skore[1] === "")) {
                            $sql = "DELETE FROM `vysledky_vysledek` WHERE `id_vysledku` = " . $vysledek;
                        } else {
                            $sql = "UPDATE `vysledky_vysledek` SET `domaci` = " . (0 + $skore[0]) . ", `hoste` = " . (0 + $skore[1]) . " WHERE `id_vysledku` = " . $vysledek;
                        }
                        mysql_query($sql);
                    } else {
                        $sql = "INSERT INTO `vysledky_vysledek` VALUES (NULL, " . $zapas . ", " . $skore[0] . ", " . $skore[1] . ")";
                        if (!($skore[0] === "" || $skore[1] === "")) {
                            mysql_query($sql);
                        }
                    }
                }
<<<<<<< HEAD

                $sql = "DELETE FROM `vysledky_hrac_hraje` WHERE `id_zapasu` = ".$zapas;
                mysql_query($sql);
                if (isset($dom_hrac[$zapas]))
                foreach ($dom_hrac[$zapas] as $hrac) {
                    $sql = "INSERT INTO `vysledky_hrac_hraje` VALUES(".$hrac.", ".$zapas.", 'D')";
                    mysql_query($sql);
                }
                if (isset($hos_hrac[$zapas]))
                foreach ($hos_hrac[$zapas] as $hrac) {
                    $sql = "INSERT INTO `vysledky_hrac_hraje` VALUES(".$hrac.", ".$zapas.", 'H')";
                    mysql_query($sql);
                }
=======
>>>>>>> a206266de26ca4d13d6c2fc157715fc98aa0e227
            }
            }
            $delete = @$_POST['delete'];
            if ($delete) {
                foreach ($delete as $del) {
                    if (0 + $del == 0) {
                        die("Špatný dotaz!");
                    }
                    $sql = "DELETE FROM `vysledky_zapas` WHERE `id_zapasu` = " . $del;
                    mysql_query($sql);
                }
            }
            if (0 + $_POST['divaci'] != 0) {
                $sql = "UPDATE `vysledky_utkani` SET `divaci` = " . $_POST['divaci'] . " WHERE `id_utkani` = " . $_POST['utkani'];
                mysql_query($sql);
            }
            echo "Zápasy byly uloženy.";
        
    }
}
<<<<<<< HEAD

if ($_POST['action'] == "new_player_form") {
    $rand = mt_rand(1000,9999);
    $tymy = '<select id="new_hrac_tym_'.$rand.'">';
    $sql = "SELECT * FROM `vysledky_tym` ORDER BY `nazev`";
    $q = mysql_query($sql);
    while ($tym = mysql_fetch_array($q)) {
        $tymy .= '<option value="'.$tym['id_tymu'].'">'.$tym['nazev'].'</option>';
    }
    $tymy .= '</select>';
    echo '<table>
        <tr><td>Jméno:</td><td><input type="text" value="" id="new_hrac_jmeno_'.$rand.'" /></td></tr>
        <tr><td>Tým:</td><td>'.$tymy.'</td></tr>
        <tr><td>Rozhodčí:</td><td><input type="checkbox" id="new_hrac_rozhodci_'.$rand.'" /></td></tr>
        <tr><td colspan="2"><input type="button" value="Vytvořit" onclick="createHrac(\''.$_POST['id'].'\', '.$rand.');" /></td></tr>
        </table>
';
}

if ($_POST['action'] == "new_player") {
    $q = mysql_query("SHOW TABLE STATUS LIKE 'vysledky_hrac'");
    $res = mysql_fetch_array($q);
    $id = $res['Auto_increment'];
    $sql = "INSERT INTO `vysledky_hrac` VALUES(NULL, NULL, ".$_POST['tym'].", '".$_POST['jmeno']."', ".($_POST['rozhodci']=="true"?1:0).", NULL, '".createLink($_POST['jmeno'])."')";
    if (mysql_query($sql)) {
        echo $id;
    }
}
=======
>>>>>>> a206266de26ca4d13d6c2fc157715fc98aa0e227
?>