
{literal}
<!--script type="text/javascript" src="/js/tinymce/jscripts/tiny_mce/tiny_mce_gzip.js"></script>
<script type="text/javascript">
tinyMCE_GZ.init({
	plugins : 'style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,imagemanager,filemanager',
	themes : 'advanced',
	languages : 'en',
	disk_cache : true,
	debug : false
});
</script-->
<style>
.my_class{
background:#000000;
color:white;
}
</style>
<script type="text/javascript" src="/js/tiny_mce/tiny_mce_gzip.js"></script>
<script type="text/javascript">
tinyMCE_GZ.init({
	plugins : "safari,pagebreak,style,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
	themes : 'advanced',
	languages : 'en',
	disk_cache : true,
	debug : false
});
</script>
<script language="javascript" type="text/javascript" src="/js/tiny_mce/tiny_mce.js"> </script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	plugins : "safari,pagebreak,style,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",

	// Theme options
	theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	content_css : "/css/1/editor.css"
});

</script>

{/literal}

<form method="post">
<input type="hidden" name="mode" value="edit" />
article_name
<input type="text" name="field__article_name" value="{$article.article_name}" /><br />


article_text
<textarea name="field_article_text" cols="100" style="width:100%" rows="30">
{$article.article_text}
</textarea><br />

article_timestamp   <input type="text" name="field__article_timestamp" value="{$article.article_timestamp|date_format}" /><br />
article_owner    <select name="field_article_owner">
{foreach from=$users item=user}
  <option value="{$user.pk_users_id}" {if $article.article_owner == $user.pk_users_id}selected{/if}>{$user.users_name}</option>
{/foreach}
</select><br />

article_publish  <select name="field_article_publish">
  <option value="yes" {if $article.article_publish == 'yes'}selected{/if}>yes</option>
  <option value="no" {if $article.article_publish == 'no'}selected{/if}>no</option>
</select><br />

article_spec <select name="field_article_spec">
  <option value="yes" {if $article.article_spec == 'yes'}selected{/if}>yes</option>
  <option value="no" {if $article.article_spec == 'no'}selected{/if}>no</option>
</select><br />

article_img  <input type="file" name="field_article_img" /><br />

<input type="submit" value="edit" />
</form>
<br />
<br />
<br />

<form method="post">
<input type="hidden" name="mode" value="delete" />
<input type="submit" value="del" />
</form>
