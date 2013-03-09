<?php
	function writeTop_title() {
		$sql = "SELECT * FROM html WHERE `parent` = -1";
		$q = mysql_query($sql);
		if ($res = mysql_fetch_array($q)) {
			$sql = "SELECT * FROM `html_style` WHERE `id` = ".$res['style']."";
			$q3 = mysql_query($sql);
			$res3 = mysql_fetch_array($q3);
			$css = $res3['css'];
			echo "<div id=\"top_title_in\" style=\"".$css."\">";
			if (is_logged_in()) {
				writeEditPane("Top_title", "", "E");
			}
			echo "".$res['content']."";
			echo "</div>";
		} else {
			$sql = "INSERT INTO `html` VALUES(NULL, 'Obsah top titulku', -1, 0, 0)";
			$q = mysql_query($sql);
			echo "Obsah top titulku";
		}
	}
	
