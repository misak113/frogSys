<?php
		                                                       
	require_once "../../../config/database.php";
	include "../../bin/scripts.php";
	
	include PATH."/frogSys/bin/ajax/edit/modules.php";
	
	if (@$_SESSION['auth'] == 1 || @$_SESSION['auth'] == 2) {
		if ($_POST['predmet'] == "menu") {
			include PATH."/frogSys/bin/ajax/edit/menu.php";
		}
		if ($_POST['predmet'] == "page") {
			include PATH."/frogSys/bin/ajax/edit/page.php";
		}
		if ($_POST['predmet'] == "top_title") {
			if ($_POST['action'] == "save") {
				$sql = "UPDATE `html` SET `content` = '".$_POST['text']."' WHERE `parent` = -1";
				$q = mysql_query($sql);
				echo "Hlavní nadpis byl editován.";
			}
		}
		if ($_POST['predmet'] == "patka") {
			if ($_POST['action'] == "save") {
				$sql = "UPDATE `html` SET `content` = '".$_POST['text']."' WHERE `parent` = -2";
				$q = mysql_query($sql);
				echo "Obsah v patce byl editován.";
			}
		}
		if ($_POST['predmet'] == "tinymce") {
			if ($_POST['action'] == "addSlideshow") {
				echo '
				<form name="form_add_slideshow" action="javascript: slideshow_to_tiny2();">
				<table>
					<tr><td>Prodleva (ms): </td><td><input type="text" name="delay" value="3000" /></td></tr>
					<tr><td>Obrázek 1: </td><td><input type="text" name="obr" id="slideshow_obr0" /><input type="button" value="najít" onclick="browseSlideshow(\'slideshow_obr0\');" /></td></tr>
					<tr><td>Obrázek 2: </td><td><input type="text" name="obr" id="slideshow_obr1" /><input type="button" value="najít" onclick="browseSlideshow(\'slideshow_obr1\');" /></td></tr>
				</table>
				<table id="table_slideshow">
				</table>
				<table>
					<tr><td colspan="2"><input type="button" name="next" value="Další obrázek" onclick="nextSlideshowImage();" /></td></tr>
					<tr><td colspan="2"><input type="submit" name="vlozit" value="Vložit" /></td></tr>
				</table>
				</form>
				';
			}
		}
                if ($_POST['predmet'] == "odkazy") {
                    include PATH."/frogSys/bin/ajax/edit/odkazy.php";
                }
                if ($_POST['predmet'] == "spravce_souboru") {
                    include PATH."/frogSys/bin/ajax/edit/spravce_souboru.php";
                }
                if ($_POST['predmet'] == "zakladni") {
                    include PATH."/frogSys/bin/ajax/edit/zakladni.php";
                }
		/*
			MODULY
		*/
		
		if ($_POST['predmet'] == "html") {
			include PATH."/frogSys/bin/ajax/edit/modules/HTML.php";
		}
		if ($_POST['predmet'] == "menu_in") {
			include PATH."/frogSys/bin/ajax/edit/modules/MENU.php";
		}
		if ($_POST['predmet'] == "plan_akci") {
			include PATH."/frogSys/bin/ajax/edit/modules/PLAK.php";
		}
		if ($_POST['predmet'] == "shop") {
			include PATH."/frogSys/bin/ajax/edit/modules/SHOP.php";
		}
		if ($_POST['predmet'] == "galerie") {
			include PATH."/frogSys/bin/ajax/edit/modules/GALE.php";
		}
		if ($_POST['predmet'] == "novinky") {
			include PATH."/frogSys/bin/ajax/edit/modules/NOVI.php";
		}
                if ($_POST['predmet'] == "diskuse") {
			include PATH."/frogSys/bin/ajax/edit/modules/DISK.php";
		}
                if ($_POST['predmet'] == "vysledky") {
			include PATH."/frogSys/bin/ajax/edit/modules/VYSL.php";
		}
                if ($_POST['predmet'] == "tabulka") {
			include PATH."/frogSys/bin/ajax/edit/modules/VTAB.php";
		}
                if ($_POST['predmet'] == "statistiky") {
			include PATH."/frogSys/bin/ajax/edit/modules/VSTA.php";
		}

	} else {
		echo "Nemáte právo pro administraci!";
	}

?>
<?php mysql_close(); ?>