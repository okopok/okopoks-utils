{if count($specsSmall)}
  {assign var="rowLimit" value=2}
  {assign var="rowCount" value=0}
  <table class="specs-small">
  {foreach from=$specsBig item=spec key=key}
  {if $rowCount == 0}<tr align="center">{/if}
  <td>{$key}</td>
  {assign var="rowCount" value=`$rowCount+1`}
  {if $rowCount == $rowLimit}</tr>{assign var="rowCount" value=0}{/if}
  {/foreach}
  {if $rowCount < $rowLimit}</tr>{/if}
  </table>
{/if}