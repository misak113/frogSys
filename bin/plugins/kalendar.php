<?php
    //require_once "../../../config/database.php";
	/*
		Pro vložení použijte například následující kód:
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
				? >
		
		V hlavičce je třeba importovat JavaScriptový soubor kalendar.js	
		
		Je potřeba plugin IAWindows.js		
	*/


	if (isset($_POST['k_id'])) {
		$k_id = $_POST['k_id'];
		$k_start = $_POST['k_start'];
		$k_stop = $_POST['k_stop'];
		$k_mesic = $_POST['k_mesic'];
		$k_rok = $_POST['k_rok'];
		$k_editable = $_POST['k_editable'];
                
	}
	if (@$_POST['echo'] == "true") {
            require_once "../../../config/database.php";
		writeKalendar($k_id, $k_start, $k_stop, $k_mesic, $k_rok, $k_editable);
	}

	function writeKalendar($id, $start, $stop, $mesic, $rok, $editable) {
		$mesice = Array("","Leden","Únor","Březen","Duben","Květen","Červen","Červenec","Srpen","Září","Říjen","Listopad","Prosinec");
		if ($mesic == 0 || $rok == 0) {
			if ($start == "0000-00-00") {
				$mesic = 0+date("n");
				$rok = 0+date("Y");
			} else {
				$st = explode("-", $start);
				$mesic = 0+$st[1];
				$rok = 0+$st[0];
			}
		}
		$mesicpred = $mesic-1;
		$rokpred = $rok;
		if($mesicpred < 1) {
			$mesicpred = 12;
			$rokpred = $rokpred-1;
		}
		$mesicpo = $mesic+1;
		$rokpo = $rok;
		if($mesicpo > 12) {
			$mesicpo = 1;
			$rokpo = $rokpo+1;
		}
		$timepred = mktime(0, 0, 0, $mesicpred, 1, $rokpred);
		$dnupred = date("t", $timepred);
		if (date("w", mktime(0, 0, 0, $mesicpred, $dnupred, $rokpred)) == 0) {
			$firstden = 1;
			$firstmesic = $mesic;
			$firstrok = $rok;
		} else {
			for ($i=$dnupred;;$i--) {
				if (date("w", mktime(0, 0, 0, $mesicpred, $i, $rokpred)) == 1) {
					$firstden = $i;
					$firstmesic = $mesicpred;
					$firstrok = $rokpred;
					break;
				}
			}
		}
		echo '
		<table class="kalendar">
			<tr>
				<td> <a href="javascript: var k_id = \''.$id.'\'; var a = postAjaxRequest(\''.URL.'frogSys/bin/plugins/kalendar.php\', \'echo=true&k_id='.$id.'&k_start=\'+document.getElementById(\'plan_akci_kdy_'.$id.'\').value+\'&k_stop=\'+document.getElementById(\'plan_akci_do_'.$id.'\').value+\'&k_mesic='.$mesicpred.'&k_rok='.$rokpred.'&k_editable='.$editable.'\', zobrazNovyMesic);">&lt;</a> </td>
				<td colspan="6"> '.$mesice[$mesic].' &nbsp; '.$mesic.'. '.$rok.' </td>
				<td> <a href="javascript: var k_id = \''.$id.'\'; var a = postAjaxRequest(\''.URL.'frogSys/bin/plugins/kalendar.php\', \'echo=true&k_id='.$id.'&k_start=\'+document.getElementById(\'plan_akci_kdy_'.$id.'\').value+\'&k_stop=\'+document.getElementById(\'plan_akci_do_'.$id.'\').value+\'&k_mesic='.$mesicpo.'&k_rok='.$rokpo.'&k_editable='.$editable.'\', zobrazNovyMesic);">&gt;</a> </td>
			</tr>
			<tr>
				<td>  </td>
				<td> Po </td>
				<td> Út </td>
				<td> St </td>
				<td> Čt </td>
				<td> Pá </td>
				<td> So </td>
				<td> Ne </td>
			
		';
		
		$cdne = 0;
		while(true) {
			$cdne++;
			if (date("w", mktime(0, 0, 0, $firstmesic, $firstden, $firstrok)) == 1) {
				echo '
					</tr>
					<tr>
						<td> '.date("W", mktime(0, 0, 0, $firstmesic, $firstden, $firstrok)).' </td>
				';
			}
			
			echo '<td id="kalendar_den_'.$id.'_'.$cdne.'" title="'.date("Y-m-d", mktime(0, 0, 0, $firstmesic, $firstden, $firstrok)).'" style="';
			$stops = explode("-", $stop);
			$starts = explode("-", $start);
			if (mktime(0, 0, 0, $firstmesic, $firstden, $firstrok) <= mktime(0, 0, 0, $stops[1], $stops[2], $stops[0]) && mktime(0, 0, 0, $firstmesic, $firstden, $firstrok) >= mktime(0, 0, 0, $starts[1], $starts[2], $starts[0])) {
				echo 'background-color: #C0C0C0;';
			}
			echo '"> <a href="javascript: var k_id = \''.$id.'\';';
			if ($editable == "true") {
				echo ' vybranoDatum(\''.date("Y-m-d", mktime(0, 0, 0, $firstmesic, $firstden, $firstrok)).'\');';
			}
			echo '" class="';
			if ($firstmesic != $mesic) {
				echo "un";
			}
			echo 'active">';
			if ($firstrok."-".$firstmesic."-".$firstden == date("Y-n-j")) {
				echo '<u><b>';
			}
			echo $firstden;
			if ($firstrok."-".$firstmesic."-".$firstden == date("Y-n-j")) {
				echo '</b></u>';
			}
			echo '</a> </td>';
			
			$firstden++;
			if ($firstden > date("t", mktime(0, 0, 0, $firstmesic, 1, $firstrok))) {
				$firstden = 1;
				$firstmesic++;
				if ($firstmesic > 12) {
					$firstmesic = 1;
					$firstrok++;
				}
			}
			if (($firstrok*12)+$firstmesic > ($rok*12)+$mesic && date("w", mktime(0, 0, 0, $firstmesic, $firstden, $firstrok)) == 1) {
				break;
			}
		}
		
		echo '</tr></table>';
		?>				
		<input type="hidden" value="<?php echo $start; ?>" id="plan_akci_kdy_<?php echo $id; ?>">
		<input type="hidden" value="<?php echo $stop; ?>" id="plan_akci_do_<?php echo $id; ?>">
		<?php
	}
	
?>
