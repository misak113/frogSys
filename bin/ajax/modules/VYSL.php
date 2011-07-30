<?php

require_once "../../../../config/database.php";
include "../../../bin/scripts.php";

if (isset($_POST['action']) && $_POST['action'] == "writeVysledkyZapasy") {
    writeVysledkyZapasy($_POST['id']);
}

if ($_POST['action'] == "save_vysledek_utkani") {
    $id_utkani = 0+$_POST['id_utkani'];
    $domaci = 0+$_POST['domaci'];
    $hoste = 0+$_POST['hoste'];
    if ($id_utkani == 0) {
        die("špatně zadaný formát id utkání!");
    }
    // zde se automaticky vygeneruje tolik zapasu pro utkani a k nim vysledky, kolik zadal finalni
    // vytvori se fiktivni vysledek... ten nebude viden v user casti
    $sql = "DELETE FROM `vysledky_zapas` WHERE `id_utkani` = ".$id_utkani;
    mysql_query($sql);
    $typy = array("1. 1D-1D","2. 2D-2D","3. 1T-1T","4. 2T-2T","5. 3D-3D","6. 1S-1S","7. 1T-2T","8. 2T-1T","9. 1D-2D","A. 2D-1D");
    for ($i=0;$i<$domaci+$hoste;$i++) {
        $q = mysql_query("SHOW TABLE STATUS LIKE 'vysledky_zapas'");
        $res = mysql_fetch_array($q);
        $id_zapasu = $res['Auto_increment'];
        $sql = "INSERT INTO `vysledky_zapas` VALUES(NULL, ".$id_utkani.", '".$typy[$i]."')";
        mysql_query($sql);
        if ($i < $domaci) {
            $dom = "10";
            $hos = "0";
        } else {
            $dom = "0";
            $hos = "10";
        }
        $sql = "INSERT INTO `vysledky_vysledek` VALUES(NULL, ".$id_zapasu.", ".$dom.", ".$hos.")";
        mysql_query($sql);
    }
    echo "Výsledek utkání byl uložen.";
}

?>
<?php mysql_close(); ?>