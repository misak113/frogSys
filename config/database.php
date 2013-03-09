<?php
	/** Pro správné nastavení je třeba
	 *
         *  Nahrát tento soubor a přejmenovat do /config/database.php
         *
	 *	upravit soubor ".htaccess" v kořenovém adresáři
	 *	nastavit práva pro adresář "userfiles" a jeho podadresáře na "777"	 	 	
	 *      Nastavit na serveru SAFE MODE na off
	 *
	 */	 	 	
	
	define("URL", "http://localhost.zabka.avantcore.cz/");
	define("PATH", 'C:\\Users\\Michael\\Work\\Programing\\internet\\avantcore\\zabka.avantcore.cz\\');

	define("DB_SERV", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "misak");
	define("DB_NAME", "avantcore_zabka");

	define("ADMIN_MAIL", "zabka@avantcore.cz");

        define("PAGE_NAME", "Michael Žabka - Programátor a vývojař");
        define("SIRKA_PAGE", 1000);
        define("GA_ID", "UA-20953873-5");
        
	define("CISLO_UCTU", "219 070 687 / 0300");
        define("DPH", "19");

        define("SMTP_USERNAME", 'info@janarandakova.cz');
        define("SMTP_SERVER", 'enterprise.vshosting.cz');
        define("SMTP_PASSWORD", 'randakova');
        define("SMTP_PORT", 25);

        define("COUNT_NOVI_ON_PAGE", 10);
	
        ini_set('date.timezone', 'Europe/Prague');
