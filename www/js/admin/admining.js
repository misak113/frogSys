// JavaScript Document

function editAdmins() {
	if (!postAjaxRequest("/bin/ajax/admining.php", "predmet=admins&action=edit_form", createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}

function setStatusPage() {
	if (!postAjaxRequest("/bin/ajax/admining.php", "predmet=pages&action=get_names&page="+aktualPage+"&sub_page="+aktualSubPage, setStatusPage2)) {
		//pokud nefunguje ajax
		return;
	}
}
function setStatusPage2(text) {
	document.getElementById("aktual_stranka").innerHTML = text;  
}

function editAdmin(id) {
	zavriWindow();
	if (!postAjaxRequest("/bin/ajax/admining.php", "predmet=admins&action=edit&id="+id, createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}

function saveAdmin(id) {
	var user = document.getElementById("username_"+id).value;
	var pass = document.getElementById("password_"+id).value;
	if (!postAjaxRequest("/bin/ajax/admining.php", "predmet=admins&action=edited&id="+id+"&user="+user+"&pass="+pass, createAlert)) {
		//pokud nefunguje ajax
		return;
	}
	zavriWindow();
}

function addAdmin() {
	zavriWindow();
	if (!postAjaxRequest("/bin/ajax/admining.php", "predmet=admins&action=add", addAdmin2)) {
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
	if (!postAjaxRequest("/bin/ajax/admining.php", "predmet=admins&action=delete&id="+id, createAlert)) {
		//pokud nefunguje ajax
		return;
	}
}









function odhlasit() {
	if (!postAjaxRequest("/bin/ajax/admining.php", "predmet=odhlasit&action=otazka", odhlasit2)) {
		//pokud nefunguje ajax
		return;
	}
}

function odhlasit2(text) {
	createDialog(text, odhlasit3, 0);
}

function odhlasit3() {
	if (!postAjaxRequest("/bin/ajax/admining.php", "predmet=odhlasit&action=odhlasit", reloadPage)) {
		//pokud nefunguje ajax
		return;
	}
}





function napoveda() {
	if (!postAjaxRequest("/text_files/napoveda.txt", "", createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}




function editTitulek() {
	//var title = document.getElementById("titulek");
	var text = '<input type="text" id="input_titulek" value="'+document.getElementById("titulek_text").innerHTML+'">'+
						'<input type="button" value="uložit" onclick="saveTitulek();">';
	changeText("titulek", text);
}

function saveTitulek() {
	var text = document.getElementById("input_titulek").value;
	if (!postAjaxRequest("/bin/ajax/admining.php", "predmet=titulek&action=save&text="+fixQuery(text), saveTitulek2)) {
		//pokud nefunguje ajax
		return;
	}
}

function saveTitulek2(text) {
	createAlert(text);
	if (!postAjaxRequest("/bin/ajax/titulek.php", "", saveTitulek3)) {
		//pokud nefunguje ajax
		return;
	}
}

function saveTitulek3(text) {
	changeText("titulek", text);
}