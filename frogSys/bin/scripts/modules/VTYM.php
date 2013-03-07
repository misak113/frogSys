<?php
/*
 *
 *
 */

function writeVyhledavaniTymu($page_part) {
    global $_SETING;
    $statistics = $_SETING['statistics'];

    $teams = '';
    if (isset($_GET['search'])) {
        $search = $_GET['search'];

        $teams .= '<table class="vysledky_tabulka vysledky_tymy">
            <tr><th>Název</th><th>Kategorie</th><th>web</th><th>Soutěž</th></tr>';
        $sql = 'SELECT DISTINCT(`id_tymu`), `vysledky_tym`.`nazev` AS nazev, `kategorie`, `web`, `link`, `vysledky_soutez`.`nazev` AS soutez_nazev, `obrazek`
                FROM `vysledky_tym`
                LEFT JOIN `vysledky_utkani` ON (`id_tymu` = `id_domaci`)
                LEFT JOIN `vysledky_kolo` USING (`id_kola`)
                LEFT JOIN `vysledky_soutez` USING (`id_souteze`)
                WHERE `vysledky_tym`.`nazev` LIKE \'%'.$search.'%\'
                AND `sezona` = \''.VYSL_SEZONA.'\'
                ORDER BY `vysledky_tym`.`nazev`';
        $q = mysql_query($sql);
        while ($tym = mysql_fetch_array($q)) {
            $teams .= '<tr>';
            $teams .= '<td><a href="' . URL.$statistics . '/' . $tym['link'] . '/">'.$tym['nazev'].'</a></td>';
            $teams .= '<td>'.$tym['kategorie'].'</td>';
            $teams .= '<td><a href="http://'.$tym['web'].'/" target="_blank">'.$tym['web'].'</a></td>';
            $teams .= '<td>'.$tym['soutez_nazev'].'</td>';
            $teams .= '</tr>';
        }
        $teams .= '</table>';
    } else {
        $search = "";
    }


    //echo '<h1>Vyhledávání týmu</h1>';
    writeHtmlEditArea($page_part, "<h1>Vyhledávání týmu</h1>");
    echo '<div class="vysledky_vyhledavani_tymu">';
    echo '<form action="./">';
    echo '<div class="search"><input value="'.$search.'" type="text" name="search" /></div>';
    echo '<div class="submit"><input value="Hledat" type="submit" /></div>';
    echo '</form>';

    echo '<div>'.$teams.'</div>';

    echo '</div>';
}
?>
