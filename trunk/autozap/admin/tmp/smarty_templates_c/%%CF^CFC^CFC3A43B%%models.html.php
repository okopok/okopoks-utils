<?php /* Smarty version 2.6.14, created on 2008-07-04 12:47:08
         compiled from models.html */ ?>
<?php $_from = $this->_tpl_vars['models']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['hash']):
?>
&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['hash']['models_name']; ?>
<br />
<?php endforeach; endif; unset($_from); ?>