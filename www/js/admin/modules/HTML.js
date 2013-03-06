// JavaScript Document


function addHtml(id) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = id;
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=html&action=add&parent="+id, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}

function deleteHtml(idHtml, id) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = id;
	createDialog('Opravdu chcete smazat tuto HTML stránku?', deleteHtml2, idHtml);
}

function deleteHtml2(id) {
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=html&action=delete&id="+id, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}


function editHtml(idHtml, id) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = id;
	var contentIn = document.getElementById("content_in_"+idHtml);
	contentIn.removeChild(getElementsByClassNameMy("edit_pane_Html", contentIn)[0]);
	var textarea = "<form action=\"javascript: saveHtml("+idHtml+");\">"+
		"<div name=\"edited_content_"+idHtml+"\" id=\"edited_content_"+idHtml+"\" class=\"edited_content\" style=\"height: "+(contentIn.offsetHeight)+"px;\">"+
		//contentIn.innerHTML+
		"</div>"+
		"</form>";
	var text = contentIn.innerHTML;
	contentIn.innerHTML = textarea;
	var ed = loadTinyMCE("edited_content_"+idHtml);
	//ed.setContent(text);
	document.getElementById("edited_content_"+idHtml).innerHTML = text;
	
	// fix vyska
	//var objekt2 = document.getElementById("page_in");
	//var vyska1 = objekt2.offsetHeight;
	//objekt2.style.height = "auto";
	//var vyska2 = objekt2.offsetHeight;
	//objekt2.style.height = vyska1+"px";
	changeWindow("page_in", false, "auto", false, false);  
}

function saveHtml(id) {
	var text = tinyMCE.get("edited_content_"+id).getContent();
	tinyMCE.remove(tinyMCE.get("edited_content_"+id));
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=html&action=save&id="+id+"&text="+fixQuery(text), partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}







function editStyleHtml(idHtml, id) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = id;
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=html&action=editStyleForm&id="+idHtml, createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}

function setStyleHtml(id, css) {
	document.getElementById(id).setAttribute("style", css);// = css;
}

function saveStyleHtml(id, style) {
	zavriWindow();
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=html&action=saveStyle&id="+id+"&style="+style, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}


function newStyleHtml(id) {
	zavriWindow();
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=html&action=newStyle&id="+id+"&style=0", createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}

function saveNewStyleHtml(id, style) {
	var css = document.getElementById("css_edit_"+id).value;
	var name = document.getElementById("name_edit_"+id).value;
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=html&action=saveNewStyle&style="+style+"&css="+fixQuery(css)+"&name="+fixQuery(name), null)) {
		//pokud nefunguje ajax
		return;
	}
	//zavriWindow();
	saveStyleHtml(id, style);
}

function deleteHtmlStyle(id, style) {
	createDialog("Opravdu chcete smazat Html styl?", deleteHtmlStyle2, style);
}
function deleteHtmlStyle2(style) {
	zavriWindow();
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=html&action=deleteNewStyle&style="+style, createAlert)) {
		//pokud nefunguje ajax
		return;
	}
}
function editHtmlStyle(id, style) {
	zavriWindow();
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=html&action=newStyle&id="+id+"&style="+style, createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}