<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function writeStatistiky($page_part) {
    global $_SETING;
    include PATH."/frogSys/bin/load_pages_id.php";
    
    if (isset($profile) && isset($profile_id)) {
        if ($profile == "hrac") {
            writeProfileHrac($profile_id);
        } else
        if ($profile == "tym") {
            writeProfileTym($profile_id);
        } else
        if ($profile == "hriste") {
            writeProfileHriste($profile_id);
        }
    } else {
        writeProfiles($page_part);
    }
}


function writeProfileHrac($id_hrace) {
    $sql = "SELECT * FROM `vysledky_hrac` WHERE `id_hrace` = ".$id_hrace;
    $q = mysql_query($sql);
    if ($hrac = mysql_fetch_array($q)) {

        ?>
<div class="hrac_jmeno">Jméno: <?php echo $hrac['jmeno']; ?></div>
        <?php
    }
}

function writeProfileTym($id_tymu) {

}

function writeProfileHriste($id_hriste) {

}

function writeProfiles($page_part) {
    global $_SETING;
    $statistics = $_SETING['statistics'];

    $id_souteze = writeNohejbalHead($page_part);

    writeHtmlEditArea($page_part, "<h2>Statistiky</h2>");

    if (isset($_GET['kolo'])) {
        $kolo = 0+$_GET['kolo'];
        if ($kolo == 0) {
            $kolo = '`poradi`';
        }
    } else {
        $kolo = '`poradi`';
    }
    if (isset($_GET['utkani'])) {
        $utkani = 0+$_GET['utkani'];
        if ($utkani == 0) {
            $utkani = '`id_utkani`';
        }
    } else {
        $utkani =  '`id_utkani`';
    }
    if (isset($_GET['tym'])) {
        $tym = (0+$_GET['tym']).' AND '.(0+$_GET['tym']);
        if ($tym == 0) {
            $tym = '0 AND 2147483647';
        }
    } else {
        $tym = '0 AND 2147483647';
    }
    if (isset($_GET['kategorie']) && ($_GET['kategorie'] == "S" || $_GET['kategorie'] == "D" || $_GET['kategorie'] == "T")) {
        $kategorie = $_GET['kategorie'];
    } else {
        $kategorie = '';
    }
    
    $filter = "1";
    //if ($kolo != "all") {
        $filter .= " AND `poradi` = ".$kolo."";
    //}
    //if ($utkani != "all") {
        $filter .= " AND `id_utkani` = ".$utkani."";
    //}
    //if ($tym != "all") {
        $filter .= " AND (`id_domaci` BETWEEN ".$tym." OR `id_host` BETWEEN ".$tym.")";
    //}
        $filter .= " AND `vysledky_zapas`.`typ` LIKE '%$kategorie%'";
    $filter_sezona = " `sezona` = '" . VYSL_SEZONA. "' AND `id_souteze` = ".$id_souteze."";
    $direction = isset($_GET['dir']) && $_GET['dir'] != ''?$_GET['dir']:'desc';
    if (isset($_GET['sort']) &&
            ($_GET['sort'] == 'jmeno' ||
            $_GET['sort'] == 'zapasy' ||
            $_GET['sort'] == 'vyhry' ||
            $_GET['sort'] == 'remizy' ||
            $_GET['sort'] == 'prohry' ||
            $_GET['sort'] == 'sety' ||
            $_GET['sort'] == '%' ||
            $_GET['sort'] == 'piskani') ) {
        $order = $_GET['sort'];
    } else {
        $order = '%';
    }
    $sql = "SELECT * FROM `vysledky_hrac`
            JOIN `vysledky_hrac_hraje` USING (`id_hrace`)
            JOIN `vysledky_zapas` USING (`id_zapasu`)
            JOIN `vysledky_utkani` USING (`id_utkani`)
            JOIN `vysledky_kolo` USING (`id_kola`)
            WHERE $filter_sezona AND $filter AND `id_tymu` BETWEEN $tym
            ";
    $q = mysql_query($sql);
    $hraci = array();
    while ($hrac = mysql_fetch_array($q)) {
        $sql = '
            SELECT count(DISTINCT `id_zapasu`) AS vyhry
            FROM `vysledky_zapas`
            LEFT JOIN `vysledky_hrac_hraje` hraje USING (`id_zapasu`)
            LEFT JOIN `vysledky_utkani` USING (`id_utkani`)
            LEFT JOIN `vysledky_kolo` USING (`id_kola`)
            LEFT JOIN `vysledky_soutez` USING (`id_souteze`)
            LEFT JOIN `vysledky_vysledek` USING (`id_zapasu`)
            WHERE 
            (
            SELECT count(`id_zapasu`)
            FROM `vysledky_vysledek`
            WHERE `vysledky_vysledek`.`domaci` > `vysledky_vysledek`.`hoste`
            AND `id_zapasu` = hraje.`id_zapasu`)
            >
            (SELECT count(`id_zapasu`)
            FROM `vysledky_vysledek`
            WHERE `vysledky_vysledek`.`domaci` < `vysledky_vysledek`.`hoste`
            AND `id_zapasu` = hraje.`id_zapasu`
            )
            AND hraje.`typ` = \'D\'
            AND `id_hrace` = '.$hrac['id_hrace'].'
            AND '.$filter_sezona.'
            AND '.$filter.'
            ';
        $q2 = mysql_query($sql);
        if ($res = mysql_fetch_array($q2)) {
            $hrac['vyhry_dom'] = $res['vyhry'];
        } else {
            $hrac['vyhry_dom'] = 0;
        }
        $sql = '
            SELECT count(DISTINCT `id_zapasu`) AS vyhry
            FROM `vysledky_zapas`
            LEFT JOIN `vysledky_hrac_hraje` hraje USING (`id_zapasu`)
            LEFT JOIN `vysledky_utkani` USING (`id_utkani`)
            LEFT JOIN `vysledky_kolo` USING (`id_kola`)
            LEFT JOIN `vysledky_soutez` USING (`id_souteze`)
            LEFT JOIN `vysledky_vysledek` USING (`id_zapasu`)
            WHERE
            (
            SELECT count(`id_zapasu`)
            FROM `vysledky_vysledek`
            WHERE `vysledky_vysledek`.`domaci` < `vysledky_vysledek`.`hoste`
            AND `id_zapasu` = hraje.`id_zapasu`)
            >
            (SELECT count(`id_zapasu`)
            FROM `vysledky_vysledek`
            WHERE `vysledky_vysledek`.`domaci` > `vysledky_vysledek`.`hoste`
            AND `id_zapasu` = hraje.`id_zapasu`
            )
            AND hraje.`typ` = \'H\'
            AND `id_hrace` = '.$hrac['id_hrace'].'
            AND '.$filter_sezona.'
            AND '.$filter.'
            ';
        $q2 = mysql_query($sql);
        if ($res = mysql_fetch_array($q2)) {
            $hrac['vyhry_hos'] = $res['vyhry'];
        } else {
            $hrac['vyhry_hos'] = 0;
        }

        $sql = '
            SELECT count(DISTINCT `id_zapasu`) AS prohry
            FROM `vysledky_zapas`
            LEFT JOIN `vysledky_hrac_hraje` hraje USING (`id_zapasu`)
            LEFT JOIN `vysledky_utkani` USING (`id_utkani`)
            LEFT JOIN `vysledky_kolo` USING (`id_kola`)
            LEFT JOIN `vysledky_soutez` USING (`id_souteze`)
            LEFT JOIN `vysledky_vysledek` USING (`id_zapasu`)
            WHERE
            (
            SELECT count(`id_zapasu`)
            FROM `vysledky_vysledek`
            WHERE `vysledky_vysledek`.`domaci` > `vysledky_vysledek`.`hoste`
            AND `id_zapasu` = hraje.`id_zapasu`)
            <
            (SELECT count(`id_zapasu`)
            FROM `vysledky_vysledek`
            WHERE `vysledky_vysledek`.`domaci` < `vysledky_vysledek`.`hoste`
            AND `id_zapasu` = hraje.`id_zapasu`
            )
            AND hraje.`typ` = \'D\'
            AND `id_hrace` = '.$hrac['id_hrace'].'
            AND '.$filter_sezona.'
            AND '.$filter.'
            ';
        $q2 = mysql_query($sql);
        if ($res = mysql_fetch_array($q2)) {
            $hrac['prohry_dom'] = $res['prohry'];
        } else {
            $hrac['prohry_dom'] = 0;
        }
        $sql = '
            SELECT count(DISTINCT `id_zapasu`) AS prohry
            FROM `vysledky_zapas`
            LEFT JOIN `vysledky_hrac_hraje` hraje USING (`id_zapasu`)
            LEFT JOIN `vysledky_utkani` USING (`id_utkani`)
            LEFT JOIN `vysledky_kolo` USING (`id_kola`)
            LEFT JOIN `vysledky_soutez` USING (`id_souteze`)
            LEFT JOIN `vysledky_vysledek` USING (`id_zapasu`)
            WHERE
            (
            SELECT count(`id_zapasu`)
            FROM `vysledky_vysledek`
            WHERE `vysledky_vysledek`.`domaci` < `vysledky_vysledek`.`hoste`
            AND `id_zapasu` = hraje.`id_zapasu`)
            <
            (SELECT count(`id_zapasu`)
            FROM `vysledky_vysledek`
            WHERE `vysledky_vysledek`.`domaci` > `vysledky_vysledek`.`hoste`
            AND `id_zapasu` = hraje.`id_zapasu`
            )
            AND hraje.`typ` = \'H\'
            AND `id_hrace` = '.$hrac['id_hrace'].'
            AND '.$filter_sezona.'
            AND '.$filter.'
            ';
        $q2 = mysql_query($sql);
        if ($res = mysql_fetch_array($q2)) {
            $hrac['prohry_hos'] = $res['prohry'];
        } else {
            $hrac['prohry_hos'] = 0;
        }

        $sql = '
            SELECT count(DISTINCT `id_zapasu`) AS remizy
            FROM `vysledky_zapas`
            LEFT JOIN `vysledky_hrac_hraje` hraje USING (`id_zapasu`)
            LEFT JOIN `vysledky_utkani` USING (`id_utkani`)
            LEFT JOIN `vysledky_kolo` USING (`id_kola`)
            LEFT JOIN `vysledky_soutez` USING (`id_souteze`)
            LEFT JOIN `vysledky_vysledek` USING (`id_zapasu`)
            WHERE
            (
            SELECT count(`id_zapasu`)
            FROM `vysledky_vysledek`
            WHERE `vysledky_vysledek`.`domaci` > `vysledky_vysledek`.`hoste`
            AND `id_zapasu` = hraje.`id_zapasu`)
            =
            (SELECT count(`id_zapasu`)
            FROM `vysledky_vysledek`
            WHERE `vysledky_vysledek`.`domaci` < `vysledky_vysledek`.`hoste`
            AND `id_zapasu` = hraje.`id_zapasu`
            )
            AND hraje.`typ` = \'D\'
            AND `id_hrace` = '.$hrac['id_hrace'].'
            AND '.$filter_sezona.'
            AND '.$filter.'
            ';
        $q2 = mysql_query($sql);
        if ($res = mysql_fetch_array($q2)) {
            $hrac['remizy_dom'] = $res['remizy'];
        } else {
            $hrac['remizy_dom'] = 0;
        }
        $sql = '
            SELECT count(DISTINCT `id_zapasu`) AS remizy
            FROM `vysledky_zapas`
            LEFT JOIN `vysledky_hrac_hraje` hraje USING (`id_zapasu`)
            LEFT JOIN `vysledky_utkani` USING (`id_utkani`)
            LEFT JOIN `vysledky_kolo` USING (`id_kola`)
            LEFT JOIN `vysledky_soutez` USING (`id_souteze`)
            LEFT JOIN `vysledky_vysledek` USING (`id_zapasu`)
            WHERE
            (
            SELECT count(`id_zapasu`)
            FROM `vysledky_vysledek`
            WHERE `vysledky_vysledek`.`domaci` < `vysledky_vysledek`.`hoste`
            AND `id_zapasu` = hraje.`id_zapasu`)
            =
            (SELECT count(`id_zapasu`)
            FROM `vysledky_vysledek`
            WHERE `vysledky_vysledek`.`domaci` > `vysledky_vysledek`.`hoste`
            AND `id_zapasu` = hraje.`id_zapasu`
            )
            AND hraje.`typ` = \'H\'
            AND `id_hrace` = '.$hrac['id_hrace'].'
            AND '.$filter_sezona.'
            AND '.$filter.'
            ';
        $q2 = mysql_query($sql);
        if ($res = mysql_fetch_array($q2)) {
            $hrac['remizy_hos'] = $res['remizy'];
        } else {
            $hrac['remizy_hos'] = 0;
        }


        $sql = '
            SELECT count(`id_vysledku`) AS sets
            FROM `vysledky_vysledek`
            LEFT JOIN `vysledky_hrac_hraje` hraje USING (`id_zapasu`)
            LEFT JOIN `vysledky_zapas` USING (`id_zapasu`)
            LEFT JOIN `vysledky_utkani` USING (`id_utkani`)
            LEFT JOIN `vysledky_kolo` USING (`id_kola`)
            LEFT JOIN `vysledky_soutez` USING (`id_souteze`)
            WHERE `vysledky_vysledek`.`domaci` > `vysledky_vysledek`.`hoste`
            AND hraje.`typ` = \'D\'
            AND `id_hrace` = '.$hrac['id_hrace'].'
            AND '.$filter_sezona.'
            AND '.$filter.'
            ';
        $q2 = mysql_query($sql);
        if ($res = mysql_fetch_array($q2)) {
            $hrac['sety+_dom'] = $res['sets'];
        } else {
            $hrac['sety+_dom'] = 0;
        }
        $sql = '
            SELECT count(`id_vysledku`) AS sets
            FROM `vysledky_vysledek`
            LEFT JOIN `vysledky_hrac_hraje` hraje USING (`id_zapasu`)
            LEFT JOIN `vysledky_zapas` USING (`id_zapasu`)
            LEFT JOIN `vysledky_utkani` USING (`id_utkani`)
            LEFT JOIN `vysledky_kolo` USING (`id_kola`)
            LEFT JOIN `vysledky_soutez` USING (`id_souteze`)
            WHERE `vysledky_vysledek`.`domaci` < `vysledky_vysledek`.`hoste`
            AND hraje.`typ` = \'H\'
            AND `id_hrace` = '.$hrac['id_hrace'].'
            AND '.$filter_sezona.'
            AND '.$filter.'
            ';
        $q2 = mysql_query($sql);
        if ($res = mysql_fetch_array($q2)) {
            $hrac['sety+_hos'] = $res['sets'];
        } else {
            $hrac['sety+_hos'] = 0;
        }

        $sql = '
            SELECT count(`id_vysledku`) AS sets
            FROM `vysledky_vysledek`
            LEFT JOIN `vysledky_hrac_hraje` hraje USING (`id_zapasu`)
            LEFT JOIN `vysledky_zapas` USING (`id_zapasu`)
            LEFT JOIN `vysledky_utkani` USING (`id_utkani`)
            LEFT JOIN `vysledky_kolo` USING (`id_kola`)
            LEFT JOIN `vysledky_soutez` USING (`id_souteze`)
            WHERE `vysledky_vysledek`.`domaci` < `vysledky_vysledek`.`hoste`
            AND hraje.`typ` = \'D\'
            AND `id_hrace` = '.$hrac['id_hrace'].'
            AND '.$filter_sezona.'
            AND '.$filter.'
            ';
        $q2 = mysql_query($sql);
        if ($res = mysql_fetch_array($q2)) {
            $hrac['sety-_dom'] = $res['sets'];
        } else {
            $hrac['sety-_dom'] = 0;
        }
        $sql = '
            SELECT count(`id_vysledku`) AS sets
            FROM `vysledky_vysledek`
            LEFT JOIN `vysledky_hrac_hraje` hraje USING (`id_zapasu`)
            LEFT JOIN `vysledky_zapas` USING (`id_zapasu`)
            LEFT JOIN `vysledky_utkani` USING (`id_utkani`)
            LEFT JOIN `vysledky_kolo` USING (`id_kola`)
            LEFT JOIN `vysledky_soutez` USING (`id_souteze`)
            WHERE `vysledky_vysledek`.`domaci` > `vysledky_vysledek`.`hoste`
            AND hraje.`typ` = \'H\'
            AND `id_hrace` = '.$hrac['id_hrace'].'
            AND '.$filter_sezona.'
            AND '.$filter.'
            ';
        $q2 = mysql_query($sql);
        if ($res = mysql_fetch_array($q2)) {
            $hrac['sety-_hos'] = $res['sets'];
        } else {
            $hrac['sety-_hos'] = 0;
        }

        $sql = '
            SELECT count(`id_hrace`) AS pisk
            FROM `vysledky_rozhodci`
            LEFT JOIN `vysledky_utkani` USING (`id_utkani`)
            LEFT JOIN `vysledky_zapas` USING (`id_utkani`)
            LEFT JOIN `vysledky_kolo` USING (`id_kola`)
            LEFT JOIN `vysledky_soutez` USING (`id_souteze`)
            WHERE `id_hrace` = '.$hrac['id_hrace'].'
            AND '.$filter_sezona.'
            AND '.$filter.'
            ';
        $q2 = mysql_query($sql);
        if ($res = mysql_fetch_array($q2)) {
            $hrac['piskani'] = $res['pisk'];
        } else {
            $hrac['piskani'] = 0;
        }

        $hrac['sety+'] = $hrac['sety+_dom']+$hrac['sety+_hos'];
        $hrac['sety-'] = $hrac['sety-_dom']+$hrac['sety-_hos'];
        $hrac['sety'] = $hrac['sety+']-$hrac['sety-'];
        $hrac['vyhry'] = $hrac['vyhry_dom']+$hrac['vyhry_hos'];
        $hrac['prohry'] = $hrac['prohry_dom']+$hrac['prohry_hos'];
        $hrac['remizy'] = $hrac['remizy_dom']+$hrac['remizy_hos'];
        $hrac['zapasy'] = $hrac['vyhry']+$hrac['prohry']+$hrac['remizy'];
        $hrac['%'] = 100 * (2*$hrac['vyhry']+1*$hrac['remizy']) / ((2*$hrac['zapasy'])==0?1:(2*$hrac['zapasy']));

        $hraci[$hrac['id_hrace']] = $hrac;
    }



    

    // FILTER
    if ($kolo == "all") {
        $select = ' selected="selected"';
    } else {
        $select = '';
    }
    $opts = '<option value="all"'.$select.'>Všechny</option>';
    $sql = 'SELECT DISTINCT(`poradi`) AS poradi
        FROM `vysledky_kolo`
        WHERE '.$filter_sezona.'
        ORDER BY `poradi`';
    $q = mysql_query($sql);
    while ($res = mysql_fetch_array($q)) {
        if ($kolo == $res['poradi']) {
            $select = ' selected=\"selected\"';
        } else {
            $select = '';
        }
        $opts .= '<option value="'.$res['poradi'].'"'.$select.'>'.$res['poradi'].'. Kolo</option>';
    }

    if ($utkani == "all") {
        $select = ' selected="selected"';
    } else {
        $select = '';
    }
    $optsu = '<option value="null">---</option>
        <option value="all"'.$select.'>Všechny</option>';
    $sql = 'SELECT `id_utkani`, dom.`nazev` AS domaci, hos.`nazev` AS hoste
        FROM `vysledky_utkani`
        LEFT JOIN `vysledky_tym` dom ON (`id_domaci` = dom.`id_tymu`)
        LEFT JOIN `vysledky_tym` hos ON (`id_host` = hos.`id_tymu`)
        LEFT JOIN `vysledky_kolo` USING (`id_kola`)
        WHERE '.$filter_sezona.' 
        AND `poradi` = '.$kolo.'
        AND (`id_domaci` BETWEEN '.$tym.' OR `id_host` BETWEEN '.$tym.')
        ORDER BY dom.nazev';
    $q = mysql_query($sql);
    while ($res = mysql_fetch_array($q)) {
        if ($utkani == $res['id_utkani']) {
            $select = ' selected=\"selected\"';
        } else {
            $select = '';
        }
        $optsu .= '<option value="'.$res['id_utkani'].'"'.$select.'>'.$res['domaci']." - ".$res['hoste'].'</option>';
    }

    if ($tym == "all") {
        $select = ' selected="selected"';
    } else {
        $select = '';
    }
    $optst = '<option value="null">---</option>
        <option value="all"'.$select.'>Všechny</option>';
    $sql = 'SELECT DISTINCT(`id_tymu`) AS id_tymu, `vysledky_tym`.`nazev` AS nazev  FROM `vysledky_tym`
        JOIN `vysledky_utkani` ON (`vysledky_utkani`.`id_domaci` = `id_tymu`)
        JOIN `vysledky_utkani` hoste_utkani ON (hoste_utkani.`id_host` = `id_tymu`)
        JOIN `vysledky_kolo` ON (`vysledky_utkani`.`id_kola` = `vysledky_kolo`.`id_kola`)
        WHERE '.$filter_sezona.'
        ORDER BY nazev';
    $q = mysql_query($sql);
    while ($res = mysql_fetch_array($q)) {
        if ($tym == $res['id_tymu']." AND ".$res['id_tymu']) {
            $select = ' selected="selected"';
        } else {
            $select = '';
        }
        $optst .= '<option value="'.$res['id_tymu'].'"'.$select.'>'.$res['nazev'].'</option>';
    }


    
    $optsk = '<option value=""'.($kategorie == ""?' selected="selected"':'').'>Všechny</option>';
    $optsk .= '<option value="S"'.($kategorie=='S'?' selected="selected"':'').'>Singly</option>';
    $optsk .= '<option value="D"'.($kategorie=='D'?' selected="selected"':'').'>Dvojice</option>';
    $optsk .= '<option value="T"'.($kategorie=='T'?' selected="selected"':'').'>Trojice</option>';

    echo '<div class="filter">
            <div>
            Kolo:
            <select id="statistiky_kolo" onchange="statistikyFiltr(\'kolo\', this);">
            '.$opts.'
            </select>
            </div>
            <div>
            Utkání:
            <select id="statistiky_utkani" onchange="statistikyFiltr(\'utkani\', this);">
            '.$optsu.'
            </select>
            </div>
            <div>
            Tým:
            <select id="statistiky_tym" onchange="statistikyFiltr(\'tym\', this);">
            '.$optst.'
            </select>
            </div>
            <div>
            Kategorie:
            <select id="statistiky_kategorie" onchange="statistikyFiltr(\'kategorie\', this);">
            '.$optsk.'
            </select>
            </div>
        </div>';


    // zde proběhne řazení
    //$hraci = subval_sort($hraci, $order, $direction);
    orderBy($hraci, "$order $direction, % DESC, sety DESC");

    // zde výpis
    echo '<table class="vysledky_tabulka">';
    echo '<tr>
            <th rowspan="2">#</th>
            <th colspan="2">Jméno</th>
            <th colspan="2">Zápasy</th>
            <th colspan="2">Výhry</th>
            <th colspan="2">Remízy</th>
            <th colspan="2">Prohry</th>
            <th colspan="2">Skóre</th>
            <th colspan="2">%</th>
            <th colspan="2">Pískání</th>
        </tr>
        <tr>
';
    $rq = explode("&", $_SERVER['QUERY_STRING']);
    $rq[0] = "";
    $rq = implode("&", $rq);
    $rq = substr($rq, 1);
    echo '
            <th><a href="./?'.addToRequestQuery('dir', null, addToRequestQuery('sort', 'jmeno', $rq)).'">&#x02C5;</a></th>
            <th><a href="./?'.addToRequestQuery('dir', 'asc', addToRequestQuery('sort', 'jmeno', $rq)).'">&#x02C4;</a></th>
            <th><a href="./?'.addToRequestQuery('dir', null, addToRequestQuery('sort', 'zapasy', $rq)).'">&#x02C5;</a></th>
            <th><a href="./?'.addToRequestQuery('dir', 'asc', addToRequestQuery('sort', 'zapasy', $rq)).'">&#x02C4;</a></th>
            <th><a href="./?'.addToRequestQuery('dir', null, addToRequestQuery('sort', 'vyhry', $rq)).'">&#x02C5;</a></th>
            <th><a href="./?'.addToRequestQuery('dir', 'asc', addToRequestQuery('sort', 'vyhry', $rq)).'">&#x02C4;</a></th>
            <th><a href="./?'.addToRequestQuery('dir', null, addToRequestQuery('sort', 'remizy', $rq)).'">&#x02C5;</a></th>
            <th><a href="./?'.addToRequestQuery('dir', 'asc', addToRequestQuery('sort', 'remizy', $rq)).'">&#x02C4;</a></th>
            <th><a href="./?'.addToRequestQuery('dir', null, addToRequestQuery('sort', 'prohry', $rq)).'">&#x02C5;</a></th>
            <th><a href="./?'.addToRequestQuery('dir', 'asc', addToRequestQuery('sort', 'prohry', $rq)).'">&#x02C4;</a></th>
            <th><a href="./?'.addToRequestQuery('dir', null, addToRequestQuery('sort', 'sety', $rq)).'">&#x02C5;</a></th>
            <th><a href="./?'.addToRequestQuery('dir', 'asc', addToRequestQuery('sort', 'sety', $rq)).'">&#x02C4;</a></th>
            <th><a href="./?'.addToRequestQuery('dir', null, addToRequestQuery('sort', null, $rq)).'">&#x02C5;</a></th>
            <th><a href="./?'.addToRequestQuery('dir', 'asc', addToRequestQuery('sort', null, $rq)).'">&#x02C4;</a></th>
            <th><a href="./?'.addToRequestQuery('dir', null, addToRequestQuery('sort', 'piskani', $rq)).'">&#x02C5;</a></th>
            <th><a href="./?'.addToRequestQuery('dir', 'asc', addToRequestQuery('sort', 'piskani', $rq)).'">&#x02C4;</a></th>

        </tr>
        ';
    $i = 0;
    if (isset($hraci))
    foreach ($hraci as $id => $hrac) {
        $i++;
        echo '<tr>';
        echo '<td>'.$i.'</td>';
        echo '<td colspan="2"><a href="' . URL.$statistics . '/' . $hrac['link'] . '/">'.$hrac['jmeno'].'</a></td>';
        echo '<td colspan="2">'.$hrac['zapasy'].'</td>';
        echo '<td colspan="2">'.$hrac['vyhry'].'</td>';
        echo '<td colspan="2">'.$hrac['remizy'].'</td>';
        echo '<td colspan="2">'.$hrac['prohry'].'</td>';
        echo '<td colspan="2">'.$hrac['sety+'].':'.$hrac['sety-'].'</td>';
        echo '<td colspan="2">'.round($hrac['%'], 1).'</td>';
        echo '<td colspan="2">'.$hrac['piskani'].'</td>';
        echo '</tr>';
    }

    echo '</table>';

}
