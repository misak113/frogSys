// JavaScript Document

function editAdmins() {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/admining.php", "predmet=admins&action=edit_form", createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}

function setStatusPage() {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/admining.php", "predmet=pages&action=get_names&page="+aktualPage+"&sub_page="+aktualSubPage, setStatusPage2)) {
		//pokud nefunguje ajax
		return;
	}
}
function setStatusPage2(text) {
	document.getElementById("aktual_stranka").innerHTML = text;
}

function editAdmin(id) {
	zavriWindow();
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/admining.php", "predmet=admins&action=edit&id="+id, createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}

function saveAdmin(id) {
	var user = document.getElementById("username_"+id).value;
	var pass = document.getElementById("password_"+id).value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/admining.php", "predmet=admins&action=edited&id="+id+"&user="+user+"&pass="+pass, createAlert)) {
		//pokud nefunguje ajax
		return;
	}
	zavriWindow();
}

function addAdmin() {
	zavriWindow();
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/admining.php", "predmet=admins&action=add", addAdmin2)) {
		//pokud nefunguje ajax
		return;
	}
}

function addAdmin2(text) {
	editAdmin(parseInt(text));
}

function deleteAdmin(id) {
	zavriWindow();
	createDialog("Opravdu chcete smazat administrátora?", deleteAdmin2, id);
}

function deleteAdmin2(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/admining.php", "predmet=admins&action=delete&id="+id, createAlert)) {
		//pokud nefunguje ajax
		return;
	}
}









function odhlasit() {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/admining.php", "predmet=odhlasit&action=odhlasit", reloadPage)) {
		//pokud nefunguje ajax
		return;
	}
}





function napoveda() {
	if (!postAjaxRequest(URL+"frogSys/text_files/napoveda.txt", "", createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}





var admin_menu = new Array();
function rozbal_menu(menu, stav) {
    if ((jQuery("#"+menu).css("height") != "26px" || stav == 0) && stav != 1) {
        changeWindow(menu, false, "26", false, false);
    } else {
        changeWindow(menu, false, "auto", false, false);
    }
}

function aboat() {
    var verze = 'Není k dispozici';
    var metas = document.getElementsByTagName("meta");
    for (var i=0;i<metas.length;i++) {
        if (metas[i].getAttribute("name") == 'version') {
            verze = metas[i].getAttribute("content");
        }
    }
    createWindow('<div style="text-align: center;"><h1>frogSys</h1><img src="'+URL+'frogSys/images/rs/logo_frogSys.png" alt="logo frogSys"><br /><span>Aktuální verze používaného systému:</span><br /><span style="font-size: 19px; color: #5b0000; font-family: Courier new; font-style: italic; font-weight: bold;">'+verze+'</span><br /><small><i>Copyright Michael Žabka - Všechna práva vyhrazena</i></small></div>');
}

function editModuly() {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/admining.php", "predmet=moduly&action=vypis", createWindow)) {
        //pokud nefunguje ajax
        return;
    }
}

function checkboxSelectModul(id, el) {
    var zapnut = 0;
    if (el.checked) {
        zapnut = 1;
        jQuery(el).parent().parent().children("span:first-child").css("color", "");
    } else {
        jQuery(el).parent().parent().children("span:first-child").css("color", "#e50000");
    }
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/admining.php", "predmet=moduly&action=set_zapnut&zapnut="+zapnut+"&id="+id, createAlert)) {
        //pokud nefunguje ajax
        return;
    }
}





function strankyAdmin() {
    createWindow("Stránky - Právě je ve vývoji.");
}

function menuAdmin() {
    createWindow("Menu - Právě je ve vývoji.");
}