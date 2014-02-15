<?php
  define('ROOT', '/var/www/vhosts/avantcore.cz/subdomains/devel/httpdocs/activecollab'); 
  define('PUBLIC_FOLDER_NAME', 'public'); 
  define('DB_HOST', 'localhost'); 
  define('DB_USER', 'activecollab'); 
  define('DB_PASS', '');
  define('DB_NAME', 'activecollab'); 
  define('DB_CAN_TRANSACT', true); 
  define('TABLE_PREFIX', 'acx_'); 
  define('ROOT_URL', 'http://devel.avantcore.cz/public'); 
  define('PATH_INFO_THROUGH_QUERY_STRING', true); 
  define('FORCE_QUERY_STRING', true); 
  define('LOCALIZATION_ENABLED', false); 
  define('ADMIN_EMAIL', 'zabka.michael@seznam.cz'); 
  define('DEBUG', 1); 
  define('API_STATUS', 1); 
  define('PROTECT_SCHEDULED_TASKS', true); 
  define('DB_CHARSET', 'utf8'); 

  require_once 'defaults.php';
?>