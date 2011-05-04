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
        if ($vr == true) {
            if (@$_SESSION['auth'] > 0) {
                ?>
<div class="vr" onmousedown="startPageResize(event, <?php echo $prevId; ?>, <?php echo $res['id']; ?>);" style="cursor: e-resize; display: block;">&nbsp;</div>
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
        $width = $res['width']/100*$sirkaSloupce-4;
        ?>
<div id="content_about_<?php echo $res['id']; ?>" class="content" onmousedown="aktualClickPart = <?php echo $res['id']; ?>;" style="width: <?php echo $width; ?>px;">
            <?php
            if (!isset($pageId2[$res['id']])) {
                $page_part = $res['first'];
            } else {
                $page_part = $pageId2[$res['id']];
            }
            if (@$_SESSION['auth'] > 0) {
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
        if (@$_SESSION['auth'] > 0) {
            echo "<p>Rozvržení stránky není definováno.</p><p>Kliknutím na ikonu vložení sloupce vložíte sloupec.</p>";
        } else {
            echo "<p>Stránka nenalezena</p>";
        }
    }
    if (@$_SESSION['auth'] > 0) {
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


?>
