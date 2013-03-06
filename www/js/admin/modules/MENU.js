// JavaScript Document

function moveMenu_in(event, id, target) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = target;
	moveItem(event, id, "menu_in_item_", saveMenuInPosition);
}
function saveMenuInPosition(id, changeWith) {
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=menu_in&action=sort&id="+id+"&change_with="+changeWith, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}












function addMenu_in(id) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = id;
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=menu_in&action=add&parent="+id, menu_inAdded)) {
		//pokud nefunguje ajax
		return;
	}
}

function menu_inAdded(text) {
	editMenu_in(parseInt(text), aktualSubPage);
}

function deleteMenu_in(id, target) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = target;
	createDialog('Opravdu chcete smazat tuto položku menu?', deleteMenu_in2, id);
}

function deleteMenu_in2(id) {
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=menu_in&action=delete&id="+id, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}


var editedMenu_inId;
function editMenu_in(id, target) {
	editedMenu_inId = id;
	aktualSubTarget = aktualClickPart;
	aktualSubPage = target;
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=menu_in&action=edit_form&id="+id, editMenu_in2)) {
		//pokud nefunguje ajax
		return;
	}
}

function editMenu_in2(text) {
	var win = createWindow(text);
	var pole = getElementsByClassNameMy("window_t", document.getElementById(win));
	var azavri = pole[0].getElementsByTagName("a")[0];
	azavri.setAttribute("href", azavri.getAttribute("href")+" odbarviPole();");
	vybarviPole();
}

function setTargetAs(pole) {
	var targ = document.getElementById("menu_in_target_"+editedMenu_inId);
	if (targ == null) {
		odbarviPole();
		return;
	}
	var id = pole.id;
	targ.value = id.substring(10, id.length);
	vybarviPole();
}

function vybarviPole() {
	var pole = getElementsByClassNameMy("edit_pole");
	for (var i=0;i < pole.length;i++) {
		if (pole[i].id == "edit_pole_"+document.getElementById("menu_in_target_"+editedMenu_inId).value) {
			pole[i].style.backgroundColor = "#F0C8C8";
		} else {
			pole[i].style.backgroundColor = "#D7D7D7";
		}
		pole[i].setAttribute("onclick", "setTargetAs(this);");
	}
}
function odbarviPole() {
	var pole = getElementsByClassNameMy("edit_pole");
	for (var i=0;i < pole.length;i++) {
		pole[i].style.backgroundColor = "";
		pole[i].setAttribute("onclick", "");
	}
}

function saveMenu_in(id) {
	var nazev = document.getElementById("menu_in_nazev_"+id).value;
	var odkaz = document.getElementById("menu_in_odkaz_"+id).value;
	var target = document.getElementById("menu_in_target_"+id).value;
	var href = document.getElementById("menu_in_href_"+id).value;
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=menu_in&action=edit&id="+id
		+"&name="+fixQuery(nazev)+"&link="+fixQuery(odkaz)+"&target="+target+"&href="+href, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
	odbarviPole();
	zavriWindow();
}

function hrefingMenu_in(id) {
	id_href_window = id;
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=menu_in&action=href_table&id="+id, createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}

function deleteHref(id) {
	createDialog('Opravdu chcete smazat tuto stránku?', deleteHref2, id);
}

function deleteHref2(id) {
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=menu_in&action=delete_href&id="+id, refreshHrefTable)) {
		//pokud nefunguje ajax
		return;
	}
}

var id_href_window;
function refreshHrefTable(text) {
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=menu_in&action=href_table&id="+id_href_window, refreshHrefTable2)) {
		//pokud nefunguje ajax
		return;
	}
	createAlert(text);
}
function refreshHrefTable2(text) {
	var objekt = document.getElementById("hrefs_"+id_href_window);
	var textObjekt = getParentNode(objekt);
	textObjekt.id = "href_text_"+Math.random();
	changeText(textObjekt.id, text);
}




function zobrazHref(id) {
	if (!postAjaxRequest("/bin/ajax/subPage.php", "page_part="+id, zobrazHref2)) {
		//pokud nefunguje ajax
		return;
	}
}

function zobrazHref2(text) {
	createWindow(text);
}




function nastavHref(id) {
	document.getElementById("menu_in_href_"+editedMenu_inId).value = id;
	zavriWindow();
}

