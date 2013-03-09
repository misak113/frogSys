<?php

function writeTabulka($page_part) {
    global $_SETING;
    $statistics = $_SETING['statistics'];

    $id_souteze = writeNohejbalHead($page_part);

    writeHtmlEditArea($page_part, "<h2>Tabulka</h2>");

    if (@$_GET['kolo']) {
        $actual_poradi = $_GET['kolo'];
    } else {
        $sql = "SELECT * FROM `vysledky_kolo` WHERE `datetime` < NOW() AND `sezona` = '".VYSL_SEZONA."' AND `id_souteze` = ".$id_souteze." ORDER BY `datetime` DESC";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $actual_poradi = $res['poradi'];
        }
    }

    ?>
<table class="vysledky_tabulka">
    <tr>
        <th>#</th>
        <th>Název</th>
        <th>web</th>
        <th>Z</th>
        <th>V</th>
        <th>R</th>
        <th>P</th>
        <th>Skóre</th>
        <th>B</th>
    </tr>
        <?php
        $sql = 'SELECT * FROM `vysledky_utkani` JOIN `vysledky_kolo` USING (`id_kola`) WHERE `id_souteze` = '.$id_souteze.' AND `sezona` = '.VYSL_SEZONA.'';
        $q = mysql_query($sql);
        $i = 0;
        $tyms = array();
        while ($tym = mysql_fetch_array($q)) {
            $tyms[$i]['id_tymu'] = $tym['id_host'];
            $i++;
            $tyms[$i]['id_tymu'] = $tym['id_domaci'];
            $i++;
        }


        $i = 0;
        $tymy = array();
        foreach ($tyms as $tym) {
            $naslo = false;
            foreach ($tymy as $tym2) {
                if ($tym['id_tymu'] == $tym2['id_tymu']) {
                    $naslo = true;
                    break;
                }
            }
            if (!$naslo) {
                $tymy[$i]['id_tymu'] = $tym['id_tymu'];
                $i++;
            }
        }


        for ($i=0;$i < count($tymy);$i++) {
            $sql = "SELECT * FROM `vysledky_tym` WHERE `id_tymu` = ".$tymy[$i]['id_tymu']."";
            $q = mysql_query($sql);
            if ($res = mysql_fetch_array($q)) {
                $tymy[$i]['nazev'] = $res['nazev'];
                $tymy[$i]['link'] = $res['link'];
                $tymy[$i]['web'] = $res['web'];
            }

            $sql = 'SELECT * FROM `vysledky_utkani` JOIN `vysledky_kolo` USING (`id_kola`)
LEFT JOIN
(
(SELECT distinct(`id_zapasu`), domaci, hoste, hos1.`id_utkani` FROM
                        (SELECT count(`id_vysledku`) AS domaci, `id_zapasu`, `id_utkani` FROM `vysledky_zapas`
                            JOIN `vysledky_vysledek` USING (`id_zapasu`) WHERE `domaci` > `hoste` GROUP BY `id_zapasu`) dom1
                        RIGHT OUTER JOIN
                        (SELECT count(`id_vysledku`) AS hoste, `id_zapasu`, `id_utkani` FROM `vysledky_zapas`
                            JOIN `vysledky_vysledek` USING (`id_zapasu`) WHERE `domaci` < `hoste` GROUP BY `id_zapasu`) hos1 USING (`id_zapasu`)) 
UNION
(SELECT distinct(`id_zapasu`), domaci, hoste, dom2.`id_utkani` FROM
                        (SELECT count(`id_vysledku`) AS domaci, `id_zapasu`, `id_utkani` FROM `vysledky_zapas`
                            JOIN `vysledky_vysledek` USING (`id_zapasu`) WHERE `domaci` > `hoste` GROUP BY `id_zapasu`) dom2
                        LEFT OUTER JOIN
                        (SELECT count(`id_vysledku`) AS hoste, `id_zapasu`, `id_utkani` FROM `vysledky_zapas`
                            JOIN `vysledky_vysledek` USING (`id_zapasu`) WHERE `domaci` < `hoste` GROUP BY `id_zapasu`) hos2 USING (`id_zapasu`)) 
) zapasy
ON (`vysledky_utkani`.`id_utkani` = zapasy.`id_utkani`)
WHERE `id_souteze` = '.$id_souteze.' AND `sezona` = '.VYSL_SEZONA.' AND
(`vysledky_utkani`.`id_host` = '.$tymy[$i]['id_tymu'].' OR vysledky_utkani.`id_domaci` = '.$tymy[$i]['id_tymu'].')
AND NOT (domaci IS NULL AND hoste IS NULL)
AND `poradi` <= '.$actual_poradi.'';
            $q = mysql_query($sql);
            $id_host = array();
            $id_domaci = array();
            $domaci = array();
            $hoste = array();
            while ($res3 = mysql_fetch_array($q)) {
                if (!isset($domaci[$res3['id_utkani']])) {
                    $domaci[$res3['id_utkani']] = 0;
                }
                if (!isset($hoste[$res3['id_utkani']])) {
                    $hoste[$res3['id_utkani']] = 0;
                }
                @$id_host[$res3['id_utkani']] = $res3['id_host'];
                @$id_domaci[$res3['id_utkani']] = $res3['id_domaci'];
                if ($res3['domaci'] > $res3['hoste']) {
                    @$domaci[$res3['id_utkani']]++;
                }
                if ($res3['domaci'] < $res3['hoste']) {
                    @$hoste[$res3['id_utkani']]++;
                }
            }
            $vyhry = 0;
            $prohry = 0;
            $remizy = 0;
            $skore_left = 0;
            $skore_right = 0;
            foreach ($id_host as $key => $dom_ut) {
                if ($id_host[$key] == $tymy[$i]['id_tymu']) {
                    if (@$domaci[$key] < @$hoste[$key]) {
                        $vyhry++;
                    }
                    if (@$domaci[$key] > @$hoste[$key]) {
                        $prohry++;
                    }
                    $skore_left += @$hoste[$key];
                    $skore_right += @$domaci[$key];
                }
                if ($id_domaci[$key] == $tymy[$i]['id_tymu']) {
                    if (@$domaci[$key] > @$hoste[$key]) {
                        $vyhry++;
                    }
                    if (@$domaci[$key] < @$hoste[$key]) {
                        $prohry++;
                    }
                    $skore_left += @$domaci[$key];
                    $skore_right += @$hoste[$key];
                }
                if (@$domaci[$key] == @$hoste[$key]) {
                    $remizy++;
                }
            }
            $tymy[$i]['vyhry'] = $vyhry;
            $tymy[$i]['prohry'] = $prohry;
            $tymy[$i]['remizy'] = $remizy;
            $tymy[$i]['zapasy'] = $remizy+$prohry+$vyhry;
            $tymy[$i]['body'] = $remizy+$vyhry*2;
            $tymy[$i]['skore'] = $skore_left.":".$skore_right;
            $tymy[$i]['skore_rozdil'] = $skore_left-$skore_right;
        }

        if ($tymy) {
        //$tymy = subval_sort($tymy, 'skore_rozdil', 'desc');
        //$tymy = subval_sort($tymy, 'body', 'desc');
        orderBy($tymy, 'body DESC, skore_rozdil DESC, zapasy ASC, vyhry DESC');
        //print_r($tymy);
        $poradi = 0;
        foreach ($tymy as $tym) {
            ?>
    <tr>
        <td class="poradi"><?php $poradi++; echo $poradi; ?>.</td>
        <td class="nazev"><a href="<?php echo URL.$statistics; ?>/<?php echo $tym['link']; ?>/"><?php echo $tym['nazev']; ?></a></td>
        <td class="web"><?php if ($tym['web']) { ?>
            <a href="http://<?php echo $tym['web']; ?>/" target="_blank">web &gt;</a></td>
                <?php } ?>
        <td class="zapasy">
                    <?php echo $tym['zapasy']; ?>
        </td>
        <td class="vyhry">
                    <?php echo $tym['vyhry']; ?>
        </td>
        <td class="remizy">
                    <?php echo $tym['remizy']; ?>
        </td>
        <td class="prohry">
                    <?php echo $tym['prohry']; ?>
        </td>
        <td class="skore">
                    <?php echo $tym['skore']; ?>
        </td>
        <td class="body">
                    <?php echo $tym['body']; ?>
        </td>
    </tr>
        <?php
        }
        }
        ?>
</table>
<?php
    $sql = "SELECT * FROM `vysledky_kolo` WHERE `sezona` = '".VYSL_SEZONA."' AND `id_souteze` = ".$id_souteze." ORDER BY `poradi`";
    $q = mysql_query($sql);
    echo '<div class="vysledky_kola"> Kolo: ';
    while ($res = mysql_fetch_array($q)) {
        if ($actual_poradi == $res['poradi']) {
            echo '<span class="actual_poradi">'.$res['poradi'].'</span>, ';
        } else {
            echo '<a href="./?kolo='.$res['poradi'].'" class="poradi">'.$res['poradi'].'</a>, ';
        }
    }
    echo '</div>';

}