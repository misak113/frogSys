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
			<img src="/images/icons/move.png" alt="move" class="move" onmousedown="move<?php echo $predmet; ?>(event, <?php echo $parametry; ?>);" />
			<?php
				}
			?>
			<?php
				if (strrpos($druhy, "E") !== false) {
			?>
			<a href="javascript: edit<?php echo $predmet; ?>(<?php echo $parametry; ?>);">
				<img src="/images/icons/edit.png" alt="edit" class="edit" />
			</a>
			<?php
				}
			?>
			<?php
				if (strrpos($druhy, "D") !== false) {
			?>
			<a href="javascript: delete<?php echo $predmet; ?>(<?php echo $parametry; ?>);">
				<img src="/images/icons/delete.png" alt="delete" class="delete" />
			</a>
			<?php
				}
			?>
			<?php
				if (strrpos($druhy, "U") !== false) {
			?>
			<a href="javascript: users<?php echo $predmet; ?>(<?php echo $parametry; ?>);">
				<img src="/images/icons/users.png" alt="users" class="users" />
			</a>
			<?php
				}
			?>
			<?php
				if (strrpos($druhy, "S") !== false) {
			?>
			<a href="javascript: editStyle<?php echo $predmet; ?>(<?php echo $parametry; ?>);">
					<img src="/images/icons/editStyle.png" alt="edit style" class="edit_style" />
				</a>
			<?php
				}
			?>
			<?php
				if (strrpos($druhy, "R") !== false) {
			?>
			<input type="radio" name="radio_select" onchange="radioSelect<?php echo $predmet; ?>(<?php echo $parametry; ?>);" class="radio_select">
			<?php
				}
			?>
			<?php
				if (strrpos($druhy, "C") !== false || strrpos($druhy, "Č") !== false) {
					if (strrpos($druhy, "Č") !== false) {
						$checked = "checked";
					}
			?>
			<input <?php echo $checked; ?> type="checkbox" name="checkbox" onchange="checkboxSelect<?php echo $predmet; ?>(<?php echo $parametry; ?>);" class="checkbox">
			<?php
				}
			?>
		</div>
	<?php
	}

?>
