<?php
if ($_POST['action'] == "get_prehled") {
    echo "<h1>Základní přehled</h1>";

    $sql = "SELECT * FROM `html` WHERE `parent` = -3";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $titulek = $res['content'];
    }
    $sql = "SELECT * FROM `html` WHERE `parent` = -4";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $nazev = $res['content'];
    }
    $sql = "SELECT * FROM `html` WHERE `parent` = -5";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $popis = $res['content'];
    }
    $sql = "SELECT * FROM `html` WHERE `parent` = -6";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $keywords = $res['content'];
    }
    $sql = "SELECT * FROM `html` WHERE `parent` = -7";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $rekonstrukce = $res['content'];
    }

    echo '
        <table style="width: 100%;" id="zakladni_prehled">
            <tr>
                <th>Název:';
            writeEditPane("Titulek", "-4", "E");
    echo '</th>
                <td id="titulek-4">'.$nazev.'</td>
            </tr>
            <tr>
                <th>Titulek:';
            writeEditPane("Titulek", "-3", "E");
    echo '</th>
                <td id="titulek-3">'.$titulek.'</td>
            </tr>
            <tr>
                <th>Popis:';
            writeEditPane("Titulek", "-5", "E");
    echo '</th>
                <td id="titulek-5">'.$popis.'</td>
            </tr>
            <tr>
                <th>Keywords:';
            writeEditPane("Titulek", "-6", "E");
    echo '</th>
                <td id="titulek-6">'.$keywords.'</td>
            </tr>
            <tr>
                <th>Info o rekonstrukci:';
    $check = "C";
    if (isset($_SETING['REKONSTRUKCE'])) {
        $check = "Č";
    }
            writeEditPane("Seting", "'REKONSTRUKCE', this", $check."E");
    echo '</th>
                <td id="seting_REKONSTRUKCE">'.@$_SETING['REKONSTRUKCE'].'</td>
            </tr>

        </table>

';
}
?>
