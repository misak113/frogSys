// JavaScript Document

addLoadEvent(initUser);

function initUser() {
	//loadPage(aktualPage);
	//loadMenu();
	//loadTop_title();
	loadingOff();
}

function loadPage(id) {
	aktualPage = id;
	aktualSubPage = null;
	if (!postAjaxRequest("/bin/ajax/page.php", "page="+id, pageLoaded)) {
		//pokud nefunguje ajax
		return;
	}
	setStatusPage();
}

function pageLoaded(text) {
		var objekt = document.getElementById("page_in");
		//var vyska1 = objekt.offsetHeight;
		var oldText = objekt.innerHTML;
		objekt.innerHTML = text;
		//objekt.style.height = "auto";
		//var vyska2 = objekt.offsetHeight;
		//objekt.style.height = vyska1+"px";
		changeWindow("page_in", false, "auto", false, false);
		objekt.innerHTML = oldText;
		changeText("page_in", text);
}

function loadMenu() {
	if (!postAjaxRequest("/bin/ajax/menu.php", "", menuLoaded)) {
		//pokud nefunguje ajax
		return;
	}
}

function menuLoaded(text) {
		changeText("menu", text);
}

function loadTop_title() {
	if (!postAjaxRequest("/bin/ajax/top_title.php", "", top_titleLoaded)) {
		//pokud nefunguje ajax
		return;
	}
}

function top_titleLoaded(text) {
		changeText("top_title", text);
}

var target, aktualSubPage, aktualSubTarget, aktualClickPart;
function loadSubPage(id, target) {
	this.target = target;
	aktualSubPage = id;
	if (!postAjaxRequest("/bin/ajax/subPage.php", "page_part="+id, subPageLoaded)) {
		//pokud nefunguje ajax
		return;
	}
	setStatusPage();
}

function subPageLoaded(text) {
	var objekt = document.getElementById("content_"+target);
	var objekt2 = document.getElementById("page_in");
	//var vyska1 = objekt2.offsetHeight;
	var oldText = objekt.innerHTML;
	objekt.innerHTML = text;
	/*objekt2.style.height = "auto";
	var vyska2 = objekt2.offsetHeight;
	objekt2.style.height = vyska1+"px"; */
	changeWindow("page_in", false, "auto", false, false);
	objekt.innerHTML = oldText;
	changeText("content_"+target, text);
}






function pageRefresh(text) {
	loadPage(aktualPage);
	createAlert(text);
}




function partRefresh(text) {
	loadSubPage(aktualSubPage, aktualSubTarget);
	createAlert(text);
}








function loadingOn() {
	//clearTimeout(timeParametry["loading"]);
	//clearTimeout(timeOpacity["loading"]);
	//changeOpacity("loading", 1);
	//changeWindow("loading", false, 100, false, false);
	document.getElementById("loading").style.display = "block";
}

function loadingOff() {
	//clearTimeout(timeParametry["loading"]);
	//clearTimeout(timeOpacity["loading"]);
	//changeOpacity("loading", 0.01);
	//changeWindow("loading", false, 1, false, false);
	document.getElementById("loading").style.display = "none";
}