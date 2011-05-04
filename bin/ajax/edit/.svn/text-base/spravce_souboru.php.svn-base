<?php

if ($_POST['action'] == "get_soubory") {
    echo "<h1>soubory</h1>";
    if (@$_SESSION['auth'] > 0) {
        echo '
			<a href="javascript: addFiles();">
				<img src="'.URL.'frogSys/images/icons/add.png" alt="Vložit soubory" onmouseover="showInfo(event, \'Vložit soubory\', this);" />
			</a>
			<applet id="jumpLoaderApplet_spravce_souboru" name="jumpLoaderApplet_spravce_souboru"
					code="jmaster.jumploader.app.JumpLoaderApplet.class"
					archive="'.URL.'frogSys/java/jump_loader/mediautil_z.jar,/frogSys/java/jump_loader/sanselan_z.jar,/frogSys/java/jump_loader/jumploader_z.jar"
					width="0"
					height="0"
					mayscript>

			    	<param name="uc_sendImageMetadata" value="true"/>
			    	<param name="uc_imageEditorEnabled" value="true"/>
			        <param name="uc_useLosslessJpegTransformations" value="true"/>
					<param name="uc_uploadUrl" value="'.URL.'frogSys/bin/ajax/edit/spravce_souboru.php?predmet=spravce_souboru&action=add_files"/>
                                <param name="ac_fireUploaderFileAdded" value="true"/>
					<param name="ac_fireUploaderFileStatusChanged" value="true"/>
        			<param name="ac_fireUploaderStatusChanged" value="true"/>
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
    $files = "/userfiles/file/";
    $dir = dir(PATH.$files);
    echo "<table class=\"spravce_souboru\"><tr><th></th><th>Název</th><th>Velikost</th><th>Vloženo</th><th>Cesta</th><th>Smazat</th></tr>";
    $i = 0;
    while ($file = $dir->read()) {
        $fils[$i] = $file;
        $i++;
    }
    sort($fils);
    $i = 0;
    while ($file = @$fils[$i]) {
        $i++;
        $filename = PATH.$files.$file;
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
            $casti = explode(".", $file);
            if (count($casti) > 1) {
                $pripona = strtolower($casti[count($casti)-1]);
            } else {
                $pripona = "none";
            }
            echo '
<tr>
<td>
<img src="'.URL.'frogSys/images/icons/pripony/'.$pripona.'.gif" alt="'.$pripona.'" />
</td>
<td>
<a href="'.$files.$file.'" target="_blank" style="overflow:hidden; width: 200px; display: block;">
'.$file.'
</a>
</td>
<td>'.round($size, 1).' '.$mj.'B</td>
<td>'.date("j. n. Y, G:i:s", filectime($filename)).'</td>
<td>
<input type="text" value="'.str_replace("//", "/", URL.$files.$file).'" style="width: 200px;" />
</td><td>';
            writeEditPane("Soubor", "'".$file."'", "D");
            echo '</td></tr>';
        }
    }
    echo "</table>";
}

if ($_POST['action'] == "delete_soubor") {
    unlink(PATH."/userfiles/file/".$_POST['file']);
    echo "Soubor byl smazán.";
}
if ($_POST['action'] == "delete_soubor_database") {
    $sql = "DELETE FROM `spravce_souboru` WHERE `id` = ".$_POST['id']."";
    mysql_query($sql);
    echo "Soubor byl odebrán.";
}
if ($_POST['action'] == "select_file") {
    $files = "/userfiles/file/";
    $dir = dir(PATH.$files);
    echo "<table class=\"spravce_souboru\"><tr><th></th><th>Název</th><th>Velikost</th><th>Vloženo</th></tr>";
    $i = 0;
    while ($file = $dir->read()) {
        $fils[$i] = $file;
        $i++;
    }
    sort($fils);
    $i = 0;
    while ($file = $fils[$i]) {
        $i++;
        $filename = PATH.$files.$file;
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
            $casti = explode(".", $file);
            if (count($casti) > 1) {
                $pripona = strtolower($casti[count($casti)-1]);
            } else {
                $pripona = "none";
            }
            $vypis = '<span><img src=&quot;/frogSys/images/icons/pripony/'.$pripona.'.gif&quot; alt=&quot;'.$pripona.'&quot; /></span> <span><a href=&quot;'.$files.$file.'&quot; target=&quot;_blank&quot;>'.$file.'</a></span><span style=&quot;margin-left: 10px;&quot;>'.round($size, 1).' '.$mj.'B</span>';
            echo '
<tr>
<td>
<img src="'.URL.'frogSys/images/icons/pripony/'.$pripona.'.gif" alt="'.$pripona.'" />
</td>
<td>
<a href="javascript: call_back_file_selected_'.$_POST['type'].'(\''.$files.$file.'\', '.$_POST['id'].', \''.$vypis.'\');">
'.$file.'
</a>
</td>
<td>'.round($size, 1).' '.$mj.'B</td>
<td>'.date("j. n. Y, G:i:s", filectime($filename)).'</td>
</tr>';
        }
    }
    echo "</table>";
}






if (@$_GET['action'] == "add_files") {
    require_once "../../../../config/database.php";
    include "../../../bin/scripts.php";
    if (@$_SESSION['auth'] > 0) {
    //
    //	specify file parameter name
        $file_param_name = 'file';

        //
        //	retrieve uploaded file name
        $file_name = $_FILES[ $file_param_name ][ 'name' ];

        //
        //	retrieve uploaded file path (temporary stored by php engine)
        $source_file_path = $_FILES[ $file_param_name ][ 'tmp_name' ];

        //
        //	construct target file path (desired location of uploaded file) -
        //	here we put to the web server document root (i.e. '/home/wwwroot')
        //	using user supplied file name
        $fil_name = str_replace(" ", "_", $file_name);
        $target_file_path = PATH."/userfiles/file/".$fil_name;
        $casti = explode(".", $file_name);
        if (count($casti) > 1) {
            $pripona = strtolower($casti[count($casti)-1]);
        } else {
            $pripona = "none";
        }
        if ($pripona == "php") {
            $target_file_path .= ".txt";
        }
        copy($source_file_path, $target_file_path);

    }
}
?>
