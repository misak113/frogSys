<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $popis; ?>" />
<meta name="keywords" content="<?php echo $keywords.", ".$title; ?>" />
<meta name="copyright" content="2011, Avantcore media" />
<meta name="author" content="Michael Žabka" />
<meta name="robots" content="index, follow" />
<meta name="RS" content="frogSys" />
<meta name="version" content="<?php include PATH."/frogSys/version.txt"; ?>" />
<title>
    <?php
    echo strip_tags($title);
    echo $titulek;
    if (@$_SESSION['auth'] > 0) { echo " - Redakční systém frogSys"; }
    ?>
</title>
<link rel="shortcut icon" href="<?php echo URL; ?>favicon.ico" />
<link rel="icon" href="<?php echo URL; ?>favicon.ico" type="image/vnd.microsoft.icon" />

<<<<<<< HEAD
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

    loadCss($load_css, "frogSys/", @$_SESSION['auth'] > 0, URL, PATH);
    loadJs($load_js, "frogSys/", @$_SESSION['auth'] > 0, URL, PATH);
?>
=======
<link rel="stylesheet" href="<?php echo URL; ?>frogSys/css/window.css" type="text/css" />

<script type="text/javascript">
    var URL = '<?php echo URL; ?>';
</script>

<script src="<?php echo URL; ?>frogSys/js/functions.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>frogSys/js/IAWindows.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>frogSys/js/user.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>frogSys/js/kalendar.js" type="text/javascript"></script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript">
    jQuery.noConflict();
</script>


<script type="text/javascript" src="<?php echo URL; ?>frogSys/js/scriptaculous/prototype.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>frogSys/js/scriptaculous/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="<?php echo URL; ?>frogSys/js/scriptaculous/lightbox.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>frogSys/css/scriptaculous/lightbox.css" type="text/css" media="screen" />


<script type="text/javascript" src="<?php echo URL; ?>frogSys/js/jquery/jquery.autocomplete.min.js"></script>
<link rel="stylesheet" href="<?php echo URL; ?>frogSys/css/jquery/jquery.autocomplete.css" type="text/css" media="screen" />

<script src="<?php echo URL; ?>frogSys/js/scriptaculous/simple-slide-show.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo URL; ?>frogSys/css/scriptaculous/simple-slide-show.css" type="text/css" media="screen" />

<link rel="stylesheet" href="<?php echo URL; ?>frogSys/css/head.css" type="text/css" />

<script type="text/javascript">
    <?php if (isset($_SETING['REKONSTRUKCE'])) { ?>
        addLoadEvent(function () {
            createWindow("<?php echo $_SETING['REKONSTRUKCE']; ?>");
        });
    <?php } ?>
</script>

<?php if (@$_SESSION['auth'] > 0) { ?>
<script type="text/javascript">
    <?php echo "var aktualPage = ".($pageId+0).";"; ?>
</script>
<script src="<?php echo URL; ?>frogSys/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>frogSys/js/admin.js" type="text/javascript"></script>
        <?php } ?>
>>>>>>> a206266de26ca4d13d6c2fc157715fc98aa0e227
