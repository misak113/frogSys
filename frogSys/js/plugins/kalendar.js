// Kalendář JS

var k_id = 0;
function zobrazNovyMesic(text) {
	changeText("kalendar_"+k_id, text);
}

function vybranoDatum(date) {
	var sta = document.getElementById("plan_akci_kdy_"+k_id);
	var sto = document.getElementById("plan_akci_do_"+k_id);
	if (sta.value == "0000-00-00") {
		sta.value = date;
		sto.value = date;
	} else
	if (sta.value == date) {
		sta.value = "0000-00-00";
		sto.value = "0000-00-00";
	} else
	if (mktime(date) < mktime(sta.value)) {
		sta.value = date;
	} else
	if (mktime(date) > mktime(sta.value)) {
		sto.value = date;
	}
	
	for (var i=1;;i++) {
		var obj = document.getElementById("kalendar_den_"+k_id+"_"+i);
		if (obj == null) {
			break;
		} else {
			if (mktime(obj.title) <= mktime(sto.value) && mktime(obj.title) >= mktime(sta.value)) {
				obj.style.backgroundColor = "#C0C0C0";
			} else {
				obj.style.backgroundColor = "transparent";
			}
		}
	}
}


// Dělá chybu při přelomu měsíce s 31 dny
function mktime(datum) {           
	var data = datum.split("-");
	var date = new Date();
	date.setFullYear(data[0]);
	date.setMonth(data[1]-1);
	date.setDate(data[2]);
	date.setHours(12);
	date.setMinutes(0);
	date.setSeconds(0);
	//date.setMilliseconds(0);       
	var ret = date.getTime();
	return ret;              
}