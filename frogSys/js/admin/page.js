// JavaScript Document


addLoadEvent(initPage);

//anchor reload
function anchor_reload() {
    if (location.href.indexOf("#") != -1) {
        var query = location.href.split('#');
        if (query[1] == 'null') {
            var url = URL;
        } else {
            var url = URL+query[1]+"/";
        }
        location.href = url;
    }
}
anchor_reload();

function initPage() {
	appendAttribute(document.getElementsByTagName("body")[0], "onmouseup", "stopObrysMouseDragPage(event);");
	appendAttribute(document.getElementsByTagName("body")[0], "onmousemove", "obrysMouseDragPage(event);");
}

var resizePage, leftRes, rightRes, startXRes, startLeftWidth, startRightWidth, leftFinalWidth;
function startPageResize(event, left, right, el) {
    el.setAttribute("onmouseout", "");
	resizePage = true;
	leftRes = left;
	rightRes = right;
	startXRes = event.clientX;
	startLeftWidth = document.getElementById("content_about_"+left).offsetWidth;
	startRightWidth = document.getElementById("content_about_"+right).offsetWidth;	
}


function stopObrysMouseDragPage(event) {
	if (resizePage == true) {
		if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=page&action=resize&left="+leftRes+"&right="+rightRes+
			"&left_width="+leftFinalWidth, pageRefresh)) {
			//pokud nefunguje ajax
			return;
		}
		resizePage = false;
	}

}

function obrysMouseDragPage(event) {
	if (resizePage == true) {
		var delta = startXRes - event.clientX;
		clearSelection();
		if (startLeftWidth-delta > 80 && startRightWidth+delta > 80) {
			leftFinalWidth = startLeftWidth-delta;
			var rightFinalWidth = startRightWidth+delta;
			document.getElementById("content_about_"+leftRes).style.width = leftFinalWidth+"px";
			document.getElementById("content_about_"+rightRes).style.width = rightFinalWidth+"px";
                        document.getElementById("info_width_"+rightRes).innerHTML = rightFinalWidth+"px";
		}
	}

}















function movePageSloupec(event, id) {
	moveItem(event, id, "content_about_", savePageSloupecPosition);
}
function savePageSloupecPosition(id, changeWith) {
	//alert(id+" před "+changeWith);
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=page&action=sort&id="+id+"&change_with="+changeWith, pageRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}



function addPageSloupec(id, place) {
        if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=page&action=add_part&parent="+id+"&place="+place, pageRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}


function deletePageSloupec(id) {
	createDialog('Opravdu chcete smazat tento sloupec?', deletePageSloupec2, id);
}

function deletePageSloupec2(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=page&action=delete_part&id="+id, pageRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}

function moveSloupecUp(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=page&action=move&smer=up&id="+id, pageRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}
function moveSloupecDown(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=page&action=move&smer=down&id="+id, pageRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}



function editPageSloupec(id) {
    id_href_window = id;
    aktual_href_co = "Sloupec";
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=page&action=href_table&co=Sloupec&id="+id, createWindow)) {
        //pokud nefunguje ajax
        return;
    }
}





function zobrazHref(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/subPage.php", "page_part="+id, zobrazHref2)) {
		//pokud nefunguje ajax
		return;
	}
}

function zobrazHref2(text) {
	createWindow(text);
}


var id_href_window, aktual_href_co;
function refreshHrefTable(text) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=page&action=href_table&co="+aktual_href_co+"&id="+id_href_window, refreshHrefTable2)) {
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

function deleteHref(id) {
	createDialog('Opravdu chcete smazat tuto stránku?', deleteHref2, id);
}

function deleteHref2(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=page&action=delete_href&id="+id, refreshHrefTable)) {
		//pokud nefunguje ajax
		return;
	}
}

function nastavHrefSloupec(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=page&action=set_first_href&id="+id_href_window+"&first="+id, pageRefresh)) {
		//pokud nefunguje ajax
		return;
	}
	zavriWindow();
}



function showStaticEditPole(el, visible) {
    if (visible == 1) {
        changeOpacity(jQuery(el).children(".edit_pole").attr("id"), 1);
    } else {
        changeOpacity(jQuery(el).children(".edit_pole").attr("id"), 0.01);
    }
}