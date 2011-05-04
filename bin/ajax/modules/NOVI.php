<?php
	require_once "../../../../config/database.php";
	include "../../../bin/scripts.php";

	if ($_POST['action'] == "novinka") {
		writeNovinka($_POST['id']);
	}
        if ($_POST['action'] == "novinky") {
		writePagePart($_POST['page_part'], $_POST['id']);
	}

?>
<?php mysql_close(); ?>