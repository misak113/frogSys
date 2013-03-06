// JavaScript Document


addLoadEvent(initPage);

function initPage() {
	appendAttribute(document.getElementsByTagName("body")[0], "onmouseup", "stopObrysMouseDragPage(event);");
	appendAttribute(document.getElementsByTagName("body")[0], "onmousemove", "obrysMouseDragPage(event);");
}

var resizePage, leftRes, rightRes, startXRes, startLeftWidth, startRightWidth, leftFinalWidth;
function startPageResize(event, left, right) {
	resizePage = true;
	leftRes = left;
	rightRes = right;
	startXRes = event.clientX;
	startLeftWidth = document.getElementById("content_about_"+left).offsetWidth;
	startRightWidth = document.getElementById("content_about_"+right).offsetWidth;	
}


function stopObrysMouseDragPage(event) {
	if (resizePage == true) {
		if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=page&action=resize&left="+leftRes+"&right="+rightRes+
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
		}
	}

}















function movePageSloupec(event, id) {
	moveItem(event, id, "content_about_", savePageSloupecPosition);
}
function savePageSloupecPosition(id, changeWith) {
	//alert(id+" před "+changeWith);
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=page&action=sort&id="+id+"&change_with="+changeWith, pageRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}



function addPageSloupec(id) {
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=page&action=add_part&parent="+id, pageRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}


function deletePageSloupec(id) {
	createDialog('Opravdu chcete smazat tento sloupec?', deletePageSloupec2, id);
}

function deletePageSloupec2(id) {
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=page&action=delete_part&id="+id, pageRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}

