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

<link rel="stylesheet" href="<?php echo URL; ?>frogSys/css/window.css" type="text/css" />

<script type="text/javascript">
    var URL = '<?php echo URL; ?>';
</script>

<script src="<?php echo URL; ?>frogSys/js/functions.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>frogSys/js/IAWindows.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>frogSys/js/user.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>frogSys/js/kalendar.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo URL; ?>frogSys/js/jquery/jquery.js"></script>
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