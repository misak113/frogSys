// JavaScript Document
 
function loadScript(url)
{
    var version = '';
    if (jsVersions[url] != 'undefined') {
        version = '?'+jsVersions[url];
    }
   var e = document.createElement("script");
   e.src = url+version;
   e.type="text/javascript";
   document.getElementsByTagName("head")[0].appendChild(e); 
}

Array.prototype.contains = function(obj) {
  var i = this.length;
  while (i--) {
    if (this[i] === obj) {
      return true;
    }
  }
  return false;
}

function drop_double_slashes(url) {
    var url2 = url.replace("://", ":&frasl;&frasl;");
    url2 = url2.replace("//", "/");
    url2 = url2.replace(":&frasl;&frasl;", "://");
    return url2;
}

function addLoadEvent(func) {  
	var oldonload = window.onload;  
	if (typeof window.onload != 'function') {  
		window.onload = func;  
	} else {  
	    window.onload = function() {  
	    if (oldonload) {  
	        oldonload();  
	    }  
	    	func();  
	    }  
	}  
}  


function stripWhitespace(field)
{
     return field.replace(/^\s*|\s*$/g,'');
}

function setCookie(c_name,value,exdays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
document.cookie=c_name + "=" + c_value +"; path=/";
}

function appendAttribute(obj, atr, app) {
	var pred = obj.getAttribute(atr);
	if (pred == null) {
		pred = "";
	}
	obj.setAttribute(atr, pred+app);
}

function fixQuery(source) {
	var goodchars = new Array("%",  "+",  "#",  "&",  " ","\"", "\\", "'",   ";");
	var htmlquery = new Array("%25","%2b","%23","%26","+","%22","%5c","%27", "%3b");

	for(var x = 0; x < goodchars.length; x++) {
		var fixchar = source.split(goodchars[x]);
		source = fixchar.join(htmlquery[x]);
	}
	return source;
}



function getFunctionName(func) {
  if ( typeof func == "function" || typeof func == "object" )
  var fName = (""+func).match(
    /function\s*([\w\$]*)\s*\(/
  );if ( fName !== null ) return fName[1];
}

function clearSelection () {
	if (window.getSelection) {
		window.getSelection().removeAllRanges();
	} else if (document.selection) {
		document.selection.empty();
	}
}




function getURI(url) {
	var u = url.split("/");
	return u[0]+"//"+u[2];
}



function getParentNode(node) {
	var parentNod = node.parentNode;
	if (parentNod != null) {
		return parentNod;
	} else {
		var zmena = false;
		if (node.id == "" || node.id == null) {
			node.id = "mojePomocneId";
			zmena = true;
		}
		eval("parentNod = document.all."+node.id+".parentNode");
		if (zmena == true) {
			node.id = "";
		}
		return parentNod;
	}
}






function getElementsByClassNameMy(className,parentElement) {
    var elements = [];
    var parentElement = parentElement || document.getElementsByTagName("html")[0];
    var nodes = parentElement.getElementsByTagName('*');

    for (var i = 0, child; child = nodes[i]; i++) {
      if (child.className && hasClassName(child,className)) {
        elements.push(child);
      }
    }
  return elements;
}

function hasClassName(element,className) {
    return element.className.match(new RegExp("(^|\\s)" + className + "(\\s|$)"));
}






function reloadPage() {
	location.reload(true);
}






/*
	Developed by Robert Nyman, http://www.robertnyman.com
	Code/licensing: http://code.google.com/p/getelementsbyclassname/
*/	
/*var getElementsByClassName = function (className, tag, elm){
	if (document.getElementsByClassName) {
		getElementsByClassName = function (className, tag, elm) {
			elm = elm || document;
			var elements = elm.getElementsByClassName(className),
				nodeName = (tag)? new RegExp("\\b" + tag + "\\b", "i") : null,
				returnElements = [],
				current;
			for(var i=0, il=elements.length; i<il; i+=1){
				current = elements[i];
				if(!nodeName || nodeName.test(current.nodeName)) {
					returnElements.push(current);
				}
			}
			return returnElements;
		};
	}
	else if (document.evaluate) {
		getElementsByClassName = function (className, tag, elm) {
			tag = tag || "*";
			elm = elm || document;
			var classes = className.split(" "),
				classesToCheck = "",
				xhtmlNamespace = "http://www.w3.org/1999/xhtml",
				namespaceResolver = (document.documentElement.namespaceURI === xhtmlNamespace)? xhtmlNamespace : null,
				returnElements = [],
				elements,
				node;
			for(var j=0, jl=classes.length; j<jl; j+=1){
				classesToCheck += "[contains(concat(' ', @class, ' '), ' " + classes[j] + " ')]";
			}
			try	{
				elements = document.evaluate(".//" + tag + classesToCheck, elm, namespaceResolver, 0, null);
			}
			catch (e) {
				elements = document.evaluate(".//" + tag + classesToCheck, elm, null, 0, null);
			}
			while ((node = elements.iterateNext())) {
				returnElements.push(node);
			}
			return returnElements;
		};
	}
	else {
		getElementsByClassName = function (className, tag, elm) {
			tag = tag || "*";
			elm = elm || document;
			var classes = className.split(" "),
				classesToCheck = [],
				elements = (tag === "*" && elm.all)? elm.all : elm.getElementsByTagName(tag),
				current,
				returnElements = [],
				match;
			for(var k=0, kl=classes.length; k<kl; k+=1){
				classesToCheck.push(new RegExp("(^|\\s)" + classes[k] + "(\\s|$)"));
			}
			for(var l=0, ll=elements.length; l<ll; l+=1){
				current = elements[l];
				match = false;
				for(var m=0, ml=classesToCheck.length; m<ml; m+=1){
					match = classesToCheck[m].test(current.className);
					if (!match) {
						break;
					}
				}
				if (match) {
					returnElements.push(current);
				}
			}
			return returnElements;
		};
	}
	return getElementsByClassName(className, tag, elm);
};
*/


function replace(str, co, cim) {
	while (str.indexOf(co) != -1) {
		str = str.substring(0, str.indexOf(co))+cim+str.substring(str.indexOf(co)+co.length, str.length);
	}
	return str
}


var _emptyTags = {
   "IMG":   true,
   "BR":    true,
   "INPUT": true,
   "META":  true,
   "LINK":  true,
   "PARAM": true,
   "HR":    true
};

try {
HTMLElement.prototype.__defineGetter__("outerHTML", function () {
   var attrs = this.attributes;
   var str = "<" + this.tagName;
   for (var i = 0; i < attrs.length; i++)
      str += " " + attrs[i].name + "=\"" + attrs[i].value + "\"";

   if (_emptyTags[this.tagName])
      return str + ">";

   return str + ">" + this.innerHTML + "</" + this.tagName + ">";
});
} catch (e) {}

function getScrollX() {
	return document.documentElement.scrollLeft+document.body.scrollLeft;
}

function getScrollY() {
	return document.documentElement.scrollTop+document.body.scrollTop;
}






 /**
   * Retrieve the coordinates of the given event relative to the center
   * of the widget.
   *
   * @param event
   *   A mouse-related DOM event.
   * @param reference
   *   A DOM element whose position we want to transform the mouse coordinates to.
   * @return
   *    A hash containing keys 'x' and 'y'.
   */
  function getRelativeCoordinates(event, reference) {
    var x, y;
    event = event || window.event;
    var el = event.target || event.srcElement;

    if (!window.opera && typeof event.offsetX != 'undefined') {
      // Use offset coordinates and find common offsetParent
      var pos = {x: event.offsetX, y: event.offsetY};

      // Send the coordinates upwards through the offsetParent chain.
      var e = el;
      while (e) {
        e.mouseX = pos.x;
        e.mouseY = pos.y;
        pos.x += e.offsetLeft;
        pos.y += e.offsetTop;
        e = e.offsetParent;
      }

      // Look for the coordinates starting from the reference element.
      var e = reference;
      var offset = {x: 0, y: 0}
      while (e) {
        if (typeof e.mouseX != 'undefined') {
          x = e.mouseX - offset.x;
          y = e.mouseY - offset.y;
          break;
        }
        offset.x += e.offsetLeft;
        offset.y += e.offsetTop;
        e = e.offsetParent;
      }

      // Reset stored coordinates
      e = el;
      while (e) {
        e.mouseX = undefined;
        e.mouseY = undefined;
        e = e.offsetParent;
      }
    }
    else {
      // Use absolute coordinates
      var pos = getAbsolutePosition(reference);
      x = event.pageX  - pos.x;
      y = event.pageY - pos.y;
    }
    // Subtract distance to middle
    return {x: x, y: y};
  }
  
  function getAbsolutePosition(element) {
    var r = {x: element.offsetLeft, y: element.offsetTop};
    if (element.offsetParent) {
      var tmp = getAbsolutePosition(element.offsetParent);
      r.x += tmp.x;
      r.y += tmp.y;
    }
    return r;
  };
  
function stripHTML(oldString) {

   var newString = "";
   var inTag = false;
   for(var i = 0; i < oldString.length; i++) {
   
        if(oldString.charAt(i) == '<') inTag = true;
        if(oldString.charAt(i) == '>') {
              if(oldString.charAt(i+1)=="<")
              {
              		//dont do anything
	}
	else
	{
		inTag = false;
		i++;
	}
        }
   
        if(!inTag) newString += oldString.charAt(i);

   }

   return newString;
}


jQuery.fn.outerHTML = function(s) {
return (s)
? this.before(s).remove()
: jQuery("<p>").append(this.eq(0).clone()).html();
}


function addToRequestQuery(prom, val) {
    var hra = window.location.href.split("?");
    if (hra[1] !== undefined) {
        hra = hra[1].split("&");
        var out = '';
        var is = false;
        for (var i=0;i < hra.length;i++) {
            var pr = hra[i].split("=");
            if (pr[0] == prom) {
                out += prom+"="+val+"&";
                is = true;
            } else {
                out += hra[i]+"&";
            }
        }
        if (!is) {
            out += prom+"="+val+"&";
        }
        return "?"+out.substr(0, out.length-1);
    } else {
        return "?"+prom+"="+val;
    }
}


/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

/**
 * Create a cookie with the given name and value and other optional parameters.
 *
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Set the value of a cookie.
 * @example $.cookie('the_cookie', 'the_value', { expires: 7, path: '/', domain: 'jquery.com', secure: true });
 * @desc Create a cookie with all available options.
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Create a session cookie.
 * @example $.cookie('the_cookie', null);
 * @desc Delete a cookie by passing null as value. Keep in mind that you have to use the same path and domain
 *       used when the cookie was set.
 *
 * @param String name The name of the cookie.
 * @param String value The value of the cookie.
 * @param Object options An object literal containing key/value pairs to provide optional cookie attributes.
 * @option Number|Date expires Either an integer specifying the expiration date from now on in days or a Date object.
 *                             If a negative value is specified (e.g. a date in the past), the cookie will be deleted.
 *                             If set to null or omitted, the cookie will be a session cookie and will not be retained
 *                             when the the browser exits.
 * @option String path The value of the path atribute of the cookie (default: path of page that created the cookie).
 * @option String domain The value of the domain attribute of the cookie (default: domain of page that created the cookie).
 * @option Boolean secure If true, the secure attribute of the cookie will be set and the cookie transmission will
 *                        require a secure protocol (like HTTPS).
 * @type undefined
 *
 * @name $.cookie
 * @cat Plugins/Cookie
 * @author Klaus Hartl/klaus.hartl@stilbuero.de
 */

/**
 * Get the value of a cookie with the given name.
 *
 * @example $.cookie('the_cookie');
 * @desc Get the value of a cookie.
 *
 * @param String name The name of the cookie.
 * @return The value of the cookie.
 * @type String
 *
 * @name $.cookie
 * @cat Plugins/Cookie
 * @author Klaus Hartl/klaus.hartl@stilbuero.de
 */
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // CAUTION: Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
