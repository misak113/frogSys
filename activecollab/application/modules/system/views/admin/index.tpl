{title}Administration{/title}
{add_bread_crumb}Available Administration Tools{/add_bread_crumb}

<div class="admin_sections_container">
{foreach from=$admin_sections key=section_name item=section}
{if is_foreachable($section)}
  <div class="admin_section {cycle values='odd,even'}">
    <h3>{lang}{$section_name}{/lang}</h3>
    <ul>
    {foreach from=$section item=admin_section}
      {foreach from=$admin_section item=subsection}
      <li><a href="{$subsection.url}"><img src="{$subsection.icon}" alt="{$subsection.name}" /><span>{$subsection.name}</span></a></li>
      {/foreach}
    {/foreach}
    </ul>
    <div class="clear"></div>
  </div>
{/if}
{/foreach}
  
  <div class="admin_section {cycle values='odd,even'}">
    <h3>{lang}System information{/lang}</h3>
    <div class="installation_details">
      <dl>
        <dt>{lang}activeCollab Version{/lang}:</dt>
        <dd>{$ac_version}, {$licence_type}{if $license_branding_removed}, {lang}Branding removed{/lang}{/if}{if $upgrade_to_corporate_url} &middot; {link href=$upgrade_to_corporate_url}Upgrade to Corporate{/link}{/if}{if $branding_removal_url} &middot; {link href=$branding_removal_url}Purchase Branding Removal{/link}{/if}</dd>
        <dt><strong>{lang}License Key{/lang}</strong>:</dt>
        <dd><strong>Re-Nulled by FLIPMODE!</strong></dd>
        <dt>{lang}Support Expires{/lang}:</dt>
        <dd>Owned License</dd>
        <dt>{lang}Platform{/lang}:</dt>
        <dd>{lang php_version=$php_version mysql_version=$mysql_version}PHP (:php_version), MySQL (:mysql_version){/lang}</dd>
      </dl>
    </div>
  </div>
</div>