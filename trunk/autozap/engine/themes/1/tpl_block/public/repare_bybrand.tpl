<table width="100%">
{foreach from=$repare item=arr name=brands}
{if $smarty.foreach.brands.first}
  <tr class="brand_div">
    <td class="td" colspan="4">
      {if $brandsImages[$brand_id].small}<img src="{$brandsImages[$brand_id].small}" align="right"/>{/if}
      <a href="/repare/{$brandsbyid[$arr.pk_brands_id].brands_name_tag}/">{$brandsbyid[$arr.pk_brands_id].brands_name}</a>
    </td>
  </tr>
{/if}
  {if $arr.fk_models_id != $model_id}
    {assign var="model_id" value=`$arr.fk_models_id`}
    <tr class="model_div">
      <td class="td" width="100%" colspan="4">
        <a href="/repare/{$brandsbyid[$arr.pk_brands_id].brands_name_tag}/{$modelsbyid[$arr.fk_models_id].models_name_tag}/">{$modelsbyid[$arr.fk_models_id].models_name}</a>
      </td>
    </tr>
    <tr class="th" id="table_borders">
      <td class="td" width="70%">Наименование</td>
      <td class="td" width="10%">Номер</td>
      <td class="td" width="10%">Цена новой</td>
      <td class="td" width="10%">Цена старой</td>
    </tr>
  {/if}
  <tr class="tr_{cycle values='even,odd'}" id="table_borders" onmouseover="this.style.border = '1px solid #333333';" onmouseout="this.style.border = '0px'">
    <td class="td" width="70%">&nbsp;{$arr.repare_name}</td>
    <td class="td" width="10%">&nbsp;{$arr.repare_uid}</td>
    <td class="td" width="10%">&nbsp;{$arr.repare_cost}</td>
    <td class="td" width="10%">&nbsp;{$arr.repare_cost_old}</td>
  </tr>
{/foreach}
</table>
