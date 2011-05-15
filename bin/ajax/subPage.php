<?php
	require_once "../../../config/database.php";
	include "../../bin/scripts.php";
	
	if (isset($_POST['page_part'])) {
		$page = $_POST['page_part'];
	} else {
		$page = $_GET['page_part'];
	}
	
	writePagePart($page, 0);

?>
<?php mysql_close(); ?>