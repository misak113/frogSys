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
	
	define("URL", "http://localhost/avantcore/stredoceskynohejbal/");
	define("PATH", "C:\\Users\\Misak113\\programing\\internet\\apache2.2\\avantcore\\stredoceskynohejbal\\");

	define("DB_SERV", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "misak");
	define("DB_NAME", "stredoceskynohejbalcz");

	define("ADMIN_MAIL", "zabka@avantcore.cz");

        define("PAGE_NAME", "Středočeský nohejbal");
        define("SIRKA_PAGE", 705);
        define("GA_ID", "UA-20953873-10");
        
	define("CISLO_UCTU", "000 000 000 / 0300");
        define("DPH", "19");

        define("SMTP_USERNAME", 'info@janarandakova.cz');
        define("SMTP_SERVER", 'enterprise.vshosting.cz');
        define("SMTP_PASSWORD", 'randakova');
        define("SMTP_PORT", 25);

        define("COUNT_NOVI_ON_PAGE", 10);
	
        ini_set('date.timezone', 'Europe/Prague');

	
?>
