<?php

if ($_POST['action'] == "get_domains") {
    $sql = "SELECT * FROM `href`";
    $q = mysql_query($sql);
    echo '
        <p>Tato funkce funguje pouze na mateřském serveru www.avantcore.cz. Na ostatních úpravy nemají význam.</p>
        <p>Pro přidání stránky do odkazů vložte na tu stránku, kterou chcete přidat do sekce odkazy, následující PHP kód nebo ná té stránce zapněte v frogSys modul ODKAZY (HREF).</p>
        <textarea style="width: 95%; height: 25px;">&lt;?php @readfile("http://www.avantcore.cz/frogSys/bin/odkazy.php?domain=http://www.nazev-vasi-domeny.cz/"); ?&gt;</textarea>
    <table cellspacing="5" cellpadding="5" style="text-align: center;">
        <tr style="background-color: #D3D3D3;"><th>Ikona</th><th>Doména</th><th>Název</th><th>Text</th><th>Počet zobrazení</th><th>Max zobrazených odkazů</th><th>Poslední změna</th><th>Perioda změn</th><th>Odkazované stránky</th></tr>
    ';
    while ($res = mysql_fetch_array($q)) {
        echo '
            <tr style="border-bottom: 1px solid black;">
                <td style="border-bottom: 1px solid black;">
                    <img src="'.$res['domain'].'favicon.ico" alt="ikona" />
                </td>
                <td style="border-bottom: 1px solid black;">
                    <a href="'.$res['domain'].'" target="_blank">
                        '.$res['domain'].'
                    </a>';
        writeEditPane("Odkazy", $res['id'], "D");
        echo '
                </td>
                <td style="border-bottom: 1px solid black;">
                    <strong id="odkazy_nazev_'.$res['id'].'">'.$res['name'].'</strong>';
        writeEditPane("OdkazyNazev", $res['id'], "E");
        echo '
                </td>
                <td style="border-bottom: 1px solid black;">
                    <i id="odkazy_text_'.$res['id'].'">'.$res['text'].'</i>';
        writeEditPane("OdkazyText", $res['id'], "E");
        echo '
                </td>
                <td style="border-bottom: 1px solid black;">
                    '.$res['pocet_zobrazeni'].'';
        echo '
                </td>
                <td style="border-bottom: 1px solid black;">
                    <span id="odkazy_pocet_odkazu_'.$res['id'].'">'.$res['pocet_odkazu'].'</span>';
        writeEditPane("OdkazyPocetOdkazu", $res['id'], "E");
        echo '
                </td>
                <td style="border-bottom: 1px solid black;">
                    '.$res['last_change_date'].'
                </td>
                <td style="border-bottom: 1px solid black;">
                    <span id="odkazy_perioda_'.$res['id'].'">';
        $cp = $res['change_period'];
        if ($cp < 60) {
            echo $cp." sekund";
        } else {
            $cp = round($cp / 60, 2);
            if ($cp < 60) {
                echo $cp." minut";
            } else {
                $cp = round($cp / 60, 2);
                if ($cp < 60) {
                    echo $cp." hodin";
                } else {
                    $cp = round($cp / 24, 2);
                    if ($cp < 60) {
                        echo $cp." dnů";
                    } else {
                        $cp = round($cp / 30, 2);
                        if ($cp < 60) {
                            echo $cp." měsíců";
                        } else {
                            $cp = round($cp / 12, 2);
                            
                            echo $cp." roků";
                            
                        }
                    }
                }
            }
        }
        echo "</span>";
        writeEditPane("OdkazyPerioda", $res['id'], "E");
        $sql = "SELECT COUNT(*) AS count FROM `href_covcem` WHERE `id_vcem` = ".$res['id']."";
        $q2 = mysql_query($sql);
        if ($res2 = mysql_fetch_array($q2)) {
            $pocet_odkazu = $res2['count'];
        }
        echo '
                </td>
                <td style="border-bottom: 1px solid black;">
                    <a href="javascript: odkazyHrefPages('.$res['id'].');"><img src="'.URL.'frogSys/images/icons/pages.png" alt="odkazované stránky" /></a> ('.$pocet_odkazu.')
                </td>
            </tr>
        ';
    }
    echo '</table>';
}

if ($_POST['action'] == "get_href_pages") {
    $sql = "SELECT * FROM `href`";
    $q = mysql_query($sql);
    echo '<table>';
    while ($res = mysql_fetch_array($q)) {
        $sql = "SELECT * FROM `href_covcem` WHERE `id_vcem` = ".$_POST['id']." AND `id_co` = ".$res['id']."";
        $q2 = mysql_query($sql);
        $check = "";
        if ($res2 = mysql_fetch_array($q2)) {
            $check = " checked";
        }
            echo '
            <tr>
                <td>
                    '.$res['domain'].'
                </td>
                <td>
                    <input type="checkbox" onchange="changePageShow('.$_POST['id'].', '.$res['id'].', this);"'.$check.' />
                </td>
            </tr>
            ';
        
    }
    echo '</table>';
}
if ($_POST['action'] == "set_covcem") {
    if ($_POST['act'] == "add") {
        $sql = "INSERT INTO `href_covcem` VALUES(NULL, ".$_POST['id_vcem'].", ".$_POST['id_co'].", 0, 0)";
        $q = mysql_query($sql);
        echo "Stránka přidána k odkazování.";
    }
    if ($_POST['act'] == "del") {
        $sql = "DELETE FROM `href_covcem` WHERE `id_vcem` = ".$_POST['id_vcem']." AND `id_co` = ".$_POST['id_co']."";
        $q = mysql_query($sql);
        echo "Stránka odebrána z odkazování.";
    }
}

if ($_POST['action'] == "set_name") {
    $sql = "UPDATE `href` SET `name` = '".$_POST['name']."' WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    echo "Název byl změněn.";
}
if ($_POST['action'] == "set_pocet_odkazu") {
    if ($_POST['pocet'] > 0 && $_POST['pocet'] <= 50) {
        $sql = "UPDATE `href` SET `pocet_odkazu` = '".$_POST['pocet']."' WHERE `id` = ".$_POST['id']."";
        $q = mysql_query($sql);
    echo "Počet odkazů byl změněn.";
    } else {
        echo "Musí být číslovka od 1 do 50!";
    }

}
if ($_POST['action'] == "set_perioda") {
    switch ($_POST['jednotka']) {
        case "sec": $krat = 1;
            break;
        case "min": $krat = 60;
            break;
        case "hod": $krat = 60*60;
            break;
        case "den": $krat = 60*60*24;
            break;
        case "mes": $krat = 60*60*24*30;
            break;
        case "rok": $krat = 60*60*24*30*12;
            break;

    }
    $period = $_POST['pocet']*$krat;
    $sql = "UPDATE `href` SET `change_period` = '".$period."' WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    echo "Perioda změny byla změněna.";
}
if ($_POST['action'] == "set_text") {
    $sql = "UPDATE `href` SET `text` = '".$_POST['text']."' WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    echo "Text byl změněn.";
}

if ($_POST['action'] == "delete") {
    $sql = "DELETE FROM `href` WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    $sql = "DELETE FROM `href_covcem` WHERE `id_co` = ".$_POST['id']." OR `id_vcem` = ".$_POST['id']."";
    $q = mysql_query($sql);
    echo "Stránka byla smazána z odkazů.";
}


?>
