<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if ($_POST['action'] == "save_web_pages_tymu") {
    $id_tymu = $_POST['id_tymu'];
    $web_pages = $_POST['web_pages'];
    $sql = "UPDATE `vysledky_tym` SET `web` = '".$web_pages."' WHERE `id_tymu` = '".$id_tymu."';";
    if (mysql_query($sql)) {
	echo 'Webov� str�nky byla ulo�ena.';
    } else {
	echo 'Nepoda�ilo se ulo�it wbov� str�nky.';
    }

}

?>
