/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function ulozitWebPagesTymu(id_tymu) {
    aktualSubTarget = aktualClickPart;
    var web_pages = jQuery("#web_pages_"+id_tymu).val();
        if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=tabulka&action=save_web_pages_tymu&id_tymu="+id_tymu+"&web_pages="+web_pages, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}