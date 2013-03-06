<?php
//vypisuje menu
	function writeMenu($id) {
		if ($id == 0) {
			$sql = "SELECT * FROM `menu` WHERE `parent` = '$id' ORDER BY `order`";
			$q = mysql_query($sql);
			while ($res = mysql_fetch_array($q)) {
				if ($res['visible'] == 0 && @$_SESSION['auth'] == 0) {
					continue;
				}
				$hiden = "";
				if ($res['visible'] == 0) {
					$hiden = " style=\"font-style: italic; text-decoration: line-through; color: darkgrey;\"";
				}
				?>
				<div class="menu_left_head" id="menu_left_head_<?php echo $res['id']; ?>"<?php echo $hiden; ?>>
					<?php
					if (@$_SESSION['auth'] > 0) {
						echo $res['name'];
						writeEditPane("MenuHead", $res['id'], "EDM");
					} else {
						echo $res['name'];
					}
					?>
				</div>
				<div class="menu_left" id="menu_left_<?php echo $res['id']; ?>">
					<div class="menu_left_in" id="menu_left_in_<?php echo $res['id']; ?>">
						<?php writeMenu($res['id']); ?>
					</div>
				</div>
				<?php
			}
			if (@$_SESSION['auth'] > 0) {
				?>
				<a href="javascript: addMenu(0);"><img src="/images/icons/addHeadMenu.png" alt="add" class="addHeadMenu" /></a>
				<?php
				//<a href="javascript: openMenu();"><img src="/images/icons/open.png" alt="open" class="open" /></a>
			}
		} else {
				$sql = "SELECT * FROM `menu` WHERE `parent` = '$id' ORDER BY `order`";
				$q = mysql_query($sql);
				$i = 1;
				while ($res = mysql_fetch_array($q)) {
					$i++;
					if ($res['visible'] == 0 && @$_SESSION['auth'] == 0) {
						continue;
					}
					$hiden = "";
					if ($res['visible'] == 0) {
						$hiden = " style=\"font-style: italic; text-decoration: line-through; color: darkgrey;\"";
					}
					?>
						<div class="menu_left_item" id="menu_item_<?php echo $res['id']; ?>">
							<?php
							if (@$_SESSION['auth'] > 0) {
							?>
							<a href="javascript: loadPage(<?php echo $res['id']; ?>);"<?php echo $hiden; ?>><?php echo $res['name']; ?></a>
						    <?php 
								writeEditPane("Menu", $res['id'], "EDM");
							} else {
								if ($i == 1) {
								?>
								<a href="/"><?php echo $res['name']; ?></a>
								<?php
								} else {
								?>
								<a href="/<?php echo $res['link']; ?>/"><?php echo $res['name']; ?></a>
								<?php
								}
							}
							?>
						</div>
					<?php
				}
		
			if (@$_SESSION['auth'] > 0) {
				?>
				<a href="javascript: addMenu(<?php echo $id; ?>);"><img src="/images/icons/add.png" alt="add" class="add" /></a>
				<?php
				//<a href="javascript: openMenu();"><img src="/images/icons/open.png" alt="open" class="open" /></a>
			}
		}
	}
?>
