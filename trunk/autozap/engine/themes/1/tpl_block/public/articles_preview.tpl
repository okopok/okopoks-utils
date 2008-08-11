<table width="100%">
{foreach from=$articles item=arr}
  <tr class="tr_{cycle values='even,odd'}" id="table_borders" onmouseover="this.style.border = '1px solid #333333';" onmouseout="this.style.border = '0px'">
    <td class="td" width="40%">
      <p>
      <strong><a href="/articles/{$arr.article_name_tag}-{$arr.pk_article_id}/">{$arr.article_name}</a></strong> &mdash; {$arr.article_timestamp|date_format} <br />
      {$arr.article_text}... <a href="/articles/{$arr.article_name_tag}-{$arr.pk_article_id}/">далее</a> &mdash; by <i><strong>{$arr.users_name}</strong></i>
      </p>
    </td>
  </tr>
{/foreach}
</table>