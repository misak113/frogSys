<?php
header("Content-Type: text/xml; charset=utf-8");
header("Pragma: no-cache");
header("Cache-Control: no-cache,must-revalidate,max_age=0");
header("Expires: 0");

require_once "../../config/database.php";
include PATH."/bin/scripts.php";

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">


    <?php
    $sql = "SELECT DISTINCT `parent` FROM `menu` ORDER BY `parent` DESC";
    $q = mysql_query($sql);
    while ($res = mysql_fetch_array($q)) {
        if ($res['parent'] == 0) {
            continue;
        }
        $sql = "SELECT * FROM `menu` WHERE `parent` = ".$res['parent']." AND `visible` = 1 ORDER BY `order`";
        $q2 = mysql_query($sql);
        while ($res2 = mysql_fetch_array($q2)) {
            echo "\n<url>\n<loc>".URL.$res2['link']."/</loc>\n<changefreq>daily</changefreq>\n</url>\n";
            $sql = "SELECT `first` FROM `page` WHERE `parent` = ".$res2['id']." ORDER BY `order`";
            $q3 = mysql_query($sql);
            while ($res3 = mysql_fetch_array($q3)) {
                $sql = "SELECT `type` FROM `page_parts` WHERE `id` = ".$res3['first']."";
                $q4 = mysql_query($sql);
                if ($res4 = mysql_fetch_array($q4)) {
                    if ($res4['type'] == "MENU") {
                        $sql = "SELECT * FROM `menu_in` WHERE `parent` = ".$res3['first']." ORDER BY `order`";
                        $q5 = mysql_query($sql);
                        while ($res5 = mysql_fetch_array($q5)) {
                            echo "\n<url>\n<loc>".URL.$res2['link']."/".$res5['link']."/</loc>\n<changefreq>daily</changefreq>\n</url>\n";
                        }
                    }
                    if ($res4['type'] == "SHOP") {
                        $sql = "SELECT * FROM `shop_menu` WHERE `parent` = ".$res3['first']." ORDER BY `nazev`";
                        $q5 = mysql_query($sql);
                        while ($res5 = mysql_fetch_array($q5)) {
                            echo "\n<url>\n<loc>".URL.$res2['link']."/".$res5['link']."/</loc>\n<changefreq>daily</changefreq>\n</url>\n";
                            $sql = "SELECT * FROM `shop` WHERE `parent` = ".$res5['id']." ORDER BY `nazev`";
                            $q6 = mysql_query($sql);
                            while ($res6 = mysql_fetch_array($q6)) {
                                echo "\n<url>\n<loc>".URL.$res2['link']."/".$res6['link']."/</loc>\n<changefreq>daily</changefreq>\n</url>\n";
                            }
                        }
                    }
                }
            }
        }
    }
    ?>
</urlset>