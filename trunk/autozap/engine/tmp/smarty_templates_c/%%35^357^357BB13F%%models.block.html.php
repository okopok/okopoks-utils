<?php /* Smarty version 2.6.14, created on 2008-07-24 13:19:01
         compiled from models.block.html */ ?>
<?php $this->assign('model_id', 0); ?>
<h4> |
<?php $_from = $this->_tpl_vars['models']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
  <?php if ($this->_tpl_vars['arr']['pk_models_id'] != $this->_tpl_vars['model_id']): ?>
    <?php $this->assign('model_id', ($this->_tpl_vars['arr']['pk_models_id'])); ?>
    <a href="/parts/<?php echo $this->_tpl_vars['arr']['brands_name_tag']; ?>
/<?php echo $this->_tpl_vars['arr']['models_name_tag']; ?>
/"><?php echo $this->_tpl_vars['arr']['models_name']; ?>
</a> |
  <?php endif;  endforeach; endif; unset($_from); ?>
</h4>