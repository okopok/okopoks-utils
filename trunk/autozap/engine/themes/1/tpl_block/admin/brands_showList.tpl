{assign var="model_id" value=0}
{assign var="brand_id" value=0}
{foreach from=$brandsModels key=brand_tag item=brand name=brands}
  {$brand.brands_name} - <a href="/admin/brands/{$brand.pk_brands_id}/edit/">edit</a><br />
{/foreach}
