<?php

	require_once "../../../config/database.php";
	include "../../bin/scripts.php";
	
	writePatka();
	
?>
<?php mysql_close(); ?>