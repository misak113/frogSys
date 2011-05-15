<?php

	require_once "../../../config/database.php";
	include "../../bin/scripts.php";
	
	if (isset($_POST['page'])) {
		$pageId = $_POST['page'];
	}
	
	writePage($pageId, false);
	
?>
<?php mysql_close(); ?>