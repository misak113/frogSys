// JavaScript Document







var patka_editing = false;
function editPatka() {
	var contentIn = document.getElementById("patka_in");
	contentIn.removeChild(getElementsByClassNameMy("edit_pane_Patka", contentIn)[0]);
	var textarea = "<form action=\"javascript: savePatka();\">"+
		"<div name=\"edited_patka\" id=\"edited_patka\" class=\"edited_patka\" style=\"height: 350px; width: 600px;\">"+
		//contentIn.innerHTML+
		"</div>"+
		"</form>";
	patka_editing = true;
	var text = contentIn.innerHTML;
	contentIn.innerHTML = textarea;
	var ed = loadTinyMCE("edited_patka");
	document.getElementById("edited_patka").innerHTML = text;
}


function savePatka() {
	var text = tinyMCE.get("edited_patka").getContent();
	tinyMCE.remove(tinyMCE.get("edited_patka"));
	if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=patka&action=save&text="+fixQuery(text), refreshPatka)) {
		//pokud nefunguje ajax
		return;
	}
}

function refreshPatka(text) {
	if (!postAjaxRequest("/bin/ajax/patka.php", "", refreshPatka2)) {
		//pokud nefunguje ajax
		return;
	}
	patka_editing = false;
	createAlert(text);
}

function refreshPatka2(text) {
	//document.getElementById("top_title").innerHTML = text;
	changeText("copyright_right", text);
}





