<?php
require_once "../../../config/database.php";
include "../../bin/scripts.php";

if (is_logged_in()) {
    if ($_POST['predmet'] == "odhlasit") {
        if ($_POST['action'] == "odhlasit") {
            $_SESSION['auth'] = null;
            $_SESSION['user'] = null;
        }
    }
    if ($_POST['predmet'] == "admins") {
        if ($_POST['action'] == "edit_form") {
            echo "<table>";
            $sql = "SELECT * FROM `admin` ORDER BY `auth`";
            $q = mysql_query($sql);
            while ($res = mysql_fetch_array($q)) {
                echo "<tr>";
                if (is_logged_in(array(1))) {
                    echo "<td>";
                    if ($res['auth'] > 1) {
                        echo "<a href=\"javascript: deleteAdmin(".$res['id'].");\"><img src=\"".URL."frogSys/images/icons/delete.png\" alt=\"delete\" class=\"delete\" /></a>";
                    }
                    echo "</td>";
                }
                echo "<td><a href=\"javascript: editAdmin(".$res['id'].");\">".$res['user']."</a></td>";
                echo "</tr>";
            }
            if (is_logged_in(array(1))) {
                echo "<tr><td><a href=\"javascript: addAdmin();\"><img src=\"".URL."frogSys/images/icons/add.png\" alt=\"add\" class=\"add\" /></a></td></tr>";
            }
            echo "</table>";
        }
        if ($_POST['action'] == "add") {
            if (is_logged_in(array(1))) {
                $rand = mt_rand(1000, 9999);
                $pass = mt_rand(10000, 99999);
                $sql = "INSERT INTO `admin` VALUES(NULL, 'user$rand', '$pass', 2)";
                $q = mysql_query($sql);
                $sql = "SELECT * FROM `admin` WHERE `user` = 'user$rand'";
                $q = mysql_query($sql);
                $res = mysql_fetch_array($q);
                echo $res['id'];
            }
        }
        if ($_POST['action'] == "delete") {
            $sql = "DELETE FROM `admin` WHERE `id` = ".$_POST['id']."";
            $q = mysql_query($sql);
            echo "Administrátor smazán!";
        }
        if ($_POST['action'] == "edit") {
            if (is_logged_in(array(1))) {
                $sql = "SELECT * FROM `admin` WHERE `id` = ".$_POST['id']."";
                $q = mysql_query($sql);
                if ($res = mysql_fetch_array($q)) {
                    ?>
<table>
    <tr>
        <td>
									username:
        </td>
        <td>
            <input type="text" value="<?php echo $res['user']; ?>" id="username_<?php echo $res['id']; ?>">
        </td>
    </tr>
    <tr>
        <td>
									password:
        </td>
        <td>
            <input type="text" value="<?php echo $res['pass']; ?>" id="password_<?php echo $res['id']; ?>">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="button" value="uložit" onclick="saveAdmin(<?php echo $res['id']; ?>)">
        </td>
    </tr>
</table>
                <?php
                }
            } else {
                echo "Nemáte právo editovat administrátory!";
            }
        }
        if ($_POST['action'] == "edited") {
            if (is_logged_in(array(1))) {
                $sql = "UPDATE `admin` SET `user` = '".$_POST['user']."', `pass` = '".$_POST['pass']."' WHERE `id` = ".$_POST['id']."";
                $q = mysql_query($sql);
                echo "Přihlašovací údaje byly změněny.";
            }

        }
    }
    if ($_POST['predmet'] == "pages") {
        if ($_POST['action'] == "get_names") {
            $sql = "SELECT * FROM `menu` WHERE `id` = ".$_POST['page']."";
            $q = mysql_query($sql);
            $res = mysql_fetch_array($q);
            $sql = "SELECT * FROM `menu_in` WHERE `href` = ".$_POST['sub_page']."";
            $q2 = mysql_query($sql);
            $res2 = @mysql_fetch_array($q2);
            echo @$res['name']." &gt; ".@$res2['name'];
        }
    }
    if ($_POST['predmet'] == "titulek") {
        if ($_POST['action'] == "save") {
            $text = $_POST['text'];
            $text = str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $text);
            $sql = "UPDATE `html` SET `content` = '".$text."' WHERE `parent` = ".$_POST['id'];
            if ($q = mysql_query($sql)) {
                echo $_POST['id'];
            }
        }
    }
    if ($_POST['predmet'] == "seting") {
        if ($_POST['action'] == "clear_seting") {
            $sql = "DELETE FROM `seting` WHERE `name` = '".$_POST['name']."'";
            mysql_query($sql);
            echo "Nastavení ".$_POST['name']." bylo smazáno.";
        }
        if ($_POST['action'] == "set_seting") {
            $text = $_POST['text'];
            $text = str_replace(array("\n","'"), array(" ","&#39;"), $text);
            $sql = "INSERT INTO `seting` VALUES(NULL, '".$_POST['name']."', '".$text."')";
            mysql_query($sql);
            $sql = "UPDATE `seting` SET `value` = '".$text."' WHERE `name` = '".$_POST['name']."'";
            if ($q = mysql_query($sql)) {
                echo "Nastavení bylo nastaveno na ".$text;
            }
        }
    }
    if ($_POST['predmet'] == "moduly") {
        if (is_logged_in(array(1))) {
            if ($_POST['action'] == "vypis") {
                $nosuper = "`zapnut` = 1 AND ";
                if (is_logged_in(array(1))) {
                    $nosuper = "";
                }
                echo "<div class=\"modules\"><ul>";
                $sql = "SELECT * FROM `modules` WHERE $nosuper`parent` = 0";
                $q2 = mysql_query($sql);
                while ($res2 = mysql_fetch_array($q2)) {
                    $vypnuty = "";
                    $check = "Č";
                    if ($res2['zapnut'] == 0) {
                        $vypnuty = " style=\"color: #e50000;\"";
                        $check = "C";
                    }
                    echo '<li><span'.$vypnuty.'>'.$res2['text'].'</span>';
                    writeEditPane("Modul", $res2['id'].", this", $check);
                    echo "<ul>";
                    $sql = "SELECT * FROM `modules` WHERE $nosuper`parent` = ".$res2['id'];
                    $q3 = mysql_query($sql);
                    while ($res3 = mysql_fetch_array($q3)) {
                        $vypnuty = "";
                        $check = "Č";
                        if ($res3['zapnut'] == 0) {
                            $vypnuty = "style=\"color: #e50000;\" ";
                            $check = "C";
                        }
                        echo '<li style="list-style-type: none;">
                                <img src="'.URL.'frogSys/images/modules/'.$res3['type'].'_25x25.png" alt="'.$res3['text'].'" style="width: 25px; height: 25px;" />
                                <span '.$vypnuty.'onmouseover="showInfo(event, \'<img src=&quot;/frogSys/images/modules/'.$res3['type'].'.png&quot; alt=&quot;'.$res3['text'].'&quot; class=&quot;page_typy&quot; id=&quot;'.$res3['type'].'&quot;>\', this)">'.$res3['text'].'</span>';
                        writeEditPane("Modul", $res3['id'].", this", $check);
                        echo '</li>';
                    }
                    echo "</ul>";
                    echo '</li>';
                }
                echo "</ul></div>";
                ?>
            <?php
            }
            if ($_POST['action'] == "set_zapnut") {
                $sql = "UPDATE `modules` SET `zapnut` = ".$_POST['zapnut']." WHERE `id` = ".$_POST['id']."";
                mysql_query($sql);
                echo "Modul byl vypnut/zapnut.";
            }
        } else {
            echo "Nejste super administrátor!";
        }

    }
} else {
    echo "Nemáte právo pro administraci!";
}
?><?php mysql_close(); ?>