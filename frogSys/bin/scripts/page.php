<?php
function writePage($pageId, $pageId2) {
    $sirkaSloupce = SIRKA_PAGE;
    $sql = "SELECT * FROM `page` WHERE `parent` = ".$pageId." ORDER BY `order`";
    $q = mysql_query($sql);
    $vr = false;
    $sirka = 0;
    echo "<div>";
    while ($res = @mysql_fetch_array($q)) {
        if ($sirka >= 100) {
            $vr = false;
            $sirka = 0;
        }
        $sirka += $res['width'];
        $width = $res['width']/100*$sirkaSloupce-4;
        if ($vr == true) {
            if (is_logged_in()) {
                ?>
<div class="vr" onmousedown="startPageResize(event, <?php echo $prevId; ?>, <?php echo $res['id']; ?>, this);" style="cursor: e-resize; display: block;"
     onmouseout="changeOpacity('info_width_<?php echo $res['id']; ?>', 0.01);"
     onmouseover="changeOpacity('info_width_<?php echo $res['id']; ?>', 1);">
    &nbsp;
    <div class="info_width" style="display: none;" id="info_width_<?php echo $res['id']; ?>"><?php echo round($width); ?>px</div>
</div>
            <?php
            } else {
                ?>
<div class="vr">&nbsp;</div>
            <?php
            }
        } else {
            echo "</div><div class=\"content_radek\">";
        }
        $prevId = $res['id'];
        $vr = true;
        
        ?>
<div id="content_about_<?php echo $res['id']; ?>" class="content" onmousedown="aktualClickPart = <?php echo $res['id']; ?>;" style="width: <?php echo $width; ?>px;">
            <?php
            if (!isset($pageId2[$res['id']])) {
                $page_part = $res['first'];
            } else {
                $page_part = $pageId2[$res['id']];
            }
            if (is_logged_in()) {
                ?>
    <div class="edit_pole" id="edit_pole_<?php echo $res['id']; ?>" style="width: 100%;">
        <p>editace sloupce</p>
        <a href="javascript: addPageSloupec(<?php echo $pageId; ?>, <?php echo $res['id']; ?>);">
            <img src="<?php echo URL; ?>frogSys/images/icons/plus.png" alt="vložit sloupec vpravo" onmouseover="showInfo(event, 'Vložit sloupec vpravo', this);" class="addSloupec" />
        </a>
        <a href="javascript: moveSloupecUp(<?php echo $res['id']; ?>);">
            <img src="<?php echo URL; ?>frogSys/images/icons/up.png" alt="přesunout nahoru" onmouseover="showInfo(event, 'Přesunout sloupec nahoru', this);" class="moveSloupecUp" />
        </a>
        <a href="javascript: moveSloupecDown(<?php echo $res['id']; ?>);">
            <img src="<?php echo URL; ?>frogSys/images/icons/down.png" alt="přesunout dolu" onmouseover="showInfo(event, 'Přesunout sloupec dolů', this);" class="moveSloupecDown" />
        </a>
                    <?php
                    writeZmenaTypu($page_part);
                    writeEditPane("PageSloupec", $res['id'], "DEM");
                    ?>
    </div>
            <?php
            }
            ?>
    <div class="content_in" id="content_<?php echo $res['id']; ?>">
                <?php
                writePagePart($page_part, $pageId);
                ?>
    </div>
</div>
    <?php
    }
    echo "</div>";
    if ($vr == false) {
        if (is_logged_in()) {
            echo "<p>Rozvržení stránky není definováno.</p><p>Kliknutím na ikonu vložení sloupce vložíte sloupec.</p>";
        } else {
            echo "<p>Stránka nenalezena</p>";
        }
    }
    if (is_logged_in()) {
        ?>

<hr />
<a href="javascript: addPageSloupec(<?php echo $pageId; ?>, 'under');">
    <img src="<?php echo URL; ?>frogSys/images/icons/addSloupec.png" id="addSloupecPod" onmouseover="showInfo(event, 'Vložit slot dolů', this);" class="addPod" />
</a>
    <?php
    }
}

function writeZmenaTypu($page_part) {
//<p>Pro změnu typu stránky klikni na změnit typ.</p>
    ?>
<a href="javascript: ;" onclick="changeType(this);">
    <img src="<?php echo URL; ?>frogSys/images/icons/changeType.png" alt="změnit typ" onmouseover="showInfo(event, 'změnit typ aktuální stránky', this);" class="change_page" />
</a>
<?php
}


function writeHtmlEditArea($page_part, $defalt_value) {
    $sql = "SELECT * FROM `html` WHERE `parent` = " . $page_part . " ORDER BY `sort`";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        echo "<div class=\"content_in_class\" id=\"content_in_".$res['id']."\">";
        echo $res['content'];
        $id_html = $res['id'];
    } else {
        $q = mysql_query("SHOW TABLE STATUS LIKE 'html'");
        $res = mysql_fetch_array($q);
        $id_html = $res['Auto_increment'];
        echo "<div id=\"content_in_".$id_html."\">";
        $sql = "INSERT INTO `html` VALUES(NULL, '$defalt_value', $page_part, 0, 0)";
        mysql_query($sql);
        echo $defalt_value;
    }
    if (is_logged_in()) {
        writeEditPane("Html", $id_html.", ".$page_part, "E");
    }
    echo '</div>';
}


function writeBreadcrumb($pageId, $pageId2) {
    echo '<span class="desc">'._t('Nacházíte se:').'</span>';
    
    $first_name = _t('Úvod');
    
    $sql = 'SELECT * FROM `menu` WHERE `id` = '.$pageId.'';
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $first_name = $res['name'];
        $first_url = URL.getMenuLink($pageId).'/';
    }
    if (is_array($pageId2)) {
        foreach ($pageId2 as $menu => $pp) {
            $sql = 'SELECT * 
                FROM `menu_in`
                WHERE `target` = '.$menu.' AND `href` = '.$pp.'';
            $q = mysql_query($sql);
            if ($res = mysql_fetch_array($q)) {
                $second_name = $res['name'];
                $second_url = URL.getMenuLink($pp).'/';
                break;
            }
        }
    }
    
    if (isset($second_name)) {
            echo '<a class="item" href="'.$first_url.'">'.$first_name.'</a><span class="item">'.$second_name.'</span>';
        } else {
            echo '<span class="item">'.$first_name.'</span>';
        }
    
    
}
