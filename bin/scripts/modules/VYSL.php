<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function writeNohejbalHead($page_part) {

    $sql = "SELECT * FROM `vysledky` WHERE `parent` = " . $page_part;
    $q = mysql_query($sql);
    $select = "";
    $set_id = 0;
    if ($res = mysql_fetch_array($q)) {
        $set_id = $res['soutez'];
    } else {
        $select = " selected";
        $set_id = '`id_souteze`';
    }

    if (@$_SESSION['auth'] > 0) {
        ?>
        <span>Vyberte soutěž pro aktuální výsledky: </span>
        <select name="soutez" onchange="changeSoutezVysledky(this, <?php echo $page_part; ?>)">

            <option value="not"<?php $select; ?>>---</option>
            <?php
            $sql = "SELECT * FROM `vysledky_soutez`";
            $q = mysql_query($sql);
            while ($res = mysql_fetch_array($q)) {
                ?>
                <option value="<?php echo $res['id_souteze']; ?>"<?php if ($res['id_souteze'] == $set_id) {
                echo " selected";
            } ?>>
                <?php echo $res['nazev']; ?>
                </option>
                <?php
            }
            ?>
            <option value="new">+ Nová soutěž</option>
        </select>
        <hr/>
        <?php
    }
    $sql = "SELECT * FROM `vysledky_soutez` WHERE `id_souteze` = " . $set_id;
    $q = mysql_query($sql);
    if ($set_id != '`id_souteze`') {
        if ($res = mysql_fetch_array($q)) {
            $nazev = $res['nazev'];
        }
    } else {
        $nazev = "Všechny soutěže";
    }
    ?>
    <h1 id="nazev_soutez"><?php
    echo $nazev;
    if (@$_SESSION['auth'] > 0) {
        writeEditPane("Soutez", $set_id, "ED");
    }
    ?></h1>
    <?php
    return $set_id;
}

function writeVysledky($page_part) {
    global $tyden;
    global $_SETING;
    $statistics = $_SETING['statistics'];
    

    createProfiles();

    $set_id = writeNohejbalHead($page_part);

    writeHtmlEditArea($page_part, "<h2>Výsledky</h2>");

    if (@$_GET['kolo']) {
        $actual_poradi = $_GET['kolo'];
    } else {
        $sql = "SELECT * FROM `vysledky_kolo` WHERE `datetime` < NOW() AND `sezona` = '" . VYSL_SEZONA. "' AND `id_souteze` = " . $set_id . " ORDER BY `datetime` DESC";
        $q = mysql_query($sql);
        if ($kolo = mysql_fetch_array($q)) {
            $actual_poradi = $kolo['poradi'];
        }
    }
    $sql = "SELECT * FROM `vysledky_kolo` WHERE `id_souteze` = " . $set_id . " AND `sezona` = '" . VYSL_SEZONA . "' ORDER BY `poradi` DESC";
    $q = mysql_query($sql);
    ?>
    <a href="javascript: openNeodehranaKola();" class="vysledky_neodehrane_a">
        <img src="<?php echo URL; ?>frogSys/images/icons/podrobnosti_open.png" alt="podrobnosti" class="podrobnosti_img_neodehrana_kola" width="15" height="15">
    				zobrazit neodehraná kola
    </a>
    <?php
    echo '<div class="vysledky_neodehrane_all">';
    if (@$_SESSION['auth'] > 0) {
        echo '<a href="javascript: editKolo(\'new\', ' . $set_id . ');"><img src="' . URL . 'frogSys/images/modules/VYSL/add_kolo.png" alt="přidat kolo" onmouseover="showInfo(event, \'Přidat další kolo\', this);" /></a>';
    }
    while ($kolo = mysql_fetch_array($q)) {
        if ($actual_poradi == $kolo['poradi']) {
            echo "</div>";
        }
        ?>
        <div class="vysledky_kolo">
            <h2><?php echo $kolo['poradi'] . ". kolo - " . $kolo['nazev']; ?></h2>
            <span><?php
        if (@$_SESSION['auth'] > 0) {
            writeEditPane("Kolo", $kolo['id_kola'], "ED");
        }

        $dt = explode(" ", $kolo['datetime']);
        $d = explode("-", $dt[0]);
        $datum = mktime(0, 0, 0, $d[1], $d[2], $d[0]);
        echo date("j. n. Y", $datum);
        ?></span>
            <div class="vysledky_utkani_head">
                <?php
                $sql = "SELECT * FROM `vysledky_utkani` WHERE `id_kola` = " . $kolo['id_kola'] . "";
                $q2 = mysql_query($sql);
                while ($utkani = mysql_fetch_array($q2)) {
                    ?>
                    <div class="vysledky_utkani">
                        <div class="head_vysledky">
                            <div class="datetime"><?php
                    $dt = explode(" ", $utkani['datetime']);
                    $d = explode("-", $dt[0]);
                    $t = explode(":", $dt[1]);
                    $datum = mktime($t[0], $t[1], $t[2], $d[1], $d[2], $d[0]);
                    echo '<span onmouseover="showInfo(event, \''.$tyden[date("w", $datum)] . " " . date("j. n. Y, G:i", $datum).'\',this)">'.
                            mb_substr($tyden[date("w", $datum)], 0, 2, 'UTF-8').' '.date("G:i", $datum).'</span>';
                    //echo $tyden[date("w", $datum)] . " " . date("j. n. Y, G:i", $datum);
                    ?><?php
                    if (@$_SESSION['auth'] > 0) {
                        if ($utkani['overeno'] == "1") {
                            $check = "Č";
                        } else {
                            $check = "C";
                        }
                        writeEditPane("Utkani", $utkani['id_utkani'] . ", this", "ED" . $check);
                    }
                    ?></div>
                            <div class="tymy"><?php
                    $sql = "SELECT * FROM `vysledky_tym` WHERE `id_tymu` = " . $utkani['id_domaci'];
                    $q3 = mysql_query($sql);
                    if ($domaci = mysql_fetch_array($q3)) {
                        echo '<a href="' . URL .$statistics. '/' . $domaci['link'] . '/">' . $domaci['nazev'] . '</a>';
                    }
                    echo " - ";
                    $sql = "SELECT * FROM `vysledky_tym` WHERE `id_tymu` = " . $utkani['id_host'];
                    $q3 = mysql_query($sql);
                    if ($hoste = mysql_fetch_array($q3)) {
                        echo '<a href="' . URL.$statistics . '/' . $hoste['link'] . '/">' . $hoste['nazev'] . '</a>';
                    }
                    ?></div>
                            <div class="skore" id="vysledky_skore_<?php echo $utkani['id_utkani']; ?>"><?php
                    $sql = 'SELECT distinct(`id_zapasu`), domaci, hoste FROM
                        (SELECT count(`id_vysledku`) AS domaci, `id_zapasu` FROM `vysledky_zapas`
                            JOIN `vysledky_vysledek` USING (id_zapasu) WHERE `id_utkani` = ' . $utkani['id_utkani'] . ' AND `domaci` > `hoste` GROUP BY `id_zapasu`) dom
                        RIGHT OUTER JOIN
                        (SELECT count(`id_vysledku`) AS hoste, `id_zapasu` FROM `vysledky_zapas`
                            JOIN `vysledky_vysledek` USING (id_zapasu) WHERE `id_utkani` = ' . $utkani['id_utkani'] . ' AND `domaci` < `hoste` GROUP BY `id_zapasu`) hos USING (`id_zapasu`)
UNION
SELECT * FROM
                        (SELECT count(`id_vysledku`) AS domaci, `id_zapasu` FROM `vysledky_zapas`
                            JOIN `vysledky_vysledek` USING (id_zapasu) WHERE `id_utkani` = ' . $utkani['id_utkani'] . ' AND `domaci` > `hoste` GROUP BY `id_zapasu`) dom
                        LEFT OUTER JOIN
                        (SELECT count(`id_vysledku`) AS hoste, `id_zapasu` FROM `vysledky_zapas`
                            JOIN `vysledky_vysledek` USING (id_zapasu) WHERE `id_utkani` = ' . $utkani['id_utkani'] . ' AND `domaci` < `hoste` GROUP BY `id_zapasu`) hos
USING (`id_zapasu`) order by `id_zapasu`
                        ';
                    $q3 = mysql_query($sql);
                    $domaci = 0;
                    $hoste = 0;
                    while ($zapas = mysql_fetch_array($q3)) {
                        if ($zapas['domaci'] > $zapas['hoste']) {
                            $domaci++;
                        }
                        if ($zapas['domaci'] < $zapas['hoste']) {
                            $hoste++;
                        }
                    }
                    if ($utkani['overeno'] == 0 && !(@$_SESSION['auth'] > 0)) {
                        echo '<input onkeyup="kontrolovatVysledekUtkani('.$utkani['id_utkani'].')" id="utkani_vysledek_skore_domaci_'.$utkani['id_utkani'].'" value="'.$domaci.'" /> : 
                            <input onkeyup="kontrolovatVysledekUtkani('.$utkani['id_utkani'].')" id="utkani_vysledek_skore_hoste_'.$utkani['id_utkani'].'" value="'.$hoste.'" />
                            <a href="javascript: ulozitVysledekUtkani('.$utkani['id_utkani'].');">    
                            <img src="'.URL.'frogSys/images/icons/save_small.png" alt="uložit" onmouseover="showInfo(event, \'Uložit\', this)" />
                            </a>';
                    } else {
                        echo $domaci . ":" . $hoste;
                    }
                    ?></div>
                            <div class="vice">
                                <a href="javascript: openUtkaniPodrobnosti(<?php echo $utkani['id_utkani']; ?>);">
                                    <img src="<?php echo URL; ?>frogSys/images/icons/podrobnosti_open.png" alt="podrobnosti" class="podrobnosti_img_utkani" id="podrobnosti_img_utkani_<?php echo $utkani['id_utkani']; ?>" width="15" height="15">
            				více
                                </a>      
                            </div>
                        </div>
                        <div class="vysledky_zapasy_head" id="vysledky_zapasy_head_<?php echo $utkani['id_utkani']; ?>">
                            <?php
                            writeVysledkyZapasy($utkani);
                            ?>


                        </div>
                    </div>
                    <?php
                }

                if (@$_SESSION['auth'] > 0) {
                    echo '<a href="javascript: editUtkani(\'new\', ' . $kolo['id_kola'] . ');"><img src="' . URL . 'frogSys/images/modules/VYSL/add_utkani.png" alt="přidat utkání" onmouseover="showInfo(event, \'Přidat další utkání do tohoto kola\', this);" /></a>';
                }
                ?>
            </div>
        </div>
        <?php
    }
}

function writeVysledkyZapasy($utkani) {
    global $_SETING;
    $statistics = $_SETING['statistics'];
    
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
                    if (@$_SESSION['auth'] > 0) {
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
                    if (@$_SESSION['auth'] > 0) {
                        echo '<input type="text" class="zapas_typ" id="zapas_typ_'.$zapas['id_zapasu'].'" value="';
                    }
                    echo $zapas['typ'];
                    if (@$_SESSION['auth'] > 0) {
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
                    if (@$_SESSION['auth'] > 0) {
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
                if (@$_SESSION['auth'] > 0) {
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
                    if (@$_SESSION['auth'] > 0) {
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
                if (@$_SESSION['auth'] > 0) {
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
                        if (@$_SESSION['auth'] > 0) {
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
                    if (@$_SESSION['auth'] > 0) {
                        echo '<td><input type="checkbox" class="zapas_smazat" id="zapas_smazat_'.$zapas['id_zapasu'].'" onchange="deleteZapas('.$utkani['id_utkani'].', '.$zapas['id_zapasu'].')" /></td>';
                    }
                    ?>
                </tr>
                <?php
            }
            if ($poradi_zapasu == 0) {
                echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
            }
            if (@$_SESSION['auth'] > 0) {
                
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
        if (@$_SESSION['auth'] > 0) {
                        echo '<input type="text" class="utkani_divaci" id="utkani_divaci_'.$utkani['id_utkani'].'" value="';
                    }
                    echo $utkani['divaci']; 
                    if (@$_SESSION['auth'] > 0) {
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

function writeVysledky_sezona() {


    $sql = "SELECT * FROM `page_parts` WHERE `type` = 'VYSL' OR `type` = 'VSTA' OR `type` = 'VTAB'";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        echo '<div id="vysledky_sezona_div">Sezóna: <select name="vysledky_sezona" onchange="changeSezona(this)" id="vysledky_sezona">';
        $sql = "SELECT distinct(`sezona`) AS sezona FROM `vysledky_kolo` ORDER BY `sezona` DESC";
        $q = mysql_query($sql);
        while ($res = mysql_fetch_array($q)) {
            $select = "";
            if ($res['sezona'] == VYSL_SEZONA) {
                $select = " selected";
            }
            echo '<option value="' . $res['sezona'] . '"' . $select . '>' . $res['sezona'] . '</option>';
        }
        echo '</select></div>';
    }
}


function createProfiles() {
    global $_SETING;
    if (isset ($_SETING['statistics'])) {
        $statistics = $_SETING['statistics'];
    } else {
        $statistics = "statistiky";
        $sql = "INSERT INTO `seting` VALUES(NULL, 'statistics', '$statistics')";
        mysql_query($sql);
    }

    $sql = "SELECT * FROM `menu` WHERE `link` = '$statistics'";
    $q = mysql_query($sql);
    if (!($res = mysql_fetch_array($q))) {
        $q = mysql_query("SHOW TABLE STATUS LIKE 'menu'");
        $res = mysql_fetch_array($q);
        $id_menu = $res['Auto_increment'];

        $sql = "INSERT INTO `menu` VALUES(NULL, 'Statistiky', -1, 0, '$statistics', 0)";
        mysql_query($sql);

        $q = mysql_query("SHOW TABLE STATUS LIKE 'page_parts'");
        $res = mysql_fetch_array($q);
        $id_part = $res['Auto_increment'];

        $sql = "INSERT INTO `page_parts` VALUES(NULL, 'VSTA')";
        mysql_query($sql);

        $sql = "INSERT INTO `page` VALUES(NULL, ".$id_part.", 100, ".$id_menu.", 0)";
        mysql_query($sql);

    }
}
?>
