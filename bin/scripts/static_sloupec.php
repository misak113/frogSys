<?php

function writeStaticSloupec() {
    $sirkaSloupce = SIRKA_PAGE;
    $sql = "SELECT * FROM `page` WHERE `parent` = 0 ORDER BY `order`";
    $q = mysql_query($sql);
    //echo '<div id="static_sloupce">';
    while ($res = @mysql_fetch_array($q)) {
        $width = $res['width']/100*$sirkaSloupce-4;
        $width = $res['width'];
        ?>
<div id="content_about_<?php echo $res['id']; ?>" class="content_static"
     <?php
     if (is_logged_in()) {
     echo 'onmouseover="showStaticEditPole(this, 1);"
     onmouseout="showStaticEditPole(this, 0);"';
     }
     ?>
     onmousedown="aktualClickPart = <?php echo $res['id']; ?>;" style="width: <?php echo $width; ?>px;">
            <?php
            if (!isset($pageId2[$res['id']])) {
                $page_part = $res['first'];
            } else {
                $page_part = $pageId2[$res['id']];
            }
            if (is_logged_in()) {
                ?>
    <div class="edit_pole" id="edit_pole_<?php echo $res['id']; ?>" style="width: 100%; display: none;">
        <p>editace sloupce</p>
                    <?php
                    writeZmenaTypu($page_part);
                    writeEditPane("StaticSloupec", $res['id'], "DEM");
                    ?>
    </div>
            <?php
            }
            ?>
    <div class="content_in" id="content_<?php echo $res['id']; ?>">
                <?php
                writePagePart($page_part, 0);
                ?>
    </div>
</div>
    <?php
    }
    //echo '</div>';
}
?>
