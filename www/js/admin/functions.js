


function generujLink(type, id) {
	var name = document.getElementById(type+"_nazev_"+id).value;
	var link = name.toLowerCase();
	link = stripHTML(link);
	link = replace(link, "  ", " ");
	link = replace(link, " ", "-");
	var co = new Array("ě","ř","ť","š","ď","č","ň","é","ú","í","ó","á","ý","ů","ž");
	var cim = new Array("e","r","t","s","d","c","n","e","u","i","o","a","y","u","z");
	for (var i = 0;i < co.length;i++) {
		link = replace(link, co[i], cim[i]);
	}
	var allowedChars = new Array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","-");
	var link2 = link;
	for (var i = 0;i < link2.length;i++) {
		var ok = false;
		for (var j = 0;j < allowedChars.length;j++) {
			if (link2.toLowerCase()[i] == allowedChars[j]) {
				ok = true;
				break;
			}
		}
		if (ok == false) {
			link = replace(link, link2[i], "");
		}
	}
	document.getElementById(type+"_odkaz_"+id).value = link;
}

