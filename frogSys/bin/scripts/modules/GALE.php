<?php

	function writeGalerie($page_part) {
		/*$sql = "SELECT * FROM `html` WHERE `parent` = ".$page_part."";
		$q = mysql_query($sql);
		if (!($res = mysql_fetch_array($q))) {
			$sql = "INSERT INTO `html` VALUES(NULL, 'Obsah úvodu k galerii', $page_part, 0, 0)";
			$q = mysql_query($sql);
		}
		$sql = "SELECT * FROM `html` WHERE `parent` = ".$page_part."";
		$q = mysql_query($sql);
		if ($res = mysql_fetch_array($q)) {
			if (is_logged_in()) {
				$zobraz = "style=\"min-height: 20px; width: 100%;\"";
			}
			echo "<div id=\"content_in_".$res['id']."\" $zobraz>";
			if (is_logged_in()) {
				writeEditPane("GalerieHtml", $res['id'].", ".$page_part, "E");
			}
			echo $res['content']."</div>";	
		}*/
            writeHtmlEditArea($page_part, '<h1>Galerie</h1>');
		
		if (@$_SESSION['auth'] > 0) {
		echo '
			<a href="javascript: addImages('.$page_part.');">
				<img src="'.URL.'frogSys/images/icons/addImages.png" alt="Vložit obrázky" />
			</a>
			<applet id="jumpLoaderApplet_GALE" name="jumpLoaderApplet_GALE"
					code="jmaster.jumploader.app.JumpLoaderApplet.class"
					archive="'.URL.'frogSys/java/jump_loader/mediautil_z.jar,/frogSys/java/jump_loader/sanselan_z.jar,/frogSys/java/jump_loader/jumploader_z.jar"
					width="0"
					height="0"
					mayscript>
					
			    	<param name="uc_sendImageMetadata" value="true"/>
			    	<param name="uc_imageEditorEnabled" value="true"/>
			        <param name="uc_useLosslessJpegTransformations" value="true"/>
					<param name="uc_uploadUrl" value="'.URL.'frogSys/bin/ajax/edit/modules/GALE.php?predmet=galerie&action=add_images&parent='.$page_part.'"/>
    			    <param name="uc_uploadScaledImages" value="true"/>
        			<param name="uc_scaledInstanceNames" value="small,large"/>
       				<param name="uc_scaledInstanceDimensions" value="200x150,800x600"/>
       				<param name="uc_scaledInstanceQualityFactors" value="800,800"/>
        			<param name="ac_fireUploaderFileAdded" value="true"/>
					<param name="ac_fireUploaderFileStatusChanged" value="true"/>
        			<param name="ac_fireUploaderStatusChanged" value="true"/>
					<param name="uc_fileNamePattern" value="^.+\.(?i)((jpg)|(jpe)|(jpeg)|(gif)|(png)|(tif)|(tiff))$"/>
        			<param name="vc_fileNamePattern" value="^.+\.(?i)((jpg)|(jpe)|(jpeg)|(gif)|(png)|(tif)|(tiff))$"/>
        			<param name="vc_disableLocalFileSystem" value="false"/>
        			<param name="vc_mainViewFileTreeViewVisible" value="true"/>
        			<param name="vc_mainViewFileListViewVisible" value="true"/>
        			<param name="uc_imageRotateEnabled" value="true"/>
        			<param name="uc_scaledInstancePreserveMetadata" value="true"/>
        			<param name="uc_deleteTempFilesOnRemove" value="true"/>
				</applet>
				<hr />
		';
		}
		
		$sql = "SELECT * FROM `galerie` WHERE `parent` = $page_part ORDER BY `order`";
		$q = mysql_query($sql);
		while ($res = mysql_fetch_array($q)) {
			if ($res['show'] == 1 || is_logged_in()) {
				echo '
				
				<div class="galerie" id="galerie_image_div_'.$res['id'].'">';
                                $trans = "";
				if (is_logged_in()) {
					if ($res['show'] == 0) {
						$check = "C";
						$trans = "style=\"opacity: 0.3; -moz-opacity: 0.3;\"";
					} else {
						$check = "Č";
						$trans = "";
					}
					writeEditPane("Galerie", $res['id'].", ".$page_part, "DM".$check);
				}
				echo '	<a href="'.URL.'userfiles/galerie/'.$res['id'].'.'.$res['name'].'" class="lightbox-image">
						<img '.$trans.' src="'.URL.'userfiles/galerie/thumbs/'.$res['id'].'.'.$res['name'].'" alt="'.$res['title'].'" title="'.$res['title'].'" id="image_'.$res['id'].'" class="galerie" />
					</a>
					';
				if (is_logged_in()) {
					echo '
						<input type="text" id="galerie_image_'.$res['id'].'" class="popisek" name="title" value="'.$res['title'].'" onblur="saveGalerie('.$res['id'].');" />
					';
				}
				echo '	
				</div>
				';
			}
		}
	}

?>
