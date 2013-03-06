<?php
		$sql = "SELECT * FROM `html` WHERE `parent` = -3";
		$q = mysql_query($sql);
		if ($res = mysql_fetch_array($q)) {
			$titulek = $res['content'];
		} else {
			$sql = "INSERT INTO `html` VALUES(NULL, 'Titulek stránky', -3, 0, 0)";
			$q = mysql_query($sql);
			$titulek = "Titulek stránky";
		}
		
		$title = "";
		$sql = "SELECT MIN(`order`) AS min FROM `menu` WHERE `parent` = 0";
		$q = mysql_query($sql);                                                          
		if ($res = mysql_fetch_array($q)) {
			$min = $res['min'];                                                      
		}
		$sql = "SELECT * FROM `menu` WHERE `parent` = 0 AND `order` = $min";
		$q = mysql_query($sql);
		if ($res = @mysql_fetch_array($q)) {
			$firstId = $res['id'];                                                     
		}
		$sql = "SELECT MIN(`order`) AS min FROM `menu` WHERE `parent` = $firstId";
		$q = mysql_query($sql);
		if ($res = @mysql_fetch_array($q)) {
			$min = $res['min'];                                                         
		}
		$sql = "SELECT * FROM `menu` WHERE `parent` = $firstId AND `order` = $min";
		$q = mysql_query($sql);
		if ($res = @mysql_fetch_array($q)) {
			$pageId = $res['id'];                                                           
		}
		$page = @$_GET['page'];
		$page = explode("/", $page);
		if (isset($page[0]) && $page[0] != "") {
			$sql = "SELECT * FROM `menu` WHERE `link` = '".$page[0]."' LIMIT 1";
			$q = mysql_query($sql);
			if ($res = mysql_fetch_array($q)) {
				$title = $res['name']." - ".$title;
				$pageId = $res['id'];
				
				$sql = "SELECT * FROM `page` WHERE `parent` = $pageId";
				$q = mysql_query($sql);
				while ($res = mysql_fetch_array($q)) {
					$pageId2[$res['id']] = $res['first'];
				}
				$shop_id = 0;
				$shop_produkt_id = 0;
				if (isset($page[1])) {
					$sql = "SELECT * FROM `menu_in` WHERE `link` = '".$page[1]."'";
					$q = mysql_query($sql);
					$isMenu = false;
					while ($res = mysql_fetch_array($q)) {
						$sql = "SELECT * FROM `page` WHERE `first` = ".$res['parent']."";
						$q2 = mysql_query($sql);
						if ($res2 = mysql_fetch_array($q2)) {    
							if ($res2['parent'] == $pageId) {   
								$title = $res['name']." - ".$title;
								$pageId2[$res['target']] = $res['href'];
								$isMenu = true;
							}
						}
					}
					if (!$isMenu) {
						$page[2] = $page[1];
					}
					if (isset($page[2])) {
						$sql = "SELECT * FROM `shop_menu` WHERE `link` = '".$page[2]."'";
						$q = mysql_query($sql);
						if ($res = mysql_fetch_array($q)) {
							$title = $res['nazev']." - ".$title;
							$shop_id = $res['id'];
						} else {
							$sql = "SELECT * FROM `shop` WHERE `code` = '".$page[2]."'";
							$q = mysql_query($sql);
							if ($res = mysql_fetch_array($q)) {
								$title = $res['nazev']." - ".$title;
								$shop_produkt_id = $res['id'];
							}
						}
					}
				}
			} else {
				$sql = "SELECT * FROM `menu` WHERE `link` = '404' LIMIT 1";
				$q = mysql_query($sql);
				if ($res = mysql_fetch_array($q)) {
					$title = "Error 404 - Stránka nenalezena - ".$title;
					$pageId = $res['id'];
				} else {
					$sql = "INSERT INTO `menu` VALUES(NULL, '404', -400, 404, '404', 1)";
					$q = mysql_query($sql);
					$sql = "SELECT * FROM `menu` WHERE `link` = '404'";
					$q = mysql_query($sql);
					if ($res = mysql_fetch_array($q)) {
						$rand = mt_rand(1000, 9999);
						$sql = "INSERT INTO `page_parts` VALUES(NULL, '$rand')";
						$q = mysql_query($sql);
						$sql = "SELECT * FROM `page_parts` WHERE `type` = '$rand'";
						$q2 = mysql_query($sql);
						if ($res2 = mysql_fetch_array($q2)) {
							$sql = "INSERT INTO `page` VALUES(NULL, ".$res2['id'].", 100, ".$res['id'].", 1)";
							$q = mysql_query($sql);
						}
					}
				}
			}
		}      
		
?>
