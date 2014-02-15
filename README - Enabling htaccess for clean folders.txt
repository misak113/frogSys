WHEN ENABLING MOD_REWRITE:

STEP 1.
Create an .htaccess add the following contents and upload.


Options -Indexes
<IfModule mod_rewrite.c>
  RewriteEngine On

  RewriteCond %{REQUEST_FILENAME} -f [OR]
  RewriteCond %{REQUEST_FILENAME} -d
  RewriteRule ^(.+) - [PT,L]

  RewriteRule ^projects_icons/(.*)$ public/projects_icons/$1 [L]
  RewriteRule ^avatars/(.*)$ public/avatars/$1 [L]
  RewriteRule ^logos/(.*)$ public/logos/$1 [L]
  RewriteRule ^thumb.php$ public/thumb.php [L]
  RewriteRule ^captcha.php$ public/captcha.php [L]
  RewriteRule ^$ public/index.php [L]
  RewriteRule ^(.*) public/index.php?path_info=$1 [L]
</IfModule>



STEP 2.
Edit /config/config.php and add the following contents.

FIND:
define('ROOT_URL', 'http://projects.example.com/public');

CHANGE TO:
define('ROOT_URL', 'http://projects.example.com');



STEP 3.
After step 2, add the following code after 'define('ROOT_URL'............'

define('URL_BASE', ROOT_URL . '/');
define('ASSETS_URL', ROOT_URL . '/public/assets');



STEP 4.
Find the following:
define('PATH_INFO_THROUGH_QUERY_STRING', true);

Remove it by adding // infront:
// define('PATH_INFO_THROUGH_QUERY_STRING', true);



http://www.activecollab.com/docs/manuals/admin/tweak/removing-public-index-from-urls





