<?php

$tyden = array("Neděle", "Pondělí", "Úterý", "Středa", "Čtvrtek", "Pátek", "Sobota");
$rok = array("leden", "únor", "březen", "duben", "květen", "červen", "červenec", "srpen", "září", "říjen", "listopad", "prosinec");

/**
 * @param array|int $priv
 * @param int $additional
 */
function is_logged_in($priv = array(1, 2), $additional = null) {//_d($priv);_d($_SESSION['auth']);
    // udělá pole z priv
    if (!is_array($priv)) $priv = array($priv);
    // vše v poli na int
    foreach ($priv as $key => &$value) { $priv[$key] = (int)$value; }
    // stáhne auth z session
    $auth = (int)(isset($_SESSION['auth']) ? $_SESSION['auth'] : 0);
    // pokud má právo, porovnává dál
    if (in_array($auth, $priv)) {
        // pokud je super admin, nebo hlavní admin, rovnou vracej true
        if ($auth == 1 || $auth == 2) {
            return true;
        }
        // pokud je zadán additional, kontŕoluje ten
        if ($additional !== null) {
            $sessionAdditional = isset($_SESSION['additional_id']) ? $_SESSION['additional_id'] : 0;
            // pokud additional neni pole, tak ho udělej
            if (!is_array($sessionAdditional)) $sessionAdditional = array($additional);
            // vše v poli na int
            foreach ($sessionAdditional as $key => &$value) { $sessionAdditional[$key] = (int)$value; }
            // pokud je v sessione tennto additional, vrať true
            if (in_array($additional, $sessionAdditional)) {
                return true;
            } else {
                // pokud nemá pravo na tento additional, vrať false
                return false;
            }
        } else {
            // pokud není additional zadán, vrať že může true
            return true;
        }
    } else {
        return false;
    }
}

function loadModule($name = 'Module', $type = 'scripts') {
    if ($name === 'Module') {
        $filename = PATH . "/frogSys/bin/Module.php";
    } else {
        $filename = PATH . "/frogSys/bin/" . $type . "/modules/" . $name . ".php";
    }
    if (!file_exists($filename)) {
        return false;
    } else {
        require_once $filename;
        return true;
    }
}

function _t($text) {
    return $text;
}

function createLink($name) {
    $name = strtolower($name);
    $co = array("ě", "ř", "ť", "š", "ď", "č", "ň", "é", "ú", "í", "ó", "á", "ý", "ů", "ž", " ", "Ě", "Ř", "Ť", "Š", "Ď", "Č", "Ň", "É", "Ú", "Í", "Ó", "Á", "Ý", "Ů", "Ž");
    $cim = array("e", "r", "t", "s", "d", "c", "n", "e", "u", "i", "o", "a", "y", "u", "z", "-", "e", "r", "t", "s", "d", "c", "n", "e", "u", "i", "o", "a", "y", "u", "z");
    $allowedChars = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "-", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9");

    $name = str_replace($co, $cim, $name);
    $name = str_replace("--", "-", $name);
    $link = "";
    for ($i = 0; $i < strlen($name); $i++) {
        if (in_array($name[$i], $allowedChars)) {
            $link .= $name[$i];
        }
    }
    return $link;
}

function getLastRightWord($w) {
    $w2 = explode(' ', $w);
    if (count($w2) > 1) {
	for ($i = count($w2)-1;$i >= 0;$i--) {
	    if (strlen($w2[$i]) > 2) {
		return $w2[$i];
	    }
	}
	return $w;
    } else {
	return $w;
    }
}

if (!function_exists('subval_sort')) {

    function subval_sort($a, $subkey, $order=null) {
        $order = strtoupper($order);
        if (count($a) != 0 || (!empty($a))) {
            foreach ($a as $k => $v) {
                $b[$k] = function_exists('mb_strtolower') ? mb_strtolower($v[$subkey]) : strtolower($v[$subkey]);
            }
            if ($order == null || $order != 'DESC') {
                asort($b);
            } else {
                if ($order == 'DESC') {
                    arsort($b);
                }
            }
            foreach ($b as $key => $val) {
                $c[] = $a[$key];
            }
            return $c;
        }
    }

}

if (!function_exists('orderBy')) {
    /*
     * @param array $ary the array we want to sort
     * @param string $clause a string specifying how to sort the array similar to SQL ORDER BY clause
     * @param bool $ascending that default sorts fall back to when no direction is specified
     * @return null
     */

    function orderBy(&$ary, $clause, $ascending = true) {
        $clause = str_ireplace('order by', '', $clause);
        $clause = preg_replace('/\s+/', ' ', $clause);
        $keys = explode(',', $clause);
        $dirMap = array('desc' => 1, 'asc' => -1);
        $def = $ascending ? -1 : 1;

        $keyAry = array();
        $dirAry = array();
        foreach ($keys as $key) {
            $key = explode(' ', trim($key));
            $keyAry[] = trim($key[0]);
            if (isset($key[1])) {
                $dir = strtolower(trim($key[1]));
                $dirAry[] = $dirMap[$dir] ? $dirMap[$dir] : $def;
            } else {
                $dirAry[] = $def;
            }
        }

        $fnBody = '';
        for ($i = count($keyAry) - 1; $i >= 0; $i--) {
            $k = $keyAry[$i];
            $t = $dirAry[$i];
            $f = -1 * $t;
            $aStr = '$a[\'' . $k . '\']';
            $bStr = '$b[\'' . $k . '\']';
            if (strpos($k, '(') !== false) {
                $aStr = '$a->' . $k;
                $bStr = '$b->' . $k;
            }

            if ($fnBody == '') {
                $fnBody .= "if({$aStr} == {$bStr}) { return 0; }\n";
                $fnBody .= "return ({$aStr} < {$bStr}) ? {$t} : {$f};\n";
            } else {
                $fnBody = "if({$aStr} == {$bStr}) {\n" . $fnBody;
                $fnBody .= "}\n";
                $fnBody .= "return ({$aStr} < {$bStr}) ? {$t} : {$f};\n";
            }
        }

        if ($fnBody) {
            $sortFn = create_function('$a,$b', $fnBody);
            usort($ary, $sortFn);
        }
    }

}

if (!function_exists('html_attr_output')) {

    function html_attr_output($str) {
        $str2 = str_replace(array('"', '<', '>', '&'), array('&quot;', '&lt;', '&gt;', '&amp;'), $str);
        return $str2;
    }

}

if (!function_exists('js_string_output')) {

    function js_string_output($str) {
        $str2 = str_replace(array('"'), array('\"'), $str);
        return $str2;
    }

}

if (!function_exists('addToRequestQuery')) {

    function addToRequestQuery($prom, $val, $rq) {
        $out = "";
        $rq2 = explode("&", $rq);
        $is = false;
        foreach ($rq2 as $hod) {
            $ho = explode("=", $hod);
            if ($ho[0] == $prom) {
                if ($val != null) {
                    $out .= $prom . "=" . $val . "&";
                }
                $is = true;
            } else {
                $out .= $hod . "&";
            }
        }
        if (!$is) {
            $out .= $prom . "=" . $val . "&";
        }
        return substr($out, 0, strlen($out) - 1);
    }

}

function strip_html_tags($text) {
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
            ), array(
        ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
        "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
        "\n\$0", "\n\$0",
            ), $text);
    return strip_tags($text);
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
function unzip($src_file, $dest_dir=false, $create_zip_name_dir=true, $overwrite=true) {
    if (function_exists("zip_open")) {
        if (!is_resource(zip_open($src_file))) {
            $src_file = dirname($_SERVER['SCRIPT_FILENAME']) . "/" . $src_file;
        }

        if (is_resource($zip = zip_open($src_file))) {
            $splitter = ($create_zip_name_dir === true) ? "." : "/";
            if ($dest_dir === false)
                $dest_dir = substr($src_file, 0, strrpos($src_file, $splitter)) . "/";

            // Create the directories to the destination dir if they don't already exist
            create_dirs($dest_dir);

            // For every file in the zip-packet
            while ($zip_entry = zip_read($zip)) {
                // Now we're going to create the directories in the destination directories
                // If the file is not in the root dir
                $pos_last_slash = strrpos(zip_entry_name($zip_entry), "/");
                if ($pos_last_slash !== false) {
                    // Create the directory where the zip-entry should be saved (with a "/" at the end)
                    create_dirs($dest_dir . substr(zip_entry_name($zip_entry), 0, $pos_last_slash + 1));
                }

                // Open the entry
                if (zip_entry_open($zip, $zip_entry, "r")) {

                    // The name of the file to save on the disk
                    $file_name = $dest_dir . zip_entry_name($zip_entry);

                    // Check if the files should be overwritten or not
                    if ($overwrite === true || $overwrite === false && !is_file($file_name)) {
                        // Get the content of the zip entry
                        $fstream = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

                        if (!is_dir($file_name))
                            file_put_contents($file_name, $fstream);
                        // Set the rights
                        if (file_exists($file_name)) {
                            chmod($file_name, 0777);
                            echo "<span style=\"color:#1da319;\">file saved: </span>" . $file_name . "<br />";
                        } else {
                            echo "<span style=\"color:red;\">file not found: </span>" . $file_name . "<br />";
                        }
                    }

                    // Close the entry
                    zip_entry_close($zip_entry);
                }
            }
            // Close the zip-file
            zip_close($zip);
        } else {
            echo "No Zip Archive Found.";
            return false;
        }

        return true;
    } else {
        if (version_compare(phpversion(), "5.2.0", "<"))
            $infoVersion = "(use PHP 5.2.0 or later)";

        echo "You need to install/enable the php_zip.dll extension $infoVersion";
    }
}

function create_dirs($path) {
    if (!is_dir($path)) {
        $directory_path = "";
        $directories = explode("/", $path);
        array_pop($directories);

        foreach ($directories as $directory) {
            $directory_path .= $directory . "/";
            if (!is_dir($directory_path)) {
                mkdir($directory_path);
                chmod($directory_path, 0777);
            }
        }
    }
}

require_once PATH . '/frogSys/ext_libs/swiftmailer/swift_required.php';
$transport = Swift_SmtpTransport::newInstance(SMTP_SERVER, SMTP_PORT)
        ->setUsername(SMTP_USERNAME)
        ->setPassword(SMTP_PASSWORD);

//Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

function get_mail_header($predmet, $from_name="Info", $from_mail="no-replay") {
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    $headers .= "From: =?utf-8?B?" . base64_encode($from_name) . "?= <" . $from_mail . ">\r\n";
    //$headers .= "To: ".$_POST['email'].", ".ADMIN_MAIL."\r\n";
    $headers .= "Bcc: " . $from_mail . "\r\n";
    $headers .= "Subject: =?utf-8?B?" . base64_encode($predmet) . "?=\r\n";
    //$headers .= "Date: ".Time()."\r\n";
    $headers .= "Reply-To: " . $from_name . " <" . $from_mail . ">\r\n";
    //$headers .= "Return-Path: ".PAGE_NAME." <".ADMIN_MAIL.">\r\n";
    $headers .= "X-Priority: 2\r\n";
    $headers .= "X-MSMail-Priority: Normal\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
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

function get_first_img_tag($text) {
    //$t = preg_match('~<img.+src=".*".*/? >~', $text);
    $start = strpos($text, '<img ');
    $ex = explode("<img ", $text);
    if (isset($ex[1])) {
        $len = strpos($ex[1], '>');
        $ret = substr($text, $start, $len + 6);
        return $ret;
    } else {
        return "";
    }
}

/**
 * Naloaduje css styly a vypíše
 */
function loadCss($in = array(), $root = '/', $logged_in = false, $url = '/', $path = '') {
    if ($path == '') {
        $path = $_SERVER['DOCUMENT_ROOT'];
    }
    foreach ($in as $i) {
        $i2 = explode(": ", $i);
        $val = substr($i, strlen($i2[0]) + 2);
        $t = explode("&", $i2[0]);
        $show = isset($t[1]) && $t[1] == 'admin' ? $logged_in : true;
        $media = isset($t[2]) ? $t[2] : "screen";
        if ($show) {
            switch ($t[0]) {
                case '#fil':
                    $val2 = explode("?", $val);
                    $val2 = $val2[0];
                    if (file_exists($path . $root . $val2)) {
                        $mtime = filemtime($path . $root . $val2);
                    } else {
                        $mtime = 'cache';
                    }
                    echo "<link rel=\"stylesheet\" href=\"" . $url . $root . $val . (strstr($val, "?") ? "&amp;" : '?') . $mtime . "\" type=\"text/css\" media=\"" . $media . "\" />\n";
                    break;
                case '#url':
                    echo "<link rel=\"stylesheet\" href=\"" . $val . "\" type=\"text/css\" media=\"" . $media . "\" />\n";
                    break;
                case '#app':
                    echo "<style type=\"text/css\">\n" . $val . "\n</style>\n";
                    break;
                default :
                    continue;
            }
        }
    }
}

/**
 * Naloaduje js scripty a vypíše
 */
function loadJs($in = array(), $root = '/', $logged_in = false, $url = '/', $path = '') {
    if ($path == '') {
        $path = $_SERVER['DOCUMENT_ROOT'];
    }
    foreach ($in as $i) {
        $i2 = explode(": ", $i);
        $val = substr($i, strlen($i2[0]) + 2);
        $t = explode("&", $i2[0]);
        $show = isset($t[1]) && $t[1] == 'admin' ? $logged_in : true;
        if ($show) {
            switch ($t[0]) {
                case '#fil':
                    $val2 = explode("?", $val);
                    $val2 = $val2[0];
                    if (file_exists($path . $root . $val2)) {
                        $mtime = filemtime($path . $root . $val2);
                    } else {
                        $mtime = 'cache';
                    }
                    echo "<script type=\"text/javascript\" src=\"" . $url . $root . $val . (strstr($val, "?") ? "&amp;" : '?') . $mtime . "\"></script>\n";
                    break;
                case '#url':
                    echo "<script type=\"text/javascript\" src=\"" . $val . "\"></script>\n";
                    break;
                case '#app':
                    echo "<script type=\"text/javascript\">\n" . $val . "\n</script>\n";
                    break;
                default :
                    continue;
            }
        }
    }
}

function getFilesVersions($path, $index) {
    $ver = array();
    $way = '';
    
    function browseDir($path, $way, $index, $ver) {
        $dir = dir($path.$way);
        while ($file = $dir->read()) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (is_dir($path.$way.$file)) {
                $ver = browseDir($path, $way.$file.'/', $index, $ver);
            } else {
                $ver[$index.$way.$file] = filemtime($path.$way.$file);
            }
        }
        return $ver;
    }
    $ver = browseDir($path, $way, $index, $ver);
    
    return $ver;
}

class Watch {
	protected static $timers = array();
	protected static $i = 0;

	public static function start($name) {
		self::$timers[$name] = date('U');
		self::$i++;
	}

	public static function stop($name) {
		if (!is_logged_in()) return;

		if (isset(self::$timers[$name])) {
			$diff = date('U') - self::$timers[$name];
			echo '<div class="watch"><strong>'.$name.' ('.self::$i.'):</strong> '.$diff.'s </div>';
		}
		self::start($name);
	}
}

function _d($dump) {
    var_dump($dump);
}
