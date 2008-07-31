<table width="100%">
{foreach from=$articles->result item=arr}
  <tr class="tr_{cycle values='even,odd'}" id="table_borders" onmouseover="this.style.border = '1px solid #333333';" onmouseout="this.style.border = '0px'">
    <td class="td" width="40%">&nbsp;<a href="/articles/{$arr.article_name_tag}-{$arr.pk_article_id}/">{$arr.article_name}</a></td>
    <td class="td" width="50%">&nbsp;{$arr.article_timestamp|date_format}</td>
    <td class="td" width="10%">&nbsp;{$arr.users_name}</td>
  </tr>
{/foreach}
</table>
