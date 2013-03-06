<?php if (@$_SESSION['auth'] > 0) { ?>
		<div id="admin_menu">
			<div id="admin_akt_str">
				aktuální stránka: 
			</div>
			<div id="aktual_stranka">úvod</div>
			<a href="javascript: editAdmins();" id="admin_admin">
				administrátoři
			</a>
			<div id="admin_titulek">
				titulek: 
				<?php
					writeEditPane("Titulek", "", "E");
				?>
			</div>
			<div id="titulek">
				<?php writeTitulek(); ?>
			</div>
			<div id="admin_prihlasen">
				přihlášen jako: <span id="loged_as"><?php echo $_SESSION['user']; ?></span>
			</div>
			<a href="javascript: napoveda();" id="admin_napoveda">
				nápověda
			</a>
			<a href="javascript: odhlasit();" id="admin_odhlasit">
				odhlásit
			</a>
			
		</div>
<?php } ?>