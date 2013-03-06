<?php
	function writePage($pageId, $pageId2) {
		$sirkaSloupce = SIRKA_PAGE;
		$sql = "SELECT * FROM `page` WHERE `parent` = ".$pageId." ORDER BY `order`";
		$q = mysql_query($sql);
		$vr = false;
		while ($res = @mysql_fetch_array($q)) {
			if ($vr == true) {
				if (@$_SESSION['auth'] > 0) {
			?>
			<div class="vr" onmousedown="startPageResize(event, <?php echo $prevId; ?>, <?php echo $res['id']; ?>);" style="cursor: e-resize; display: block;">&nbsp;</div>
			<?php
				} else {
			?>
			<div class="vr">&nbsp;</div>
			<?php
				}
			}
			$prevId = $res['id'];
			$vr = true;
			$width = $res['width']/100*$sirkaSloupce-4;
			?>
			<div id="content_about_<?php echo $res['id']; ?>" class="content" onmousedown="aktualClickPart = <?php echo $res['id']; ?>;" style="width: <?php echo $width; ?>px;">
				<?php                           
				if (!isset($pageId2[$res['id']])) {                  
					$page_part = $res['first'];
				} else {
					$page_part = $pageId2[$res['id']];
				}
				if (@$_SESSION['auth'] > 0) {
				?>
					<div class="edit_pole" id="edit_pole_<?php echo $res['id']; ?>" style="width: 100%;">
						<p>editace sloupce</p>
						<?php
							writeZmenaTypu($page_part);
							writeEditPane("PageSloupec", $res['id'], "DEM");
						?>
					</div>
				<?php
				}
				?>
				<div class="content_in" id="content_<?php echo $res['id']; ?>">
				<?php
					writePagePart($page_part, $pageId);
				?>
				</div>
			</div>
			<?php
		}
		if ($vr == false) {
			if (@$_SESSION['auth'] > 0) {
				echo "<p>Rozvržení stránky není definováno.</p><p>Kliknutím na ikonu vložení sloupce vložíte sloupec.</p>";
			} else {
				echo "<p>Stránka nenalezena</p>";
			}
		}
		if (@$_SESSION['auth'] > 0) {
		?>
			<a href="javascript: addPageSloupec(<?php echo $pageId; ?>);">
				<img src="/images/icons/addSloupec.png" id="addSloupec" alt="vložit sloupec" class="add" onmouseover="changeWindow(this.id, false, false, <?php echo $sirkaSloupce;?>-73, false);" onmouseout="changeWindow(this.id, false, false, <?php echo $sirkaSloupce;?>-73+45, false);" />
			</a>
		<?php
		}
	}
	
	function writeZmenaTypu($page_part) {
		//<p>Pro změnu typu stránky klikni na změnit typ.</p>
		?>
		<a href="javascript: changeType(<?php echo $page_part; ?>);">
			<img src="/images/icons/changeType.png" alt="změnit typ" class="change_page" />
		</a>
		<?php
	}
	

?>
