<?php /* Smarty version 2.6.14, created on 2008-08-14 16:46:34
         compiled from D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/admin/articles_edit_one.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/admin/articles_edit_one.tpl', 64, false),)), $this); ?>

<?php echo '
<!--script type="text/javascript" src="/js/tinymce/jscripts/tiny_mce/tiny_mce_gzip.js"></script>
<script type="text/javascript">
tinyMCE_GZ.init({
	plugins : \'style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,imagemanager,filemanager\',
	themes : \'advanced\',
	languages : \'en\',
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
	themes : \'advanced\',
	languages : \'en\',
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
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	content_css : "/css/1/editor.css"
});

</script>

'; ?>


<form method="post">
<input type="hidden" name="mode" value="edit" />
article_name
<input type="text" name="field__article_name" value="<?php echo $this->_tpl_vars['article']['article_name']; ?>
" /><br />


article_text
<textarea name="field_article_text" cols="100" style="width:100%" rows="30">
<?php echo $this->_tpl_vars['article']['article_text']; ?>

</textarea><br />

article_timestamp   <input type="text" name="field__article_timestamp" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['article']['article_timestamp'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
" /><br />
article_owner    <select name="field_article_owner">
<?php $_from = $this->_tpl_vars['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['user']):
?>
  <option value="<?php echo $this->_tpl_vars['user']['pk_users_id']; ?>
" <?php if ($this->_tpl_vars['article']['article_owner'] == $this->_tpl_vars['user']['pk_users_id']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['user']['users_name']; ?>
</option>
<?php endforeach; endif; unset($_from); ?>
</select><br />

article_publish  <select name="field_article_publish">
  <option value="yes" <?php if ($this->_tpl_vars['article']['article_publish'] == 'yes'): ?>selected<?php endif; ?>>yes</option>
  <option value="no" <?php if ($this->_tpl_vars['article']['article_publish'] == 'no'): ?>selected<?php endif; ?>>no</option>
</select><br />

article_spec <select name="field_article_spec">
  <option value="yes" <?php if ($this->_tpl_vars['article']['article_spec'] == 'yes'): ?>selected<?php endif; ?>>yes</option>
  <option value="no" <?php if ($this->_tpl_vars['article']['article_spec'] == 'no'): ?>selected<?php endif; ?>>no</option>
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