

function deleteDiskuse(page_part, id) {
    aktual_content_in_id = jQuery("#page_part_"+page_part).parent().attr("id");
    actual_page_part = page_part;
    createDialog("Opravdu chcete smazat příspěvek?", deleteDiskuse2, id);
}

function deleteDiskuse2(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=diskuse&action=delete&id="+id, diskuseDeleted)) {
        //pokud nefunguje ajax
        return;
    }
}

function diskuseDeleted(text) {
    createAlert(text);
    loadSubPage(actual_page_part, parseInt(aktual_content_in_id.substring(8, aktual_content_in_id.length)), aktualLink);
}