<?php
	function writeSitemap($page_part) {
		echo "<h1>Mapa webu</h1>\n";
		$sql = "SELECT DISTINCT `parent` FROM `menu` ORDER BY `parent` DESC";
		$q = mysql_query($sql);
		echo "<ul class=\"sitemap\">\n";
		while ($res = mysql_fetch_array($q)) {
			if ($res['parent'] == 0) {
				continue;
			} else
			if ($res['parent'] > 0) {
				$sql = "SELECT * FROM `menu` WHERE `id` = ".$res['parent']."";
				$q2 = mysql_query($sql);
				if ($res2 = mysql_fetch_array($q2)) {
					echo "<li>".$res2['name']."\n";
				}
			} else 
			if ($res['parent']%100 == 0) {
				echo "<li>Chyby ".substr($res['parent'], 1)."\n";
			} else {
				echo "<li>část ".substr($res['parent'], 1)."\n";
			}
			echo "	<ul>\n";
			$sql = "SELECT * FROM `menu` WHERE `parent` = ".$res['parent']." ORDER BY `order`";
			$q2 = mysql_query($sql);
			while ($res2 = mysql_fetch_array($q2)) {
				echo "<li><a href=\"/".$res2['link']."/\">".$res2['name']."</a>\n";
				if (@$_SESSION['auth'] > 0) {
					echo "<div style=\"position: relative; width: 200px;\">";
					writeEditPane("Menu", $res2['id'], "ED");
					echo "</div>";
				}
				$sql = "SELECT `first` FROM `page` WHERE `parent` = ".$res2['id']." ORDER BY `order`";
				$q3 = mysql_query($sql);
				while ($res3 = mysql_fetch_array($q3)) {
					$sql = "SELECT `type` FROM `page_parts` WHERE `id` = ".$res3['first']."";
					$q4 = mysql_query($sql);
					if ($res4 = mysql_fetch_array($q4)) {
						if ($res4['type'] == "MENU") {
							echo "<ul>\n";
							$sql = "SELECT * FROM `menu_in` WHERE `parent` = ".$res3['first']." ORDER BY `order`";
							$q5 = mysql_query($sql);
							while ($res5 = mysql_fetch_array($q5)) {
								echo "<li><a href=\"/".$res2['link']."/".$res5['link']."/\">".$res5['name']."</a></li>\n";
								if (@$_SESSION['auth'] > 0) {
									echo "<div style=\"position: relative; width: 220px;\">";
									writeEditPane("Menu_in", $res5['id'], "ED");
									echo "</div>";
								}
							}
							echo "</ul>\n";
						}
					}
				}
				echo "</li>\n";
			}
			echo "	</ul>\n</li>\n";
		}
		echo "</ul>\n";
		/*if (@$_SESSION['auth'] > 0) {
			writeZmenaTypu($page_part);
		} */
	}
?>
