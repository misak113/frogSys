<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $popis; ?>" />
<meta name="keywords" content="<?php echo $keywords.", ".$title; ?>" />
<meta name="author" content="Michael Žabka" />
<meta name="robots" content="index, follow" />
<?php if (is_logged_in()) { ?>
<meta name="RS" content="frogSys" />
<meta name="version" content="<?php include PATH."/frogSys/version.txt"; ?>"
<meta name="copyright" content="2011, Avantcore media" />
<?php } ?>
<title>
    <?php
    echo strip_tags($title);
    echo $titulek;
    if (is_logged_in()) { echo " - Redakční systém frogSys"; }
    ?>
</title>
<link rel="shortcut icon" href="<?php echo URL; ?>favicon.ico" />
<link rel="icon" href="<?php echo URL; ?>favicon.ico" type="image/vnd.microsoft.icon" />

<?php
    $load_js = array(
        '#app: var URL = "'.URL.'";',
        '#url: http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js',
        '#app: jQuery.noConflict();',
        '#fil: js/functions.js',
        '#fil: js/IAWindows.js',
        '#fil: js/user.js',
        '#fil: js/kalendar.js',
        '#fil: js/scriptaculous/prototype.js',
        '#fil: js/scriptaculous/scriptaculous.js?load=effects,builder',
        '#fil: js/scriptaculous/lightbox.js',
        '#fil: js/jquery/jquery.autocomplete.min.js',
        '#fil: js/scriptaculous/simple-slide-show.js',
        '#app: var rek = "'.js_string_output(isset($_SETING['REKONSTRUKCE'])?$_SETING['REKONSTRUKCE']:'')
            .'"; if (rek != "") addLoadEvent(function () {createWindow(rek);});',
        '#app&admin: var aktualPage = '.($pageId+0).';',
        '#fil&admin: js/tiny_mce/tiny_mce.js',
        '#fil&admin: js/admin.js'
    );

    $load_css = array(
        '#fil: css/window.css',
        '#fil: css/scriptaculous/lightbox.css',
        '#fil: css/jquery/jquery.autocomplete.css',
        '#fil: css/scriptaculous/simple-slide-show.css',
        '#fil: css/head.css'
    );

    loadCss($load_css, "frogSys/", is_logged_in(), URL, PATH);
    loadJs($load_js, "frogSys/", is_logged_in(), URL, PATH);
?>
