{assign var="model_id" value=0}
{assign var="brand_id" value=0}
{foreach from=$brandsModels.brandsModels key=brand_tag item=models name=brands}
  {foreach from=$models item=model key=model_tag}
    {if $model.pk_brands_id != $brand_id}
      {assign var="brand_id" value=`$model.pk_brands_id`}
        {if $brands_images[$model.pk_brands_id].small}<img src="{$brands_images[$model.pk_brands_id].small}" align="right"/>{/if}
        <a href="/admin/brands/{$model.pk_brands_id}/edit/">{$brandsModels.brandsbyid[$model.pk_brands_id].brands_name}</a>
    {/if}
    {if $model.pk_models_id != $model_id}
      {assign var="model_id" value=`$model.pk_models_id`}
      <blockquote>
        {if $models_images[$arr.pk_models_id].small}<img src="{$models_images[$model.fk_models_id].small}" align="right"/>{/if}
        <a href="/admin/models/{$model.pk_models_id}/edit/">{$model.models_name}</a>
      </blockquote>
    {/if}
  {/foreach}
{/foreach}
