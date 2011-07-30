<?php

require_once "../../../../config/database.php";
include "../../../bin/scripts.php";

if (isset($_POST['action']) && $_POST['action'] == "writeVysledkyZapasy") {
    global $_SETING;
    $statistics = $_SETING['statistics'];
    
    $id_utkani = mysql_real_escape_string($_POST['id']);
    $sql = "SELECT * FROM vysledky_utkani WHERE id_utkani = '" . $id_utkani . "'";
    $result = mysql_query($sql);
    $utkani = mysql_fetch_array($result);
    
    if ($utkani['overeno'] == 1) {
    ?>
    <table class="vysledky_zapasy" id="vysledky_zapasy_<?php echo $utkani['id_utkani']; ?>">
        <tbody>
            <tr>
                <th class="zapas">Zápas</th>
                <th class="hraci">Hráči</th>
                <th class="vysledky" colspan="3">Výsledky</th>
                <th class="sety">Sety</th>
                <th class="stav">Stav</th>
                <?php
                    if (is_logged_in()) {
                        echo '<th>Smazat</th>';
                    }
                ?>
            </tr>
            <?php
            $sql = "SELECT * FROM `vysledky_zapas` WHERE `id_utkani` = " . $utkani['id_utkani'] . " ORDER BY `typ`";
            $q3 = mysql_query($sql);
            $dom_zap = 0;
            $hos_zap = 0;
            $poradi_zapasu = 0;
            while ($zapas = mysql_fetch_array($q3)) {
                $poradi_zapasu++;
                ?>
                <tr class="vysledky_zapas">
                    <td id="vysledky_zapas_<?php echo $zapas['id_zapasu']; ?>"><?php 
                    if (is_logged_in()) {
                        echo '<input type="text" class="zapas_typ" id="zapas_typ_'.$zapas['id_zapasu'].'" value="';
                    }
                    echo $zapas['typ'];
                    if (is_logged_in()) {
                        echo '" />';
                    }
                    ?></td>
                    <td id="vysledky_zapas_hraci_<?php echo $zapas['id_zapasu']; ?>">
                        <div class="domaci"><?php
                        $options = array();
                        $options[0] = ' value="-">&nbsp;</option>';
                        $options[-1] = ' value="new">Nový hráč</option>';
                        $sql = "SELECT * FROM `vysledky_hrac` JOIN `vysledky_tym` USING (`id_tymu`) WHERE `id_tymu` = ".$utkani['id_domaci']." ORDER BY `jmeno`";
                        $q = mysql_query($sql);
                        while ($hrd = mysql_fetch_array($q)) {
                            $options[$hrd['id_hrace']] = ' value="'.$hrd['id_hrace'].'">'.$hrd['jmeno'].' ('.  substr($hrd['nazev'], 0, 5).')</option>';
                        }
                        $sql = "SELECT * FROM `vysledky_hrac` JOIN `vysledky_tym` USING (`id_tymu`) WHERE `id_tymu` <> ".$utkani['id_domaci']." ORDER BY `jmeno`";
                        $q = mysql_query($sql);
                        while ($hrd = mysql_fetch_array($q)) {
                            $options[$hrd['id_hrace']] = ' value="'.$hrd['id_hrace'].'">'.$hrd['jmeno'].' ('.  substr($hrd['nazev'], 0, 5).')</option>';
                        }

                $sql = "SELECT * FROM `vysledky_hrac_hraje` JOIN `vysledky_hrac` USING (`id_hrace`) WHERE `id_zapasu` = " . $zapas['id_zapasu'] . " AND `typ` = 'D'";
                $q4 = mysql_query($sql);
                while ($hrac = mysql_fetch_array($q4)) {
                    if (is_logged_in()) {
                        echo '<select 
                            onchange="changeHrac(this);"
                            class="select_hrac"
                            id="domaci_hrac_'.$zapas['id_zapasu'].'_'.$hrac['id_hrace'].'">';
                        $opt = $options;
                        $opt[$hrac['id_hrace']] = " selected=\"selected\"".$opt[$hrac['id_hrace']];
                        echo "<option".implode("<option", $opt);
                        echo '</select>';
                    } else {
                        $short_name = explode(" ", $hrac['jmeno']);
                        $short_name = $short_name[0]." ".@$short_name[1][0].".";
                        echo '<a href="' . URL.$statistics . '/' . $hrac['link'] . '/">' . $short_name . "</a>, ";
                    }
                }
                if (is_logged_in()) {
                    $opt = $options;
                    echo '<select
                        onchange="changeHrac(this);"
                        class="select_hrac"
                        id="domaci_hrac_'.$zapas['id_zapasu'].'_-">';
                    $opt[0] = " selected=\"selected\"".$opt[0];
                    echo "<option".implode("<option", $opt);
                    echo '</select>';
                }
                ?>
                        </div>
                        <div class="hoste"><?php
                        $options = array();
                        $options[0] = ' value="-">&nbsp;</option>';
                        $options[-1] = ' value="new">Nový hráč</option>';
                        $sql = "SELECT * FROM `vysledky_hrac` JOIN `vysledky_tym` USING (`id_tymu`) WHERE `id_tymu` = ".$utkani['id_host']." ORDER BY `jmeno`";
                        $q = mysql_query($sql);
                        while ($hrd = mysql_fetch_array($q)) {
                            $options[$hrd['id_hrace']] = ' value="'.$hrd['id_hrace'].'">'.$hrd['jmeno'].' ('.  substr($hrd['nazev'], 0, 5).')</option>';
                        }
                        $sql = "SELECT * FROM `vysledky_hrac` JOIN `vysledky_tym` USING (`id_tymu`) WHERE `id_tymu` <> ".$utkani['id_host']." ORDER BY `jmeno`";
                        $q = mysql_query($sql);
                        while ($hrd = mysql_fetch_array($q)) {
                            $options[$hrd['id_hrace']] = ' value="'.$hrd['id_hrace'].'">'.$hrd['jmeno'].' ('.  substr($hrd['nazev'], 0, 5).')</option>';
                        }

                $sql = "SELECT * FROM `vysledky_hrac_hraje` JOIN `vysledky_hrac` USING (`id_hrace`) WHERE `id_zapasu` = " . $zapas['id_zapasu'] . " AND `typ` = 'H'";
                $q4 = mysql_query($sql);
                while ($hrac = mysql_fetch_array($q4)) {
                    if (is_logged_in()) {
                        echo '<select
                            onchange="changeHrac(this);"
                            class="select_hrac"
                            id="host_hrac_'.$zapas['id_zapasu'].'_'.$hrac['id_hrace'].'">';
                        $opt = $options;
                        $opt[$hrac['id_hrace']] = " selected=\"selected\"".$opt[$hrac['id_hrace']];
                        echo "<option".implode("<option", $opt);
                        echo '</select>';
                    } else {
                        $short_name = explode(" ", $hrac['jmeno']);
                        $short_name = $short_name[0]." ".@$short_name[1][0].".";
                        echo '<a href="' . URL.$statistics . '/' . $hrac['link'] . '/">' . $short_name . "</a>, ";
                    }
                }
                if (is_logged_in()) {
                    $opt = $options;
                    echo '<select
                        onchange="changeHrac(this);"
                        class="select_hrac"
                        id="host_hrac_'.$zapas['id_zapasu'].'_-">';
                    $opt[0] = " selected=\"selected\"".$opt[0];
                    echo "<option".implode("<option", $opt);
                    echo '</select>';
                }
                ?>
                        </div>
                    </td>
                    <?php
                    $sql = "SELECT * FROM `vysledky_vysledek` WHERE `id_zapasu` = " . $zapas['id_zapasu'];
                    $q4 = mysql_query($sql);
                    $domaci = 0;
                    $hoste = 0;
                    $next = 0;
                    for ($i = 0; $i < 3; $i++) {
                        $vysledek = mysql_fetch_array($q4);
                        echo "<td class=\"vysledky_vysledek_bunka\" id=\"vysledky_zapas_vysledek".$i."_".$zapas['id_zapasu']."\">";
                        if (is_logged_in()) {
                            if ($vysledek) {
                                echo '<input onkeyup="prepocitejZapasy('.$utkani['id_utkani'].');" class="vysledky_vysledek" type="text" value="'.$vysledek['domaci'].'" id="vysledky_zapas_0_'.$zapas['id_zapasu'].'_'.$vysledek['id_vysledku'].'" /> 
                                    : 
                                    <input onkeyup="prepocitejZapasy('.$utkani['id_utkani'].');" class="vysledky_vysledek" type="text" value="'.$vysledek['hoste'].'" id="vysledky_zapas_1_'.$zapas['id_zapasu'].'_'.$vysledek['id_vysledku'].'" /> ';
                                if ($vysledek['domaci'] > $vysledek['hoste']) {
                                    $domaci++;
                                }
                                if ($vysledek['domaci'] < $vysledek['hoste']) {
                                    $hoste++;
                                }
                            } else {
                                $next++;
                                echo '<input onkeyup="prepocitejZapasy('.$utkani['id_utkani'].');" class="vysledky_vysledek" type="text" value="" id="vysledky_zapas_0_'.$zapas['id_zapasu'].'_-'.$next.'" /> 
                                    : 
                                    <input onkeyup="prepocitejZapasy('.$utkani['id_utkani'].');" class="vysledky_vysledek" type="text" value="" id="vysledky_zapas_1_'.$zapas['id_zapasu'].'_-'.$next.'" /> ';
                            }
                        } else {
                            if ($vysledek) {
                                echo $vysledek['domaci'] . ":" . $vysledek['hoste'];
                                if ($vysledek['domaci'] > $vysledek['hoste']) {
                                    $domaci++;
                                }
                                if ($vysledek['domaci'] < $vysledek['hoste']) {
                                    $hoste++;
                                }
                            } else {
                                echo "X";
                            }
                        }
                        echo "</td>";
                    }
                    ?>
                    <td id="vysledky_sety_<?php echo $zapas['id_zapasu']; ?>">
                        <?php
                        echo $domaci . ":" . $hoste;
                        ?>
                    </td>
                    <td id="vysledky_stav_<?php echo $zapas['id_zapasu']; ?>">
                        <?php
                        if ($domaci > $hoste) {
                            $dom_zap++;
                        }
                        if ($domaci < $hoste) {
                            $hos_zap++;
                        }
                        echo $dom_zap . ":" . $hos_zap;
                        ?>
                    </td>
                    
                    <?php
                    if (is_logged_in()) {
                        echo '<td><input type="checkbox" class="zapas_smazat" id="zapas_smazat_'.$zapas['id_zapasu'].'" onchange="deleteZapas('.$utkani['id_utkani'].', '.$zapas['id_zapasu'].')" /></td>';
                    }
                    ?>
                </tr>
                <?php
            }
            if ($poradi_zapasu == 0) {
                echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
            }
            if (is_logged_in()) {
                
                echo '<tr><td colspan="5">
                        Kolik zápasů přidat: <input type="text" value="1" id="pocet_zapasu_' . $utkani['id_utkani'] . '" />
                        <a href="javascript: addZapasy(\'' . $utkani['id_utkani'] . '\');">
                            <img src="' . URL . 'frogSys/images/icons/add.png" alt="přidat zápasy" onmouseover="showInfo(event, \'Přidat zápasy do tohoto utkání\', this);" />
                        </a>
                        </td>';
                echo '<td colspan="3">
                       <input type="button" value="Uložit" onclick="saveZapasy(\'' . $utkani['id_utkani'] . '\')" />
                        </td></tr>';
            }
            ?>

        </tbody>
    </table>
        <?php
}
        ?>
    <div class="vysledky_ostatni">
        <div class="vysledky_item">Počet diváků: <div class="vysledky_divaci" id="vysledky_divaci_<?php echo $utkani['id_utkani']; ?>">
        <?php 
        if (is_logged_in()) {
                        echo '<input type="text" class="utkani_divaci" id="utkani_divaci_'.$utkani['id_utkani'].'" value="';
                    }
                    echo $utkani['divaci']; 
                    if (is_logged_in()) {
                        echo '" />';
                    }
        ?>
            </div></div>
        <div class="vysledky_item">Hřiště: <div class="vysledky_hriste" id="vysledky_hriste_<?php echo $utkani['id_utkani']; ?>"><?php
            $sql = "SELECT * FROM `vysledky_hriste` WHERE `id_hriste` = " . $utkani['id_hriste'];
            $q3 = mysql_query($sql);
            if ($hriste = @mysql_fetch_array($q3)) {
                echo '<a href="' . URL.$statistics . '/' . $hriste['link'] . '/">' . $hriste['nazev'] . '</a>';
            }
            ?></div></div>
        <div class="vysledky_item">Rozhodčí: <div class="vysledky_rozhodci" id="vysledky_rozhodci_<?php echo $utkani['id_utkani']; ?>"><?php
            $sql = "SELECT * FROM `vysledky_hrac` JOIN `vysledky_rozhodci` USING (`id_hrace`) WHERE `id_utkani` = " . $utkani['id_utkani'];
            $q3 = mysql_query($sql);
            while ($rozhodci = @mysql_fetch_array($q3)) {
                echo '<a href="' . URL.$statistics . '/' . $rozhodci['link'] . '/">' . $rozhodci['jmeno'] . '</a>, ';
            }
            ?></div></div>
    </div>
    <?php
    
}


if ($_POST['action'] == "zapasy") {
    $sql = "SELECT * FROM `vysledky_utkani` WHERE `id_utkani` = " . $_POST['utkani'];
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        writeVysledkyZapasy($res);
    }
}

if ($_POST['action'] == "save_vysledek_utkani") {
    $id_utkani = 0+$_POST['id_utkani'];
    $domaci = 0+$_POST['domaci'];
    $hoste = 0+$_POST['hoste'];
    if ($id_utkani == 0) {
        die("špatně zadaný formát id utkání!");
    }
    // zde se automaticky vygeneruje tolik zapasu pro utkani a k nim vysledky, kolik zadal finalni
    // vytvori se fiktivni vysledek... ten nebude viden v user casti
    $sql = "DELETE FROM `vysledky_zapas` WHERE `id_utkani` = ".$id_utkani;
    mysql_query($sql);
    $typy = array("1. 1D-1D","2. 2D-2D","3. 1T-1T","4. 2T-2T","5. 3D-3D","6. 1S-1S","7. 1T-2T","8. 2T-1T","9. 1D-2D","A. 2D-1D");
    for ($i=0;$i<$domaci+$hoste;$i++) {
        $q = mysql_query("SHOW TABLE STATUS LIKE 'vysledky_zapas'");
        $res = mysql_fetch_array($q);
        $id_zapasu = $res['Auto_increment'];
        $sql = "INSERT INTO `vysledky_zapas` VALUES(NULL, ".$id_utkani.", '".$typy[$i]."')";
        mysql_query($sql);
        if ($i < $domaci) {
            $dom = "10";
            $hos = "0";
        } else {
            $dom = "0";
            $hos = "10";
        }
        $sql = "INSERT INTO `vysledky_vysledek` VALUES(NULL, ".$id_zapasu.", ".$dom.", ".$hos.")";
        mysql_query($sql);
    }
    echo "Výsledek utkání byl uložen.";
}

?>
<?php mysql_close(); ?>