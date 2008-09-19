{assign var="model_id" value=0}
{assign var="brand_id" value=0}
{foreach from=$brandsModels key=brand_tag item=arr name=brands}
    {foreach from=$arr key=model_tag item=model name=models}
        {$model.brands_name} - {$model.models_name} - <a href="/admin/models/{$model.pk_models_id}/edit/">edit</a><br />
    {/foreach}
{/foreach}