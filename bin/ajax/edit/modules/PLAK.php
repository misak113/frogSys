<?php
if ($_POST['action'] == "add") {
    $podminky = 'Pro závazné přihlášení na akci je nutné poslat poslat 500 kč na učet '.CISLO_UCTU.'. s variabilním symbolem XXXXXXXX. Po obdržení Vám bude zaslán potvrzující email. Více info na <a href="mailto:info@janarandakova.cz">info@janarandakova.cz</a><br />
» <a href="'.URL.'obchodni-podminky/">Podmínky a postup platby</a>';
    $rand = mt_rand(1000, 9999);
    $sql = "INSERT INTO `plan_akci` VALUES(NULL, '$rand', NOW(), NOW(), '', '', '', NOW(), ".$_POST['parent'].", 0, 0, '$podminky', '')";
    $q = mysql_query($sql);
    $sql = "SELECT * FROM `plan_akci` WHERE `name` = '$rand'";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        echo $res['id'];
    }
}
if ($_POST['action'] == "edit") {
    $sql = "SELECT * FROM `plan_akci` WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        ?>
<table class="edit_table">
    <tr>
        <td>
							název:
        </td>
        <td>
            <input type="text" value="<?php echo $res['name']; ?>" id="plan_akci_nazev_<?php echo $res['id']; ?>" class="table_input">
        </td>
    </tr>
    <tr>
        <td>
							Datum:
        </td>
        <td>
                    <?php
                    $k_id = $res['id'];
                    $k_start = $res['kdy'];
                    $k_stop = $res['do'];
                    $k_mesic = 0;
                    $k_rok = 0;
                    $k_editable = "true";
                    echo '<div id="kalendar_'.$k_id.'">';
                    include PATH."/frogSys/bin/plugins/kalendar.php";
                    writeKalendar($k_id, $k_start, $k_stop, $k_mesic, $k_rok, $k_editable);
                    echo '</div>';
                    ?>
        </td>
    </tr>
    <tr>
        <td>
							kde:
        </td>
        <td>
            <input type="text" value="<?php echo $res['kde']; ?>" id="plan_akci_kde_<?php echo $res['id']; ?>" class="table_input">
        </td>
    </tr>
    <tr>
        <td>
							cíl akce:
        </td>
        <td>
            <input type="text" value="<?php echo $res['co']; ?>" id="plan_akci_co_<?php echo $res['id']; ?>" class="table_input">
        </td>
    </tr>
    <tr>
        <td>
							text:
        </td>
        <td>
            <textarea id="plan_akci_popis_<?php echo $res['id']; ?>"><?php echo $res['text']; ?></textarea>
        </td>
    </tr>
    <tr>
        <td>
							Počet lidí:
        </td>
        <td>
            <input type="text" value="<?php echo $res['limit_lidi']; ?>" id="plan_akci_limit_lidi_<?php echo $res['id']; ?>" class="table_input">
        </td>
    </tr>
    <tr>
        <td>
							Info o ceně:
        </td>
        <td>
            <input type="text" value="<?php echo $res['cena']; ?>" id="plan_akci_cena_<?php echo $res['id']; ?>" class="table_input">
        </td>
    </tr>
    <tr>
        <td>
            <input type="button" value="uložit" class="window_button" onclick="savePlan_akci(<?php echo $res['id']; ?>);">
        </td>
        <td>
            <input type="button" value="kopírovat" class="window_button" onclick="copyPlan_akci(<?php echo $res['id']; ?>);">
        </td>
    </tr>
</table>
    <?php
    }
}
if ($_POST['action'] == "save") {
    $sql = "UPDATE `plan_akci` SET `name` = '".str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['name'])."', `kdy` = '".$_POST['kdy']."', `kde` = '".str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['kde'])."', `co` = '".str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['co'])."', `text` = '".str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['text'])."', `do` = '".$_POST['do']."', `limit_lidi` = ".$_POST['limit_lidi'].", `cena` = '".str_replace(array("&", "<", ">"), array("&amp;", "&lt;", "&gt;"), $_POST['cena'])."', `time` = NOW() WHERE `id` = ".$_POST['id']."";
    if ($q = mysql_query($sql)) {
        echo "Akce byla editována.";
    }
}
if ($_POST['action'] == "add_file") {
    $sql = "INSERT INTO `spravce_souboru` VALUES(NULL, 'PLAK', '".$_POST['cesta']."', '', ".$_POST['id'].")";
    mysql_query($sql);
    echo "Soubor ještě nebyl přidán.";

}
if ($_POST['action'] == "set_text_podminky") {
    $sql = "UPDATE `plan_akci` SET `text_podminky` = '".$_POST['text']."'WHERE `id` = ".$_POST['id']."";
    if ($q = mysql_query($sql)) {
        echo "Text podmínek byl editován.";
    }
}
if ($_POST['action'] == "delete") {
    $sql = "DELETE FROM `plan_akci` WHERE `id` = ".$_POST['id']."";
    if ($q = mysql_query($sql)) {
        echo "Akce byla smazána.";
    }
}
if ($_POST['action'] == "get_id_part") {
    $sql = "SELECT * FROM `plan_akci` WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        echo $res['parent'];
    }
}
if ($_POST['action'] == "delete_user") {
    $sql = "DELETE FROM `plan_akci_prihlaseni` WHERE `id` = ".$_POST['id']."";
    if ($q = mysql_query($sql)) {
        echo "Účastník byl smazán.";
    }
}
if ($_POST['action'] == "cash_user") {
    $sql = "SELECT * FROM `plan_akci_prihlaseni` WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        if ($res['zaplatil'] == 0) {
            $zaplatil = 1;
            $z = "";
        } else {
            $zaplatil = 0;
            $z = "ne";
        }
    }
    $sql = "UPDATE `plan_akci_prihlaseni` SET `zaplatil` = $zaplatil WHERE `id` = ".$_POST['id']."";
    if ($q = mysql_query($sql)) {
        echo "Označil jste účastníka jako ".$z."zaplaceného.";
    }
}
if ($_POST['action'] == "mail_user") {
    $sql = "SELECT * FROM `plan_akci_prihlaseni` WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        $sql2 = "SELECT * FROM `plan_akci` WHERE `id` = ".$res['akce']."";
        $q2 = mysql_query($sql2);
        if ($res2 = mysql_fetch_array($q2)) {
            $akce = $res2['name'];
        }

        $headers = get_mail_header("Záloha na akci - ".$akce, "Info ".PAGE_NAME, ADMIN_MAIL);
        imap_mail("".$res['email']."",
            "",
            "Dobrý den ".$res['jmeno']." ".$res['prijmeni'].",<br />\n".
            "Byla obdržena záloha za akci \"$akce\" .<br />\n".
            "S pozdravem Jana Randáková\n",
            $headers
        );
        $sql = "UPDATE `plan_akci_prihlaseni` SET `mailed` = 1 WHERE `id` = ".$_POST['id']."";
        if ($q = mysql_query($sql)) {
            echo "Účastníkovi byl zaslán email o obdržení zálohy.";
        }
    }
}
if ($_POST['action'] == "users") {
    echo '
				<a href="javascript: sendCollectiveMail('.$_POST['id'].');">
					Poslat hromadný e-mail
				</a>
				<table id="users_'.$_POST['id'].'" class="table_uziv_sez" borderspacing="0" cellspacing="0">
					<tr>
						<th colspan="3">
							Akce
						</th>
						<th>
							Jméno
						</th>
						<th>
							Příjmení
						</th>
						<th>
							Email
						</th>
						<th>
							Variabilní symbol
						</th>
						<th>
							Telefonní číslo
						</th>
						<th>
							Adresa
						</th>
						<th>
							poznámka
						</th>
					</tr>
				';
    $sql = "SELECT * FROM `plan_akci_prihlaseni` WHERE `akce` = ".$_POST['id']."";
    $q = mysql_query($sql);
    while ($res = mysql_fetch_array($q)) {
        echo '
					<tr>
						<td style="padding:0; padding-top:5px;">
							<a href="javascript: deleteUser('.$res['id'].');">
								<img src="'.URL.'frogSys/images/icons/delete.png" alt="delete" class="delete" />
							</a>
						</td>
						<td style="padding:0; padding-top:5px;">
							<a href="javascript: cashUser('.$res['id'].');">
								<img src="'.URL.'frogSys/images/icons/';
        if ($res['zaplatil'] == 1) {
            echo 'cash';
        } else {
            echo 'uncash';
        }
        echo '.png" alt="cash" class="cash" />
							</a>
						</td>
						<td style="padding:0; padding-top:5px;">
							<a href="javascript: mailUser('.$res['id'].');">
								<img src="'.URL.'frogSys/images/icons/message';
        if ($res['mailed'] == 1) {
            echo 'send';
        } else {
            echo 'unsend';
        }
        echo '.png" alt="message" class="message" />
							</a>
						</td>
						<td>
							'.$res['jmeno'].'
						</td>
						<td>
							'.$res['prijmeni'].'
						</td>
						<td>
							'.$res['email'].'
						</td>
						<td>
							'.$res['vs'].'
						</td>
						<td>
							'.$res['telefonni_cislo'].'
						</td>
						<td>
							'.$res['adresa'].'
						</td>
						<td>
							'.$res['poznamka'].'
						</td>
					</tr>
					';
    }
    echo '</table>';
}
if ($_POST['action'] == "collective_mail") {
    $sql = "SELECT * FROM `plan_akci` WHERE `id` = ".$_POST['id']."";
    $q = mysql_query($sql);
    if ($res = mysql_fetch_array($q)) {
        echo '
			<form action="javascript: sendCollectiveMail2('.$_POST['id'].');" name="send_mail_'.$_POST['id'].'" class="send_mail">
				<table>
					<tr>
						<td>
							Předmět: <input type="text" name="predmet" value="'.$res['name'].' - důležité sdělení">
						</td>
					</tr>
					<tr>
						<td>
							<textarea name="obsah"></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="id" value="'.$_POST['id'].'">
							<input type="submit" value="Odeslat">
						</td>
					</tr>
				</table>
			</form>
				';
    }
}
if ($_POST['action'] == "send_collective_mail") {
    $sql = "SELECT * FROM `plan_akci_prihlaseni` WHERE `akce` = ".$_POST['id']."";
    $q = mysql_query($sql);
    $mail = "";
    while ($res = mysql_fetch_array($q)) {
        $mail .= $res['email'].", ";
    }

    $headers = get_mail_header($_POST['predmet_mail'], "Info ".PAGE_NAME, ADMIN_MAIL);

    imap_mail("".$mail."",
        "",
        "<pre>".$_POST['text']."</pre>",
        $headers
    );

    echo "Hromadný e-mail byl odeslán";

}
?>
