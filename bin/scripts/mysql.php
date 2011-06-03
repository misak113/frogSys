<?php

<<<<<<< HEAD
        $chyba = "Nastala chyba při komunikaci s databází.";
	mysql_connect(DB_SERV, DB_USER, DB_PASS) or die($chyba);
	mysql_select_db(DB_NAME) or die($chyba);
	mysql_query('SET CHARACTER SET utf8');

=======
>>>>>>> a206266de26ca4d13d6c2fc157715fc98aa0e227
$dotazy =  explode(";", file_get_contents(PATH."/frogSys/sql/mySQL.sql"));

foreach($dotazy as $dotaz) {
    mysql_query($dotaz);
}

$sql = "SELECT * FROM `seting`";
$q = mysql_query($sql);
while ($res = mysql_fetch_array($q)) {
    $_SETING[$res['name']] = $res['value'];
}

$modules = file(PATH."/frogSys/modules.txt");
foreach($modules as $module) {
    if ($module[0] == ".") {
        $parent = 0;
    }
    if ($module[1] == ".") {
        $parent = $parent_id;
    } else {
        $parent_type = '';
    }
    $zapnut = 0;
    $radek = str_replace(".", "", $module);
    $radek = explode("/", $radek);
    if ($parent_type == 'ZAKL' || $radek[1] == 'ZAKL') {
        $zapnut = 1;
    }
    $sql = "INSERT INTO `modules` VALUES(NULL, '".$radek[1]."', '".$radek[0]."', ".$parent.", $zapnut)";
    mysql_query($sql);
    $sql = "SELECT * FROM `modules` WHERE `type` = '".$radek[1]."'";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $id = $res['id'];
    }
    if ($parent == 0) {
        $parent_id = $id;
        $parent_type = $radek[1];
    }

}
?>
