<?php

	/**
	 * @predmet nazev v jednotlivych funkcich: "Menu"
	 * @parametry vsechny parametry s carky: "6, 23" 
	 * @druhy jake editacni ikonky budou zobrazeny	E - edit
	 * 												D - delete
	 * 												M - move
	 * 												S - edit style
	 * 												U - users	
	 * 												R - radio select
	 * 												C(Č) - checkbox	 	  
	 * 											: "EDS" 	 	 	 
	 */	 	 	
	function writeEditPane($predmet, $parametry, $druhy) {
	?>
		<div class="edit_pane_<?php echo $predmet; ?>">
			<?php
				if (strrpos($druhy, "M") !== false) {
			?>
			<!--<img src="<?php echo URL; ?>frogSys/images/icons/move.png" alt="move" class="move" onmousedown="move<?php echo $predmet; ?>(event, <?php echo $parametry; ?>);" />-->
                        <div class="move" onmousedown="move<?php echo $predmet; ?>(event, <?php echo $parametry; ?>);" style="background-image: url('<?php echo URL; ?>frogSys/images/icons/move.png'); cursor: Move;">&nbsp;</div>
			<?php
				}
			?>
			<?php
				if (strrpos($druhy, "E") !== false) {
			?>
			<a href="javascript: edit<?php echo $predmet; ?>(<?php echo $parametry; ?>);">
				<img src="<?php echo URL; ?>frogSys/images/icons/edit.png" onmouseover="showInfo(event, 'Editovat', this);" alt="edit" class="edit" />
			</a>
			<?php
				}
			?>
			<?php
				if (strrpos($druhy, "D") !== false) {
			?>
			<a href="javascript: delete<?php echo $predmet; ?>(<?php echo $parametry; ?>);">
				<img src="<?php echo URL; ?>frogSys/images/icons/delete.png" onmouseover="showInfo(event, 'Smazat', this);" alt="delete" class="delete" />
			</a>
			<?php
				}
			?>
			<?php
				if (strrpos($druhy, "U") !== false) {
			?>
			<a href="javascript: users<?php echo $predmet; ?>(<?php echo $parametry; ?>);">
				<img src="<?php echo URL; ?>frogSys/images/icons/users.png" onmouseover="showInfo(event, 'Více', this);" alt="users" class="users" />
			</a>
			<?php
				}
			?>
			<?php
				if (strrpos($druhy, "S") !== false) {
			?>
			<a href="javascript: editStyle<?php echo $predmet; ?>(<?php echo $parametry; ?>);">
					<img src="<?php echo URL; ?>frogSys/images/icons/editStyle.png" onmouseover="showInfo(event, 'Editovat styl', this);" alt="edit style" class="edit_style" />
				</a>
			<?php
				}
			?>
			<?php
				if (strrpos($druhy, "R") !== false) {
			?>
			<input type="radio" name="radio_select" onchange="radioSelect<?php echo $predmet; ?>(<?php echo $parametry; ?>);" class="radio_select" />
			<?php
				}
			?>
			<?php
				if (strrpos($druhy, "C") !== false || strrpos($druhy, "Č") !== false) {
                                    $checked = "";
					if (strrpos($druhy, "Č") !== false) {
						$checked = "checked=\"checked\"";
					}
			?>
			<input <?php echo $checked; ?> type="checkbox" name="checkbox" onchange="checkboxSelect<?php echo $predmet; ?>(<?php echo $parametry; ?>);" class="checkbox" />
			<?php
				}
			?>
		</div>
	<?php
	}

?>
