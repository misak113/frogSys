<?php
	function writeMenu_in($page_part, $pageId) {
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
			if (!isset($_SESSION['auth']) || @$_SESSION['auth'] == 0) {
				$sql = "SELECT * FROM `menu` WHERE `id` = ".$pageId." LIMIT 1";
				$q = mysql_query($sql);
				if ($res = mysql_fetch_array($q)) {
				?>
					<a href="/<?php echo $res['link']; ?>/<?php echo $res2['link']; ?>/">
				<?php
				}
			} else {
			?>
				<a href="javascript: loadSubPage('<?php echo $res2['href']; ?>', <?php echo $res2['target']; ?>);">
			<?php
			}
			?>
					&gt; <?php echo $res2['name']; ?>
				</a>
				<?php
				if (@$_SESSION['auth'] > 0) {
					writeEditPane("Menu_in", $res2['id'].", ".$page_part, "EDM");
				}
				?>
			</div>
		<?php
		}
		if (@$_SESSION['auth'] > 0) {
		?>
			<a href="javascript: addMenu_in(<?php echo $page_part; ?>);"><img src="/images/icons/add.png" alt="add" class="add_menu_in"></a>
		<?php
		}
		?>
		</div>
		<?php
		/*if ($hr == false && @$_SESSION['auth'] > 0) {
			writeZmenaTypu($page_part);
		} */
	}
	
	
	function getMenuLink($page_part) {
			$sql2 = "SELECT `parent`, `link` FROM `menu_in` WHERE `href` = ".$page_part."";
			$q2 = mysql_query($sql2);
			if ($res2 = mysql_fetch_array($q2)) {
				$menuinlink = $res2['link'];
				$sql3 = "SELECT `parent` FROM `page` WHERE `first` = ".$res2['parent']."";
				$q3 = mysql_query($sql3);
				if ($res3 = mysql_fetch_array($q3)) {
					$sql4 = "SELECT `link` FROM `menu` WHERE `id` = ".$res3['parent']."";
					$q4 = mysql_query($sql4);
					if ($res4 = mysql_fetch_array($q4)) {
						$menulink = $res4['link']."/".$menuinlink;
					}
				}
			} else {
				$sql3 = "SELECT `parent` FROM `page` WHERE `first` = ".$page_part."";
				$q3 = mysql_query($sql3);
				if ($res3 = mysql_fetch_array($q3)) {
					$sql4 = "SELECT `link` FROM `menu` WHERE `id` = ".$res3['parent']."";
					$q4 = mysql_query($sql4);
					if ($res4 = mysql_fetch_array($q4)) {
						$menulink = $res4['link'];
					}
				}
			}
			return $menulink;
	}
?>
