<?php
		                                                       
	include "../../config/database.php";
	include "../../bin/scripts.php";
	
	include PATH."/bin/ajax/edit/modules.php";
	
	if (@$_SESSION['auth'] == 1 || @$_SESSION['auth'] == 2) {
		if ($_POST['predmet'] == "menu") {
			include PATH."/bin/ajax/edit/menu.php";
		}
		if ($_POST['predmet'] == "page") {
			include PATH."/bin/ajax/edit/page.php";
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
		/*
			MODULY
		*/
		
		if ($_POST['predmet'] == "html") {
			include PATH."/bin/ajax/edit/modules/HTML.php";
		}
		if ($_POST['predmet'] == "menu_in") {
			include PATH."/bin/ajax/edit/modules/MENU.php";
		}
		if ($_POST['predmet'] == "plan_akci") {
			include PATH."/bin/ajax/edit/modules/PLAK.php";
		}
		if ($_POST['predmet'] == "shop") {
			include PATH."/bin/ajax/edit/modules/SHOP.php";
		}
		if ($_POST['predmet'] == "galerie") {
			include PATH."/bin/ajax/edit/modules/GALE.php";
		}
		
	} else {
		echo "Nemáte právo pro administraci!";
	}

?>
<?php mysql_close(); ?>