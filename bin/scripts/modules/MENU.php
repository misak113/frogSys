<?php
	function writeMenu_in($page_part, $pageId) {
            $menu_link = getMenuLink($page_part);
		?>
		<div class="menu_in">
		<?php
		$sql2 = "SELECT * FROM `menu_in` WHERE `parent` = ".$page_part." ORDER BY `order`";
		$q2 = mysql_query($sql2);
		$hr = false;
		while ($res2 = mysql_fetch_array($q2)) {
			if ($hr == true) {
			?>
			<div class="hr">&nbsp;</div>
			<?php
			}
			$hr = true
			?>
			<div class="menu_in_item" id="menu_in_item_<?php echo $res2['id']; ?>">
			<?php
				    $aktual = "";
                                    if ($menu_link."/".$res2['link'] == @$_GET['page']) {
                                        $aktual = " class=\"aktual\"";
                                    }
                                
			if (!is_logged_in()) {
				?>
                            <a href="<?php echo URL; ?><?php echo $menu_link; ?>/<?php echo $res2['link']; ?>/" <?php echo $aktual; ?>>
				<?php
				
			} else {
			?>
				<a href="javascript: loadSubPage('<?php echo $res2['href']; ?>', <?php echo $res2['target']; ?>, '<?php echo $menu_link; ?>/<?php echo $res2['link']; ?>');">
			<?php
			}
			?>
					&gt; <?php echo $res2['name']; ?>
				</a>
				<?php
				if (is_logged_in()) {
					writeEditPane("Menu_in", $res2['id'].", ".$page_part, "EDM");
				}
				?>
			</div>
		<?php
		}
		if (is_logged_in()) {
		?>
			<a href="javascript: addMenu_in(<?php echo $page_part; ?>);"><img src="<?php echo URL; ?>frogSys/images/icons/add.png" alt="add" class="add_menu_in"></a>
		<?php
		}
		?>
		</div>
		<?php

                writeHtmlEditArea($page_part, "");

		/*if ($hr == false && is_logged_in()) {
			writeZmenaTypu($page_part);
		} */
	}
	
	
	function getMenuLink($page_part) {
            $menulink = "";
			$sql2 = "SELECT `parent`, `link` FROM `menu_in` WHERE `href` = ".$page_part."";
			$q2 = mysql_query($sql2);
			if ($res2 = mysql_fetch_array($q2)) {
				$menuinlink = $res2['link'];
				$sql3 = "SELECT `parent` FROM `page` WHERE `first` = ".$res2['parent']."";
				$q3 = mysql_query($sql3);
				if ($res3 = mysql_fetch_array($q3)) {
					$sql4 = "SELECT `link`, `parent` FROM `menu` WHERE `id` = ".$res3['parent']."";
					$q4 = mysql_query($sql4);
					if ($res4 = mysql_fetch_array($q4)) {
						$menulink = $res4['link']."/";
					}
				}
                                $menulink .= $menuinlink;
			} else {
				$sql3 = "SELECT `parent` FROM `page` WHERE `first` = ".$page_part."";
				$q3 = mysql_query($sql3);
				if ($res3 = mysql_fetch_array($q3)) {
					$sql4 = "SELECT `link`, `parent` FROM `menu` WHERE `id` = ".$res3['parent']."";
					$q4 = mysql_query($sql4);
					if ($res4 = mysql_fetch_array($q4)) {
						$menulink = $res4['link'];
					}
				}
			}
                        if (@$res4['parent'] != 0) {
                            $sql = "SELECT * FROM `menu` WHERE `id` = ".$res4['parent'];
                            $q = mysql_query($sql);
                            if ($res = mysql_fetch_array($q)) {
                                $menulink = $res['link']."/".$menulink;
                            }
                        }
                        return $menulink;
	}
?>
