<?php
	/** Pro správné nastavení je třeba
	 *
	 *	upravit soubor ".htaccess" v kořenovém adresáři
	 *	nastavit práva pro adresář "userfiles" a jeho podadresáře na "777"	 	 	
	 *
	 *
	 */	 	 	
	
	define("URL", "http://localhost.zabka.avantcore.cz/");
	define("PATH", 'C:\\Users\\Michael\\Work\\Programing\\internet\\avantcore\\zabka.avantcore.cz\\www');
	define("DB_SERV", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "misak");
	define("DB_NAME", "avantcore_zabka");
	define("ADMIN_MAIL", "zabka.michael@seznam.cz");
        define("PAGE_NAME", "Michael Žabka - Programátor a vývojař");
	
	define("SIRKA_PAGE", 1000);

	$chyba = "Nastala chyba při komunikaci s databází.";
	mysql_connect(DB_SERV, DB_USER, DB_PASS) or die($chyba);
	mysql_select_db(DB_NAME) or die($chyba);
	mysql_query('SET CHARACTER SET utf8');
	
	include PATH."/bin/users_loging.php";
?>
