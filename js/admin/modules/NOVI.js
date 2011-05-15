
var aktual_content_in_id;
function addNovinka(page_part, el) {
    actual_page_part = page_part;
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=novinky&action=add&page_part="+page_part, addNovinka2)) {
        //pokud nefunguje ajax
        return;
    }
}

function addNovinka2(text) {
    loadNovinka(actual_page_part, parseInt(text));
}



var actual_novinka_id;
function loadNovinka(page_part, id, link) {
    hashMark(link+"#loadNovinka("+page_part+", "+id+", '"+link+"')");
    aktual_content_in_id = jQuery("#page_part_"+page_part).parent().attr("id");
    actual_page_part = page_part;
    actual_novinka_id = id;
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/modules/NOVI.php", "action=novinka&page_part="+page_part+"&id="+id, novinkaLoaded)) {
        //pokud nefunguje ajax
        return;
    }
}

function novinkaLoaded(text) {
    changeText(aktual_content_in_id, text);
}

function deleteNovinka(page_part, id) {
    aktual_content_in_id = jQuery("#page_part_"+page_part).parent().attr("id");
    actual_page_part = page_part;
    createDialog("Opravdu chcete smazat novinku?", deleteNovinka2, id);
}

function deleteNovinka2(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=novinky&action=delete&id="+id, novinkaDeleted)) {
        //pokud nefunguje ajax
        return;
    }
}

function novinkaDeleted(text) {
    createAlert(text);
    loadSubPage(actual_page_part, parseInt(aktual_content_in_id.substring(8, aktual_content_in_id.length)), aktualLink);
    /*if (!postAjaxRequest(URL+"frogSys/bin/ajax/modules/NOVI.php", "action=novinky&page_part="+actual_page_part, novinkaLoaded)) {
        //pokud nefunguje ajax
        return;
    }*/
}

function editNovinkaNazev(id) {
    var text = '<input type="text" id="input_novinka_nazev_'+id+'" style="width: 400px;" value="'+document.getElementById("novinka_nazev_s_"+id).innerHTML.replace(/"/, "&quot;")+'" onkeyup="generujLink(\'input_novinka\', '+id+')" /> '+
                                                '<input type="button" value="uložit" onclick="saveNovinkaNazev('+id+');" />';
    var link = '<input type="text" id="input_novinka_odkaz_'+id+'" style="width: 400px;" value="'+document.getElementById("novinka_link_s_"+id).innerHTML.replace(/"/, "&quot;")+'" /> ';
	changeText("novinka_nazev_s_"+id, text);
        changeText("novinka_link_s_"+id, link);
}

function saveNovinkaNazev(id) {
	var text = document.getElementById("input_novinka_nazev_"+id).value;
	var link = document.getElementById("input_novinka_odkaz_"+id).value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=novinky&action=save_nazev&nazev="+fixQuery(text)+"&id="+id+"&link="+link, saveNovinkaNazev2)) {
		//pokud nefunguje ajax
		return;
	}
}

function saveNovinkaNazev2(text) {
	changeText("novinka_nazev_s_"+text, ""+document.getElementById("input_novinka_nazev_"+text).value+"");
        changeText("novinka_link_s_"+text, ""+document.getElementById("input_novinka_odkaz_"+text).value+"");
}



function editNovinkaText(id) {
    var contentIn = document.getElementById("novinka_text_"+id);
	var textarea = "<form action=\"javascript: saveNovinkaText("+id+");\">"+
		"<div name=\"input_novinka_text\" id=\"input_novinka_text\">"+
		//contentIn.innerHTML+
		"</div>"+
		"</form>";
	var text = contentIn.innerHTML;
	contentIn.innerHTML = textarea;
	var ed = loadTinyMCE("input_novinka_text");
	//ed.setContent(text);
	document.getElementById("input_novinka_text").innerHTML = text;
}

function saveNovinkaText(id) {
	var text = tinyMCE.get("input_novinka_text").getContent();
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=novinky&action=save_text&text="+fixQuery(text)+"&id="+id, saveNovinkaText2)) {
		//pokud nefunguje ajax
		return;
	}
}

function saveNovinkaText2(text) {
	changeText("novinka_text_"+text, tinyMCE.get("input_novinka_text").getContent());
}

function checkboxSelectNovinka(page_part, id, el) {
    var visible = 0;
    if (el.checked) {
        visible = 1;
        document.getElementById("novinka_"+id).style.backgroundColor = "transparent";
    } else {
        document.getElementById("novinka_"+id).style.backgroundColor = "#D3D3D3";
    }
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=novinky&action=set_visible&visible="+visible+"&id="+id, createAlert)) {
        //pokud nefunguje ajax
        return;
    }
}