<?php
	function writePatka() {
		$sql = "SELECT * FROM html WHERE `parent` = -2";
		$q = mysql_query($sql);
		if ($res = mysql_fetch_array($q)) {
			$sql = "SELECT * FROM `html_style` WHERE `id` = ".$res['style']."";
			$q3 = mysql_query($sql);
			$res3 = mysql_fetch_array($q3);
			$css = $res3['css'];
			echo "<div id=\"patka_in\" style=\"".$css."\">";
			if (@$_SESSION['auth'] > 0) {
				writeEditPane("Patka", "", "E");
			}
			echo "".$res['content']."";
			echo "</div>";
		} else {
			$sql = "INSERT INTO `html` VALUES(NULL, 'Obsah patky', -2, 0, 0)";
			$q = mysql_query($sql);
			echo "Obsah patky";
		}
	}
	
	
?>
