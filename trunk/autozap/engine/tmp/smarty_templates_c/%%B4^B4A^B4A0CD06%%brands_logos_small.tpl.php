<?php /* Smarty version 2.6.14, created on 2008-08-13 12:26:33
         compiled from D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/brands_logos_small.tpl */ ?>
<?php $this->assign('rowLimit', 2);  $this->assign('rowCount', 0); ?>
<table class="brands">
<?php $_from = $this->_tpl_vars['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['brand_tag'] => $this->_tpl_vars['brand']):
 if ($this->_tpl_vars['rowCount'] == 0): ?><tr><?php endif; ?>
<td>
  <a href="#">
    <?php if ($this->_tpl_vars['brands_images'][$this->_tpl_vars['brand']['pk_brands_id']]['small']): ?>
      <img src="<?php echo $this->_tpl_vars['brands_images'][$this->_tpl_vars['brand']['pk_brands_id']]['small']; ?>
" alt="<?php echo $this->_tpl_vars['brand']['brands_name']; ?>
" border="0" title="<?php echo $this->_tpl_vars['brand']['brands_name']; ?>
"/>
    <?php else: ?>
      <img width="50" height="50" alt="<?php echo $this->_tpl_vars['brand']['brands_name']; ?>
" border="0" title="<?php echo $this->_tpl_vars['brand']['brands_name']; ?>
"/>
    <?php endif; ?>
  </a>
</td>
<?php $this->assign('rowCount', ($this->_tpl_vars['rowCount']+1));  if ($this->_tpl_vars['rowCount'] == $this->_tpl_vars['rowLimit']): ?></tr><?php $this->assign('rowCount', 0);  endif;  endforeach; endif; unset($_from);  if ($this->_tpl_vars['rowCount'] < $this->_tpl_vars['rowLimit']): ?></tr><?php endif; ?>
</table>