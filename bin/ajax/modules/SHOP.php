<?php
	require_once "../../../../config/database.php";
	include "../../../bin/scripts.php";
	
	/*if (isset($_POST['page_part'])) {
		$page_part = $_POST['page_part'];
	} else {
		$page_part = $_GET['page_part'];
	}      */
	
	if ($_POST['action'] == "produkty") {
		writeShopProdukty($_POST['page_part'], $_POST['shop_id']);
	}
	if ($_POST['action'] == "show_menu") {
		writeShopMenu($_POST['page_part']);
	}
	if ($_POST['action'] == "produkt") {
		writeShopProdukt($_POST['id']);
	}

?>
<?php mysql_close(); ?>