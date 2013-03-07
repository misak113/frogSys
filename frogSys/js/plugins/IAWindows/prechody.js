// JavaScript Document


var changedText = new Array();
function changeText(id, text) {
    id = stripWhitespace(id);
	changedText[id] = text;
	if (document.getElementById(id) == null) {
		createAlert("Pro správné zobrazení použijte refresh!");
		return;
	}
	changeOpacity(id, 0.01);
	setTimeout("changeText2('"+id+"')", 20*21);
}

function changeText2(id) {
	document.getElementById(id).innerHTML = changedText[id];
	changeOpacity(id, 1);
}

function changeOpacityQuick(id, opacity) {
	var objekt = document.getElementById(id);
	if (opacity != false) {
		if (navigator.userAgent.indexOf("MSIE") > -1) {
			objekt.style.filter = "alpha(opacity="+Math.round(opacity*100)+")";
		}
		objekt.style.opacity = opacity;
		if (opacity <= 0.01) {
			objekt.style.display = "none";
		} else {
			objekt.style.display = "block";
		}	
	}
}

function changeOpacity(id, opacity) {
	var objekt = document.getElementById(id);
	if (opacity != false) {
		objektOpacity[id] = objekt;
		aktualOpacity[id] = objekt.style.opacity;
		if (aktualOpacity[id] == "" || aktualOpacity[id] == undefined) {
			aktualOpacity[id] = 1;
		} else {
			aktualOpacity[id] = parseFloat(aktualOpacity[id]);
		}
		finalyOpacity[id] = opacity;
		skokOpacity[id] = (finalyOpacity[id]-aktualOpacity[id])/20;
		meniOpacity[id] = 1;
	} else {
		meniOpacity[id] = 0;
	}
	menOpacity(id);
}


var skokOpacity = new Array();
var aktualOpacity = new Array();
var finalyOpacity = new Array();
var objektOpacity = new Array();
var meniOpacity = new Array();
var timeOpacity = new Array();
function menOpacity(id) {
	var podminka;
	if (meniOpacity[id] == 1) {
		if (skokOpacity[id] > 0) {
			podminka = (aktualOpacity[id]+skokOpacity[id]) < finalyOpacity[id];
		} else {
			podminka = (aktualOpacity[id]+skokOpacity[id]) > finalyOpacity[id];
		}
		aktualOpacity[id] += skokOpacity[id];
		if (podminka) {
			if (navigator.userAgent.indexOf("MSIE") > -1) {
				objektOpacity[id].style.filter = "alpha(opacity="+Math.round(aktualOpacity[id]*100)+")";
			}
			objektOpacity[id].style.opacity = aktualOpacity[id]; 
		} else {
			if (navigator.userAgent.indexOf("MSIE") > -1) {
				//objektOpacity[id].style.filter = "alpha(opacity="+Math.round(finalyOpacity[id]*100)+")";
				objektOpacity[id].style.filter = "";
			}
			objektOpacity[id].style.opacity = finalyOpacity[id];
			meniOpacity[id] = 0;      
		}
		if (aktualOpacity[id] <= 0.01) {
			objektOpacity[id].style.display = "none";
		} else {
			objektOpacity[id].style.display = "block";
		}
	}
	if (meniOpacity[id] > 0) {
		timeOpacity[id] = setTimeout("menOpacity('"+id+"')", 20);
	}
}







function changeWindow(id, width, height, x, y) {
	var objekt = document.getElementById(id);
	if (height !== false) {
		objektHeight[id] = objekt;
		aktualHeight[id] = objekt.offsetHeight;
		if (height != "auto") {
			finalyHeight[id] = height;
			lastHeight[id] = height+"px";
		} else {
			var zpet = objekt.style.height;
			objekt.style.height = "auto";
			finalyHeight[id] = objekt.offsetHeight;
			objekt.style.height = zpet;
			lastHeight[id] = "auto";
		}
		skokHeight[id] = (finalyHeight[id]-aktualHeight[id])/20;
		meniHeight[id] = 1;
	} else {
		meniHeight[id] = 0;
	}
	if (width !== false) {
		objektWidth[id] = objekt;
		aktualWidth[id] = objekt.offsetWidth;
		if (width != "auto") {
			finalyWidth[id] = width;
			lastWidth[id] = width+"px";
		} else {
			var zpet = objekt.style.width;
			objekt.style.width = "auto";
			finalyWidth[id] = objekt.offsetWidth;
			objekt.style.width = zpet;
			lastWidth[id] = "auto";
		}
		skokWidth[id] = (finalyWidth[id]-aktualWidth[id])/20;
		meniWidth[id] = 1;
	} else {
		meniWidth[id] = 0;
	}
	if (x !== false) {
		objektX[id] = objekt;
		aktualX[id] = objekt.offsetLeft;
		finalyX[id] = x;
		skokX[id] = (finalyX[id]-aktualX[id])/20;
		meniX[id] = 1;
	} else {
		meniX[id] = 0;
	}
	if (y !== false) {
		objektY[id] = objekt;
		aktualY[id] = objekt.offsetTop;
		finalyY[id] = y;
		skokY[id] = (finalyY[id]-aktualY[id])/20;
		meniY[id] = 1;
	} else {
		meniY[id] = 0;
	}
	menParametry(id);
}

function changeWindowQuick(id, width, height, x, y) {
	var objekt = document.getElementById(id);
	if (height !== false) {
		if (height == "auto") {
			objekt.style.height = height;
		} else {
			objekt.style.height = height+"px";
		}
	}
	if (width !== false) {
		if (width == "auto") {
			objekt.style.width = width;
		} else {
			objekt.style.width = width+"px";
		}
	}
	if (x !== false) {
		objekt.style.left = x+"px";
	}
	if (y !== false) {
		objekt.style.top = y+"px";
	}
}

var skokHeight = new Array();
var aktualHeight = new Array();
var finalyHeight = new Array();
var objektHeight = new Array();
var meniHeight = new Array();
var lastHeight = new Array();
var skokWidth = new Array();
var aktualWidth = new Array();
var finalyWidth = new Array();
var objektWidth = new Array();
var meniWidth = new Array();
var lastWidth = new Array();
var skokX = new Array();
var aktualX = new Array();
var finalyX = new Array();
var objektX = new Array();
var meniX = new Array();
var skokY = new Array();
var aktualY = new Array();
var finalyY = new Array();
var objektY = new Array();
var meniY = new Array();
var timeParametry = new Array();

function menParametry(id) {
	var podminka;
	if (meniHeight[id] == 1) {
		if (skokHeight[id] > 0) {
			podminka = (aktualHeight[id]+skokHeight[id]) < finalyHeight[id];
		} else {
			podminka = (aktualHeight[id]+skokHeight[id]) > finalyHeight[id];
		}
		if (podminka) {
			aktualHeight[id] += skokHeight[id];
			objektHeight[id].style.height = Math.round(aktualHeight[id])+"px";
		} else {
			//objektHeight[id].style.height = finalyHeight[id]+"px";
			objektHeight[id].style.height = lastHeight[id];
			meniHeight[id] = 0;
		}
	}
	if (meniWidth[id] == 1) {
		if (skokWidth[id] > 0) {
			podminka = (aktualWidth[id]+skokWidth[id]) < finalyWidth[id];
		} else {
			podminka = (aktualHeight[id]+skokWidth[id]) > finalyWidth[id];
		}
		if (podminka) {
			aktualWidth[id] += skokWidth[id];
			objektWidth[id].style.width = Math.round(aktualWidth[id])+"px";
		} else {
			//objektWidth[id].style.width = finalyWidth[id]+"px";
			objektWidth[id].style.width = lastWidth[id];
			meniWidth[id] = 0;
		}
	}
	if (meniX[id] == 1) {
		if (skokX[id] > 0) {
			podminka = (aktualX[id]+skokX[id]) < finalyX[id];
		} else {
			podminka = (aktualX[id]+skokX[id]) > finalyX[id];
		}
		if (podminka) {
			aktualX[id] += skokX[id];
			objektX[id].style.left = Math.round(aktualX[id])+"px";
		} else {
			objektX[id].style.left = finalyX[id]+"px";
			meniX[id] = 0;
		}
	}
	if (meniY[id] == 1) {
		if (skokY[id] > 0) {
			podminka = (aktualY[id]+skokY[id]) < finalyY[id];
		} else {
			podminka = (aktualY[id]+skokY[id]) > finalyY[id];
		}
		if (podminka) {
			aktualY[id] += skokY[id];
			objektY[id].style.top = Math.round(aktualY[id])+"px";
		} else {
			objektY[id].style.top = finalyY[id]+"px";
			meniY[id] = 0;
		}
	}
	if (meniHeight[id]+meniWidth[id]+meniX[id]+meniY[id] > 0) {
		timeParametry[id] = setTimeout("menParametry('"+id+"')", 20);
	}
}


















/**
 *               Funkce pro presouvani MOVE
 *
 */  

addLoadEvent(function() {
	appendAttribute(document.getElementsByTagName("body")[0], "onmouseup", "stopMouseMove(event);");
	appendAttribute(document.getElementsByTagName("body")[0], "onmousemove", "goMouseDrag(event);");
	var element = "<div class=\"obrys_objekt\" id=\"obrys_objekt\"> </div>";
	getBody().innerHTML += element;
});



function stopMouseMove(event) {
	if (moveObrys == true) {
		var parent = getParentNode(document.getElementById(aktualGroup_id+idObrys));
		var child = parent.childNodes;
		var objekt;
		var obj = false;
		for (var i = 0;i < child.length;i++) { 
			/*if (child[i].outerHTML == undefined) {
				continue;
			}*/
			if (!(child[i] instanceof HTMLDivElement)) {
					continue;
			}
			if (obj == true && child[i].id.indexOf(aktualGroup_id) > -1) {
				objekt = child[i];
				break;
			}
			if (child[i].id == aktualGroup_id+idObrys) {
				obj = true;
			}
		}
		if (objekt != null) {
			var lastxchid = objekt.id.substring(aktualGroup_id.length, objekt.id.length);
		} else {
			var lastxchid = "";
		}
		aktualSaveFunction(idObrys, lastxchid);
		changeOpacity(aktualGroup_id+idObrys, 1);
		changeOpacity("obrys_objekt", 0.01);
		moveObrys = false;
	}	
}

function getItemIdOnStay(event) {
	var items = parentAktualItem.childNodes;
	var id = false;
	for (var i = 0;i < items.length;i++) {
		var obj = items[i];
		if (getRelativeCoordinates(event, parentAktualItem).x > parseInt(obj.offsetLeft) && 
			getRelativeCoordinates(event, parentAktualItem).x < parseInt(obj.offsetLeft) + obj.offsetWidth && 
			getRelativeCoordinates(event, parentAktualItem).y > parseInt(obj.offsetTop) && 
			getRelativeCoordinates(event, parentAktualItem).y < parseInt(obj.offsetTop) + obj.offsetHeight) {
			id = obj.id;
			id = id.substring(aktualGroup_id.length, id.length);
			break;
		}
	}
	return id;
}

function goMouseDrag(event) {
	if (moveObrys == true) {
		var objekt = document.getElementById("obrys_objekt");
		var deltaX = event.clientX-mysObrysX;
		var deltaY = event.clientY-mysObrysY;
		mysObrysX = event.clientX;	
		mysObrysY = event.clientY;	
		clearSelection();
		objekt.style.left = (objekt.offsetLeft+deltaX)+"px";
		objekt.style.top = (objekt.offsetTop+deltaY)+"px";
		
		var xchid = getItemIdOnStay(event);
		if (xchid != false && xchid != idObrys) {
			var parent = getParentNode(document.getElementById(aktualGroup_id+xchid));
			var poziceXchid, poziceObrys;
			var child = parent.childNodes;
			var j = 0;
			for (var i = 0;i < child.length;i++) { 
				/*if (child[i].outerHTML == undefined) {
					continue;
				}*/
                                if (!(child[i] instanceof HTMLDivElement)) {
                                    continue;
                                }
				if (child[i].id == aktualGroup_id+xchid) {
					poziceXchid = j;
				}
				if (child[i].id == aktualGroup_id+idObrys) {
					poziceObrys = j;
				}
                                j++;
			}
			var text = "";
			for (var i = 0;i < polozkyItem.length;i++) {
				if (idPolozekItem[poziceXchid] == aktualGroup_id+idObrys && idPolozekItem[i] == aktualGroup_id+idObrys) {
					text += document.getElementById(aktualGroup_id+idObrys).outerHTML;
				}
				if (idPolozekItem[i] == aktualGroup_id+idObrys) {
					continue;
				}
				if (i == poziceXchid && poziceXchid < poziceObrys) {
					text += document.getElementById(aktualGroup_id+idObrys).outerHTML;
				}
				text += polozkyItem[i];
				if (i == poziceXchid && poziceXchid > poziceObrys) {
					text += document.getElementById(aktualGroup_id+idObrys).outerHTML;
				}
			}
			parent.innerHTML = text;
		}
	}
}

function createObrys(id) {
	var element = document.getElementById("obrys_objekt");  
	element.innerHTML = document.getElementById(id).innerHTML;
	element.style.width = document.getElementById(id).offsetWidth;
	element.style.height = document.getElementById(id).offsetHeight;
	changeOpacityQuick("obrys_objekt", 0.01);        
	changeOpacity("obrys_objekt", 0.6);
	changeOpacity(id, 0.4);
}

var idObrys, moveObrys, mysObrysX, mysObrysY, polozkyItem, idPolozekItem, parentAktualItem, aktualGroup_id, aktualSaveFunction;
function moveItem(event, id, group_id, saveFunction) {
	aktualSaveFunction = saveFunction;
	aktualGroup_id = group_id;
	
	var movedElement = document.getElementById(group_id+id);
	//var idSloupceNad = (getParentNode(getParentNode(getParentNode(movedElement)))).id;
	idObrys = id;
	createObrys(group_id+id);
	document.getElementById("obrys_objekt").style.top = (event.clientY+5)+"px";
	document.getElementById("obrys_objekt").style.left = (event.clientX-50)+"px";
	parentAktualItem = getParentNode(movedElement);
	var aktualniChildren = parentAktualItem.childNodes;
	polozkyItem = new Array();
	idPolozekItem = new Array();
	var j = 0;
	for (var i = 0;i < aktualniChildren.length;i++) { 
		//if (aktualniChildren[i].outerHTML == undefined) {
                if (!(aktualniChildren[i] instanceof HTMLDivElement)) {
			continue;
		}
		polozkyItem[j] = aktualniChildren[i].outerHTML;
		idPolozekItem[j] = aktualniChildren[i].id;
		j++;
	}
	moveObrys = true;
	mysObrysX = event.clientX;	
	mysObrysY = event.clientY;	
}




