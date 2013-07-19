// JavaScript Document


function addHtml(id) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = id;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=html&action=add&parent="+id, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}

function deleteHtml(idHtml, id) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = id;
	createDialog('Opravdu chcete smazat tento editovatelný obsah?', deleteHtml2, idHtml);
}

function deleteHtml2(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=html&action=delete&id="+id, partRefresh)) {
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
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=html&action=save&id="+id+"&text="+fixQuery(text), partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}







function editStyleHtml(idHtml, id) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = id;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=html&action=editStyleForm&id="+idHtml, createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}

function setStyleHtml(id, css, name) {
	document.getElementById(id).setAttribute("style", css);// = css;
        var trida = document.getElementById(id).getAttribute("class");
        var tridy = trida.split(" ", trida.length);
        trida = "";
        for (var i=0;i < tridy.length;i++) {
            if (tridy[i].indexOf("html_style_") == -1) {
                trida += tridy[i]+" ";
            }
        }
        trida += "html_style_"+name;
        document.getElementById(id).setAttribute("class", trida);
}

function saveStyleHtml(id, style) {
	zavriWindow();
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=html&action=saveStyle&id="+id+"&style="+style, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}


function newStyleHtml(id) {
	zavriWindow();
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=html&action=newStyle&id="+id+"&style=0", createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}

function saveNewStyleHtml(id, style) {
	var css = document.getElementById("css_edit_"+id).value;
	var name = document.getElementById("name_edit_"+id).value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=html&action=saveNewStyle&style="+style+"&css="+fixQuery(css)+"&name="+fixQuery(name), null)) {
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
	//zavriWindow();
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=html&action=deleteNewStyle&style="+style, createAlert)) {
		//pokud nefunguje ajax
		return;
	}
}
function editHtmlStyle(id, style) {
	zavriWindow();
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=html&action=newStyle&id="+id+"&style="+style, createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}




function moveHtml(event, id, target) {
    var cont = jQuery("#page_part_"+target).parent().attr("id");
    var part = cont.substring(8);
    aktualSubTarget = part;
    aktualSubPage = target;
    var eo = jQuery("#page_part_"+target).parent().children();
    eo.css("height", "30px");
    eo.css("margin", "20px 10px");
    eo.css("background-color", "#E2E2E2");
    eo.css("border", "1px solid #CCCCCC");
    eo.css("padding", "10px");
    eo.css("overflow", "hidden")
    moveItem(event, id, "content_in_", saveHtmlPosition);
}
function saveHtmlPosition(id, changeWith) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=html&action=sort&id="+id+"&change_with="+changeWith, partRefresh)) {
        //pokud nefunguje ajax
        return;
    }
}

