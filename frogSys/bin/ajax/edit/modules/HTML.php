<?php
if ($_POST['action'] == "editStyleForm") {
    echo "<table>";
    $sql = "SELECT * FROM `html` WHERE `id` = ".$_POST['id']." ";
    $q = mysql_query($sql);
    $res = mysql_fetch_array($q);
    $aktual = $res['style'];
    $sql = "SELECT * FROM `html_style` WHERE `id` = ".$aktual."";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $aktualcss = str_replace(array("\n", "\r"), "", $res['css']);
        $aktualname = $res['name'];
    }
    $sql = "SELECT * FROM `html_style` ORDER BY `name`";
    $q = mysql_query($sql);
    while ($res = mysql_fetch_array($q)) {
        ?>
<tr>
    <td style="position: relative;">
        <div style="position: relative;">
                <?php
                writeEditPane("HtmlStyle", $_POST['id'].", ".$res['id'], "DE");
            echo "</div>";
                echo "<a href=\"javascript: saveStyleHtml(".$_POST['id'].", ".$res['id'].");\" ".
                    "onmouseover=\"setStyleHtml('content_in_".$_POST['id']."', '".str_replace(array("\n", "\r"), "", $res['css'])."', '".$res['name']."');\" ".
                    "onmouseout=\"setStyleHtml('content_in_".$_POST['id']."', '".$aktualcss."', '".$aktualname."');\">";
                ?>
                <?php
                if ($res['id'] == $aktual) {
                    echo "&gt; ";
                }
                ?>
                <?php echo $res['name']; ?>
    </a>
</td>
</tr>
    <?php
    }
    echo '
					<tr>
						<td>
							<a href="javascript: newStyleHtml('.$_POST['id'].');" style="color: #D3D3D3;">Přidat nový styl</a>
						</td>
					</tr>
				';
    echo "</table>";
}
if ($_POST['action'] == "saveStyle") {
    $sql = "UPDATE `html` SET `style` = ".$_POST['style']." WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    echo "Styl změněn.";
}
if ($_POST['action'] == "add") {
    $sql = "SELECT MAX(`sort`) AS sort FROM `html` WHERE `parent` = ".$_POST['parent']."";
    $q = mysql_query($sql);
    $res = mysql_fetch_array($q);
    $sql = "INSERT INTO `html` VALUES(NULL, '<p>Obsah stránky</p>', ".$_POST['parent'].", ".($res['sort']+1).", 1)";
    if ($q = mysql_query($sql)) {
        echo "HTML stránka byla vložena.";
    }
}
if ($_POST['action'] == "delete") {
    $sql = "DELETE FROM `html` WHERE `id` = ".$_POST['id']."";
    if ($q = mysql_query($sql)) {
        echo "HTML stránka byla smazána.";
    }
}
if ($_POST['action'] == "save") {
    $sql = "UPDATE `html` SET `content` = '".$_POST['text']."' WHERE `id` = ".$_POST['id']."";
    if ($q = mysql_query($sql)) {
        echo "HTML stránka byla změněna.";
    }
}
if ($_POST['action'] == "newStyle") {
    $style = $_POST['style'];
    if ($style != 0) {
        $sql = "SELECT * FROM `html_style` WHERE `id` = ".$style."";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $name = $res['name'];
            $css = $res['css'];
        }
    } else {
        $rand = mt_rand(1000, 9999);
        $sql = "INSERT INTO `html_style` VALUES(NULL, 'new$rand', '')";
        $q = mysql_query($sql);
        $sql = "SELECT * FROM `html_style` WHERE `name` = 'new$rand'";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $style = $res['id'];
            $name = $res['name'];
            $css = "";
        }
    }
    echo '
					<table width="100%" height="100%">
					<tr><td>
						Název: <input type="text" value="'.$name.'" id="name_edit_'.$_POST['id'].'" />
					</td></tr>
					<tr><td>
					<textarea style="min-width: 300px; width: 100%; height: 100%; min-height: 300px;" id="css_edit_'.$_POST['id'].'" onkeyup="setStyleHtml(\'content_in_'.$_POST['id'].'\', this.value);">'.$css.'</textarea>
					</td>
					</tr>
					<tr><td>
						<input type="button" value="uložit" onclick="saveNewStyleHtml('.$_POST['id'].', '.$style.');" />
					</td></tr>
					</table>
				';
}
if ($_POST['action'] == "saveNewStyle") {
    $sql = "UPDATE `html_style` SET `name` = '".$_POST['name']."', `css` = '".$_POST['css']."' WHERE `id` = ".$_POST['style']."";
    $q = mysql_query($sql);
}
if ($_POST['action'] == "deleteNewStyle") {
    $sql = "DELETE FROM `html_style` WHERE `id` = ".$_POST['style']."";
    $q = mysql_query($sql);
    echo "Html styl byl smazán.";
}
if ($_POST['action'] == "sort") {
    $sql = "SELECT `parent` FROM `html` WHERE `id` = '".$_POST['id']."' LIMIT 1";
    $q = mysql_query($sql);
    $res = mysql_fetch_array($q);
    $parent = $res['parent'];
    $sql = "SELECT `sort` AS target FROM `html` WHERE `id` = '".$_POST['change_with']."' LIMIT 1";
    if ($_POST['change_with'] == "") {
        $sql = "SELECT (MAX(`sort`)+1) AS target FROM `html` WHERE `parent` = ".$parent." LIMIT 1";
    }
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $target = $res['target']-1;
        $sql = "SELECT * FROM `html` WHERE `id` = '".$_POST['id']."' LIMIT 1";
        $q = mysql_query($sql);
        if ($res = mysql_fetch_array($q)) {
            $from = $res['sort'];
            if ($target > $from) {
                $sql = "UPDATE `html` SET `sort` = `sort`-1 WHERE `sort` >= $from AND `sort` <= $target AND `parent` = $parent";
                $q = mysql_query($sql);
                $sql = "UPDATE `html` SET `sort` = ".$target." WHERE `id` = ".$_POST['id']."";
                $q = mysql_query($sql);
                echo "Úspěšně přesunut editovatelné obsah.";
            }
            if ($target < $from) {
                $sql = "UPDATE `html` SET `sort` = `sort`+1 WHERE `sort` >= ".($target+1)." AND `sort` <= $from AND `parent` = $parent";
                $q = mysql_query($sql);
                $sql = "UPDATE `html` SET `sort` = ".($target+1)." WHERE `id` = ".$_POST['id']."";
                $q = mysql_query($sql);
                echo "Úspěšně přesunut editovatelné obsah.";
            }
            if ($target == $from) {
                echo "Edotovatelný obsah nebyl přesunut.";
            }
        } else {
            echo "Nastala chyba při přemisťování!";
        }
    } else {
        echo "Nastala chyba při přemisťování!";
    }
}

?>
