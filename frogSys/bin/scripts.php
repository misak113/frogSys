<?php
        ob_start();
	session_start();

        include PATH."/frogSys/bin/scripts/functions.php";

	include PATH."/frogSys/bin/scripts/mysql.php";
        
        include PATH."/frogSys/bin/users_loging.php";

        include PATH."/frogSys/bin/scripts/menu.php";
	
	include PATH."/frogSys/bin/scripts/modules.php";

    include PATH."/frogSys/bin/scripts/edit_panes.php";
	
    include PATH."/frogSys/bin/scripts/page.php";

    include PATH."/frogSys/bin/scripts/top_title.php";
	
    include PATH."/frogSys/bin/scripts/patka.php";
		
    
    include PATH."/frogSys/bin/scripts/static_sloupec.php";

