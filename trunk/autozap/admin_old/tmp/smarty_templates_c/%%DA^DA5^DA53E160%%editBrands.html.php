<?php /* Smarty version 2.6.14, created on 2008-07-24 13:20:54
         compiled from editBrands.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<h3>Это admin.index template</h3>
<form method="post" enctype="multipart/form-data">
  <input type="hidden" name="old_name" value="<?php echo $this->_tpl_vars['brand']['brands_name']; ?>
">
  <input type="text" name="name" value="<?php echo $this->_tpl_vars['brand']['brands_name']; ?>
">
  <input type="file" name="img" />
  <?php if ($this->_tpl_vars['brand']['img']): ?>
    <input type="checkbox" name="del_img" value="1">
    <img src="<?php echo $this->_tpl_vars['brand']['img']; ?>
" />
  <?php endif; ?>
  <input type="submit">
</form>
<form method="post" enctype="multipart/form-data" onsubmit="if(!confirm('уверен?!') return false;">
  <input type="hidden" name="del_brand" value="<?php echo $this->_tpl_vars['brand']['pk_brands_id']; ?>
">
  <input type="submit">
</form>