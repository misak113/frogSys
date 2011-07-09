<?php

function writeDisk($page_part) {
    global $tyden, $rok;
    $count_on_page = 5;
    $menulink = getMenuLink($page_part);

    //echo '<h1>Diskuse</h1>';
    writeHtmlEditArea($page_part, '<h1>Diskuse</h1>');

    $sql = "SELECT * FROM `users` WHERE `id` = ".USER_ID."";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $user = $res['jmeno']." ".$res['prijmeni'];
    }
    echo '<form action="javascript: ;" onsubmit="addDiskuse('.$page_part.', this);">';
    echo 'Jméno: <input type="text" id="diskuse_user_'.$page_part.'" class="diskuse_user" value="'.$user.'" /><br />';
    echo '<textarea id="diskuse_text_'.$page_part.'" class="diskuse_text"></textarea><br />';
    echo '<input type="submit" value="Odeslat" />';
    echo '</form>';
    
    $unlogged2 = "LIMIT ".($count_on_page*@$_GET['str']).", $count_on_page";
    if (is_logged_in()) {
        $unlogged2 = "";
    }
    $sql = "SELECT * FROM `diskuse` WHERE `parent` = $page_part ORDER BY `datetime` DESC $unlogged2";
    $q = mysql_query($sql);
    while ($res = @mysql_fetch_array($q)) {
        $user = $res['writer'];
        $datetime = explode(" ", $res['datetime']);
        $datum = explode("-", $datetime[0]);
        $time = explode(":", $datetime[1]);
        $tim = mktime(0, 0, 0, $datum[1], $datum[2], $datum[0]);
        $date = $tyden[date("w", $tim)].", ".$datum[2].". ".$rok[$datum[1]-1]." ".$datum[0].", ".$time[0].":".$time[1]."";
        $text = $res['text'];
        echo '
            <div class="prispevek" id="prispevek_'.$res['id'].'">
                <h2 class="user">'.$user.'</h2>
                <div class="datum">'.$date.'</div>
                <div class="text">'.$text.'</div>';
        if (is_logged_in()) {
            writeEditPane("Diskuse", $res['parent'].", ".$res['id'].", this", "D");
        }
        echo '
            </div>';
    }

    if (!is_logged_in()) {

        echo '<div class="strankovani">';
        if ($_GET['str'] > 0) {
            echo '<a href="'.URL.$menulink.'/?str='.($_GET['str']-1).'">&lt; předchozí</a> ';
        }
        $sql = "SELECT COUNT(*) AS pocet FROM `diskuse` WHERE `parent` = $page_part";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $pages = floor($res['pocet']/$count_on_page);
            if ($pages > 0) {
            for ($i=0;$i<=$pages;$i++) {
                if ($i == $_GET['str']) {
                    echo '<span class="aktual">'.($i+1).'</span>';
                } else {
                    echo "<a href=\"".URL."$menulink/?str=$i\">".($i+1)."</a>  ";
                }
            }
            }
        }
        if ($_GET['str'] < $pages) {

            echo '<a href="'.URL.$menulink.'/?str='.($_GET['str']+1).'">následující &gt;</a> ';

        }

        echo '</div>';
    }
}
?>
