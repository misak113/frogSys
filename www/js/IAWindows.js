// JavaScript Document

loadScript("/js/IAWindows/prechody.js");
loadScript("/js/IAWindows/windows.js");

addLoadEvent(function() {
	appendAttribute(document.getElementsByTagName("body")[0], "onmouseup", "stopMouseDrag(event);");
	appendAttribute(document.getElementsByTagName("body")[0], "onmousemove", "mouseDrag(event);");
	createEmptyWindow();
});

function postAjaxRequest(page, parametrs, afterFunction) {
	var http_request = false;
	if (typeof window.ActiveXObject != 'undefined') {
    	http_request = new ActiveXObject('Microsoft.XMLHTTP');
	} else {
		http_request = new XMLHttpRequest();
	}
	if (!http_request) {
		createAlert("Ve vašem prohlížeči nefunguje podpora AJAX!");
		return false;
	}	
	try {
		loadingOn();
	} catch (e) {}
	http_request.onreadystatechange = function () {
		if (http_request.readyState == 4) {
			if (http_request.status == 200) {
				result = http_request.responseText;
				afterFunction(result);            
			} else {
				afterFunction("<p>Při načítání stránky došlo k chybě "+http_request.status+"</p>"); 
			}
			try {
				loadingOff();
			} catch (e) {}
		}
	}
	http_request.open('POST', page, true);
	http_request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	http_request.setRequestHeader("Connection", "close");
	http_request.setRequestHeader("Content-length", parametrs.length);
	http_request.send(parametrs);
	return true;
}






/**
 *   Pro použití INFOBOX na kterýkoli objekt vložte následující atributy
 *
 *   onmouseover="showInfo(event, 'Zobrazovaný text');" onmouseout="hideInfo();" onmousemove="reshowInfo(event);"
 */   



function showInfo(event, text) {
	clearTimeout(hidingTime);
	var objekt = document.getElementById("info_box");
	objekt.innerHTML = text;
	objekt.style.display = "block";
	objekt.style.left = (event.clientX+document.documentElement.scrollLeft+document.body.scrollLeft+15)+"px";
	objekt.style.top = (event.clientY+document.documentElement.scrollTop+document.body.scrollTop+3)+"px";
	changeOpacity("info_box", 1);
}

function reshowInfo(event) {
	var objekt = document.getElementById("info_box");
	objekt.style.left = (event.clientX+document.documentElement.scrollLeft+document.body.scrollLeft+15)+"px";
	objekt.style.top = (event.clientY+document.documentElement.scrollTop+document.body.scrollTop+3)+"px";
}

var hidingTime;
function hideInfo() {
	changeOpacity("info_box", 0.01);
	hidingTime = setTimeout("document.getElementById('info_box').style.display = 'none'", 20*20);
}




function getBody() {
	try {
		var body = document.getElementById("head_body");
	} catch (e) {
		var body = document.all.head_body;
	}
	return body;//$$('body')[0];
}

