<div class="caption" >{$article.article_name}</div>
<div class="padding">
  <p>{$article.article_text}</p>
  <div align="right">
    <small>
      автор: <b>{$article.users_name}</b><br />
      {$article.article_timestamp|date_format}
    </small>
  </div>
</div>