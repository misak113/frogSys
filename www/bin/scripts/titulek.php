<?php
	function writeTitulek() {
		include PATH."/bin/load_pages_id.php";
		echo "<span id=\"titulek_text\">".$titulek."</span>";
		//writeEditPane("Titulek", "", "E");
	}
?>
