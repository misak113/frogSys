<?php
	function writeHtml($page_part) {
		$class = "";
		$sql2 = "SELECT * FROM `html` WHERE `parent` = ".$page_part." ORDER BY `sort`";
		$q2 = mysql_query($sql2);
		$isEmpty = true;
		while ($res2 = mysql_fetch_array($q2)) {
			$isEmpty = false;
			$sql = "SELECT * FROM `html_style` WHERE `id` = ".$res2['style']."";
			$q3 = mysql_query($sql);
			if ($res3 = mysql_fetch_array($q3)) {
				$css = $res3['css'];
				$class = " html_style_".$res3['name'];
			} else {
				$sql = "SELECT * FROM `html_style`";
				$q4 = mysql_query($sql);
				if (!($res4 = mysql_fetch_array($q4))) {
					$sql = "INSERT INTO `html_style` VALUES(NULL, 'normální', '')";
					mysql_query($sql);
				}
				$css = "";
			}
			echo "<div id=\"content_in_".$res2['id']."\" class=\"content_in_id".$class."\" style=\"".$css."\">";
			if (is_logged_in()) {
				writeEditPane("Html", $res2['id'].", ".$page_part, "EDSM");
			}
			echo "".$res2['content']."";
			echo "</div>";
		} 
		if (is_logged_in()) {
			/*if ($isEmpty) {
				writeZmenaTypu($page_part);
			} */
			?>
				<a href="javascript: addHtml(<?php echo $page_part; ?>);">
					<img src="<?php echo URL; ?>frogSys/images/icons/addHtml.png" alt="vložit" class="add_page" />
				</a>
			<?php
		}
	}
?>
