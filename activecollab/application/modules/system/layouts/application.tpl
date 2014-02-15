<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us" lang="en-us">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    {if $mobile_device_css}
      <link rel="stylesheet" href="{$mobile_device_css}" type="text/css" />
    {else}
      <link rel="stylesheet" href="{$assets_url}/css.php" type="text/css" />
      <link rel="stylesheet" href="{$assets_url}/themes/{$theme_name}/theme.css" type="text/css" />
      <!--[if IE]>
        <link rel="stylesheet" href="{$assets_url}/stylesheets/iefix.css" type="text/css" />
      <![endif]-->
    {/if}
    
    <script type="text/javascript" src="{$assets_url}/js.php"></script>
    <link rel="shortcut icon" href="{image_url name='favicon.png'}" type="image/x-icon" />

    <title>{page_title default="Projects"} / {$owner_company->getName()|clean}</title>
    {page_head_tags}
    {template_vars_to_js}
  </head>
  <body style="margin: 0;">
    <div id="wrapper">
      <!--<h1>{page_title default="Page"}</h1> -->
      {flash_box}
      <div id="content">{$content_for_layout}</div>
      <div id="footer">
      {if $application->copyright_removed()}
        <p id="copyright">&copy;{year} by {$owner_company->getName()|clean}</p>
      {else}
      	<p id="powered_by"><img src="{image_url name=acpowered.gif}" alt="Re-Nulled by FLIPMODE!" /></p>
      {/if}
      </div>
    </div>

{literal}
    <div id="cboxbutton" style="z-index:10000;position: fixed; bottom: 8px; right: 16px; width: 200px; padding: 3px; text-align: center; cursor: pointer; background-color: #EDF3F7; border:#C3D7E5 1px solid;border-radius: 3px; font-family: Tahoma, sans-serif; font-size: 14px;" onclick="togglecbox()"><b>Open Cbox</b></div>
<div id="cboxdiv" style="z-index:10000;display: block; position: fixed; bottom: 48px; right: 16px; width: 200px; background: #EDF3F7; padding: 3px; line-height: 0;border:#C3D7E5 1px solid;border-radius: 3px;"></div>
<script type="text/javascript">
var cbvis = false;
var cbload = false;
var cbcookie = "cboxvis=";

function togglecbox () {
  var cbdiv = document.getElementById("cboxdiv");
  var cbbut = document.getElementById("cboxbutton");

  if (!cbvis) {
    if (!cbload) {
      cbdiv.innerHTML = '<iframe frameborder="0" width="200" height="305" src="http://www5.cbox.ws/box/?boxid=844841&amp;boxtag=7phfvg&amp;sec=main" marginheight="2" marginwidth="2" scrolling="auto" allowtransparency="yes" name="cboxmain5-844841" style="z-index:10000;border:#ababab 1px solid;border-bottom:0px" id="cboxmain5-844841"></iframe><iframe frameborder="0" width="200" height="75" src="http://www5.cbox.ws/box/?boxid=844841&amp;boxtag=7phfvg&amp;sec=form" marginheight="2" marginwidth="2" scrolling="no" allowtransparency="yes" name="cboxform5-844841" style="z-index:10000;border:#ababab 1px solid;border-top:0px" id="cboxform5-844841"></iframe>';
      cbload = true;
    }
    cbdiv.style.display = "block";
    cbbut.innerHTML = "Close Cbox";
  }
  else {
    cbdiv.style.display = "none";
    cbbut.innerHTML = "Open Cbox";
  }
  cbvis = !cbvis;
  document.cookie = cbcookie+((cbvis)?1:0);
}
// Toggle Cbox open if it was previously
var cbcookiei = document.cookie.indexOf(cbcookie);
if (cbcookiei >= 0) {
  if (document.cookie.substring(cbcookiei+cbcookie.length, cbcookiei+cbcookie.length+1) === "1") {
    togglecbox();
  }
}
</script>
{/literal}


  </body>
</html>