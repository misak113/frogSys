// JavaScript Document


function changeType(el) { 
        var id = jQuery(el).parent().parent().children(".content_in").children(".page_part_id").text();
	aktualSubTarget = aktualClickPart;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=page&action=change_type_form&id="+id, changeType2)) {
		//pokud nefunguje ajax
		return;
	}
}

function changeType2(text) {
	createWindow(text);
}

function nastavType(text, id) {
	aktualSubPage = id;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=page&action=change_type&id="+id+"&type="+text, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
	zavriWindow();
}
