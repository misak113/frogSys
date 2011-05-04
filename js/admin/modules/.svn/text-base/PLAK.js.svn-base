// JavaScript Document







function addAkce(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=plan_akci&action=add&parent="+id, editPlan_akci)) {
		//pokud nefunguje ajax
		return;
	}
}

var id_plan_akci_del;
function editPlan_akci(id) {
	id_plan_akci_del = id;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=plan_akci&action=get_id_part&id="+id, editPlan_akci2)) {
		//pokud nefunguje ajax
		return;
	}
}
function editPlan_akci2(str) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = str;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=plan_akci&action=edit&id="+id_plan_akci_del, createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}

function savePlan_akci(id) {
	var name = fixQuery(document.getElementById("plan_akci_nazev_"+id).value);
	var kdy = fixQuery(document.getElementById("plan_akci_kdy_"+id).value);
	var dokdy = fixQuery(document.getElementById("plan_akci_do_"+id).value);
	var kde = fixQuery(document.getElementById("plan_akci_kde_"+id).value);
	var co = fixQuery(document.getElementById("plan_akci_co_"+id).value);
	var text = fixQuery(document.getElementById("plan_akci_popis_"+id).value);
	var limit_lidi = fixQuery(document.getElementById("plan_akci_limit_lidi_"+id).value);
	var cena = fixQuery(document.getElementById("plan_akci_cena_"+id).value);
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=plan_akci&action=save&id="+id+"&name="+name+"&kdy="+kdy+"&kde="+kde+"&co="+co+"&text="+text+"&do="+dokdy+"&limit_lidi="+limit_lidi+"&cena="+cena, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
	zavriWindow();
}

var id_plan_akci_del;
function deletePlan_akci(id) {
	id_plan_akci_del = id;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=plan_akci&action=get_id_part&id="+id, deletePlan_akci2)) {
		//pokud nefunguje ajax
		return;
	}
}
function deletePlan_akci2(str) {
	aktualSubTarget = aktualClickPart;
	aktualSubPage = str;
	createDialog('Opravdu chcete smazat tuto akci?', deletePlan_akci3, id_plan_akci_del);
}
function deletePlan_akci3(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=plan_akci&action=delete&id="+id, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}

function usersPlan_akci(id) {
	id_plan_akci_del = id;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=plan_akci&action=users&id="+id, createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}

function deleteUser(id) {
	createDialog('Opravdu chcete smazat tohoto účastníka?', deleteUser2, id);
}
function deleteUser2(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=plan_akci&action=delete_user&id="+id, obnovUsery)) {
		//pokud nefunguje ajax
		return;
	}
}

function cashUser(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=plan_akci&action=cash_user&id="+id, obnovUsery)) {
		//pokud nefunguje ajax
		return;
	}
}

function obnovUsery(text) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=plan_akci&action=users&id="+id_plan_akci_del, obnovUsery2)) {
		//pokud nefunguje ajax
		return;
	}
	createAlert(text);
}
function obnovUsery2(text) {
	var objekt = document.getElementById("users_"+id_plan_akci_del);
	var textObjekt = getParentNode(objekt);
	textObjekt.id = "user_text_"+Math.random();
	changeText(textObjekt.id, text);
}

function mailUser(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=plan_akci&action=mail_user&id="+id, obnovUsery)) {
		//pokud nefunguje ajax
		return;
	}
}







function sendCollectiveMail(id) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=plan_akci&action=collective_mail&id="+id, createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}

function sendCollectiveMail2(id) {
	eval("var predmet = fixQuery(document.send_mail_"+id+".predmet.value)");
	eval("var text = fixQuery(document.send_mail_"+id+".obsah.value)");
	zavriWindow();
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=plan_akci&action=send_collective_mail&id="+id+"&predmet_mail="+predmet+"&text="+text, createAlert)) {
		//pokud nefunguje ajax
		return;
	}
}

function editPlanAkci_podminky(id) {
        var textarea = "<form action=\"javascript: editPlanAkci_podminky2("+id+");\">"+
		"<div name=\"editPlanAkci_podminky_e_"+id+"\" id=\"editPlanAkci_podminky_e_"+id+"\" class=\"edited_content\" style=\"height: 200px;\">"+
		"</div>"+
		"</form>";
	var text = document.getElementById("prihlaseni_info_"+id).innerHTML;
        //document.getElementById("plak_outer_podminky_"+id).innerHTML = textarea;
        createWindow(textarea);
        var ed = loadTinyMCE("editPlanAkci_podminky_e_"+id);
	document.getElementById("editPlanAkci_podminky_e_"+id).innerHTML = text;

}

function editPlanAkci_podminky2(id) {
    var text = tinyMCE.get("editPlanAkci_podminky_e_"+id).getContent();
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=plan_akci&action=set_text_podminky&id="+id+"&text="+fixQuery(text), pageRefresh)) {
        //pokud nefunguje ajax
        return;
    }
}

function call_back_file_selected_PLAK(filename, id, vypis) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=plan_akci&action=add_file&id="+id+"&cesta="+fixQuery(filename), createAlert)) {
        //pokud nefunguje ajax
        return;
    }
    document.getElementById("plan_akci_soubory_"+id).innerHTML += "<div>"+vypis+"</div>";
    zavriWindow();
}

function deletePlakSouborDatabase(id) {
    //document.getElementById("plan_akci_soubor_"+id).parentNode.
    jQuery("#plan_akci_soubor_"+id).remove();
    deleteSouborDatabase(id);
}