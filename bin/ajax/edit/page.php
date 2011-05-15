<?php
if ($_POST['action'] == "add_part") {
    if ($_POST['place'] == "under") {
        $sql = "SELECT MAX(`order`) AS maxorder FROM `page` WHERE `parent` = ".$_POST['parent']."";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $max_order = $res['maxorder'];
        }

        $rand = mt_rand(1000, 9999);
        $sql = "INSERT INTO `page_parts` VALUES(NULL, '".$rand."')";
        mysql_query($sql);
        $sql = "SELECT * FROM `page_parts` WHERE `type` = '".$rand."'";
        $q2 = mysql_query($sql);
        if ($res2 = mysql_fetch_array($q2)) {
            $sql = "INSERT INTO `page` VALUES(NULL, ".$res2['id'].", 100, ".$_POST['parent'].", ".($max_order+1).")";
            mysql_query($sql);
            echo "Nový sloupec byl vložen dole.";
        }
    } else {
        $sql = "SELECT * FROM `page` WHERE `id` = ".$_POST['place']."";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $sql = "UPDATE `page` SET `order` = `order` + 1 WHERE `order` > ".$res['order']."";
            mysql_query($sql);

            $rand = mt_rand(1000, 9999);
            $sql = "INSERT INTO `page_parts` VALUES(NULL, '".$rand."')";
            mysql_query($sql);
            $sql = "SELECT * FROM `page_parts` WHERE `type` = '".$rand."'";
            $q2 = mysql_query($sql);
            $sirka = round($res['width']/2);
            if ($res2 = mysql_fetch_array($q2)) {
                $sql = "INSERT INTO `page` VALUES(NULL, ".$res2['id'].", ".$sirka.", ".$_POST['parent'].", ".($res['order']+1).")";
                mysql_query($sql);
                $sql = "UPDATE `page` SET `width` = ".($res['width']-$sirka)." WHERE `id` = ".$_POST['place']."";
                mysql_query($sql);
                srovnejSloupce($_POST['parent']);
                echo "Nový sloupec byl vložen vpravo.";
            }
        }
    }
}
if ($_POST['action'] == "delete_part") {
    $sql = "SELECT * FROM `page` WHERE `id` = ".$_POST['id']." LIMIT 1";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $sql5 = "DELETE FROM `page` WHERE `id` = ".$_POST['id']."";
        if (mysql_query($sql5)) {
            srovnejSloupce($res['parent']);
            echo "Sloupec byl smazán.".$sirka." ".$predchozi_id;
        }
    } else {
        echo "Při mazání sloupce došlo k chybě!";
    }
}

function srovnejSloupce($parent) {
    $sql = "SELECT * FROM `page` WHERE `parent` = ".$parent." ORDER BY `order`";
    $q4 = mysql_query($sql);
    $sirka = 0;
    $predchozi_id = null;
    while ($res4 = mysql_fetch_array($q4)) {
        if ($sirka+$res4['width'] > 100) {
            $sql = "UPDATE `page` SET `width` = `width`+".(100-$sirka)." WHERE `id` = ".$predchozi_id."";
            mysql_query($sql);
            $sirka = $res4['width'];
        } else {
            $sirka += $res4['width'];
        }
        $predchozi_id = $res4['id'];
    }
    if ($sirka < 100 && $predchozi_id != null) {
        $sql = "UPDATE `page` SET `width` = `width`+".(100-$sirka)." WHERE `id` = ".$predchozi_id."";
        mysql_query($sql);
    }
    $sql = "UPDATE `page` SET `width` = 100 WHERE `width` > 100 AND `parent` <> 0";
    mysql_query($sql);
}
if ($_POST['action'] == "move") {
    if ($_POST['smer'] == "up") {
        $desc = " ASC";
        $then = ">";
        $znam = "+";
        $lim = "MIN";
        $znam2 = "-";
    } else {
        $desc = " DESC";
        $then = "<";
        $znam = "-";
        $lim = "MAX";
        $znam2 = "+";
    }
    $sql = "SELECT * FROM `page` WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $sql = "SELECT * FROM `page` WHERE `parent` = ".$res['parent']." ORDER BY `order`$desc";
        $q2 = mysql_query($sql);
        $sirka = 0;
        $above_id = null;
        $srovnej = false;
        while ($res2 = mysql_fetch_array($q2)) {
            if ($srovnej) {
                if ($last != 100) {
                    $sql = "UPDATE `page` SET `width` = `width` + $srovnej WHERE `id` = ".$res2['id']."";
                    mysql_query($sql);
                }
                break;
            }
            $sirka += $res2['width'];
            if ($res2['id'] == $_POST['id']) {
                if ($above_id != null) {
                    $sql = "UPDATE `page` SET `order` = `order` $znam 1 WHERE `order` $then ".$above_order." AND `parent` = ".$res['parent']."";
                    mysql_query($sql);
                    $sir2 = round($above_sirka/2);
                    $sql = "UPDATE `page` SET `order` = ".$above_order." $znam 1, `width` = ".$sir2." WHERE `id` = ".$_POST['id']."";
                    mysql_query($sql);
                    $sql = "UPDATE `page` SET `width` = ".($above_sirka-$sir2)." WHERE `id` = ".$above_id."";
                    mysql_query($sql);

                } else {
                    $sql = "SELECT $lim(`order`) AS lim FROM `page` WHERE `parent` = ".$res['parent']."";
                    $q3 = mysql_query($sql);
                    if ($res3 = mysql_fetch_array($q3)) {
                        $lim_order = $res3['lim'];
                    }
                    $sql = "UPDATE `page` SET `order` = ".$lim_order." $znam2 1, `width` = 100 WHERE `id` = ".$_POST['id']."";
                    mysql_query($sql);
                //srovnejSloupce($res['parent']);
                //break;
                }
                $last = $res2['width'];
                $srovnej = $res2['width'];
            }
            if ($sirka >= 100) {
                $above_id = $res2['id'];
                $above_order = $res2['order'];
                $above_sirka = $res2['width'];
                $sirka = 0;
            }

        }
        srovnejSloupce($res['parent']);
        echo "Sloupec byl přesunut.";
    }

}
if ($_POST['action'] == "sort") {
    $sql = "SELECT `parent` FROM `page` WHERE `id` = ".$_POST['id']." LIMIT 1";
    $q = mysql_query($sql);
    $res = mysql_fetch_array($q);
    $parent = $res['parent'];
    $sql = "SELECT `order` AS target FROM `page` WHERE `id` = ".$_POST['change_with']." LIMIT 1";
    if ($_POST['change_with'] == "") {
        $sql = "SELECT * FROM `page` WHERE `parent` = ".$res['parent']." ORDER BY `order`";
        $q2 = mysql_query($sql);
        $radek = false;
        $sirka = 0;
        $sql = false;
        while ($res2 = mysql_fetch_array($q2)) {
            $sirka += $res2['width'];
            if ($sirka > 100) {
                $sirka = $res2['width'];
                if ($radek == true) {
                    $sql = "SELECT (`order`) AS target FROM `page` WHERE `id` = ".$res2['id']." LIMIT 1";
                    break;
                }
            }
            if ($res2['id'] == $_POST['id']) {
                $radek = true;
            }

        }
        if ($sql == false) {
            $sql = "SELECT (MAX(`order`)+1) AS target FROM `page` WHERE `parent` = ".$res['parent']." LIMIT 1";
        }
    }
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $target = $res['target']-1;
        $sql = "SELECT * FROM `page` WHERE `id` = '".$_POST['id']."' LIMIT 1";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $from = $res['order'];
            if ($target > $from) {
                $sql = "UPDATE `page` SET `order` = `order`-1 WHERE `order` >= $from AND `order` <= $target AND `parent` = ".$res['parent']."";
                $q = mysql_query($sql);
                $sql = "UPDATE `page` SET `order` = ".$target." WHERE `id` = ".$_POST['id']."";
                $q = mysql_query($sql);
                echo "Úspěšně přesunut sloupec.";
            }
            if ($target < $from) {
                $sql = "UPDATE `page` SET `order` = `order`+1 WHERE `order` >= ".($target+1)." AND `order` <= $from AND `parent` = ".$res['parent']."";
                $q = mysql_query($sql);
                $sql = "UPDATE `page` SET `order` = ".($target+1)." WHERE `id` = ".$_POST['id']."";
                $q = mysql_query($sql);
                srovnejSloupce($parent);
                echo "Úspěšně přesunut sloupec";
            }
            if ($target == $from) {
                echo "Sloupec nebyl přesunuty.";
            }
        } else {
            echo "Nastala chyba při přemisťování sloupce!";
        }
    } else {
        echo "Nastala chyba při přemisťování sloupce!";
    }
}
if ($_POST['action'] == "resize") {
    $sql = "SELECT SUM(`width`) AS wid FROM `page` WHERE `id` = ".$_POST['left']." OR `id` = ".$_POST['right']."";
    $q = mysql_query($sql);
    $res = mysql_fetch_array($q);
    $wid = $res['wid'];
    $sql = "SELECT `parent` FROM `page` WHERE `id` = ".$_POST['right']."";
    $q = mysql_query($sql);
    $res = mysql_fetch_array($q);
    $parent = $res['parent'];
    $leftWid = round($_POST['left_width']/SIRKA_PAGE*100);
    $sql = "UPDATE `page` SET `width` = ".$leftWid." WHERE `id` = ".$_POST['left']."";
    $q = mysql_query($sql);
    $sql = "UPDATE `page` SET `width` = ".($wid-$leftWid)." WHERE `id` = ".$_POST['right']."";
    $q = mysql_query($sql);
    srovnejSloupce($parent);
    echo "Šířka stránky změněna.";
}






if ($_POST['action'] == "change_type_form") {
    ?>
<table class="edit_table">
    <tr>
        <th>Změna typu stránky</th>
    </tr>
    <tr>
            <?php
            $sql = "SELECT * FROM `page_parts` WHERE `id` = ".$_POST['id']."";
            $q = mysql_query($sql);
            if ($res = mysql_fetch_array($q)) {
                $nosuper = "`zapnut` = 1 AND ";
                if (@$_SESSION['auth'] == 1) {
                    $nosuper = "";
                }
                echo "<td class=\"modules\"><table><tr>";
                $sql = "SELECT * FROM `modules` WHERE $nosuper`parent` = 0";
                $q2 = mysql_query($sql);
                $i=0;
                while ($res2 = mysql_fetch_array($q2)) {
                    $i++;
                    $vypnuty = "";
                    if ($res2['zapnut'] == 0) {
                        $vypnuty = " color: #e50000;";
                    }
                    echo '<td style=" width: 150px; text-align: center;'.$vypnuty.'">
                            <img src="'.URL.'frogSys/images/modules/'.$res2['type'].'.png" alt="'.$res2['text'].'" style="width: 80px; height: 80px;" />
                            <div style="margin-bottom: 30px; text-align: center;">'.$res2['text'].'</div>';
                    echo "<ul style=\"padding-left: 2px; text-align: left;\">";
                    $sql = "SELECT * FROM `modules` WHERE $nosuper`parent` = ".$res2['id'];
                    $q3 = mysql_query($sql);
                    while ($res3 = mysql_fetch_array($q3)) {
                        $vypnuty = "";
                        if ($res3['zapnut'] == 0) {
                            $vypnuty = "style=\"color: #e50000;\" ";
                        }
                        echo '<li style="padding-left: 2px; font-size: 11px; list-style-type: none;">
                                <img src="'.URL.'frogSys/images/modules/'.$res3['type'].'_25x25.png" alt="'.$res3['text'].'" style="width: 25px; height: 25px;" />
                                <a href="javascript: nastavType(\''.$res3['type'].'\', '.$res['id'].');" '.$vypnuty.'onmouseover="showInfo(event, \'<img src=&quot;/frogSys/images/modules/'.$res3['type'].'.png&quot; alt=&quot;'.$res3['text'].'&quot; class=&quot;page_typy&quot; id=&quot;'.$res3['type'].'&quot;>\', this)">'.$res3['text'].'</a>
                                </li>';
                    }
                    echo "</ul>";
                    echo '</td>';
                    if ($i%7 == 0) {
                        echo "</tr><tr>";
                    }
                }
                echo "</tr></table></td>";
                ?>
        
    </tr>
    <tr>
        <td>

                <?php
                } else {
                    echo "Problémy s databází.";
                }
                ?>
        </td>
    </tr>

</table>
<?php
}
if ($_POST['action'] == "change_type") {
    $sql = "UPDATE `page_parts` SET `type` = '".$_POST['type']."' WHERE `id` = ".$_POST['id']."";
    if ($q = mysql_query($sql)) {
        echo "Typ stránky byl změněn.";
    }
}









if ($_POST['action'] == "href_table") {
    ?>
<div class="href_table" id="hrefs_<?php echo $_POST['id']; ?>">
    <table class="edit_table">
            <?php
            $sql = "SELECT * FROM `menu_in` WHERE `id` = ".$_POST['id']."";
            $q = mysql_query($sql);
            $res = mysql_fetch_array($q);
            $aktual = $res['href'];
            $sql = "SELECT * FROM `page_parts`";
            $q = mysql_query($sql);
            while ($res = mysql_fetch_array($q)) {
                $sql2 = "SELECT COUNT(*) AS c FROM `page` WHERE `first` = ".$res['id']."";
                $q2 = mysql_query($sql2);
                if ($res2 = mysql_fetch_array($q2)) {
                    $sql3 = "SELECT COUNT(*) AS c FROM `menu_in` WHERE `href` = ".$res['id']."";
                    $q3 = mysql_query($sql3);
                    if ($res3 = mysql_fetch_array($q3)) {
                        if (($res2['c'] + $res3['c']) == 0) {
                            $color = "red";
                        } else {
                            $color = "blue";
                        }
                    }
                }
                ?>
        <tr>
            <td>
                        <?php
                        if ($res['id'] == $aktual) {
                            $size = "15";
                        } else {
                            $size = "10";
                        }
                        ?>
                <div class="href_ikon">
                    <a href="javascript: deleteHref(<?php echo $res['id']; ?>);">
                        <img src="<?php echo URL; ?>frogSys/images/icons/delete.png" alt="delete" class="delete" />
                    </a>
                    <a href="javascript: zobrazHref(<?php echo $res['id']; ?>);;">
                        <img src="<?php echo URL; ?>frogSys/images/icons/oko.png" alt="zobraz" class="zobraz" />
                    </a>
                    <a href="javascript: nastavHref<?php echo $_POST['co']; ?>(<?php echo $res['id']; ?>);">
                        <img src="<?php echo URL; ?>frogSys/images/icons/set.png" alt="nastav" class="nastav" />
                    </a>
                </div>
            </td>
            <td>
                <span style="color: <?php echo $color; ?>; font-size: <?php echo $size; ?>px;">
                            <?php
                            $pole = file(URL."frogSys/bin/ajax/subPage.php?page_part=".$res['id']);
                            echo substr(strip_html_tags(implode(" ", $pole)), 0, 100);
                            ?>
                </span>
            </td>
        </tr>
            <?php
            }
            ?>
    </table>
</div>
<?php
}
if ($_POST['action'] == "delete_href") {
    $sql2 = "SELECT * FROM `page_parts` WHERE `id` = ".$_POST['id']."";
    $q2 = mysql_query($sql2);
    if ($res2 = mysql_fetch_array($q2)) {
        $sql = "DELETE FROM `page_parts` WHERE `id` = ".$_POST['id']."";
        if ($q = mysql_query($sql)) {
            deletePageIfEmpty($res2['type'], $_POST['id']);
            echo "Stránka byla smazána.";
        }
    }
}

if ($_POST['action'] == "set_first_href") {
    $sql = "UPDATE `page` SET `first` = ".$_POST['first']." WHERE `id` = ".$_POST['id']."";
    mysql_query($sql);
    echo "Výchozí stránka sloupce byla změněna.";
}
?>
