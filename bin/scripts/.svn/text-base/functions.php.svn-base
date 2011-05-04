<?php

$tyden = array("Neděle", "Pondělí", "Úterý", "Středa", "Čtvrtek", "Pátek", "Sobota");
$rok = array("leden", "únor", "březen", "duben", "květen", "červen", "červenec", "srpen", "září", "říjen", "listopad", "prosinec");

function createLink($name) {
    $name = strtolower($name);
    $co = array("ě", "ř", "ť", "š", "ď", "č", "ň", "é", "ú", "í", "ó", "á", "ý", "ů", "ž"," ");
    $cim = array("e", "r", "t", "s", "d", "c", "n", "e", "u", "i", "o", "a", "y", "u", "z","-");
    $allowedChars = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","-","0","1","2","3","4","5","6","7","8","9");

    $name = str_replace($co, $cim, $name);
    $name = str_replace("--", "-", $name);
    $link = "";
    for($i = 0;$i < strlen($name);$i++) {
        if (in_array($name[$i], $allowedChars)) {
            $link .= $name[$i];
        }
    }
    return $link;
}

function subval_sort($a,$subkey) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	arsort($b, SORT_NUMERIC);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}
	return $c;
}

function strip_html_tags( $text )
{
    $text = preg_replace(
        array(
          // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
          // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
            "\n\$0", "\n\$0",
        ),
        $text );
    return strip_tags( $text );
} 
	

/**
 * Unzip the source_file in the destination dir
 *
 * @param   string      The path to the ZIP-file.
 * @param   string      The path where the zipfile should be unpacked, if false the directory of the zip-file is used
 * @param   boolean     Indicates if the files will be unpacked in a directory with the name of the zip-file (true) or not (false) (only if the destination directory is set to false!)
 * @param   boolean     Overwrite existing files (true) or not (false)
 * 
 * @return  boolean     Succesful or not
 */
function unzip($src_file, $dest_dir=false, $create_zip_name_dir=true, $overwrite=true)
{
  if(function_exists("zip_open"))
  {   
      if(!is_resource(zip_open($src_file)))
      { 
          $src_file=dirname($_SERVER['SCRIPT_FILENAME'])."/".$src_file; 
      }
      
      if (is_resource($zip = zip_open($src_file)))
      {          
          $splitter = ($create_zip_name_dir === true) ? "." : "/";
          if ($dest_dir === false) $dest_dir = substr($src_file, 0, strrpos($src_file, $splitter))."/";
         
          // Create the directories to the destination dir if they don't already exist
          create_dirs($dest_dir);

          // For every file in the zip-packet
          while ($zip_entry = zip_read($zip))
          {
            // Now we're going to create the directories in the destination directories
           
            // If the file is not in the root dir
            $pos_last_slash = strrpos(zip_entry_name($zip_entry), "/");
            if ($pos_last_slash !== false)
            {
              // Create the directory where the zip-entry should be saved (with a "/" at the end)
              create_dirs($dest_dir.substr(zip_entry_name($zip_entry), 0, $pos_last_slash+1));
            }

            // Open the entry
            if (zip_entry_open($zip,$zip_entry,"r"))
            {
             
              // The name of the file to save on the disk
              $file_name = $dest_dir.zip_entry_name($zip_entry);
             
              // Check if the files should be overwritten or not
              if ($overwrite === true || $overwrite === false && !is_file($file_name))
              {
                // Get the content of the zip entry
                $fstream = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));           
                
                if(!is_dir($file_name))            
                file_put_contents($file_name, $fstream );
                // Set the rights
                if(file_exists($file_name))
                {
                    chmod($file_name, 0777);
                    echo "<span style=\"color:#1da319;\">file saved: </span>".$file_name."<br />";
                }
                else
                {
                    echo "<span style=\"color:red;\">file not found: </span>".$file_name."<br />";
                }
              }
             
              // Close the entry
              zip_entry_close($zip_entry);
            }      
          }
          // Close the zip-file
          zip_close($zip);
      }
      else
      {
        echo "No Zip Archive Found.";
        return false;
      }
     
      return true;
  }
  else
  {
      if(version_compare(phpversion(), "5.2.0", "<"))
      $infoVersion="(use PHP 5.2.0 or later)";
      
      echo "You need to install/enable the php_zip.dll extension $infoVersion"; 
  }
}

function create_dirs($path)
{
  if (!is_dir($path))
  {
    $directory_path = "";
    $directories = explode("/",$path);
    array_pop($directories);
   
    foreach($directories as $directory)
    {
      $directory_path .= $directory."/";
      if (!is_dir($directory_path))
      {
        mkdir($directory_path);
        chmod($directory_path, 0777);
      }
    }
  }
}


function get_mail_header($predmet, $from_name="Info", $from_mail="no-replay") {
  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=utf-8\r\n";
  $headers .= "From: =?utf-8?B?".base64_encode($from_name)."?= <".$from_mail.">\r\n";
  //$headers .= "To: ".$_POST['email'].", ".ADMIN_MAIL."\r\n";
  $headers .= "Bcc: ".$from_mail."\r\n";
  $headers .= "Subject: =?utf-8?B?".base64_encode($predmet)."?=\r\n";
  //$headers .= "Date: ".Time()."\r\n";
  $headers .= "Reply-To: ".$from_name." <".$from_mail.">\r\n";
  //$headers .= "Return-Path: ".PAGE_NAME." <".ADMIN_MAIL.">\r\n";
  $headers .= "X-Priority: 2\r\n";
  $headers .= "X-MSMail-Priority: Normal\r\n";
  $headers .= "X-Mailer: PHP/".phpversion()."\r\n";
  $headers .= "Content-Transfer-Encoding: 8bit\r\n";
  return $headers;
}

function strip_no_a_html_tags($text) {
    $t = str_replace("<a ", "#change#&lt;a #", $text);
    $t = str_replace("</a>", "#change#&lt;/a>#", $t);
    $t = strip_html_tags($t);
    $t = str_replace("#change#&lt;a #", "<a ", $t);
    $t = str_replace("#change#&lt;/a>#", "</a>", $t);
    return $t;
}

?>
