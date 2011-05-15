
function spravceSouboru(text) {
    if (text != null) {
        createAlert(text);
    }
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=spravce_souboru&action=get_soubory", pageLoaded)) {
        //pokud nefunguje ajax
        return;
    }
    setStatusPage();
}

function deleteSoubor(file) {
    createDialog("Opravdu chcete soubor smazat?", deleteSoubor2, file);
}
function deleteSoubor2(file) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=spravce_souboru&action=delete_soubor&file="+fixQuery(file), spravceSouboru)) {
        //pokud nefunguje ajax
        return;
    }

}

function addFiles() {
	changeWindow('jumpLoaderApplet_spravce_souboru', false, 600, false, false);
	document.getElementById('jumpLoaderApplet_spravce_souboru').style.width = "100%";
        aktual_uploader = "spravce_souboru";
}


function deleteSouborDatabase(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=spravce_souboru&action=delete_soubor_database&id="+id, createAlert)) {
        //pokud nefunguje ajax
        return;
    }
}