
function editZakladni(text) {
    if (text != null) {
        createAlert(text);
    }
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=zakladni&action=get_prehled", pageLoaded)) {
        //pokud nefunguje ajax
        return;
    }
    setStatusPage();
}




function editTitulek(id) {
	var text = '<input type="text" id="input_titulek" style="width: 400px;" value="'+document.getElementById("titulek"+id).innerHTML+'">'+
						'<input type="button" value="uložit" onclick="saveTitulek('+id+');">';
	changeText("titulek"+id, text);
}

function saveTitulek(id) {
	var text = document.getElementById("input_titulek").value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/admining.php", "predmet=titulek&action=save&text="+fixQuery(text)+"&id="+id, saveTitulek2)) {
		//pokud nefunguje ajax
		return;
	}
}
function checkboxSelectSeting(id, el) {
    if (!el.checked) {
        if (!postAjaxRequest(URL+"frogSys/bin/ajax/admining.php", "predmet=seting&action=clear_seting&name="+id, editZakladni)) {
		//pokud nefunguje ajax
		return;
	}
    } else {
        if (!postAjaxRequest(URL+"frogSys/bin/ajax/admining.php", "predmet=seting&action=set_seting&text="+fixQuery("<h2>"+id+"</h2>")+"&name="+id, editZakladni)) {
		//pokud nefunguje ajax
		return;
	}
    }
}

function editSeting(id) {
    var textarea = "<form action=\"javascript: editSeting2('"+id+"');\">"+
		"<div name=\"seting_tiny_"+id+"\" id=\"seting_tiny_"+id+"\" class=\"edited_content\" style=\"height: 200px;\">"+
		"</div>"+
		"</form>";
	var text = document.getElementById("seting_"+id).innerHTML;
        createWindow(textarea);
	var ed = loadTinyMCE("seting_tiny_"+id);
	document.getElementById("seting_tiny_"+id).innerHTML = text;

}

function editSeting2(id) {
    var text = tinyMCE.get("seting_tiny_"+id).getContent();
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/admining.php", "predmet=seting&action=set_seting&text="+fixQuery(text)+"&name="+id, editZakladni)) {
		//pokud nefunguje ajax
		return;
	}
       zavriWindow();
}

function saveTitulek2(text) {
	changeText("titulek"+text, document.getElementById("input_titulek").value);
}