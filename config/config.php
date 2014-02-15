<?php
  define('ROOT', 'C:\Users\misak113\dev\avantcore\devel.avantcore.cz');
  define('PUBLIC_FOLDER_NAME', 'public'); 
  define('DB_HOST', 'localhost'); 
  define('DB_USER', 'root');
  define('DB_PASS', 'misak');
  define('DB_NAME', 'activecollab'); 
  define('DB_CAN_TRANSACT', true); 
  define('TABLE_PREFIX', 'acx_'); 
  define('ROOT_URL', 'http://localhost/avantcore/deve.avantcore.cz');
  define('URL_BASE', ROOT_URL . '/');
  define('ASSETS_URL', ROOT_URL . '/public/assets');
  //define('PATH_INFO_THROUGH_QUERY_STRING', true); 
  define('FORCE_QUERY_STRING', true); 
  define('LOCALIZATION_ENABLED', false); 
  define('ADMIN_EMAIL', 'zabka.michael@seznam.cz'); 
  define('DEBUG', 1); 
  define('API_STATUS', 1); 
  define('PROTECT_SCHEDULED_TASKS', true); 
  define('DB_CHARSET', 'utf8'); 

  require_once 'defaults.php';
?>