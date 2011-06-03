<?php
	include PATH."/frogSys/bin/scripts/modules/MENU.php";
	include PATH."/frogSys/bin/scripts/modules/SMAP.php";
	include PATH."/frogSys/bin/scripts/modules/PLAK.php";
	include PATH."/frogSys/bin/scripts/modules/HTML.php";
	include PATH."/frogSys/bin/scripts/modules/SHOP.php";
	include PATH."/frogSys/bin/scripts/modules/KOSI.php";
	include PATH."/frogSys/bin/scripts/modules/GALE.php";
	include PATH."/frogSys/bin/scripts/modules/HREF.php";
        include PATH."/frogSys/bin/scripts/modules/NOVI.php";
        include PATH."/frogSys/bin/scripts/modules/DISK.php";
        include PATH."/frogSys/bin/scripts/modules/VYSL.php";
        include PATH."/frogSys/bin/scripts/modules/VTAB.php";
        include PATH."/frogSys/bin/scripts/modules/VSTA.php";
<<<<<<< HEAD
        include PATH."/frogSys/bin/scripts/modules/VTYM.php";
        include PATH."/frogSys/bin/scripts/modules/NSOU.php";
=======
>>>>>>> a206266de26ca4d13d6c2fc157715fc98aa0e227

	
	
	function writePagePart($page_part, $pageId) {
            if (@$_SESSION['auth'] > 0) {
                echo "<div class=\"page_part_id\" id=\"page_part_".$page_part."\" style=\"display: none;\">".$page_part."</div>";
            }
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
				case "NOVI":
					writeNovi($page_part);
					break;
				case "DISK":
					writeDisk($page_part);
					break;
                                case "VYSL":
					writeVysledky($page_part);
					break;
                                case "VTAB":
					writeTabulka($page_part);
					break;
                                case "VSTA":
					writeStatistiky($page_part);
					break;
<<<<<<< HEAD
                                case "VTYM":
					writeVyhledavaniTymu($page_part);
					break;
                                case "NSOU":
					writeNovinkySouhrne($page_part);
					break;
=======
>>>>>>> a206266de26ca4d13d6c2fc157715fc98aa0e227
				default:
					if (@$_SESSION['auth'] > 0) {
						//writeZmenaTypu($page_part);
                                                echo "<p>Nastavte typ stránky!</p>";
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
