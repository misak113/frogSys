/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function changeSoutezVysledky(el, page_part) {
    aktualSubTarget = aktualClickPart;
    if (el.value == "new") {
        if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=add_soutez&parent="+page_part, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
    }
    if (el.value == "not") {

    } else {
        if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=set_soutez&parent="+page_part+"&soutez="+el.value, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
    }
}

function editSoutez(id) {
    aktualSubTarget = aktualClickPart;
    jQuery("#nazev_soutez").children(".edit_pane_Soutez").remove();
    var text = '<input type="text" id="input_soutez" style="width: 400px;" value="'+stripWhitespace(document.getElementById("nazev_soutez").innerHTML)+'">'+
						'<input type="button" value="uložit" onclick="saveSoutez('+id+');">';
	changeText("nazev_soutez", text);
}

function saveSoutez(id) {
	var text = document.getElementById("input_soutez").value;
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=save_soutez&nazev="+fixQuery(text)+"&id="+id, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}


function deleteSoutez(id) {
    aktualSubTarget = aktualClickPart;
    createDialog("Opravdu chcete smazet tuto soutěž?<br/>Po smazání bude soutěž nanávratně ztracena!", deleteSoutez2, id);
}

function deleteSoutez2(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=delete_soutez&id="+id, partRefresh)) {
		//pokud nefunguje ajax
		return;
	}
}







var utkani_kolo;
function editUtkani(id, kolo) {
    aktualSubTarget = aktualClickPart;
    utkani_kolo = kolo;
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=edit_utkani_table&id="+id+"&id_kola="+kolo, function (text) {
	createWindow(text);
	var changeSelectTym = function (type, el) {
	    if (el.val() == 'new') {
		var nazev = jQuery('<input/>').attr('type', 'text').attr('id', type+'_nazev_new');
		el.after(nazev);
	    } else {
		jQuery('#'+type+'_nazev_new').remove();
	    }
	};
	jQuery('.id_domaci_select').bind('change', function(ev) {
	    changeSelectTym('domaci', jQuery(this));
	});
	jQuery('.id_hoste_select').bind('change', function(ev) {
	    changeSelectTym('hoste', jQuery(this));
	});
    })) {
		//pokud nefunguje ajax
		return;
	}
}

var aktual_element;
function changeNazevUtkani(el, tymy) {
    var ar = tymy.split("Đ");
    var ac = jQuery(el).autocomplete(ar, {
        autoFocus: true,
        delay: 0,
        minLength: 0
    });
    ac.result(function (event, item) {
        changeNazevUtkani(el, tymy);
    });
    aktual_element = el;
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=get_id_tymu&nazev="+fixQuery(el.value), changeNazevUtkaniIdFounded)) {
		//pokud nefunguje ajax
		return;
	}
}

function changeNazevUtkaniIdFounded(text) {
    if (text == "false") {
        document.getElementById("ids_"+aktual_element.id).value = "";
        aktual_element.style.backgroundColor = "#ffeeee";
    } else {
        document.getElementById("ids_"+aktual_element.id).value = text;
        aktual_element.style.backgroundColor = "#eeffee";
    }
}


function changeHristeUtkani(el, hriste) {
    var ar = hriste.split("Đ");
    var ac = jQuery(el).autocomplete(ar, {
        autoFocus: true,
        delay: 0,
        minLength: 0
    });
    ac.result(function (event, item) {
        changeHristeUtkani(el, hriste);
    });
    aktual_element = el;
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=get_id_hriste&nazev="+fixQuery(el.value), changeNazevUtkaniIdFounded)) {
		//pokud nefunguje ajax
		return;
	}
}

function changeRozhodciUtkani(el, roz) {
    var ar = roz.split("Đ");
    var ac = jQuery(el).autocomplete(ar, {
        autoFocus: true,
        delay: 0,
        minLength: 0
    });
    ac.result(function (event, item) {
        changeRozhodciUtkani(el, roz);
    });
    aktual_element = el;
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=get_id_rozhodci&nazev="+fixQuery(el.value), changeRozhodciUtkaniIdFounded)) {
		//pokud nefunguje ajax
		return;
	}
}


function changeRozhodciUtkaniIdFounded(text) {
    if (text == "false") {
        aktual_element.style.backgroundColor = "#ffeeee";
    } else {
        aktual_element.style.backgroundColor = "#eeffee";
    }
    jQuery(aktual_element).attr("name", text);
    var els = getElementsByClassNameMy(jQuery(aktual_element).attr("class"), document);
    var clas = jQuery(aktual_element).attr("class");
    clas = clas.split(" ")[0];
    jQuery("#ids_"+clas).attr("value", "");
    for (var i=0;i < els.length;i++) {
        document.getElementById("ids_"+clas).value += jQuery(els[i]).attr("name")+",";
    }
}



function ulozitUtkani(id) {
    var date = jQuery("#plan_akci_kdy_ids_datum_"+id).attr("value");
    var time = jQuery("#cas_"+id).attr("value");
    var domaci = jQuery("#id_domaci_"+id).val();
    var hoste = jQuery("#id_hoste_"+id).val();
    var hriste = jQuery("#ids_hriste_"+id).attr("value");
    var rozhodci = jQuery("#ids_rozhodci_"+id).attr("value");

    var text = "predmet=vysledky&action=save_utkani&id="+id;
    text += "&rozhodci="+rozhodci;
    
    if (utkani_kolo != null) {
        text += "&kolo="+utkani_kolo;
    }
    if (date.match(/20\d\d-\d{1,2}-\d{1,2}/) == null) {
        createWindow("Špatné datum.");
        return;
    }
    text += "&date="+date;
    if (time.match(/\d?\d:\d\d/) == null) {
        createWindow("Špatný čas (př.: '14:30').");
        return;
    }
    text += "&time="+time;
    if (jQuery("#domaci_"+id).attr("value") == "") {
        createWindow("Chybí domácí tým!");
        return;
    }
    if (jQuery("#hoste_"+id).attr("value") == "") {
        createWindow("Chybí hostující tým!");
        return;
    }
    if (jQuery("#hriste_"+id).attr("value") == "") {
        createAlert("Nebylo zadáno hřiště!");
    }
    if (domaci == "new") {
        text += "&domaci_nazev="+jQuery("#domaci_nazev_new").val();
    } else {
        text += "&domaci_id="+domaci;
    }
    if (hoste == "new") {
        text += "&hoste_nazev="+jQuery("#hoste_nazev_new").val()
    } else {
        text += "&hoste_id="+hoste;
    }
    if (hriste == "" && jQuery("#hriste_"+id).attr("value") != "") {
        text += "&hriste_nazev="+jQuery("#hriste_"+id).attr("value");
    } else {
        text += "&hriste_id="+hriste;
    }
    /*if (domaci == "" || hoste == "" || hriste == "" && jQuery("#hriste_"+id).attr("value") != "") {
        //createDialog("Domácí hráč, Hostující hráč nebo hřiště neexistuje!\n Chcete jej opravdu vyvořit?", ulozitUtkani2, text);
        var answer = confirm('Domácí hráč, Hostující hráč nebo hřiště neexistuje!\n Chcete jej opravdu vyvořit?')
        if (answer) {
            ulozitUtkani2(text);
        }
        return;
    }*/
    zavriWindow();
    ulozitUtkani2(text);
}

function ulozitUtkani2(text) {
    zavriWindow();
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", text, partRefresh)) {
        //pokud nefunguje ajax
        return;
    }
}

function addRozhodci(el, id) {
    var out = getElementsByClassNameMy('rozhodci_'+id, document)[0].outerHTML;
    out = out.replace(/value="[^"]*"/, "value=\"\"");
    out = out.replace(/name="[^"]*"/, "name=\"\"");
    jQuery(el).parent().append("<br />"+
        out
    );
}


function checkboxSelectUtkani(id, id_kola, el) {
    aktualSubTarget = aktualClickPart;
    var check = 0;
    if (el.checked) {
        check = 1;
    }
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=set_utkani_overeno&id="+id+"&overeno="+check, partRefresh)) {
        //pokud nefunguje ajax
        return;
    }
}











var kolo_soutez;
function editKolo(id, soutez) {
    aktualSubTarget = aktualClickPart;
    kolo_soutez = soutez;
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=edit_kolo_table&id="+id+"&id_souteze="+soutez, createWindow)) {
		//pokud nefunguje ajax
		return;
	}
}

function ulozitKolo(id) {
    var date = jQuery("#plan_akci_kdy_ids_kolo_datum_"+id).attr("value");
    var nazev = jQuery("#nazev_k_kolo_"+id).attr("value");
    var poradi = jQuery("#poradi_kolo_"+id).attr("value");
    
    var text = "predmet=vysledky&action=save_kolo&id="+id+"&id_souteze="+kolo_soutez;
    if (date.match(/20\d\d-\d{1,2}-\d{1,2}/) == null) {
        createWindow("Špatné datum.");
        return;
    }
    text += "&date="+date;
    if (nazev.match(/.{0,20}/) == null) {
        createWindow("Špatný název.");
        return;
    }
    text += "&nazev="+fixQuery(nazev);
    if (poradi.match(/\d{1,5}/) == null) {
        createWindow("Špatný formát pořadí, musí být číslo.");
        return;
    }
    text += "&poradi="+poradi;
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", text, partRefresh)) {
        //pokud nefunguje ajax
        return;
    }
    zavriWindow();
}




function deleteKolo(id) {
    aktualSubTarget = aktualClickPart;
    createDialog("Opravdu chcete smazat toto kolo?<br/>Bude nenávratně ztraceno!", deleteKolo2, id);
}

function deleteKolo2(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=delete_kolo&id="+id, partRefresh)) {
        //pokud nefunguje ajax
        return;
    }
}


function deleteUtkani(id) {
    aktualSubTarget = aktualClickPart;
    createDialog("Opravdu chcete smazat toto Utkání?<br/>Bude nenávratně ztraceno!", deleteUtkani2, id);
}

function deleteUtkani2(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=delete_utkani&id="+id, partRefresh)) {
        //pokud nefunguje ajax
        return;
    }
}



function deleteZapas(id) {
    aktualSubTarget = aktualClickPart;
    createDialog("Opravdu chcete smazat tento zápas?<br/>Bude nenávratně ztracen!", deleteZapas2, id);
}

function deleteZapas2(id) {
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=delete_zapas&id="+id, partRefresh)) {
        //pokud nefunguje ajax
        return;
    }
}














function addZapasy(utkani) {
    aktual_utkani = utkani;
    var pocet = jQuery("#pocet_zapasu_"+utkani).val();
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=add_zapasy&pocet="+pocet+"&utkani="+utkani, loadZapasy)) {
        //pokud nefunguje ajax
        return;
    }
}

var aktual_utkani;
function loadZapasy(text) {
    createAlert(text);
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/modules/VYSL.php", "predmet=vysledky&action=writeVysledkyZapasy&id="+aktual_utkani, loadZapasy2)) {
        //pokud nefunguje ajax
        return;
    }
}

function loadZapasy2(text) {
    changeText("vysledky_zapasy_head_"+aktual_utkani, text);
}







function saveZapasy(utkani) {
    aktual_utkani = utkani;
    prepocitejZapasy(utkani);
    var table = document.getElementById("vysledky_zapasy_"+utkani);
    var zapasy = getElementsByClassNameMy("vysledky_zapas", table);
    var req = "predmet=vysledky&action=save_zapasy&utkani="+utkani;
    var vysled = 0;
    for (var i=0;i < zapasy.length;i++) {
        var zapas = zapasy[i];
        var tid = jQuery(zapas).children("td:first-child").attr("id");
        var id_zapasu = tid.substring(15, tid.length)
        
        if (document.getElementById("zapas_smazat_"+id_zapasu).checked) {
            req += "&delete[]="+id_zapasu;
            continue;
        }
        
        var typ = jQuery("#zapas_typ_"+id_zapasu).val();
        req += "&typ["+id_zapasu+"]="+fixQuery(typ);
        
        var vysledky = getElementsByClassNameMy("vysledky_vysledek", zapas);
        for (var j=0;j < vysledky.length;j++) {
            var id_v = vysledky[j].id;
            var dh = id_v.split("_")[2];
            var vys = id_v.split("_")[4];
            req += "&vysledek["+id_zapasu+"]["+vys+"]["+dh+"]="+fixQuery(vysledky[j].value);
        }

        var dom = jQuery("#vysledky_zapas_hraci_"+id_zapasu).children(".domaci").children("select");
        for (j=0;j < dom.length;j++) {
            var p = dom[j].id.split("_");
            var hrac = p[3];
            if (hrac != "-") {
                req += "&dom_hrac["+id_zapasu+"][]="+hrac;
            }
        }

        var hos = jQuery("#vysledky_zapas_hraci_"+id_zapasu).children(".hoste").children("select");
        for (j=0;j < hos.length;j++) {
            var pe = hos[j].id.split("_");
            var hrace = pe[3];
            if (hrace != "-") {
                req += "&hos_hrac["+id_zapasu+"][]="+hrace;
            }
        }
        
        
    }
    req += "&divaci="+document.getElementById("utkani_divaci_"+utkani).value;
	req += "&kontumace="+(document.getElementById("utkani_kontumace_"+utkani).checked ?1 :0);
	if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", req, loadZapasy)) {
        //pokud nefunguje ajax
        return;
    }
    //createWindow(req);
}

function prepocitejZapasy(utkani) {
    createAlert("prepocitej");
}

function deleteZapas(utkani, zapas) {
    var op = "transparent";
    if (document.getElementById("zapas_smazat_"+zapas).checked) {
        op = "#444444";
    }
    jQuery("#vysledky_zapas_"+zapas).parent().children("td").css("background-color", op);
    prepocitejZapasy(utkani);
}



jQuery.fn.selectVal = function(value) {
    var opt = this.children("option");
    opt.select(false);
    for (var i=0;i < opt.length;i++) {
        if (opt[i].value == value) {
            opt[i].selected = true;
            break;
        }
    }
}


function changeHrac(el) {
    el = jQuery(el);
    var p = el.attr("id").split("_");
    var dh = p[0];
    var zapas = p[2];
    var hrac = p[3];
    var n_hrac = el.val();
    if (n_hrac == "new") {
        el.selectVal("-");
        if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=new_player_form&id="+el.attr("id"), createWindow)) {
            //pokud nefunguje ajax
            return;
        }
        return;
    }
    if (hrac == "-") {
        // přidej nový prázdný select
        var temp = el.outerHTML();
        el.attr("id", dh+"_hrac_"+zapas+"_"+n_hrac);
        el.parent().append(temp);
    } else {
        el.attr("id", dh+"_hrac_"+zapas+"_"+n_hrac);
    }
    if (n_hrac == "-") {
        // smaz tohoto hrace select
        el.remove();
    }
}




var aktual_select_opt, aktual_new_opt;
function createHrac(id, rand) {
    aktual_select_opt = jQuery("#"+id);
    var jmeno = jQuery("#new_hrac_jmeno_"+rand).val();
    var tym = jQuery("#new_hrac_tym_"+rand).val();
    var rozhodci = jQuery("#new_hrac_rozhodci_"+rand).attr("checked");
    aktual_new_jmeno = jmeno;
    zavriWindow();
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/edit.php", "predmet=vysledky&action=new_player&jmeno="+fixQuery(jmeno)+"&rozhodci="+rozhodci+"&tym="+tym, createHrac2)) {
        //pokud nefunguje ajax
        return;
    }
}

function createHrac2(id) {
    id = parseInt(id);
    if (id > 0) {
        var opt = '<option value="'+id+'">'+aktual_new_jmeno+'</option>';
        jQuery("select.select_hrac").append(opt);
        aktual_select_opt.selectVal(""+id);
        changeHrac(aktual_select_opt);
    }
}