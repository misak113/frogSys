<?php
	include PATH."/bin/scripts/modules/MENU.php";
	include PATH."/bin/scripts/modules/SMAP.php";
	include PATH."/bin/scripts/modules/PLAK.php";
	include PATH."/bin/scripts/modules/HTML.php";
	include PATH."/bin/scripts/modules/SHOP.php";
	include PATH."/bin/scripts/modules/KOSI.php";
	include PATH."/bin/scripts/modules/GALE.php";
	include PATH."/bin/scripts/modules/HREF.php";

	
	
	function writePagePart($page_part, $pageId) {
		$sql1 = "SELECT * FROM `page_parts` WHERE `id` = ".$page_part."";
		$q1 = mysql_query($sql1);
		if ($res1 = mysql_fetch_array($q1)) {
			switch ($res1['type']) {
				case "HTML":
					writeHtml($page_part);
					break;
				case "MENU":
					writeMenu_in($page_part, $pageId);
					break;
				case "SMAP":
					writeSitemap($page_part);
					break;
				case "PLAK":
					writePlanAkci($page_part);
					break;
				case "SHOP":
					writeShop($page_part);
					break;
				case "KOSI":
					writeShop_obsah_kosiku($page_part);
					break;
				case "GALE":
					writeGalerie($page_part);
					break;
				case "HREF":
					writeHref($page_part);
					break;
				default:
					if (@$_SESSION['auth'] > 0) {
						//writeZmenaTypu($page_part);
					} else {
						echo "<p>Stránka nenalezena.</p>";
					}
			}
		} else {
			if (@$_SESSION['auth'] > 0) {
				echo "<p>Výchozí stránku této části definujete v editaci sloupce kliknutím na ikonu editace.</p>";
			} else {
				echo "<p>Stránka nenalezena</p>";
			}
		}
	}
	
	
	
?>
