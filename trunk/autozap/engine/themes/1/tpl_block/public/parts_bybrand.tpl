<div class="caption">Запчасти</div>
<table width="100%"  id="parts_grid">
{foreach from=$parts item=arr name=brands}
{if $smarty.foreach.brands.first}
  <tr class="brand_div">
    <td class="td" colspan="4">
      {if $brands_images[$arr.pk_brands_id].small}<img src="{$brands_images[$arr.pk_brands_id].small}" align="right"/>{/if}
      <a href="/parts/{$brandsbyid[$arr.pk_brands_id].brands_name_tag}/">{$brandsbyid[$arr.pk_brands_id].brands_name}</a>
    </td>
  </tr>
{/if}
  {if $arr.fk_models_id != $model_id}
    {assign var="model_id" value=`$arr.fk_models_id`}
    <tr class="model_div">
      <td class="td" width="100%" colspan="4">
        <a href="/parts/{$brandsbyid[$arr.pk_brands_id].brands_name_tag}/{$modelsbyid[$arr.fk_models_id].models_name_tag}/">{$modelsbyid[$arr.fk_models_id].models_name}</a>
      </td>
    </tr>
    <tr class="th" id="table_borders">
      <td class="td" width="70%">Наименование</td>
      <td class="td" width="10%">Номер</td>
      <td class="td" width="10%">Цена новой</td>
      <td class="td" width="10%">Цена старой</td>
    </tr>
  {/if}
  <tr class="tr_{cycle values='even,odd'}" id="table_borders" >
    <td class="td" width="70%">&nbsp;{$arr.parts_name}</td>
    <td class="td" width="10%">&nbsp;{$arr.parts_uid}</td>
    <td class="td" width="10%">&nbsp;{$arr.parts_cost}</td>
    <td class="td" width="10%">&nbsp;{$arr.parts_cost_old}</td>
  </tr>
{/foreach}
</table>
