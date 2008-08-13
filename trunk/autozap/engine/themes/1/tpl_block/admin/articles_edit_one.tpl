<form method="post">
<input type="hidden" name="mode" value="edit" />
article_name
<input type="text" name="field__article_name" value="" /><br />


article_text
<textarea name="filed__article_text">

</textarea><br />

article_timestamp   <input type="text" name="field__article_timestamp" value="" /><br />

article_owner    <select name="filed__article_owner">
  <option value="1">Sasha</option>
</select><br />

article_publish  <select name="filed__article_publish">
  <option value="yes">yes</option>
  <option value="no">no</option>
</select><br />

article_spec <select name="filed__article_spec">
  <option value="yes">yes</option>
  <option value="no">no</option>
</select><br />

article_img  <input type="file" name="filed__article_img" /><br />

<input type="submit" value="edit" />
</form>
<br />
<br />
<br />

<form method="post">
<input type="hidden" name="mode" value="delete" />
<input type="submit" value="del" />
</form>
