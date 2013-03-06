// JavaScript Document





addLoadEvent(init);

function init() {
	//createWindow("<p>Na našich stránkách jsou prováděny nutné změny, děkujeme za pochopení.</p>");
}

function openPodrobnost(id) {
	var objekt = document.getElementById("telo_plan_akci_"+id);
	var img = document.getElementById("podrobnosti_img_plan_akci_"+id);
	if (objekt.style.height == "1px") {
		changeWindow("telo_plan_akci_"+id, false, "auto", false, false);
		img.src = "/images/icons/podrobnosti_close.png";
	} else {
		changeWindow("telo_plan_akci_"+id, false, 1, false, false);
		img.src = "/images/icons/podrobnosti_open.png";
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
		if (!postAjaxRequest("/bin/ajax/user.php", "predmet=kontakt&action=send&jmeno="+jmeno+"&email="+email+"&tel="+tel+"&text="+text, createAlert)) {
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
	if (document.formular.jmeno.value == "" ||
		document.formular.prijmeni.value == "" ||
		document.formular.telefon.value == "" ||
		document.formular.email.value == "" ||
		document.formular.ulice.value == "" ||
		document.formular.obec.value == "" ||
		document.formular.psc.value == "" ||
		document.formular.stat.value == "") {
		createAlert("Nevyplnil jste některé údaje!");
		return false;
	}
}

function smazZKosiku(id) {
	document.getElementsByName("pocet["+id+"]")[0].value = 0;
	document.prepocitani.submit();
}