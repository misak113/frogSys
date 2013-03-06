// JavaScript Document


function loadTinyMCE(id) {
		//nevim proc to nemaze ty editory... dodelat nekdy
		var t = tinyMCE.editors;
		for (var i in t){
			try {
				tinyMCE.remove(tinymce.get(i));
			} catch (e) {}
		}
		tinyMCE.init({ 
			// General options 
			mode : "exact",
			elements: id, 
			theme : "advanced", 
			language : "cs",
			plugins : "inlinepopups,safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template", 
			
			setup : function(ed) { 
				ed.addButton('close', { 
					title : 'zavřít bez uložení', 
					image : '/images/icons/close.png', 
					onclick : close_tiny
				});
				ed.addButton('kontakt', { 
					title : 'formulář pro kontaktování', 
					image : '/images/icons/kontakt.png', 
					onclick : kontakt_to_tiny
				});
				ed.addButton('slideshow', { 
					title : 'Slideshow obrázky', 
					image : '/images/icons/slideshow.png', 
					onclick : slideshow_to_tiny
				});
			}, 
			
			// Theme options 
			theme_advanced_buttons1 : "save,newdocument,|,undo,redo,|,fullscreen,|,close",
			theme_advanced_buttons2: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,kontakt,slideshow",
			theme_advanced_buttons3 : "formatselect,fontselect,fontsizeselect", 
			theme_advanced_buttons4 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent", 
			theme_advanced_buttons5 : "link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons6 : "charmap,emotions,iespell,media,advhr,|,ltr,rtl,|,styleprops,|,insertlayer,moveforward,movebackward,absolute", 
			theme_advanced_toolbar_location : "top", 
			theme_advanced_toolbar_align : "left", 
			theme_advanced_statusbar_location : "bottom", 
			
			//fullscreen_new_window : true,
			//theme_advanced_resizing : true, 
			// Example content CSS (should be your site CSS) 
			content_css : "css/example.css", 
			// Drop lists for link/image/media/template dialogs 
			template_external_list_url : "js/template_list.js", 
			external_link_list_url : "js/link_list.js", 
			external_image_list_url : "js/image_list.js", 
			media_external_list_url : "js/media_list.js", 
			file_browser_callback : "fileBrowserCallBack",
			save_onsavecallback : "save_tiny"
			// Replace values for the template plugin 
			//template_replace_values : { 
			//	username : "Some User", 
			//	staffid : "991234" 
			//} 
		});
		return tinyMCE.get(id);
		
	}
	
	function kontakt_to_tiny(e) {
		var t = tinyMCE.editors;
		for (var i in t){
			var ob = tinyMCE.get(i);
			var id = (Math.random()+"").split(".")[1];
			ob.setContent(ob.getContent()+
		'<form action="javascript: sendKontakt(\''+id+'\');">'+
		'<table style="width: 500px;" border="0" cellspacing="0" cellpadding="0" class="kontakt_table">'+
            '<tr class="jmeno" title="">'+
            '    <th width="20%">Jméno:<span class="required">*</span></th>'+
            '    <td align="left">'+
            '    <input type="text" id="jmeno_'+id+'" value="" style="width: 400px; margin: 5px; padding: 2px 10px 2px 5px;" />                </td>'+
            '</tr>'+
            '<tr class="telefon" title="">'+
            '    <th width="20%">Telefon:<span class="required"></span></th>'+
            '    <td align="left">'+
            '    <input type="text" id="telefon_'+id+'" value="" style="width: 400px; margin: 5px; padding: 2px 10px 2px 5px;" />                </td>'+
            '</tr>'+
            '<tr class="email" title="">'+
            '    <th width="20%">E-mail:<span class="required">*</span></th>'+
            '    <td align="left">'+
            '    <input type="text" id="email_'+id+'" value="" style="width: 400px; margin: 5px; padding: 2px 10px 2px 5px;" />                </td>'+
            '</tr>'+
            '<tr class="text" title="">'+
            '    <th width="20%">Zpráva:<span class="required">*</span></th>'+
            '    <td align="left">'+
            '    <textarea id="text_'+id+'" cols="30" rows="5" style="width: 400px; margin: 5px; height: 100px; padding: 2px 10px 2px 5px;"></textarea>                </td>'+
            '</tr>'+
            '<tr>'+
            '    <td colspan="2" align="right" class="submit">'+
            '    <input type="submit" name="commit" value="Odeslat" style="width: 150px; height: 20px; margin: 5px;" />                </td>'+
            '</tr>'+
        '</table>'+
		'</form>');
			break;
		}
		
	}
	
	var aktual_tinymce_editor;
	function slideshow_to_tiny(e) {
		aktual_tinymce_editor = e;
		if (!postAjaxRequest("/bin/ajax/edit.php", "predmet=tinymce&action=addSlideshow", createWindow)) {
			//pokud nefunguje ajax
			return;
		}
	}
	
	function slideshow_to_tiny2() {
		var form = document.form_add_slideshow;
		var delay = form.delay.value;
		var rand = Math.random();
		var lis = '<div class="slide-show">'+
					'<script type="text/javascript">// <![CDATA['+
					'Event.observe(window, \'load\', function() {initSlideshow(\'slide-show-'+rand+'\', '+delay+');}, false);'+
					'// ]]></script>'+
					'<ul id="slide-show-'+rand+'" class="slide-images">';
		for (var i=0;i < form.length;i++) {
			if (form[i].name == "obr") {
				lis += '<li><img title="Obrázek" src="'+form[i].value+'" alt="Obrázek" /></li>';
			}
		}
		lis += '</ul></div>';
		
		var t = tinyMCE.editors;
		for (var i in t){
			var ob = tinyMCE.get(i);
			ob.setContent(ob.getContent()+lis);
			break;
		}
		zavriWindow();
	}
	
	function browseSlideshow(id) {
		fileBrowserCallBack(id, '', 'image', window);
	}
	
	function nextSlideshowImage() {
		var rand = Math.random();
		document.getElementById("table_slideshow").innerHTML += '<tr><td>Obrázek X: </td><td><input type="text" name="obr" id="slideshow_obr'+rand+'" /><input type="button" value="najít" onclick="browseSlideshow(\'slideshow_obr'+rand+'\');" /></td></tr>';
	}
	
	function close_tiny(ed) {
		tinyMCE.remove(ed);
		try {
			document.body.removeChild(document.getElementById("mce_fullscreen_container"));
		} catch (e) {}
		if (produkt_editing == true) {
			shopProduktRefresh("Editace zavřena bez uložení!");
		} else 
		if (top_title_editing == true) {
			refreshTop_title("Editace zavřena bez uložení!");
		} else {
			try {
				partRefresh("Editace zavřena bez uložení!"); 
			} catch (e) {}
		}
		
		getBody().style.overflowX = "";
		getBody().style.overflowY = "";
		document.getElementsByTagName("html")[0].style.overflowX = "";
		document.getElementsByTagName("html")[0].style.overflowY = "";
		document.getElementsByTagName("html")[0].style.overflow = "";
		
	} 
	
	
	function save_tiny() {
		try {
			document.body.removeChild(document.getElementById("mce_fullscreen_container"));
			//document.getElementById("mce_fullscreen_container").close();
		} catch (e) {}
		
		getBody().style.overflowX = "";
		getBody().style.overflowY = "";
		document.getElementsByTagName("html")[0].style.overflowX = "";
		document.getElementsByTagName("html")[0].style.overflowY = "";
		document.getElementsByTagName("html")[0].style.overflow = "";
		
		var t = tinyMCE.editors;
		for (var i in t){
			try {
				getParentNode(document.getElementById(i)).submit();
			} catch (e) {}
		}
		//tinymce;
	}
	
	function SetUrl(fileUrl) {
			var iframe = null;
			var i = 0;
			while (iframe == null && i < 1000) {
				i++;
				iframe = document.getElementById("mce_"+i+"_ifr");
				
			}
			//iframe.contentWindow.document.
			aktual_fbcb_win.document.getElementById(aktual_field_name).value = getURI(document.location.href)+""+fileUrl;
	}

var aktual_field_name, aktual_fbcb_win;
function fileBrowserCallBack(field_name, url, type, win) {
	aktual_field_name = field_name;
	aktual_fbcb_win = win;
	var connector = "/js/tiny_mce/plugins/filemanager/browser/default/browser.html?Connector=connectors/php/connector.php";
	var enableAutoTypeSelection = true;
	var cType;
	tinyfck_field = field_name;
	tinyfck = win;
	switch (type) {
		case "image":
			cType = "Image";
			break;
		case "flash":
			cType = "Flash";
			break;
		case "file":
			cType = "File";
			break;
	}
	if (enableAutoTypeSelection && cType) {
		connector += "&Type=" + cType;
	}
	window.open(connector, "tinyfck", "modal,width=750,height=400");
}
