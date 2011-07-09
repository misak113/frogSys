<?php
if ($_POST['action'] == "show") {
    $sql = "UPDATE `galerie` SET `show` = ".$_POST['show']." WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    if ($_POST['show'] == 1) {
        echo "Obrázek je nyní vidět.";
    } else {
        echo "Obrázek nyní není zobrazen.";
    }
}
if ($_POST['action'] == "delete") {
    $sql = "SELECT * FROM `galerie` WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        unlink(PATH."/userfiles/galerie/".$res['id'].".".$res['name']);
        unlink(PATH."/userfiles/galerie/thumbs/".$res['id'].".".$res['name']);
    }
    $sql = "DELETE FROM `galerie` WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    echo "Obrázek byl smazán.";
}
if ($_POST['action'] == "edit") {
    $sql = "UPDATE `galerie` SET `title` = '".str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['title'])."' WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    echo "Popis obrázku byl změněn.";
}
if ($_POST['action'] == "sort") {
    $sql = "SELECT `parent` FROM `galerie` WHERE `id` = '".$_POST['id']."' LIMIT 1";
    $q = mysql_query($sql);
    $res = mysql_fetch_array($q);
    $parent = $res['parent'];
    $sql = "SELECT `order` AS target FROM `galerie` WHERE `id` = '".$_POST['change_with']."' LIMIT 1";
    if ($_POST['change_with'] == "") {
        $sql = "SELECT (MAX(`order`)+1) AS target FROM `galerie` WHERE `parent` = ".$parent." LIMIT 1";
    }
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $target = $res['target']-1;
        $sql = "SELECT * FROM `galerie` WHERE `id` = '".$_POST['id']."' LIMIT 1";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $from = $res['order'];
            if ($target > $from) {
                $sql = "UPDATE `galerie` SET `order` = `order`-1 WHERE `order` >= $from AND `order` <= $target AND `parent` = $parent";
                $q = mysql_query($sql);
                $sql = "UPDATE `galerie` SET `order` = ".$target." WHERE `id` = ".$_POST['id']."";
                $q = mysql_query($sql);
                echo "Úspěšně přesunut obrázek.";
            }
            if ($target < $from) {
                $sql = "UPDATE `galerie` SET `order` = `order`+1 WHERE `order` >= ".($target+1)." AND `order` <= $from AND `parent` = $parent";
                $q = mysql_query($sql);
                $sql = "UPDATE `galerie` SET `order` = ".($target+1)." WHERE `id` = ".$_POST['id']."";
                $q = mysql_query($sql);
                echo "Úspěšně přesunut obrázek.";
            }
            if ($target == $from) {
                echo "Obrázky nebyly přesunuty.";
            }
        } else {
            echo "Nastala chyba při přemisťování obrázků!";
        }
    } else {
        echo "Nastala chyba při přemisťování obrázků!";
    }
}








if ($_GET['action'] == "add_images") {
    require_once "../../../../../config/database.php";
    include "../../../../bin/scripts.php";
    if (is_logged_in()) {
    //
    //	specify file parameter name
        $file_param_name = 'file';

        //
        //	retrieve uploaded file name
        $file_name = $_FILES[ $file_param_name ][ 'name' ];

        //
        //	retrieve uploaded file path (temporary stored by php engine)
        $source_file_path = $_FILES[ $file_param_name ][ 'tmp_name' ];

        //
        //	construct target file path (desired location of uploaded file) -
        //	here we put to the web server document root (i.e. '/home/wwwroot')
        //	using user supplied file name
        $target_file_path = PATH."/userfiles/galerie/temp/".$file_name;

        unzip($source_file_path, $target_file_path);

        $sql = "SELECT MAX(`order`) AS max FROM `galerie` WHERE `parent` = ".$_GET['parent']."";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $order = $res['max']+1;
        }
        $file_name_2 = mt_rand(1000000, 9999999);
        $sql = "INSERT INTO `galerie` VALUES(NULL, '#new.".$file_name_2."', '', ".$_GET['parent'].", 1, $order)";
        $q = mysql_query($sql);

        $sql = "SELECT * FROM `galerie` WHERE `name` = '#new.".$file_name_2."'";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            copy(PATH."/userfiles/galerie/temp/".$file_name."small.jpg", PATH."/userfiles/galerie/thumbs/".$res['id'].".".$file_name_2.".jpg");
            copy(PATH."/userfiles/galerie/temp/".$file_name."large.jpg", PATH."/userfiles/galerie/".$res['id'].".".$file_name_2.".jpg");
            unlink(PATH."/userfiles/galerie/temp/".$file_name."small.jpg");
            unlink(PATH."/userfiles/galerie/temp/".$file_name."large.jpg");
            $sql = "UPDATE `galerie` SET `name` = '".$file_name_2.".jpg' WHERE `id` = ".$res['id']."";
            $q = mysql_query($sql);
        }
    }
}
?>
