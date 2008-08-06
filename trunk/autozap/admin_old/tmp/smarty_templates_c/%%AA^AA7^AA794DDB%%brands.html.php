<?php /* Smarty version 2.6.14, created on 2008-07-24 13:22:42
         compiled from brands.html */ ?>
<?php $_from = $this->_tpl_vars['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['hash']):
?>

<a href="/admin/showbrands/<?php echo $this->_tpl_vars['hash']['brands_name_tag']; ?>
"><?php echo $this->_tpl_vars['hash']['brands_name']; ?>
</a>
<small>(<a href="/admin/editbrands/<?php echo $this->_tpl_vars['hash']['brands_name_tag']; ?>
/edit/">edit</a>)</small>
<br />
<?php endforeach; endif; unset($_from); ?>