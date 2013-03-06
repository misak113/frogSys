// JavaScript Document


function createEmptyWindow() {
	var win = ''+
		'<div id="outer_window_objekt">'+
		'	<div id="window_objekt" class="window_objekt" onmousedown="setActive1(this.id);">'+
		'		<table class="window_table" cellspacing="0" border="0">'+
		'			<tr onmousedown="startPresun(event);">'+
		'				<td class="window_lt"></td>'+
		'				<td class="window_t">'+
		'					<div class="window_popisek"></div>'+
		'					<a href="javascript: zavriWindow();"><img src="/images/window/close.png" class="window_close" alt="zavřít" /></a>'+
		'				</td>'+
		'				<td class="window_rt"></td>'+
		'			</tr>'+
		'			<tr>'+
		'				<td class="window_lm"></td>'+
		'				<td class="window_m">'+
		'					<div class="window_text"></div>'+
		'				</td>'+
		'				<td class="window_rm"></td>'+
		'			</tr>'+
		'			<tr>'+
		'				<td class="window_lb"></td>'+
		'				<td class="window_b"></td>'+
		'				<td class="window_rb" onmousedown="startResize(event);"></td>'+
		'			</tr>'+
		'		</table>'+
		'	</div>'+
		'</div>'+
		'<div id="info_box">'+
		'</div>'+
		'';
		
	var body = getBody();
	body.innerHTML = body.innerHTML + win;
	
	/*body.appendChild(Builder.node('div',{id:'outer_window_objekt'}, [
		Builder.node('div',{id:'window_objekt', class:'window_objekt', onmousedown:'setActive1(this.id);'}, [
		
		])
	]));*/
	//document.getElementById("outer_window_objekt").innerHTML = win;
	
	changeOpacityQuick("window_objekt", 0.01);
}



var presouvam = false;
var resizing = false;
var mysX;
var mysY;
function startPresun(event) {
	presouvam = true;
	mysX = event.clientX;
	mysY = event.clientY;
}

function startResize(event) {
	resizing = true;
	mysX = event.clientX;
	mysY = event.clientY;
}

function stopMouseDrag(event) {
	presouvam = false;
	resizing = false;
}

function mouseDrag(event) {
	var objekt = document.getElementById(aktualId);
	var deltaX = event.clientX-mysX;
	var deltaY = event.clientY-mysY;
	mysX = event.clientX;
	mysY = event.clientY;
	if (presouvam == true) {
		clearSelection();
		objekt.style.left = (objekt.offsetLeft+deltaX)+"px";
		objekt.style.top = (objekt.offsetTop+deltaY)+"px";
	}
	if (resizing == true) {
		clearSelection();
		objekt.style.width = (objekt.offsetWidth+deltaX)+"px";
		objekt.style.height = (objekt.offsetHeight+deltaY)+"px";
	} 
}

var aktualId = "window_objekt";
var preAktualId = "window_objekt";
function setActive1(id) {
	try {
		if (document.getElementById(aktualId).style.zIndex < 50) {
			document.getElementById(id).style.zIndex = 50;
		} else {
			document.getElementById(id).style.zIndex = 1+parseInt(document.getElementById(aktualId).style.zIndex);
		}
	} catch (e) {}
	preAktualId = aktualId;
	aktualId = id;
}

function zavriWindow() {
	zavriWindowId(aktualId);
}

function zavriWindowId(id) {
	changeOpacity(id, 0.01);
	setTimeout("document.body.removeChild(document.getElementById('"+id+"')); aktualId='window_objekt'", 20*21);
	clearTimeout(autoZavriWindow[id]);
	aktualId = "window_objekt";
	setActive1(preAktualId);
}














function createDialog(text, potvrzeno, id) {
	//vytvori dialog a po stisknuti ANO spusti funkci potvrzeno s parametrem id
	var newWin = document.getElementById("window_objekt").cloneNode(true);
	getBody().appendChild(newWin); 
	//var noveOkno = document.getElementById("outer_window_objekt").innerHTML;
	document.getElementById("window_objekt").id = "window_zalozni";
	//document.getElementById("head_body").innerHTML += noveOkno;
	var idWin = "window_"+Math.random();
	document.getElementById("window_objekt").id = idWin;
	document.getElementById("window_zalozni").id = "window_objekt";
	//changeWindow(idWin, 210, 180, 400+Math.ceil(Math.random()*50)+document.documentElement.scrollLeft, 100+Math.ceil(Math.random()*50)+document.documentElement.scrollTop);
	changeWindowQuick(idWin, 210, 180, 400+Math.ceil(Math.random()*50)+document.documentElement.scrollLeft+document.body.scrollLeft, 100+Math.ceil(Math.random()*50)+document.documentElement.scrollTop+document.body.scrollTop);
	changeOpacity(idWin, 1);    
	var objekt = document.getElementById(idWin);
	var textObjekt = getElementsByClassNameMy("window_text", objekt)[0];
	var nadpisObjekt = getElementsByClassNameMy("window_popisek", objekt)[0];
	var resizeObjekt = getElementsByClassNameMy("window_rb", objekt)[0];
	resizeObjekt.onmousedown = "";
	resizeObjekt.style.cursor = "Auto";
	nadpisObjekt.innerHTML = "dialogové okno";
	textObjekt.innerHTML += "<div style=\"margin: 10px auto 10px auto; position: relative;\">"+text+"</div>";
	textObjekt.innerHTML += "<div style=\"margin: 10px auto 10px auto; position: relative;\">"+
							createButon("ano", getFunctionName(potvrzeno)+"('"+id+"'); zavriWindow('"+idWin+"')") + 
							createButon("ne", "zavriWindow()") +
							"</div>";
	setActive1(idWin);
	return idWin;
}

var autoZavriWindow = new Array();
function createAlert(text) {
	//return; // vypnuto kvuli kuchvovi
	//vytvori upozorneni ktere pouze oznámí, a lze odkliknout OK
	var newWin = document.getElementById("window_objekt").cloneNode(true);
	getBody().appendChild(newWin); 
	//var noveOkno = document.getElementById("outer_window_objekt").innerHTML;
	document.getElementById("window_objekt").id = "window_zalozni";
	//document.getElementById("head_body").innerHTML += noveOkno;
	var idWin = "window_"+Math.random();
	document.getElementById("window_objekt").id = idWin;
	document.getElementById("window_zalozni").id = "window_objekt";
	changeWindowQuick(idWin, 200, 60, 10, 40);
	changeOpacity(idWin, 1);                
	var objekt = document.getElementById(idWin);
	objekt.style.position = "fixed";
	var textObjekt = getElementsByClassNameMy("window_text", objekt)[0];
	var nadpisObjekt = getElementsByClassNameMy("window_popisek", objekt)[0];
	var resizeObjekt = getElementsByClassNameMy("window_rb", objekt)[0];
	resizeObjekt.onmousedown = "";
	resizeObjekt.style.cursor = "Auto";
	nadpisObjekt.innerHTML = "upozornění";
	textObjekt.innerHTML += "<div style=\"margin: 10px auto 10px auto; position: relative;\">"+text+"</div>";
	textObjekt.innerHTML += "<div style=\"margin: 10px auto 10px auto; position: relative;\">"+
							//createButon("OK", "zavriWindow()") +
							"</div>";
	autoZavriWindow[idWin] = setTimeout("zavriWindowId('"+idWin+"')", 2000);
	setActive1(idWin);
	return idWin;
}

function createButon(text, kliknuti) {
	var buton =	"<input type=\"button\" onclick=\""+kliknuti+";\" value=\""+text+"\" class=\"window_buton\">";
	return buton;
}


function createWindow(text) {
	var newWin = document.getElementById("window_objekt").cloneNode(true);
	getBody().appendChild(newWin); 
	//var noveOkno = document.getElementById("outer_window_objekt").innerHTML;
	document.getElementById("window_objekt").id = "window_zalozni";
	
	//document.getElementById("head_body").innerHTML += noveOkno;
	var idWin = "window_"+Math.random();
	document.getElementById("window_objekt").id = idWin;
	document.getElementById("window_zalozni").id = "window_objekt";                
	changeOpacity(idWin, 1);              
	var objekt = document.getElementById(idWin);
	var textObjekt = getElementsByClassNameMy("window_text", objekt)[0];
	var nadpisObjekt = getElementsByClassNameMy("window_popisek", objekt)[0];
	nadpisObjekt.innerHTML = "okno";
	textObjekt.innerHTML = text;
	changeWindowQuick(idWin, "auto", "auto", 50, 50);
	changeWindowQuick(idWin, false, false, (document.body.clientWidth-document.getElementById(idWin).offsetWidth)/2+document.documentElement.scrollLeft+document.body.scrollLeft, 
	//(document.body.clientHeight-document.getElementById(idWin).offsetHeight)/2+document.documentElement.scrollTop+document.body.scrollTop
	100+document.documentElement.scrollTop+document.body.scrollTop
	);
	setActive1(idWin);
	return idWin;
}

