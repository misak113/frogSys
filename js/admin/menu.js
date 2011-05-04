// JavaScript Document



function moveMenu(event, id) {
	moveItem(event, id, "menu_item_", saveMenuPosition);
}
function saveMenuPosition(id, changeWith) {
	//alert(id+" před "+changeWith);
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=menu&action=sort&id="+id+"&change_with="+changeWith, menuEdited)) {
		//pokud nefunguje ajax
		return;
	}
}









function deleteMenu(id) {
	createDialog('Opravdu chcete smazat tuto položku menu?', deleteMenu2, id);
}

function deleteMenu2(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=menu&action=delete&id="+id, menuEdited)) {
		//pokud nefunguje ajax
		return;
	}
}

var idEditedMenu;
function editMenu(id) {
	idEditedMenu = id;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=menu&action=edit_form&id="+id, editMenu2)) {
		//pokud nefunguje ajax
		return;
	}
}
function editMenu2(text) {
	createWindow(text);
	//loadTinyMCE("menu_nazev_"+idEditedMenu);
}
function menuEdited(text) {
	// nacti menu znova
	loadMenu();
	createAlert(text);
}



var staraSirkaMenuLeft;
function openMenu() {
	var objekt = document.getElementById("menu_left");
	var objektIn = document.getElementById("menu_left_in");
	var objektR = document.getElementById("menu_right");
	if (objekt.style.width != "auto") {
		staraSirkaMenuLeft = objekt.style.width;
		objekt.style.width = "auto";
		objektIn.style.width = "auto";
		objektR.style.zIndex = "-1";
	} else {
		objekt.style.width = staraSirkaMenuLeft;
		objektIn.style.width = staraSirkaMenuLeft;
		objektR.style.zIndex = "0";
	}
}


function saveMenu(id) {
	var nazev = document.getElementById("menu_nazev_"+id).value;
	var odkaz = document.getElementById("menu_odkaz_"+id).value;
	var visible = 1;
	if (document.getElementById("menu_hide_"+id).checked) {
		visible = 0;
	}
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=menu&action=edit&id="+id+"&name="+fixQuery(nazev)+"&link="+fixQuery(odkaz)+"&visible="+visible, menuEdited)) {
		//pokud nefunguje ajax
		return;
	}
	zavriWindow();
}






function addMenu(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=menu&action=add&id="+id, menuAdded)) {
		//pokud nefunguje ajax
		return;
	}
}

function menuAdded(text) {
	loadMenu();
	editMenu(parseInt(text));
}
