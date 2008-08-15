<div class="caption">Ремонт</div>
{assign var="model_id" value=0}
{assign var="brand_id" value=0}
<table width="100%"  id="repare_grid">
{foreach from=$repare item=arr name=brands}

{if $arr.pk_brands_id != $brand_id}
  {assign var="brand_id" value=`$arr.pk_brands_id`}
  <tr class="brand_div">
    <td class="td" colspan="2">
      {if $brands_images[$arr.pk_brands_id].small}<img src="{$brands_images[$arr.pk_brands_id].small}" align="right"/>{/if}
      <a href="/repare/{$brandsbyid[$arr.pk_brands_id].brands_name_tag}/">{$brandsbyid[$arr.pk_brands_id].brands_name}</a>
    </td>
  </tr>
{/if}
{if $arr.fk_models_id != $model_id}
  {assign var="model_id" value=`$arr.fk_models_id`}
  <tr class="model_div">
    <td class="td" width="100%" colspan="2">
      {if $models_images[$arr.pk_models_id].small}<img src="{$models_images[$arr.fk_models_id].small}" align="right"/>{/if}
      <a href="/repare/{$brandsbyid[$arr.pk_brands_id].brands_name_tag}/{$modelsbyid[$arr.fk_models_id].models_name_tag}/">{$modelsbyid[$arr.fk_models_id].models_name}</a>
    </td>
  </tr>
  <tr class="th" id="table_borders">
    <td class="td" width="70%">Наименование</td>
    <td class="td" width="10%">Стоимость</td>
  </tr>
{/if}

  <tr class="tr_{cycle values='even,odd'}" id="table_borders" >
    <td class="td" width="70%">&nbsp;{$arr.repare_name}</td>
    <td class="td" width="10%">&nbsp;{$arr.repare_cost}</td>
  </tr>
{/foreach}
</table>
