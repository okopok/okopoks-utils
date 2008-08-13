{assign var="rowLimit" value=2}
{assign var="rowCount" value=0}
<table class="brands">
{foreach from=$brands item=brand key=brand_tag}
{if $rowCount == 0}<tr>{/if}
<td>
  <a href="#">
    {if $brands_images[$brand.pk_brands_id].small}
      <img src="{$brands_images[$brand.pk_brands_id].small}" alt="{$brand.brands_name}" border="0" title="{$brand.brands_name}"/>
    {else}
      <img width="50" height="50" alt="{$brand.brands_name}" border="0" title="{$brand.brands_name}"/>
    {/if}
  </a>
</td>
{assign var="rowCount" value=`$rowCount+1`}
{if $rowCount == $rowLimit}</tr>{assign var="rowCount" value=0}{/if}
{/foreach}
{if $rowCount < $rowLimit}</tr>{/if}
</table>