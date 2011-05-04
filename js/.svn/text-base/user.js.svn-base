// JavaScript Document


//anchor reload
function anchor_reload() {
    if (location.href.indexOf("#") != -1) {
        var query = location.href.split('#');
        var url = URL+query[1]+"/";
        location.href = url;
    }
}
anchor_reload();


addLoadEvent(init);

function init() {
	//createWindow("<p>Na našich stránkách jsou prováděny nutné změny, děkujeme za pochopení.</p>");
}

function openPodrobnost(id) {
	var objekt = document.getElementById("telo_plan_akci_"+id);
	var img = document.getElementById("podrobnosti_img_plan_akci_"+id);
	if (objekt.style.height == "1px") {
		changeWindow("telo_plan_akci_"+id, false, "auto", false, false);
		img.src = URL+"frogSys/images/icons/podrobnosti_close.png";
	} else {
		changeWindow("telo_plan_akci_"+id, false, 1, false, false);
		img.src = URL+"frogSys/images/icons/podrobnosti_open.png";
	}
}

function prihlasitNaAkci(id) {
	var objekt = document.getElementById("plan_akci_prihlasit_"+id);
	if (objekt.style.height == "1px") {
		changeWindow("plan_akci_prihlasit_"+id, false, "auto", false, false);
	} else {
		changeWindow("plan_akci_prihlasit_"+id, false, 1, false, false);
	}
}

function prihlasitAkci(id) {  
	var plno = document.getElementById("plan_akci_plno_"+id).value;
	if (plno == "true") {
		createWindow("Na akci je již plno.");
		return false;
	}
	var jmeno = document.getElementById("plan_akci_jmeno_"+id).value;
	if (jmeno.length < 3) {
		createWindow("Zadejte správné jméno.");
		return false;
	}
	var prijmeni = document.getElementById("plan_akci_prijmeni_"+id).value;
	if (prijmeni.length < 3) {
		createWindow("Zadejte správné příjmení.");
		return false;
	}
	var email = document.getElementById("plan_akci_email_"+id).value;
	if (email.length < 6) {
		createWindow("Zadejte správný e-mail.");
		return false;
	}
	var souhlas = document.getElementById("souhlas_"+id);
	if (souhlas.checked == false) {
		createWindow("Musíte souhlsit s podmínkama.");
		return false;
	}
}

function showKalendar(id) {
	var a = document.getElementById(id).style;
	if (a.display == 'block') {
		a.display = 'none';
	} else {
		a.display = 'block';
	}
}



function sendKontakt(id) {
	var jmeno = fixQuery(document.getElementById("jmeno_"+id).value);
	var email = fixQuery(document.getElementById("email_"+id).value);
	var tel = fixQuery(document.getElementById("telefon_"+id).value);
	var text = fixQuery(document.getElementById("text_"+id).value);
	if (jmeno == "" || email == "" || text == "") {
		createAlert("Musíte vyplnit povinné položky!", "center", "midle");
	} else {
		if (!postAjaxRequest(URL+"frogSys/bin/ajax/user.php", "predmet=kontakt&action=send&jmeno="+jmeno+"&email="+email+"&tel="+tel+"&text="+text, function (text) {createAlert(text, "center", "midle");})) {
			//pokud nefunguje ajax
			return;
		}
	}
	document.getElementById("text_"+id).value = "";
}



function zkontrolujDoprava() {
	var zatrzeno = false;
	for(var i = 0; i < document.formular.doprava.length; i++)
	{
		if(document.formular.doprava[i].checked) zatrzeno = true;
	}
	if (zatrzeno == false) {
		createAlert("Nemáte výbrán způsob dopravy a platby!");
		return false;
	}
}

function zkontrolujOsobni() {
    if (document.formular.jmeno.value.match(/^[^0-9]{2,15}$/) == null) {
        createAlert("Jméno je špatně vyplněno!", "center", "midle");
        return false;
    }
    if (document.formular.prijmeni.value.match(/^[^0-9]{2,15}$/) == null) {
        createAlert("Příjmení je špatně vyplněno!", "center", "midle");
        return false;
    }
    if (document.formular.telefon.value.match(/^(\+[0-9]{3})?( ?[0-9]{3}){3}$/) == null) {
        createAlert("Špatný formát telefonu! : (+420 666 555 444)", "center", "midle");
        return false;
    }
    if (document.formular.email.value.match(/^[a-zA-Z\.\-\_]{1,20}@[a-zA-Z\.\-]{1,20}\.[a-zA-Z]{2,10}$/) == null) {
        createAlert("Email špatně vyplněn : (abc@mail.cz)!", "center", "midle");
        return false;
    }
    if (document.formular.ulice.value == "") {
        createAlert("Nevplnil jste ulici!", "center", "midle");
        return false;
    }
    if (document.formular.obec.value == "") {
        createAlert("Nevyplnil jste obec!", "center", "midle");
        return false;
    }
    if (document.formular.psc.value.match(/^\d{3} ?\d{2}$/) == null) {
        createAlert("Špatný tvar PSČ : (100 00)!", "center", "midle");
        return false;
    }
    if (document.formular.stat.value == "") {
        createAlert("Nevyplnil jste stát!", "center", "midle");
        return false;
    }
}

function smazZKosiku(id) {
	document.getElementsByName("pocet["+id+"]")[0].value = 0;
	document.prepocitani.submit();
}



function addDiskuse(page_part, el) {
    var user = fixQuery(document.getElementById("diskuse_user_"+page_part).value);
    var text = fixQuery(document.getElementById("diskuse_text_"+page_part).value);
    if (user == "" || text == "") {
        createAlert("Musíte vyplnit povinné položky!", "center", "midle");
    } else {
        if (!postAjaxRequest(URL+"frogSys/bin/ajax/user.php", "predmet=diskuse&action=add_prispevek&user="+user+"&text="+text+"&page_part="+page_part, function (text) {
            window.location.reload();
        })) {
            //pokud nefunguje ajax
            return;
        }
    }
}

















var menuTimeout = new Array();
var openingMenu = new Array();
function openMenuUser(id, open) {
    var obj2 = document.getElementById(id);
    if (openingMenu[id] == null) {
        if (obj2.offsetHeight == null || obj2.offsetHeight == 0) {
            openingMenu[id] = "height";
        } else
        if (obj2.offsetWidth == null || obj2.offsetWidth == 0) {
            openingMenu[id] = "width";
        } else {
            openingMenu[id] = null;
        }
    }
    if (openingMenu[id] != null) {
        var h, w;
        if (open == 1) {
            if (openingMenu[id] == "height") {
                h = "auto";
                w = false;
            }
            if (openingMenu[id] == "width") {
                h = false;
                w = "auto";
            }
            changeWindow(id, w, h, false, false);
        } else {
            if (openingMenu[id] == "height") {
                h = "0";
                w = false;
            }
            if (openingMenu[id] == "width") {
                h = false;
                w = "0";
            }
            changeWindow(id, w, h, false, false);
        }
    }
}




function changeSezona(el) {
    setCookie("vysledky_sezona", el.value, 1);
    window.location.reload();
}




function openUtkaniPodrobnosti(id) {
    var all = jQuery(".vysledky_zapasy_head");
    var img = jQuery(".podrobnosti_img_utkani");
    img.attr("src", URL+"frogSys/images/icons/podrobnosti_open.png")
    all.animate({
        height: 0
    }, 300);

    var act = jQuery("#vysledky_zapasy_head_"+id);
    var im = jQuery("#podrobnosti_img_utkani_"+id);
    var hb = document.getElementById("vysledky_zapasy_head_"+id).offsetHeight;
    var h = 0;
    if (hb == 0) {
        act.css("height", "auto");
        h = document.getElementById("vysledky_zapasy_head_"+id).offsetHeight;
        act.css("height", "0px");
        im.attr("src", URL+"frogSys/images/icons/podrobnosti_close.png");
    }
    act.animate({
        height: h
    }, 300, function () {
        if (h > 0) {
            act.css("height", "auto");
        }
    });
}

function openNeodehranaKola() {
    var act = jQuery(".vysledky_neodehrane_all");
    var im = jQuery(".podrobnosti_img_neodehrana_kola");
    var hb = getElementsByClassNameMy("vysledky_neodehrane_all", document)[0].offsetHeight;
    var h = 0;
    if (hb == 0) {
        act.css("height", "auto");
        h = getElementsByClassNameMy("vysledky_neodehrane_all", document)[0].offsetHeight;
        act.css("height", "0px");
        im.attr("src", URL+"frogSys/images/icons/podrobnosti_close.png");
        //h = 300;
    } else {
        im.attr("src", URL+"frogSys/images/icons/podrobnosti_open.png");
    }
    act.animate({
        height: h
    }, 300, function () {
        if (h > 0) {
            act.css("height", "auto");
        }
    });
}




function ulozitVysledekUtkani(id_utkani) {
    var domaci = jQuery("#utkani_vysledek_skore_domaci_"+id_utkani).val();
    var hoste = jQuery("#utkani_vysledek_skore_hoste_"+id_utkani).val();
    
    if (!postAjaxRequest(URL+"frogSys/bin/ajax/modules/VYSL.php", "predmet=vysledky&action=save_vysledek_utkani&id_utkani="+id_utkani+"&domaci="+domaci+"&hoste="+hoste, createWindow)) {
        //pokud nefunguje ajax
        return;
    }
}

function kontrolovatVysledekUtkani(id_utkani) {
    var cisla = new Array("1","2","3","4","5","6","7","8","9","0");
    var domaci = jQuery("#utkani_vysledek_skore_domaci_"+id_utkani).val();
    var hoste = jQuery("#utkani_vysledek_skore_hoste_"+id_utkani).val();
    if (domaci.length > 0) {
    domaci = domaci.substr(0, 1);
    if (!cisla.contains(domaci)) {
        domaci = 0;
    }
    jQuery("#utkani_vysledek_skore_domaci_"+id_utkani).val(domaci);
    }
    if (hoste.length > 0) {
    hoste = hoste.substr(0, 1);
    if (!cisla.contains(hoste)) {
        hoste = 0;
    }
    jQuery("#utkani_vysledek_skore_hoste_"+id_utkani).val(hoste);
    }
}