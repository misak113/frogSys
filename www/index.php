<?php                  
header("Content-Type: text/html; charset=utf-8");
header("Pragma: no-cache");
header("Cache-Control: no-cache,must-revalidate,max_age=0");
header("Expires: 0");
if (@$_GET['page'] == "404") {
    header("HTTP/1.0 404 Not Found");
}


include "./config/database.php";
include "./bin/scripts.php";
include "./bin/load_pages_id.php";
?>		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Cache-Control" content="no-cache,must-revalidate,max_age=0" />
        <meta http-equiv="Expires" content="0" />
        <meta http-equiv="Author" content="Michael Žabka" />
        <meta http-equiv="Version" content="0.000.001" />
        <meta http-equiv="Date" content="8. 1. 2010" />
        <meta name="description" content="Pokud sháníte kvalitního programátora či vývojaře, Michael Žabka je správná volba. V současné době pracuje na ŽL ve vlastní firmě Avantcore media." />
        <meta name="keywords" content="Avantcore media, Michael Žabka" />
        <meta name="copyright" content="2011, Michael Žabka" />
        <meta name="author" content="Misak113" />
        <meta name="robots" content="index, follow" />
        <title>
            <?php
            echo strip_tags($title);
            echo $titulek;
            if (@$_SESSION['auth'] > 0) { echo " - Administrační verze"; }
            ?>
        </title>
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon" />

        <link rel="stylesheet" href="/css/head.css" type="text/css" />
        <link rel="stylesheet" href="/css/window.css" type="text/css" />

        <script src="/js/functions.js" type="text/javascript"></script>
        <script src="/js/IAWindows.js" type="text/javascript"></script>
        <script src="/js/user.js" type="text/javascript"></script>
        <script src="/js/kalendar.js" type="text/javascript"></script>

        <script type="text/javascript" src="/js/jquery/jquery.js"></script>
        <script type="text/javascript">
            jQuery.noConflict();
        </script>


        <script type="text/javascript" src="/js/scriptaculous/prototype.js"></script>
        <script type="text/javascript" src="/js/scriptaculous/scriptaculous.js?load=effects,builder"></script>
        <script type="text/javascript" src="/js/scriptaculous/lightbox.js"></script>
        <link rel="stylesheet" href="/css/scriptaculous/lightbox.css" type="text/css" media="screen" />


        <script type="text/javascript" src="/js/jquery/jquery.autocomplete.min.js"></script>
        <link rel="stylesheet" href="/css/jquery/jquery.autocomplete.css" type="text/css" media="screen" />

        <script src="/js/scriptaculous/simple-slide-show.js" type="text/javascript"></script>
        <link rel="stylesheet" href="/css/scriptaculous/simple-slide-show.css" type="text/css" media="screen" />
        <?php if (@$_SESSION['auth'] > 0) { ?>
        <script type="text/javascript">
    <?php echo "var aktualPage = ".($pageId+0).";"; ?>
        </script>
        <script src="/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
        <script src="/js/admin.js" type="text/javascript"></script>
        <?php } ?>
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-20953873-5']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
    </head>
    <body id="head_body">
        <?php
        include "./bin/admin_menu.php";
        ?>
        <div id="body">
            <?php if (@$_SESSION['auth'] > 0) { ?>
            <div id="loading">
                <img src="/images/design/loading.gif" alt="loading" />
				Načítání
            </div>
            <?php } ?>
            <div id="top">
                <a href="/" title="Hlavní stránka">
                    <img src="/images/design/logo.png" alt="Michael Žabka" title="Michael Žabka - logo" id="logo" />
                </a>
                <div id="menu">
                    <?php writeMenu(0); ?>
                </div>
                <div id="top_title">
                    <?php writeTop_title(); ?>
                </div>
            </div>
            <div id="midle">
                <div id="page_top">&nbsp;</div>
                <div id="page">
                    <div id="page_in">
                        <?php writePage($pageId, @$pageId2); ?>
                    </div>
                </div>
                <div id="page_bottom">&nbsp;</div>

            </div>
            <?php writeShop_kosik(); ?>
        </div>
        <div id="copyright">
            <div id="copyright_center">
                <div id="copyright_left">
                    <?php
                    readfile("http://www.avantcore.cz/frogSys/bin/copyright.php");
                    ?>
                </div>
                <div id="copyright_right">
                    <?php writePatka(); ?>
                </div>
            </div>
        </div>

<script type="text/javascript">
var myxHost = (('https:'==document.location.protocol)?'https://secure.myxheat.com':'http://api.myx.cz');
document.write(unescape("%3Cscript src='" + myxHost + "/js/myx.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<noscript><a href="http://www.myx.cz">Heat maps</a></noscript>
<script type="text/javascript">
SiteOneMYX.code = 'b1263P6r7skx7xZ1c24A6Wp1rh:2047:26';
SiteOneMYX.init();
</script>

    </body>
</html>
<?php mysql_close(); ?>