<?php /* Smarty version 2.6.14, created on 2008-07-04 12:25:43
         compiled from brands.block.html */ ?>
<?php $this->assign('brand_id', 0); ?>
<h2> |

<?php $_from = $this->_tpl_vars['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
  <?php if ($this->_tpl_vars['arr']['pk_brands_id'] != $this->_tpl_vars['brand_id']): ?>
    <?php $this->assign('brand_id', ($this->_tpl_vars['arr']['pk_brands_id'])); ?>
    <a href="/parts/<?php echo $this->_tpl_vars['arr']['brands_name_tag']; ?>
/"><?php echo $this->_tpl_vars['arr']['brands_name']; ?>
</a> |
  <?php endif;  endforeach; endif; unset($_from); ?>
</h2>