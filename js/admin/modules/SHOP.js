// JavaScript Document



function moveShop_menu(event, id, target) {
	actual_page_part = target;
	moveItem(event, id, "shop_menu_item_", saveShop_menuPosition);
}
function saveShop_menuPosition(id, changeWith) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=sort_menu&id="+id+"&change_with="+changeWith, shop_menuRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}



function moveShop_produkt(event, page_part, shop_id, id) {
	actual_page_part = page_part;
        actual_shop_id = shop_id;
	moveItem(event, id, "shop_produkt_item_", saveShop_produktPosition);
}
function saveShop_produktPosition(id, changeWith) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=sort_produkt&id="+id+"&change_with="+changeWith, shopProduktyRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}

function shopProduktyRefresh(text) {
    loadShopCategory(actual_page_part, actual_shop_id, actual_link);
    //history.go(0);
    createAlert(text);
}


var actual_page_part;
function loadShopCategory(page_part, shop_id, link) {
    hashMark(link+"#loadShopCategory("+page_part+", "+shop_id+", '"+link+"')");
	actual_page_part = page_part;
        actual_link = link;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/modules/SHOP.php", "action=produkty&page_part="+page_part+"&shop_id="+shop_id, shopLoaded)) {
		//pokud nefunguje ajax
		return;
	}
}

function shopLoaded(text) {
	changeText("shop_"+actual_page_part, text);
}

var editedShop_menuId;
function editShop_menu(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=get_parent&id="+id, setActualPagePart)) {
		//pokud nefunguje ajax
		return;
	}
	editedShop_menuId = id;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=edit_menu_form&id="+id, createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}

function saveShop_menu(id) {
	var nazev = document.getElementById("shop_menu_nazev_"+id).value;
	var odkaz = document.getElementById("shop_menu_odkaz_"+id).value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=edit_menu&id="+id
		+"&nazev="+fixQuery(nazev)+"&link="+fixQuery(odkaz), shop_menuRefresh)) {
		//pokud nefunguje ajax
		return;
	}
	zavriWindow();
}

function shop_menuRefresh(text) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/modules/SHOP.php", "action=show_menu&page_part="+actual_page_part, shop_menuRefresh2)) {
		//pokud nefunguje ajax
		return;
	}
	createAlert(text);
}

function shop_menuRefresh2(text) {
	changeText("shop_menu_"+actual_page_part, text);
}

function deleteShop_menu(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=get_parent&id="+id, setActualPagePart)) {
		//pokud nefunguje ajax
		return;
	}
	createDialog('Opravdu chcete smazat kategorii e-shopu?', deleteShop_menu2, id);
}

function deleteShop_menu2(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=delete_menu&id="+id, shop_menuRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}

function setActualPagePart(text) {
	actual_page_part = parseInt(text);
}

function addShop_menu(parent) {
	actual_page_part = parseInt(parent);
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=add_menu&parent="+parent, editShop_menu)) {
		//pokud nefunguje ajax
		return;
	}
}







var actual_shop_produkt_id;
function loadShopProdukt(page_part, id, link) {
    hashMark(link+"#loadShopProdukt("+page_part+", "+id+", '"+link+"')");
	actual_page_part = page_part;
	actual_shop_produkt_id = id;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/modules/SHOP.php", "action=produkt&page_part="+page_part+"&id="+id, shopLoaded)) {
		//pokud nefunguje ajax
		return;
	}
}



var produkt_editing = false;
function editShop_produkt_popis(id) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = id;
	var contentIn = document.getElementById("popis_"+id);
	contentIn.removeChild(getElementsByClassNameMy("edit_pane_Shop_produkt_popis", contentIn)[0]);
	var textarea = "<form action=\"javascript: saveShop_produkt_popis("+id+");\">"+
		"<div name=\"edited_popis_"+id+"\" id=\"edited_popis_"+id+"\" class=\"edited_popis\" style=\"height: "+(contentIn.offsetHeight)+"px;\">"+
		//contentIn.innerHTML+
		"</div>"+
		"</form>";
	var text = contentIn.innerHTML;
	contentIn.innerHTML = textarea;
	produkt_editing = true;
	var ed = loadTinyMCE("edited_popis_"+id);
	//ed.setContent(text);
	document.getElementById("edited_popis_"+id).innerHTML = text;

	// fix vyska
	//var objekt2 = document.getElementById("page_in");
	//var vyska1 = objekt2.offsetHeight;
	//objekt2.style.height = "auto";
	//var vyska2 = objekt2.offsetHeight;
	//objekt2.style.height = vyska1+"px";
	changeWindow("page_in", false, "auto", false, false);
}

function saveShop_produkt_popis(id) {
	var text = tinyMCE.get("edited_popis_"+id).getContent();
	tinyMCE.remove(tinyMCE.get("edited_popis_"+id));
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=save_produkt_popis&id="+id+"&text="+fixQuery(text), shopProduktRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}







function editShop_produkt_anotace(id) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = id;
	var contentIn = document.getElementById("anotace_"+id);
	contentIn.removeChild(getElementsByClassNameMy("edit_pane_Shop_produkt_anotace", contentIn)[0]);
	var textarea = "<form action=\"javascript: saveShop_produkt_anotace("+id+");\">"+
		"<div name=\"edited_anotace_"+id+"\" id=\"edited_anotace_"+id+"\" class=\"edited_anotace\" style=\"height: "+(contentIn.offsetHeight)+"px;\">"+
		//contentIn.innerHTML+
		"</div>"+
		"</form>";
	var text = contentIn.innerHTML;
	contentIn.innerHTML = textarea;
	produkt_editing = true;
	var ed = loadTinyMCE("edited_anotace_"+id);
	//ed.setContent(text);
	document.getElementById("edited_anotace_"+id).innerHTML = text;

	// fix vyska
	//var objekt2 = document.getElementById("page_in");
	//var vyska1 = objekt2.offsetHeight;
	//objekt2.style.height = "auto";
	//var vyska2 = objekt2.offsetHeight;
	//objekt2.style.height = vyska1+"px";
	changeWindow("page_in", false, "auto", false, false);
}

function saveShop_produkt_anotace(id) {
	var text = tinyMCE.get("edited_anotace_"+id).getContent();
	tinyMCE.remove(tinyMCE.get("edited_anotace_"+id));
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=save_produkt_anotace&id="+id+"&text="+fixQuery(text), shopProduktRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}






function shopProduktRefresh(text) {
	loadShopProdukt(actual_page_part, actual_shop_produkt_id);
	createAlert(text);
}

function setShowProdukt(id, checkb) {
	var set = 0;
	if (checkb.checked) {
		set = 1;
	}
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=set_produkt_show&id="+id+"&show="+set, createAlert)) {
		//pokud nefunguje ajax
		return;
	}
}

function checkboxSelectShop_produkt(page_part, shop_id, id, el) {
    setShowProdukt(id, el);
    var color = "#D3D3D3";
    if (el.checked) {
        color = "transparent";
    }
    jQuery(el).parent().parent().css("background-color", color);
}

function setDoporucujemeProdukt(id, checkb) {
	var set = 0;
	if (checkb.checked) {
		set = 1;
	}
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=set_produkt_doporucujeme&id="+id+"&doporucujeme="+set, createAlert)) {
		//pokud nefunguje ajax
		return;
	}
}

function editShop_produkt_nazev(id) {
	var text = '<input type="text" onkeyup="generujLink(\'input\', '+id+');" id="input_nazev_'+id+'" value="'+document.getElementById("nazev_text_"+id).innerHTML+'">'+
						'<input type="button" value="uložit" onclick="saveShop_produkt_nazev('+id+');">';
	changeText("nazev_"+id, text);
	var text = 'Link: <input type="text" id="input_odkaz_'+id+'" value="'+document.getElementById("link_text_"+id).innerHTML+'">';
	changeText("link_"+id, text);
}


function saveShop_produkt_nazev(id) {
	var text = document.getElementById("input_nazev_"+id).value;
	var link = document.getElementById("input_odkaz_"+id).value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=set_produkt_nazev&id="+id+"&nazev="+fixQuery(text)+"&link="+fixQuery(link), shopProduktRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}


function editShop_produkt_cena(id) {
	var text = 'Cena bez DPH: <input type="text" id="input_cena_'+id+'" onkeyup=\"control_shop_cena('+id+');\" value="'+document.getElementById("shop_cena_"+id).innerHTML+'"> Kč, '+
				'DPH: <input type="text" id="input_dph_'+id+'" onkeyup=\"control_shop_cena('+id+');\" value="'+document.getElementById("shop_dph_"+id).innerHTML+'"> %, '+
				'Cena s DPH: <span class="cena_sdph" id="cena_sdph_'+id+'"></span> Kč '+
					'<input type="button" value="uložit" onclick="saveShop_produkt_cena('+id+');">';
	changeText("shop_ceny_"+id, text);
}

function saveShop_produkt_cena(id) {
	var cena = document.getElementById("input_cena_"+id).value;
	var dph = document.getElementById("input_dph_"+id).value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=set_produkt_cena&id="+id+"&cena="+fixQuery(cena)+"&dph="+fixQuery(dph), shopProduktRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}

function control_shop_cena(id) {
	var cena = document.getElementById("input_cena_"+id).value;
	var dph = document.getElementById("input_dph_"+id).value;
	var cena2 = '';
	for (var i = 0;i < cena.length;i++) {
		if (cena[i] == '0' || cena[i] == '1' || cena[i] == '2' || cena[i] == '3' || cena[i] == '4' || cena[i] == '5' || cena[i] == '6' || cena[i] == '7' || cena[i] == '8' || cena[i] == '9') {
			cena2 += ''+cena[i];
		}
	}
	document.getElementById("input_cena_"+id).value = cena2;
	var dph2 = '';
	for (var i = 0;i < dph.length;i++) {
		if (dph[i] == '0' || dph[i] == '1' || dph[i] == '2' || dph[i] == '3' || dph[i] == '4' || dph[i] == '5' || dph[i] == '6' || dph[i] == '7' || dph[i] == '8' || dph[i] == '9') {
			dph2 += ''+dph[i];
		}
	}
	document.getElementById("input_dph_"+id).value = dph2;
	document.getElementById("cena_sdph_"+id).innerHTML = Math.round(cena2*(1+dph2/100));
}

function editShop_produkt_skladem(id) {
	var text = '<input type="text" id="input_skladem_'+id+'" onkeyup=\"control_shop_skladem('+id+');\" value="'+document.getElementById("shop_skladem_"+id).innerHTML+'">'+
						'<input type="button" value="uložit" onclick="saveShop_produkt_skladem('+id+');">';
	changeText("shop_skladem_"+id, text);
}


function saveShop_produkt_skladem(id) {
	var text = document.getElementById("input_skladem_"+id).value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=set_produkt_skladem&id="+id+"&skladem="+fixQuery(text), shopProduktRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}

function control_shop_skladem(id) {
	var skladem = document.getElementById("input_skladem_"+id).value;
	var skladem2 = '';
	for (var i = 0;i < skladem.length;i++) {
		if (skladem[i] == '0' || skladem[i] == '1' || skladem[i] == '2' || skladem[i] == '3' || skladem[i] == '4' || skladem[i] == '5' || skladem[i] == '6' || skladem[i] == '7' || skladem[i] == '8' || skladem[i] == '9') {
			skladem2 += ''+skladem[i];
		}
	}
	document.getElementById("input_skladem_"+id).value = skladem2;
}

function editShop_produkt_vyrobce(id) {
	var text = '<input type="text" id="input_vyrobce_'+id+'" onkeyup=\"naseptavac_vyrobce('+id+');\" value="'+document.getElementById("shop_vyrobce_"+id).innerHTML+'">'+
						'<input type="button" value="uložit" onclick="saveShop_produkt_vyrobce('+id+');">';
	changeText("shop_vyrobce_"+id, text);
}

function saveShop_produkt_vyrobce(id) {
	var text = document.getElementById("input_vyrobce_"+id).value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=set_produkt_vyrobce&id="+id+"&vyrobce="+fixQuery(text), shopProduktRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}

var aktualVyrobce, aktual_vyrobce_id;
function naseptavac_vyrobce(id) {
	aktual_vyrobce_id = id;
	aktualVyrobce = document.getElementById("input_vyrobce_"+id);
	var text = aktualVyrobce.value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=naseptavac_vyrobce&id="+id+"&vyrobce="+fixQuery(text), naseptavac_vyrobce2)) {
		//pokud nefunguje ajax
		return;
	}
}


function naseptavac_vyrobce2(text) {
	var availableTags = text.split("Đ");
        jQuery("#input_vyrobce_"+aktual_vyrobce_id).autocomplete(availableTags);
}





function editShop_produkt_code(id) {
	var text = '<input type="text" id="input_code_'+id+'" onkeyup=\"control_code('+id+');\" value="'+document.getElementById("shop_code_"+id).innerHTML+'">'+
						'<input type="button" value="uložit" onclick="saveShop_produkt_code('+id+');">';
	changeText("shop_code_"+id, text);
}

function saveShop_produkt_code(id) {
	var text = document.getElementById("input_code_"+id).value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=set_produkt_code&id="+id+"&code="+fixQuery(text), shopProduktRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}

var aktualCode;
function control_code(id) {
	aktualCode = document.getElementById("input_code_"+id);
	var text = aktualCode.value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=control_produkt_code&id="+id+"&code="+fixQuery(text), control_code2)) {
		//pokud nefunguje ajax
		return;
	}
}

function control_code2(text) {
	if (text == "false") {
		aktualCode.style.color = "red";
	} else {
		aktualCode.style.color = "darkgreen";
	}
}





var aktual_category_id;
function shop_change_category(id) {
	aktual_category_id = id;
	var parent = document.getElementById("shop_modul_parent_"+id).value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=get_categories&id="+id+"&parent="+parent, shop_change_category2)) {
		//pokud nefunguje ajax
		return;
	}
}

function shop_change_category2(text) {
	document.getElementById("shop_menu_parent_"+aktual_category_id).innerHTML = text;
}

function shop_set_category(id) {
	var text = document.getElementById("shop_menu_parent_"+id).value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=set_produkt_category&id="+id+"&category="+text, createAlert)) {
		//pokud nefunguje ajax
		return;
	}
}


function addShop_produkt(page_part, parent) {
	actual_page_part = page_part;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=add_produkt&parent="+parent+"&page_part="+page_part, addShop_produkt2)) {
		//pokud nefunguje ajax
		return;
	}
}

function addShop_produkt2(text) {
	loadShopProdukt(actual_page_part, parseInt(text));
}


var actual_shop_id;
function deleteShop_produkt(page_part, shop_id, id) {
	actual_shop_id = shop_id;
	actual_page_part = page_part;
	createDialog('Opravdu chcete smazat tento produkt?', deleteShop_produkt2, id);
}

function deleteShop_produkt2(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=delete_produkt&id="+id, refreshShopCategory)) {
		//pokud nefunguje ajax
		return;
	}
}

function refreshShopCategory(text) {
	createAlert(text);
	loadShopCategory(actual_page_part, actual_shop_id);
}

function deleteShop_image(file) {
	createDialog('Opravdu chcete smazat tento obrazek?', deleteShop_image2, file);
}

function deleteShop_image2(file) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=delete_image&file="+file, shopProduktRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}

function radioSelectShop_image(file) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=set_head_image&file="+file, shopProduktRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}

var aktual_produkt_id;
function addShop_image(page_part, produkt_id) {
	actual_produkt_id = produkt_id;
	actual_page_part = page_part;
	changeWindow('jumpLoaderApplet_SHOP', false, 600, false, false);
	document.getElementById('jumpLoaderApplet_SHOP').style.width = "100%";
        aktual_uploader = "SHOP";
}





function editShop(text) {
    if (text != null) {
        createAlert(text);
    }
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=objednavky", pageLoaded)) {
        //pokud nefunguje ajax
        return;
    }
    setStatusPage();
}

function shopObjednavkaSetNevyrizeno(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=set_vyrizeno&vyrizeno=0&id="+id, editShop)) {
        //pokud nefunguje ajax
        return;
    }
}

function shopObjednavkaSetVyrizeno(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=set_vyrizeno&vyrizeno=1&id="+id, editShop)) {
        //pokud nefunguje ajax
        return;
    }
}
function shopObjednavkaSendMail(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=send_mail_table&id="+id, createWindow)) {
        //pokud nefunguje ajax
        return;
    }
}

function shopObjednavkaSendMail2(id) {
    zavriWindow();
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=send_mail&id="+id+"&text="+fixQuery(jQuery("#shop_mail_text").val()), editShop)) {
        //pokud nefunguje ajax
        return;
    }
}

function showObjednavka(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=show_objednavka&id="+id, createWindow)) {
        //pokud nefunguje ajax
        return;
    }
}




function save_postovne() {
    var postovne = jQuery("#shop_postovne").val();
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=set_postovne&postovne="+postovne, createAlert)) {
        //pokud nefunguje ajax
        return;
    }
}

function save_dph() {
    var dph = jQuery("#shop_dph").val();
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=shop&action=set_dph&dph="+dph, createAlert)) {
        //pokud nefunguje ajax
        return;
    }
}