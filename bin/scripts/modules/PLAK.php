<?php

function writePlanAkci($page_part) {
    if (@$_POST['prihlasit_akce'] != "" && @$_POST['jmeno'] != "" && @$_POST['prijmeni'] != "" && @$_POST['email'] != "") {
        $sql = "SELECT * FROM `plan_akci` WHERE `id` = ".$_POST['prihlasit_akce']."";
        $q = mysql_query($sql);
        $res = mysql_fetch_array($q);
        $max = $res['limit_lidi'];
        $akce = $res['name'];
        $text_podminky = $res['text_podminky'];

        $sql = "SELECT count(*) AS pocet FROM `plan_akci_prihlaseni` WHERE `akce` = ".$res['id']."";
        $q2 = mysql_query($sql);
        $res2 = mysql_fetch_array($q2);
        $prihlaseno = $res2['pocet'];

        if ($prihlaseno < $max) {
            $date = substr(str_replace("-", "", $res['kdy']), 2);
            $sql = "SELECT * FROM `plan_akci_prihlaseni` WHERE `vs` LIKE '".$date."*'";
            $q = mysql_query($sql);
            $backvs = 100;
            while ($res = mysql_fetch_array($q)) {
                $evs = substr($res['vs'], -3);
                if ($evs > $backvs) {
                    $backvs = $evs;
                }
            }
            $vs = $date.($backvs+1);
            $sql = "INSERT INTO `plan_akci_prihlaseni` VALUES(NULL, '".@$_POST['jmeno']."', '".@$_POST['prijmeni']."', '".@$_POST['email']."', ".@$_POST['prihlasit_akce'].", ".$vs.", 0, '".@$_POST['tel']."', '".@$_POST['adresa']."', '".@$_POST['poznamka']."', 0)";
            $q = mysql_query($sql);
            //$headers = get_mail_header("Přihlášení na akci - ".$akce, "Info ".PAGE_NAME, ADMIN_MAIL);

            $text = 'Dobrý den '.@$_POST['jmeno'].' '.@$_POST['prijmeni'].',<br>
děkujeme za zájem o akci, na kterou jste byl/a tímto závazně přihlášen/a.<br>
Další organizační informace Vám zašleme na uvedený e-mail. Částka bude vybírána dle následujících podmínek.<br>
<i>'.$text_podminky.'</i><br>
Těšíme se na setkání.<br>
Mějte hezké dny,<br>
<br>
Jana Randaková';

            /*imap_mail("".@$_POST['email']."",
                "",	$text,
                $headers
            );*/

            $message = Swift_Message::newInstance()
                            //Give the message a subject
                            ->setSubject("Přihlášení na akci - ".$akce)
                            //Set the From address with an associative array
                            ->setFrom(array(ADMIN_MAIL => "Info ".PAGE_NAME))
                            //Set the To addresses with an associative array
                            ->setTo(array(@$_POST['email']))
                            //Give it a body
                            //->setBody('Here is the message itself')
                            //And optionally an alternative body
                            ->addPart($text, 'text/html')
                            //Optionally add any attachments
                            //->attach(Swift_Attachment::fromPath('my-document.pdf'))
                    ;
            global $mailer;
            $result = $mailer->send($message);

            //echo "Byl jste přihlášen na akci.";
            echo '<script>
                                    addLoadEvent(function () {
                                        createWindow("<h2>Byl jste přihlášen na akci.</h2>");
                                    });
                                </script>';
        } else {
        //echo "Na akci je již plno.";
            echo '<script>
                                    addLoadEvent(function () {
                                        createWindow("<h2>Na akci je již plno.</h2>");
                                    });
                                </script>';
        }
    }
    include PATH."/frogSys/bin/plugins/kalendar.php";
    $sql = "SELECT * FROM `plan_akci` WHERE `parent` = ".$page_part." ORDER BY `kdy`";
    $q = mysql_query($sql);
    $isEmpty = true;
    while ($res = mysql_fetch_array($q)) {
        $sql = "SELECT count(*) AS pocet FROM `plan_akci_prihlaseni` WHERE `akce` = ".$res['id']."";
        $q2 = mysql_query($sql);
        $res2 = mysql_fetch_array($q2);
        $prihlaseno = $res2['pocet'];
        ?>
<div class="polozka_plan_akci">
    <div class="hlavicka_plan_akci">
        <div class="nazev_plan_akci">
            <a href="javascript: openPodrobnost(<?php echo $res['id']; ?>);">
                        <?php echo $res['name']; ?>
            </a>
        </div>
        <div class="podrobnosti_plan_akci">
            <a href="javascript: openPodrobnost(<?php echo $res['id']; ?>);">
                <img src="<?php echo URL; ?>frogSys/images/icons/podrobnosti_open.png" alt="podrobnosti" id="podrobnosti_img_plan_akci_<?php echo $res['id']; ?>" width="15" height="15">
				zobrazit podrobnosti
            </a>

                    <?php
                    if (@$_SESSION['auth'] > 0) {
                        writeEditPane("Plan_akci", $res['id'], "EDU");
                    }
                    ?>
        </div>
    </div>
    <div class="telo_plan_akci" id="telo_plan_akci_<?php echo $res['id']; ?>" style="height: 1px;">
        <div class="atribut_plan_akci">
                    <?php
                    $kdy = explode("-", $res['kdy']);
                    $kdy = $kdy[2].". ".$kdy[1].". ".$kdy[0];
                    $do = explode("-", $res['do']);
                    $do = $do[2].". ".$do[1].". ".$do[0];
                    ?>
            <span class="polozky_akce">kdy: </span><?php echo $kdy; ?> až <?php echo $do; ?>
                    <?php
                    $k_id = $res['id']."_user";
                    $k_start = $res['kdy'];
                    $k_stop = $res['do'];
                    $k_mesic = 0;
                    $k_rok = 0;
                    $k_editable = "false";
                    echo '<div id="kalendar_'.$k_id.'" style="border: 1px black solid; position: absolute; z-index: 20; background-color: white; right: 30px; top: 5px; display: none;">';
                    writeKalendar($k_id, $k_start, $k_stop, $k_mesic, $k_rok, $k_editable);
                    echo '</div>';
                    ?>
            <a href="javascript: showKalendar('kalendar_<?php echo $res['id']."_user"; ?>')">
                <img src="<?php echo URL; ?>frogSys/images/icons/calendar_day.png" alt="kalendář" class="kalendar">
            </a>
        </div>
        <div class="atribut_plan_akci">
            <span class="polozky_akce">kde: </span><?php echo $res['kde']; ?>
        </div>
        <div class="atribut_plan_akci">
            <span class="polozky_akce">cíl akce:</span> <?php echo $res['co']; ?>
        </div>
        <div class="atribut_plan_akci">
            <span class="polozky_akce">Popis: </span><?php echo $res['text']; ?>
        </div>
        <div class="atribut_plan_akci">
            <span class="polozky_akce">přihlášeno / max. počet lidí: </span><?php echo $prihlaseno; ?>/<?php echo $res['limit_lidi']; ?>
        </div>
        <div class="atribut_plan_akci">
            <span class="polozky_akce">Info o ceně: </span><?php echo $res['cena']; ?>
        </div>
             
        <div class="atribut_plan_akci">
            <table>
            <tr><td><span class="polozky_akce">Přiložené soubory: </span></td><td id="plan_akci_soubory_<?php echo $res['id']; ?>">
                    
                    <?php
                     if (@$_SESSION['auth'] > 0) {
                                ?>
                    <a href="javascript: selectFile(<?php echo $res['id']; ?>, 'PLAK');"><img src="<?php echo URL; ?>frogSys/images/icons/plus.png" onmouseover="showInfo(event, 'Přidat soubor', this)" alt="vybrat" /></a>
<?php } ?>
                        <?php
                                $sql = "SELECT * FROM `spravce_souboru` WHERE `modul` = 'PLAK' AND `parent` = ".$res['id']."";
                                $qs = mysql_query($sql);
                                while ($sou = mysql_fetch_array($qs)) {
                                    $filename = PATH.$sou['cesta'];
                                    if (is_file($filename)) {
                                        $mj = "";
                                        $size = filesize($filename);
                                        if ($size > 1000) {
                                            $mj = "K";
                                            $size = $size/1024;
                                            if ($size > 1000) {
                                                $mj = "M";
                                                $size = $size/1024;
                                            }
                                        }
                                        $casti = explode(".", $filename);
                                        if (count($casti) > 1) {
                                            $pripona = strtolower($casti[count($casti)-1]);
                                        } else {
                                            $pripona = "none";
                                        }
                                        $casti = explode("/", $filename);
                                        if (count($casti) > 1) {
                                            $file_name = strtolower($casti[count($casti)-1]);
                                        } else {
                                            $file_name = $filename;
                                        }
                                        echo '
<div id="plan_akci_soubor_'.$sou['id'].'"><span>
<img src="'.URL.'frogSys/images/icons/pripony/'.$pripona.'.gif" alt="'.$pripona.'" />
</span>
<span>
<a href="'.$sou['cesta'].'" target="_blank">
'.$file_name.'
</a>
</span>
<span style="margin-left: 10px;">'.round($size, 1).' '.$mj.'B</span>
';
                                if (@$_SESSION['auth'] > 0) {
                                    writeEditPane("PlakSouborDatabase", $sou['id'], "D");
                                }
                                echo '</div>';
                                    }

                                }

                                ?>
            </td>
            </tr>
            </table>
        </div>
            
        <div class="atribut_plan_akci">
            <a id="prihlasit-akce" href="javascript: prihlasitNaAkci(<?php echo $res['id']; ?>);">
					přihlásit se na akci
            </a>
        </div>
        <div class="plan_akci_prihlasit" id="plan_akci_prihlasit_<?php echo $res['id']; ?>" style="height: 1px;">
            <div id="plan_akci_inner">
                <form action="" method="POST" onsubmit="return prihlasitAkci(<?php echo $res['id']; ?>);">
                    <table>
                        <tr>
                            <td>jméno:</td>
                            <td><input type="text" name="jmeno" id="plan_akci_jmeno_<?php echo $res['id']; ?>"></td>
                        </tr>
                        <tr>
                            <td>příjmení:</td>
                            <td><input type="text" name="prijmeni" id="plan_akci_prijmeni_<?php echo $res['id']; ?>"></td>
                        </tr>
                        <tr>
                            <td>e-mail:</td>
                            <td><input type="text" name="email" id="plan_akci_email_<?php echo $res['id']; ?>"></td>
                        </tr>
                        <tr>
                            <td>telefonní číslo:</td>
                            <td><input type="text" name="tel" id="plan_akci_tel_<?php echo $res['id']; ?>"></td>
                        </tr>
                        <tr>
                            <td>adresa:</td>
                            <td><input type="text" name="adresa" id="plan_akci_adresa_<?php echo $res['id']; ?>"></td>
                        </tr>
                        <tr>
                            <td>poznámka:</td>
                            <td><input type="text" name="poznamka" id="plan_akci_poznamka_<?php echo $res['id']; ?>"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                        <?php
                                        if ($prihlaseno >= $res['limit_lidi']) {
                                            $plno = "true";
                                        } else {
                                            $plno = "false";
                                        }
                                        ?>
                                <input type="hidden" name="plno" id="plan_akci_plno_<?php echo $res['id']; ?>" value="<?php echo $plno; ?>">
                                <input type="hidden" name="prihlasit_akce" value="<?php echo $res['id']; ?>">
                                <div class="plak_outer_podminky" id="plak_outer_podminky_<?php echo $res['id'];?>">
                                            <?php
                                            if (@$_SESSION['auth'] > 0) {
                                                writeEditPane("PlanAkci_podminky", $res['id'], "E");
                                            }
                                            ?>
                                    <div id="prihlaseni_info_<?php echo $res['id']; ?>" class="prihlaseni-info"><?php echo $res['text_podminky']?></div>
                                </div>
                                <input type="checkbox" value="souhlasim" name="souhlas" id="souhlas_<?php echo $res['id']; ?>">
                				Souhlasím s podmínkami
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" value="přihlásit">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
        <?php
        $isEmpty = false;
    }
    if (@$_SESSION['auth'] > 0) {
        ?>
<a href="javascript: addAkce(<?php echo $page_part; ?>);"><img src="<?php echo URL; ?>frogSys/images/icons/add.png" alt="add" class="add_menu_in"></a>
    <?php
    }
		/*if ($isEmpty == true && @$_SESSION['auth'] > 0) {
			writeZmenaTypu($page_part);
		} */
    ?>
<script>
    //zavriPlanyAkci();
</script>
<?php
}

?>
