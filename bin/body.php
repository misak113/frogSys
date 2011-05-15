<div id="body">
    <?php writeStaticSloupec(); ?>
    <?php if (@$_SESSION['auth'] > 0) { ?>
    <div id="loading">
        <img src="<?php echo URL; ?>frogSys/images/design/loading.gif" alt="loading" />
				Načítání
    </div>
    <?php } 
    $format_top = "jpg";
        if (file_exists(PATH."/grafics/images/design/top/top_.png")) {
            $format_top = "png";
        }
    ?>
    <div id="top" style="background-image: url('<?php echo URL; ?>frogSys/images/design/top/top_<?php echo $page_link; ?>.<?php echo $format_top; ?>');">
        <a href="<?php echo URL; ?>" title="Hlavní stránka">
            <img src="<?php echo URL; ?>frogSys/images/design/logo.png" alt="<?php echo $nazev; ?>" title="<?php echo $nazev; ?> - logo" id="logo" />
        </a>
        <div id="top_title">
            <?php writeTop_title(); ?>
        </div>
    </div>
    <div id="menu">
            <?php writeMenu(0); ?>
        </div>
        <div id="midle">
        <div id="page">
            <div id="page_in">
                <?php writePage($pageId, @$pageId2); ?>
            </div>
        </div>
    </div>
    <?php writeShop_kosik(); ?>
    <?php writeVysledky_sezona(); ?>
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