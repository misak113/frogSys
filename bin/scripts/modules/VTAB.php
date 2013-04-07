<?php

function writeTabulka($page_part) {
	global $_SETING;
	$statistics = $_SETING['statistics'];

	$sql = 'SET SQL_BIG_SELECTS = 1;';
	mysql_query($sql);

	$id_souteze = writeNohejbalHead($page_part);

	// získání pořadí
	if (@$_GET['kolo']) {
		$actual_poradi = $_GET['kolo'];
	} else {
		$sql = "SELECT *
        FROM `vysledky_kolo`
        WHERE `datetime` < NOW() AND `sezona` = '".VYSL_SEZONA."'
        AND `id_souteze` = ".$id_souteze."
        ORDER BY `datetime` DESC";
		$q = mysql_query($sql);
		if ($res = mysql_fetch_array($q)) {
			$actual_poradi = $res['poradi'];
		} else {
			$actual_poradi = 1;
		}
	}

	$sql = "SELECT *
	FROM `vysledky_kolo`
	WHERE `sezona` = '".VYSL_SEZONA."'
	AND `id_souteze` = ".$id_souteze."
	ORDER BY `poradi`";
	$q = mysql_query($sql);
	$vsechnyPoradi = array();
	while ($res = mysql_fetch_array($q)) {
		$vsechnyPoradi[] = $res;
		$maxPoradi = $res['poradi'];
	}

	//set @sezona = 2012;
	//set @poradi = 13;
	//set @soutez = 2;
	$sql = "
-- by union

select id_domaci as id_tymu, nazev, web, link, group_concat(utkani_vyhral_nad_tymy) as utkani_vyhral_nad_tymy,

sum(utkani_domaci_vyhraly) + sum(utkani_remiza) + sum(utkani_hoste_vyhraly) as zapasy,
sum(utkani_domaci_vyhraly) as vyhry,
sum(utkani_remiza) as remizy,
sum(utkani_hoste_vyhraly) as prohry,
sum(kontumace) as kontumace,

sum(domaci_skore) as skore_plus,
sum(hoste_skore) as skore_minus,
sum(domaci_skore) - sum(hoste_skore) as skore_rozdil,

sum(utkani_domaci_vyhraly)*2 + sum(utkani_remiza) - sum(kontumace) as body


from (

(
# 1-UNION
select id_domaci, id_kola,

sum(utkani_remiza) as utkani_remiza,
sum(utkani_domaci_vyhraly) as utkani_domaci_vyhraly,
sum(utkani_hoste_vyhraly) as utkani_hoste_vyhraly,

sum(utkani_hoste_vyhraly*kontumace) as kontumace,
sum(zapas_domaci_vyhraly_skore) as domaci_skore,
sum(zapas_hoste_vyhraly_skore) as hoste_skore,

group_concat(IF(utkani_domaci_vyhraly, id_host, 0)) as utkani_vyhral_nad_tymy

from
(
# 2-SUBQUERY
select id_kola, id_utkani, kontumace, id_host, id_domaci,

sum(zapas_domaci_vyhraly) as zapas_domaci_vyhraly_skore,
sum(zapas_hoste_vyhraly) as zapas_hoste_vyhraly_skore,

sum(zapas_hoste_vyhraly) < sum(zapas_domaci_vyhraly) as utkani_domaci_vyhraly,
sum(zapas_hoste_vyhraly) > sum(zapas_domaci_vyhraly) as utkani_hoste_vyhraly,
sum(zapas_hoste_vyhraly) = sum(zapas_domaci_vyhraly) as utkani_remiza

from
(
# 1-SUBQUERY
select id_utkani, id_kola, kontumace, id_host, id_domaci,
sum(domaci > hoste) as vysledek_domaci_vyhraly,
sum(hoste > domaci) as vysledek_hoste_vyhraly,
#sum(domaci = hoste) as vysledek_remiza,

sum(hoste > domaci) < sum(domaci > hoste) as zapas_domaci_vyhraly,
sum(hoste > domaci) > sum(domaci > hoste) as zapas_hoste_vyhraly,
sum(hoste > domaci) = sum(domaci > hoste) as zapas_remiza


from vysledky_kolo
join vysledky_utkani using (id_kola)
join vysledky_zapas using (id_utkani)
join vysledky_vysledek using (id_zapasu)

WHERE sezona = @sezona
AND poradi <= @poradi
AND id_souteze = @soutez

group by id_zapasu
# /1-SUBQUERY
) zapasy

group by id_utkani
# /2-SUBQUERY
) utkani

group by id_domaci
# /1-UNION
)

UNION

(
# 2-UNION
select id_host as id_domaci, id_kola,

sum(utkani_remiza) as utkani_remiza,
sum(utkani_domaci_vyhraly) as utkani_domaci_vyhraly,
sum(utkani_hoste_vyhraly) as utkani_hoste_vyhraly,

sum(utkani_hoste_vyhraly*kontumace) as kontumace,
sum(zapas_domaci_vyhraly_skore) as domaci_skore,
sum(zapas_hoste_vyhraly_skore) as hoste_skore,

group_concat(IF(utkani_domaci_vyhraly, id_domaci, 0)) as utkani_vyhral_nad_tymy

from
(
# 2-SUBQUERY
select id_kola, id_utkani, kontumace, id_host, id_domaci,

sum(zapas_domaci_vyhraly) as zapas_domaci_vyhraly_skore,
sum(zapas_hoste_vyhraly) as zapas_hoste_vyhraly_skore,

sum(zapas_hoste_vyhraly) < sum(zapas_domaci_vyhraly) as utkani_domaci_vyhraly,
sum(zapas_hoste_vyhraly) > sum(zapas_domaci_vyhraly) as utkani_hoste_vyhraly,
sum(zapas_hoste_vyhraly) = sum(zapas_domaci_vyhraly) as utkani_remiza

from
(
# 1-SUBQUERY
select id_utkani, id_kola, kontumace, id_host, id_domaci,
sum(domaci < hoste) as vysledek_domaci_vyhraly,
sum(hoste < domaci) as vysledek_hoste_vyhraly,
#sum(domaci = hoste) as vysledek_remiza,

sum(hoste > domaci) > sum(domaci > hoste) as zapas_domaci_vyhraly,
sum(hoste > domaci) < sum(domaci > hoste) as zapas_hoste_vyhraly,
sum(hoste > domaci) = sum(domaci > hoste) as zapas_remiza


from vysledky_kolo
join vysledky_utkani using (id_kola)
join vysledky_zapas using (id_utkani)
join vysledky_vysledek using (id_zapasu)

WHERE sezona = @sezona
AND poradi <= @poradi
AND id_souteze = @soutez

group by id_zapasu
# /1-SUBQUERY
) zapasy

group by id_utkani
# /2-SUBQUERY
) utkani

group by id_host
# /2-UNION
)

) AS tabulka
join vysledky_tym on (id_domaci = id_tymu)

group by id_domaci

order by body desc, zapasy, skore_rozdil desc, skore_plus desc
	";

	$sql = str_replace('@sezona', VYSL_SEZONA, $sql);
	$sql = str_replace('@soutez', $id_souteze, $sql);
	$sql = str_replace('@poradi', $actual_poradi, $sql);

	$q = mysql_query($sql);
	$table = array();
	while ($res = mysql_fetch_array($q)) {
		$winWith = explode(',', $res['utkani_vyhral_nad_tymy']);
		$vyhral = array();
		foreach ($winWith as $team) {
			@$vyhral[$team]++;
		}
		$res['utkani_vyhral_nad_tymy'] = $vyhral;
		$table[] = $res;
	}

	// sorting by vzajemna utkani
	foreach ($table as $i => $tym) {
		if (isset($table[$i+1])
				&& $tym['body'] == $table[$i+1]['body']
				&& isset($table[$i+1]['utkani_vyhral_nad_tymy'][$tym['id_tymu']])
				&& $table[$i+1]['utkani_vyhral_nad_tymy'][$tym['id_tymu']]
						> @$tym['utkani_vyhral_nad_tymy'][$table[$i+1]['id_tymu']]
		) {
			$tmp = $table[$i+1];
			$table[$i+1] = $table[$i];
			$table[$i] = $tmp;
		}
	}


	writeHtmlEditArea($page_part, "<h2>Tabulka</h2>");

	?>
<table class="vysledky_tabulka">
	<tr>
		<th title="Pořadí">#</th>
		<th>Název</th>
		<th>web</th>
		<th title="Zápasy">Z</th>
		<th title="Výhry">V</th>
		<th title="Remízy">R</th>
		<th title="Prohry">P <span title="Kontumace">(K)</span></th>
		<th>Skóre</th>
		<th title="Body">B</th>
	</tr>

	<?php
	if (is_array($table) && !empty($table)) {

		$poradi = 0;
		foreach ($table as $tym) {
			if ($tym['nazev'] == 'VOLNO') { //TODO
				continue;
			}
			?>
			<tr>
				<td class="poradi"><?php $poradi++; echo $poradi; ?>.</td>
				<td class="nazev">
					<a href="<?php echo URL.$statistics; ?>/<?php echo $tym['link']; ?>/"><?php echo $tym['nazev']; ?></a>
				</td>
			<td class="web">
				<?php if (is_logged_in()) { ?>
				<span>http://<input type="text" value="<?php echo $tym['web']; ?>"
									id="web_pages_<?php echo $tym['id_tymu'] ?>" class="web_pages" />
		<input type="button" value="Uložit"
			   onclick="ulozitWebPagesTymu(<?php echo $tym['id_tymu'] ?>)"></span>
				<?php } else { ?>
				<?php if ($tym['web']) { ?>
					<a href="http://<?php echo $tym['web']; ?>" target="_blank">web &gt;</a></td>
	<?php } ?>
				<?php } ?>
				<td class="zapasy" title="Zápasy">
					<?php echo $tym['zapasy']; ?>
				</td>
				<td class="vyhry" title="Výhry">
					<?php echo $tym['vyhry']; ?>
				</td>
				<td class="remizy" title="Remízy">
					<?php echo $tym['remizy']; ?>
				</td>
				<td class="prohry" title="Prohry">
					<?php echo $tym['prohry']; ?>
					<span title="Kontumace"><?php echo $tym['kontumace'] ?' ('.$tym['kontumace'].')' :''; ?></span>
				</td>
				<td class="skore">
					<?php echo $tym['skore_plus'].':'.$tym['skore_minus']; ?>
				</td>
				<td class="body" title="Body">
					<?php echo $tym['body']; ?>
				</td>
			</tr>
			<?php
		}
	}
	?>

</table>
<?php

	// výběr pořadí
	echo '<div class="vysledky_kola"> Kolo: ';
	foreach ($vsechnyPoradi as $res) {
		if ($actual_poradi == $res['poradi']) {
			echo '<span class="actual_poradi">'.$res['poradi'].'</span>, ';
		} else {
			echo '<a href="./?kolo='.$res['poradi'].'" class="poradi">'.$res['poradi'].'</a>, ';
		}
	}
	echo '</div>';

}
