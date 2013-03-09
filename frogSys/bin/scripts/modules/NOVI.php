<?php



function writeNovi($page_part) {
    global $_SETING;
				include PATH."/frogSys/bin/load_pages_id.php";
				if (@$novinka_id > 0) {
					writeNovinka($novinka_id);
				} else {
					writeNovinky($page_part);
				}

   
}


function writeNovinky($page_part) {
    global $tyden, $rok;
    $count_on_page = COUNT_NOVI_ON_PAGE;
    $menulink = getMenuLink($page_part);

    writeHtmlEditArea($page_part, "<h2>Novinky</h2>");

    if (is_logged_in()) {
        echo '<a href="javascript: ;" onclick="addNovinka(' . $page_part . ', this);"><img src="' . URL . 'frogSys/images/icons/add.png" alt="add" class="add_novinka" /></a>';
    }
    $unlogged = "AND `visible` = 1";
    $unlogged2 = "LIMIT " . ($count_on_page * @$_GET['str']) . ", $count_on_page";
    if (is_logged_in()) {
        $unlogged = "";
        $unlogged2 = "";
    }
    echo '<div class="novinky">';
    $sql = "SELECT * FROM `novinky` WHERE `parent` = $page_part $unlogged ORDER BY `datetime` DESC $unlogged2";
    $q = mysql_query($sql);
    while ($res = @mysql_fetch_array($q)) {
        $sql = "SELECT `user` FROM `admin` WHERE `id` = ".$res['writer']."";
        $q2 = mysql_query($sql);
        if ($res2 = mysql_fetch_array($q2)) {
            $user = $res2['user'];
        } else {
            $user = "neznámý";
        }
        $datetime = explode(" ", $res['datetime']);
        $datum = explode("-", $datetime[0]);
        $time = explode(":", $datetime[1]);
        $tim = mktime(0, 0, 0, $datum[1], $datum[2], $datum[0]);
        $date = $tyden[date("w", $tim)].", ".$datum[2].". ".$rok[$datum[1]-1]." ".$datum[0].", ".$time[0].":".$time[1].", ".$user;
        $text = substr(strip_html_tags($res['text']), 0, 600);
        if ($text != strip_html_tags($res['text'])) {
            $text = substr($text, 0, strrpos($text, " "))." ";
            if (is_logged_in()) {
                $text .= '<a href="javascript: loadNovinka('.$page_part.', '.$res['id'].', \''.$menulink.'/'.$res['link'].'\');">';
            } else {
                $text .= '<a href="'.URL.$menulink.'/'.$res['link'].'/" title="'.$res['nazev'].'">';
            }
            $text .= "Zobrazit více...</a>";
        } else {
            $text = strip_no_a_html_tags($res['text']);
        }
        $style = "";
        if ($res['visible'] == 0) {
            $style = "background-color: #D3D3D3;";
        }
        echo '
            <div class="novinka" id="novinka_'.$res['id'].'" style="'.$style.'">
                <h3 class="nazev">';
        if (is_logged_in()) {
            echo '<a href="javascript: loadNovinka('.$page_part.', '.$res['id'].', \''.$menulink.'/'.$res['link'].'\');">';
        } else {
            echo '<a href="'.URL.$menulink.'/'.$res['link'].'/" title="'.$res['nazev'].'">';
        }
        $img = get_first_img_tag($res['text']);
        echo '
                    '.$res['nazev'].'
                    </a>
                </h3>
                <div class="datum">'.$date.'</div>
                <div class="text">'.$img.$text.'</div>';
        if (is_logged_in()) {
            writeEditPane("Novinka", $res['parent'].", ".$res['id'].", this", ($res['visible'] == 1?"Č":"C")."D");
        }
        echo '
            </div>';
    }
    echo '</div>';

    if (!(is_logged_in())) {
        $str = isset($_GET['str'])?$_GET['str']:0;

        echo '<div class="strankovani">';
        if ($str > 0) {
            echo '<a href="'.URL.$menulink.'/?str='.($str-1).'">&lt; předchozí</a> ';
        }
        $sql = "SELECT COUNT(*) AS pocet FROM `novinky` WHERE `parent` = $page_part $unlogged";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $pages = floor($res['pocet']/$count_on_page);
            if ($pages > 0) {
            for ($i=0;$i<=$pages;$i++) {
                if ($i == $str) {
                    echo '<span class="aktual">'.($i+1).'</span>';
                } else {
                    echo "<a href=\"".URL."$menulink/?str=$i\">".($i+1)."</a>  ";
                }
            }
            }
        }
        if ($str < $pages) {

            echo '<a href="'.URL.$menulink.'/?str='.($str+1).'">následující &gt;</a> ';

        }

        echo '</div>';
    }
}




function writeNovinka($novinka_id) {
    global $tyden, $rok;
    $sql = "SELECT * FROM `novinky` WHERE `id` = $novinka_id";
    $q = mysql_query($sql);
    if ($res = @mysql_fetch_array($q)) {
        $menulink = getMenuLink($res['parent']);
        $sql = "SELECT `user` FROM `admin` WHERE `id` = ".$res['writer']."";
        $q2 = mysql_query($sql);
        if ($res2 = mysql_fetch_array($q2)) {
            $user = $res2['user'];
        } else {
            $user = "neznámý";
        }
        $datetime = explode(" ", $res['datetime']);
        $datum = explode("-", $datetime[0]);
        $time = explode(":", $datetime[1]);
        $tim = mktime(0, 0, 0, $datum[1], $datum[2], $datum[0]);
        $date = $tyden[date("w", $tim)].", ".$datum[2].". ".$rok[$datum[1]-1]." ".$datum[0].", ".$time[0].":".$time[1].", ".$user;

        $text = $res['text'];
        echo '
            <div class="novinka">
                <h2 class="nazev">';
        if (is_logged_in()) {
        writeEditPane("NovinkaNazev", $res['id'], "E");
        }
        echo '<span id="novinka_nazev_s_'.$res['id'].'">'.$res['nazev'].'</span></h2>';
        if (is_logged_in()) {
            echo '<div id="novinka_link_s_'.$res['id'].'">'.$res['link'].'</div>';
        }
        echo '<div class="datum">'.$date.'</div>
                <div class="text">';
        if (is_logged_in()) {
        writeEditPane("NovinkaText", $res['id'], "E");
        }
        echo '<div id="novinka_text_'.$res['id'].'">'.$text.'</div></div>
            </div>';
    }
    if (is_logged_in()) {
        echo '<a href="javascript: ;" onclick="history.go(-1);">';
    } else {
        echo '<a href="'.URL.$menulink.'/">';
    }
    echo '&lt; zpět</a>';
}
