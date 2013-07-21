<?php if (is_logged_in(array(1,2,3))) { ?>
<div id="admin_menu">

    <div id="admin_hlavni" class="admin_head" onmouseout="admin_menu['admin_hlavni'] = setTimeout('rozbal_menu(\'admin_hlavni\', 0)', 200);" onmouseover="clearTimeout(admin_menu['admin_hlavni']); rozbal_menu('admin_hlavni', 1);">
        <div class="menu_item_head" id="admin_hlav"><a class="menu_item_head" href="javascript: rozbal_menu('admin_hlavni');">
            <img src="<?php echo URL; ?>frogSys/images/icons/down1.png" alt="rozbalit" style="margin-right: 10px;" align="middle" /> Hlavní menu</a>
        </div>
<?php if (is_logged_in(array(1,2))) { ?>
        <div class="menu_item" id="admin_zakladni"><img src="<?php echo URL; ?>frogSys/images/icons/right1.png" alt="rozbalit" style="margin-right: 10px;" /><a href="javascript: editZakladni();">základní</a></div>
        <div class="menu_item" id="admin_menuAdmin"><img src="<?php echo URL; ?>frogSys/images/icons/right1.png" alt="rozbalit" style="margin-right: 10px;" /><a href="javascript: menuAdmin();">menu</a></div>
        <div class="menu_item" id="admin_strankyAdmin"><img src="<?php echo URL; ?>frogSys/images/icons/right1.png" alt="rozbalit" style="margin-right: 10px;" /><a href="javascript: strankyAdmin();">stránky</a></div>
        <div class="menu_item" id="admin_SHOP"><img src="<?php echo URL; ?>frogSys/images/icons/right1.png" alt="rozbalit" style="margin-right: 10px;" /><a href="javascript: editShop();">e-shop</a></div>
        <div class="menu_item" id="admin_administratori"><img src="<?php echo URL; ?>frogSys/images/icons/right1.png" alt="rozbalit" style="margin-right: 10px;" /><a href="javascript: editAdmins();">administrátoři</a></div>
        <div class="menu_item" id="admin_spravce_souboru"><img src="<?php echo URL; ?>frogSys/images/icons/right1.png" alt="rozbalit" style="margin-right: 10px;" /><a href="javascript: spravceSouboru();">správce souborů</a></div>
<?php } ?>
        <div class="menu_item" id="admin_odhlasit"><img src="<?php echo URL; ?>frogSys/images/icons/right1.png" alt="rozbalit" style="margin-right: 10px;" /><a href="javascript: odhlasit();">odhlásit</a></div>
    </div>

    <?php if (is_logged_in(array(1))) { ?>
    <div id="admin_super" class="admin_head" onmouseout="admin_menu['admin_super'] = setTimeout('rozbal_menu(\'admin_super\', 0)', 200);" onmouseover="clearTimeout(admin_menu['admin_super']); rozbal_menu('admin_super', 1);">
        <div class="menu_item_head" id="admin_superi"><a class="menu_item_head" href="javascript: rozbal_menu('admin_super');">
            <img src="<?php echo URL; ?>frogSys/images/icons/down1.png" alt="rozbalit" style="margin-right: 10px;" align="middle" /> Super</a>
        </div>

        <div class="menu_item" id="admin_moduly"><img src="<?php echo URL; ?>frogSys/images/icons/right2.png" alt="rozbalit" style="margin-right: 10px;" /><a href="javascript: editModuly();">moduly</a></div>
        <?php if (URL == "http://www.avantcore.cz/") { ?>
        <div class="menu_item" id="admin_odkazy"><img src="<?php echo URL; ?>frogSys/images/icons/right2.png" alt="rozbalit" style="margin-right: 10px;" /><a href="javascript: editOdkazy();">odkazy</a></div>
        <?php } ?>
    </div>
    <?php } ?>

    <div id="admin_help" class="admin_head" onmouseout="admin_menu['admin_help'] = setTimeout('rozbal_menu(\'admin_help\', 0)', 200);" onmouseover="clearTimeout(admin_menu['admin_help']); rozbal_menu('admin_help', 1);">
        <div class="menu_item_head" id="admin_helpi"><a class="menu_item_head" href="javascript: rozbal_menu('admin_help');">
            <img src="<?php echo URL; ?>frogSys/images/icons/down1.png" alt="rozbalit" style="margin-right: 10px;" align="middle" /> Help</a>
        </div>

        <div class="menu_item" id="admin_napoveda"><img src="<?php echo URL; ?>frogSys/images/icons/right1.png" alt="rozbalit" style="margin-right: 10px;" /><a href="javascript: napoveda();">nápověda</a></div>
        <div class="menu_item" id="admin_aboat"><img src="<?php echo URL; ?>frogSys/images/icons/right1.png" alt="rozbalit" style="margin-right: 10px;" /><a href="javascript: aboat();">o frogSys</a></div>
    </div>

    <div id="admin_akt_str">
				aktuální stránka:
                                <div id="aktual_stranka">úvod</div>
    </div>
    
    <div id="admin_prihlasen">
				přihlášen jako: <span id="loged_as"><?php echo $_SESSION['user']; ?></span>
    </div>


</div>
<div id="admin_menu_place"></div>
<?php } ?>