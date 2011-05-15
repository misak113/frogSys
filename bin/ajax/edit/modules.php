<?php
	function deletePageIfEmpty($type, $id) {
		// Zde je potřeba doplňovat pluginy
					if ($type == "HTML") {
						$sql = "SELECT COUNT(*) AS pocet FROM `html` WHERE `parent` = ".$id."";
						$q3 = mysql_query($sql);
						$res3 = mysql_fetch_array($q3);
						if ($res3['pocet'] < 1) {
							$sql = "DELETE FROM `page_parts` WHERE `id` = ".$id."";
							mysql_query($sql);
						}
					} else
					if ($type == "MENU") {
						$sql = "SELECT COUNT(*) AS pocet FROM `menu_in` WHERE `parent` = ".$id."";
						$q3 = mysql_query($sql);
						$res3 = mysql_fetch_array($q3);
						if ($res3['pocet'] < 1) {
							$sql = "DELETE FROM `page_parts` WHERE `id` = ".$id."";
							mysql_query($sql);
						}
					} else {
						$sql = "DELETE FROM `page_parts` WHERE `id` = ".$id."";
						mysql_query($sql);
					}
	}
?>
