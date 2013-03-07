<?php
header("Content-Type: text/html; charset=utf-8");
header("Pragma: no-cache");
header("Cache-Control: no-cache,must-revalidate,max_age=0");
header("Expires: 0");
if (@$_GET['page'] == "404") {
    header("HTTP/1.0 404 Not Found");
}


require_once "./config/database.php";
include PATH."/frogSys/bin/scripts.php";
include PATH."/frogSys/bin/load_pages_id.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include PATH."/frogSys/bin/head.php"; ?>
        <?php include PATH."/frogSys/bin/gAnalytics.php"; ?>
    </head>
    <body id="head_body">
        <?php include PATH."/frogSys/bin/admin_menu.php"; ?>
        <?php include PATH."/frogSys/bin/body.php"; ?>
    </body>
</html>
<?php mysql_close(); ?>