// JavaScript Document



function addImages(page_part) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = page_part;
	changeWindow('jumpLoaderApplet_GALE', false, 600, false, false);
	document.getElementById('jumpLoaderApplet_GALE').style.width = "100%";
        aktual_uploader = "GALE";
}


function checkboxSelectGalerie(id, page_part) {
	var obj = document.getElementById("image_"+id);
	if (obj.style.opacity == 0.3) {
		//obj.style.opacity = "1.0";
		changeOpacity("image_"+id, 1);
		var show = 1;
	} else {
		changeOpacity("image_"+id, 0.3);
		//obj.style.opacity = "0.3";
		var show = 0;
	}
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=galerie&action=show&show="+show+"&id="+id, createAlert)) {
		//pokud nefunguje ajax
		return;
	}
}


function deleteGalerie(id, page_part) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = page_part;
	createDialog('Opravdu chcete smazat tento obrázek?', deleteGalerie2, id);
}

function deleteGalerie2(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=galerie&action=delete&id="+id, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}


function saveGalerie(id) {
	var title = document.getElementById("galerie_image_"+id).value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=galerie&action=edit&id="+id+"&title="+fixQuery(title), createAlert)) {
		//pokud nefunguje ajax
		return;
	}
	zavriWindow();
}


function editGalerieHtml(id, page_part) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = page_part;
	var contentIn = document.getElementById("content_in_"+id);
	contentIn.removeChild(getElementsByClassNameMy("edit_pane_GalerieHtml", contentIn)[0]);
	var textarea = "<form action=\"javascript: saveHtml("+id+");\">"+
		"<div name=\"edited_content_"+id+"\" id=\"edited_content_"+id+"\" class=\"edited_content\" style=\"height: "+(contentIn.offsetHeight)+"px;\">"+
		//contentIn.innerHTML+
		"</div>"+
		"</form>";
	var text = contentIn.innerHTML;
	contentIn.innerHTML = textarea;
	var ed = loadTinyMCE("edited_content_"+id);
	document.getElementById("edited_content_"+id).innerHTML = text;
	
	changeWindow("page_in", false, "auto", false, false);  
}







function moveGalerie(event, id, page_part) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = page_part;
	moveItem(event, id, "galerie_image_div_", saveGaleriePosition);
}
function saveGaleriePosition(id, changeWith) {
	//alert(id+" před "+changeWith);
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=galerie&action=sort&id="+id+"&change_with="+changeWith, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}







