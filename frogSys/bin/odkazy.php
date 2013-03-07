<?php
    require_once "../../config/database.php";
    include PATH."/bin/scripts.php";
if (isset($_GET['domain'])) {
    echo '<div class="content_in_id">';
    echo "<h1>Odkazy</h1>";

    $sql = "SELECT * FROM `href` WHERE `domain` = '".$_GET['domain']."'";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $sql = "UPDATE `href` SET `pocet_zobrazeni` = `pocet_zobrazeni` + 1 WHERE `domain` = '".$_GET['domain']."'";
        $q = mysql_query($sql);
    } else {
        $sql = "INSERT INTO `href` VALUES(NULL, '".$_GET['domain']."', 'Název odkazované stránky', 'Text popisující odkazovanou stránku.', 1, 5, NOW(), 5*24*60*60)";
        $q = mysql_query($sql);
    }

    $sql = "SELECT * FROM `href` WHERE `domain` = '".$_GET['domain']."'";
    $q = mysql_query($sql);
    if ($aktual = mysql_fetch_array($q)) {
        $dt = explode(" ", $aktual['last_change_date']);
        $t = explode(":", $dt[1]);
        $d = explode("-", $dt[0]);
        $last_change_date = mktime($t[0], $t[1], $t[2], $d[1], $d[2], $d[0]);
        if ($last_change_date + $aktual['change_period'] < mktime()) {
            //shuffle href_covcem
            $sql = "UPDATE `href` SET `last_change_date` = NOW() WHERE `id` = ".$aktual['id']."";
            $q = mysql_query($sql);

            $sql = "SELECT * FROM `href_covcem` WHERE `id_vcem` = ".$aktual['id']." ORDER BY RAND()";
            $q = mysql_query($sql);
            $i = 0;
            while ($res = mysql_fetch_array($q)) {
                $i++;
                $sql = "UPDATE `href_covcem` SET `priority` = $i WHERE `id` = ".$res['id']."";
                mysql_query($sql);
            }
            
        }

        $sql = "SELECT * FROM `href_covcem` WHERE `id_vcem` = ".$aktual['id']." ORDER BY `priority` LIMIT ".$aktual['pocet_odkazu'];
        $q = mysql_query($sql);
        while ($res = mysql_fetch_array($q)) {
            $sql = "SELECT * FROM `href` WHERE `id` = ".$res['id_co']."";
            $q2 = mysql_query($sql);
            if ($res2 = mysql_fetch_array($q2)) {
                echo "<h2>".$res2['name']."</h2>";
                echo "".$res2['text']."";
            }
        }
    }
    echo '</div>';
}
?>
<?php mysql_close(); ?>