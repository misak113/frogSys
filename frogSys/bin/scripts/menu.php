<?php

//vypisuje menu
function writeMenu($id) {
    $menu_link = getMenuLink($id);
    if ($id == 0) {
        $sql = "SELECT * FROM `menu` WHERE `parent` = '$id' ORDER BY `order`";
        $q = mysql_query($sql);
        $i = 0;
        while ($res = mysql_fetch_array($q)) {
            $i++;
            if ($res['visible'] == 0 && !is_logged_in()) {
                continue;
            }

            $actual = "";
            if (($menu_link?$menu_link . "/":'') . $res['link'] == @$_GET['page'] || $i==1 && @$_GET['page'] == '') {
                $actual = " aktual";
            }

            $hiden = "";
            if ($res['visible'] == 0) {
                $hiden = " style=\"font-style: italic; text-decoration: line-through; color: #D3D3D3;\"";
            }
            ?>
            <div class="menu_left_head" id="menu_left_head_<?php echo $res['id']; ?>"<?php echo $hiden; ?>
                 onmouseover="clearTimeout(menuTimeout['menu_left_<?php echo $res['id']; ?>']); openMenuUser('menu_left_<?php echo $res['id']; ?>', 1);"
                 onmouseout="menuTimeout['menu_left_<?php echo $res['id']; ?>'] = setTimeout('openMenuUser(\'menu_left_<?php echo $res['id']; ?>\', 0)', 200);">
                     <?php
                     if (is_logged_in()) {
                         ?>
                    <a class="head_menu_nazev<?php echo $actual; ?>" href="javascript: loadPage(<?php echo $res['id']; ?>, '<?php echo $res['link']; ?>');"<?php echo $hiden; ?>><?php echo $res['name']; ?></a>
                    <?php
                    writeEditPane("MenuHead", $res['id'], "EDM");
                } else {
                    if ($i == 1) {
                        ?>
                        <a class="head_menu_nazev<?php echo $actual; ?>" href="<?php echo URL; ?>"><?php echo $res['name']; ?></a>
                        <?php
                    } else {
                        ?>
                        <a class="head_menu_nazev<?php echo $actual; ?>" href="<?php echo URL; ?><?php echo $res['link']; ?>/"><?php echo $res['name']; ?></a>
                        <?php
                    }
                }
                ?>

                <div class="menu_left" id="menu_left_<?php echo $res['id']; ?>">
                    <div class="menu_left_in" id="menu_left_in_<?php echo $res['id']; ?>">
            <?php $in = writeMenu($res['id']); ?>
                    </div>
                </div>
                <?php
                if ($in) {
                    echo '<img src="' . URL . 'frogSys/images/icons/down2.png" class="sub_menu_down" alt="Sub menu" />';
                }
                ?>
            </div>
            <?php
        }
        if (is_logged_in()) {
            ?>
            <a href="javascript: addMenu(0);"><img src="<?php echo URL; ?>frogSys/images/icons/addHeadMenu.png" alt="add" class="addHeadMenu" /></a>
            <?php
            //<a href="javascript: openMenu();"><img src="<?php echo URL; ? >frogSys/images/icons/open.png" alt="open" class="open" /></a>
        }
    } else {
        $sql = "SELECT * FROM `menu` WHERE `id` = " . $id;
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $parent_link = $res['link'];
        }
        $sql = "SELECT * FROM `menu` WHERE `parent` = '$id' ORDER BY `order`";
        $q = mysql_query($sql);
        $i = 0;
        while ($res = mysql_fetch_array($q)) {
            $i++;
            if ($res['visible'] == 0 && !is_logged_in()) {
                continue;
            }
            $hiden = "";
            if ($res['visible'] == 0) {
                $hiden = " style=\"font-style: italic; text-decoration: line-through; color: #D3D3D3;\"";
            }
            ?>
            <div class="menu_left_item" id="menu_item_<?php echo $res['id']; ?>">
                <?php
                if (is_logged_in()) {
                    ?>
                    <a href="javascript: loadPage(<?php echo $res['id']; ?>, '<?php echo $parent_link; ?>/<?php echo $res['link']; ?>');"<?php echo $hiden; ?>><?php echo $res['name']; ?></a>
                    <?php
                    writeEditPane("Menu", $res['id'], "EDM");
                } else {
                    ?>
                    <a href="<?php echo URL; ?><?php echo $parent_link; ?>/<?php echo $res['link']; ?>/"><?php echo $res['name']; ?></a>
                    <?php
                }
                ?>
            </div>
            <?php
        }

        if (is_logged_in()) {
            ?>
            <a href="javascript: addMenu(<?php echo $id; ?>);"><img src="<?php echo URL; ?>frogSys/images/icons/add.png" alt="add" class="add" /></a>
            <?php
            //<a href="javascript: openMenu();"><img src="<?php echo URL; ? >frogSys/images/icons/open.png" alt="open" class="open" /></a>
        }
        if ($i > 0) {
            return true;
        } else {
            return false;
        }
    }
}