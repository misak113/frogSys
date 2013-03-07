// JavaScript Document







var top_title_editing = false;
function editTop_title() {
	var contentIn = document.getElementById("top_title_in");
	contentIn.removeChild(getElementsByClassNameMy("edit_pane_Top_title", contentIn)[0]);
	var textarea = "<form action=\"javascript: saveTop_title();\">"+
		"<div name=\"edited_top_title\" id=\"edited_top_title\" class=\"edited_top_title\" style=\"height: 350px; width: 600px;\">"+
		//contentIn.innerHTML+
		"</div>"+
		"</form>";
	top_title_editing = true;
	var text = contentIn.innerHTML;
	contentIn.innerHTML = textarea;
	var ed = loadTinyMCE("edited_top_title");
	document.getElementById("edited_top_title").innerHTML = text;
	//tinymce.get('edited_top_title').setContent(text);
	//tinymce.onAddEditor = function() {tinymce.get('edited_top_title').setContent(text);};
	
}


function saveTop_title() {
	var text = tinyMCE.get("edited_top_title").getContent();
	tinyMCE.remove(tinyMCE.get("edited_top_title"));
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=top_title&action=save&text="+fixQuery(text), refreshTop_title)) {
		//pokud nefunguje ajax
		return;
	}
}

function refreshTop_title(text) {
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/top_title.php", "", refreshTop_title2)) {
		//pokud nefunguje ajax
		return;
	}
	top_title_editing = false;
	createAlert(text);
}

function refreshTop_title2(text) {
	//document.getElementById("top_title").innerHTML = text;
	changeText("top_title", text);
}





