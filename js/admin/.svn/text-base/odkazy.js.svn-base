
function editOdkazy(text) {
    if (text != null) {
        createAlert(text);
    }
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=odkazy&action=get_domains", pageLoaded)) {
        //pokud nefunguje ajax
        return;
    }
    setStatusPage();
}

function odkazyHrefPages(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=odkazy&action=get_href_pages&id="+id, createWindow)) {
        //pokud nefunguje ajax
        return;
    }
}

function changePageShow(id_vcem, id_co, el) {
    var act = "del";
    if (el.checked) {
        act = "add";
    }
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=odkazy&action=set_covcem&id_co="+id_co+"&id_vcem="+id_vcem+"&act="+act, createAlert)) {
        //pokud nefunguje ajax
        return;
    }
}

function editOdkazyNazev(id) {
    createDialog('<input type="text" value="'+document.getElementById("odkazy_nazev_"+id).innerHTML+'" id="odkazy_nazev_e_'+id+'" />', editOdkazyNazev2, id);
}

function editOdkazyNazev2(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=odkazy&action=set_name&id="+id+"&name="+fixQuery(document.getElementById("odkazy_nazev_e_"+id).value), editOdkazy)) {
        //pokud nefunguje ajax
        return;
    }
}

function editOdkazyPocetOdkazu(id) {
    createDialog('<input type="text" value="'+document.getElementById("odkazy_pocet_odkazu_"+id).innerHTML+'" id="odkazy_pocet_odkazu_e_'+id+'" />', editOdkazyPocetOdkazu2, id);
}

function editOdkazyPocetOdkazu2(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=odkazy&action=set_pocet_odkazu&id="+id+"&pocet="+fixQuery(document.getElementById("odkazy_pocet_odkazu_e_"+id).value), editOdkazy)) {
        //pokud nefunguje ajax
        return;
    }
}

function editOdkazyPerioda(id) {
    var split = document.getElementById("odkazy_perioda_"+id).innerHTML.split(" ")
    var perioda = split[0];
    var jednotka = split[1];
    var sec = "";
    var min = "";
    var hod = "";
    var den = "";
    var mes = "";
    var rok = "";
    switch (jednotka) {
        case "sekund": sec = " selected";
            break;
        case "minut": min = " selected";
            break;
        case "hodin": hod = " selected";
            break;
        case "dnů": den = " selected";
            break;
        case "měsíců": mes = " selected";
            break;
        case "roků": rok = " selected";
            break;

    }
    createDialog('<input type="text" value="'+perioda+'" id="odkazy_perioda_e_'+id+'" />'+
    '<select id="odkazy_perioda_s_'+id+'"><option value="sec"'+sec+'>sekund</option><option value="min"'+min+'>minut</option><option value="hod"'+hod+'>hodin</option><option value="den"'+den+'>dnů</option><option value="mes"'+mes+'>měsíců</option><option value="rok"'+rok+'>roků</option></select>'
    , editOdkazyPerioda2, id);
}

function editOdkazyPerioda2(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=odkazy&action=set_perioda&id="+id+"&pocet="+fixQuery(document.getElementById("odkazy_perioda_e_"+id).value)+"&jednotka="+document.getElementById("odkazy_perioda_s_"+id).value, editOdkazy)) {
        //pokud nefunguje ajax
        return;
    }
}

function editOdkazyText(id) {
    var textarea = "<form action=\"javascript: editOdkazyText2("+id+");\">"+
		"<div name=\"odkazy_text_e_"+id+"\" id=\"odkazy_text_e_"+id+"\" class=\"edited_content\" style=\"height: 200px;\">"+
		"</div>"+
		"</form>";
	var text = document.getElementById("odkazy_text_"+id).innerHTML;
        createDialog(textarea, editOdkazyText2, id);
	var ed = loadTinyMCE("odkazy_text_e_"+id);
	document.getElementById("odkazy_text_e_"+id).innerHTML = text;
    
}

function editOdkazyText2(id) {
    var text = tinyMCE.get("odkazy_text_e_"+id).getContent();
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=odkazy&action=set_text&id="+id+"&text="+fixQuery(text), editOdkazy)) {
        //pokud nefunguje ajax
        return;
    }
}

function deleteOdkazy(id) {
    createDialog("Opravdu chcete vymazat tuto stránku z odkazů?", deleteOdkazy2, id);
}

function deleteOdkazy2(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=odkazy&action=delete&id="+id, editOdkazy)) {
        //pokud nefunguje ajax
        return;
    }
}