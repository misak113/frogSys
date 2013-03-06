// JavaScript Document


function changeType(id) {
	aktualSubTarget = aktualClickPart;
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=page&action=change_type_form&id="+id, changeType2)) {
		//pokud nefunguje ajax
		return;
	}
}

function changeType2(text) {
	createWindow(text);
}

function saveTypeChange(id) {
	var type = document.getElementById("page_type").value;
	aktualSubPage = id;
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=page&action=change_type&id="+id+"&type="+type, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
	zavriWindow();
}

function nastavType(text, click) {
	document.getElementById('page_type').value = text;
	var typy = getElementsByClassNameMy("page_typy");
	for (var i=0;i < typy.length;i++) {
		if (typy[i].id == click) {
			changeOpacityQuick(typy[i].id, 1);
		} else {
			changeOpacityQuick(typy[i].id, 0.4);
		}
	}            
}
