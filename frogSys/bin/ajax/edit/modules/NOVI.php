<?php


if ($_POST['action'] == "add") {
    $sql = "SELECT `id` FROM `admin` WHERE `user` = '".$_SESSION['user']."'";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $user = $res['id'];
    }
    $rand = mt_rand(1000, 9999);
    $sql = "INSERT INTO `novinky` VALUES(NULL, 'Nová novinka', 'Obsah novinky.', ".$_POST['page_part'].", $user, NOW(), 0, 'nova-novinka-".$rand."')";
    if ($q = mysql_query($sql)) {
        $sql = "SELECT `id` FROM `novinky` WHERE `link` = 'nova-novinka-".$rand."'";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            echo $res['id'];
        }
    }
}

if ($_POST['action'] == "delete") {
    $sql = "DELETE FROM `novinky` WHERE `id` = ".$_POST['id']."";
    if (mysql_query($sql)) {
        echo "Novinka byla smazána.";
    }
}

if ($_POST['action'] == "save_nazev") {
    $nazev = str_replace(array("&", "<", ">", '"'), array("&amp;", "&lt;", "&gt;", "&quot;"), $_POST['nazev']);
    $link = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['link']);

    $sql = "SELECT * FROM `novinky` WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $sql = "SELECT * FROM `novinky` WHERE `parent` = ".$res['parent']." AND `link` = '".$link."' AND `id` <> ".$_POST['id']."";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $link = $link."-".$_POST['id'];
            $relink = "<br>Byl zjištěn duplicitní 'link', proto byl nahrazen za '".$link."'";
        }
    }

    $sql = "UPDATE `novinky` SET `nazev` = '".$nazev."', `link` = '".$link."' WHERE `id` = ".$_POST['id']."";
    if (mysql_query($sql)) {
        echo $_POST['id'].$relink;
    }
}

if ($_POST['action'] == "save_text") {
    $sql = "UPDATE `novinky` SET `text` = '".$_POST['text']."' WHERE `id` = ".$_POST['id']."";
    if (mysql_query($sql)) {
        echo $_POST['id'];
    }
}

if ($_POST['action'] == "set_visible") {
    $sql = "UPDATE `novinky` SET `visible` = '".$_POST['visible']."' WHERE `id` = ".$_POST['id']."";
    if (mysql_query($sql)) {
        echo "Změnil jste zobrazitelnost novinky.";
    }
}

?>
