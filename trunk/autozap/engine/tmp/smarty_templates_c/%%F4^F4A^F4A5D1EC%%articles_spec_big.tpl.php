<?php /* Smarty version 2.6.14, created on 2008-08-13 12:25:55
         compiled from D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/articles_spec_big.tpl */ ?>
<?php if (count ( $this->_tpl_vars['specsBig'] )): ?>
  <div class="caption">Спецпреждложения</div>
  <?php $this->assign('rowLimit', 3); ?>
  <?php $this->assign('rowCount', 0); ?>
  <table class="specs-big">
  <?php $_from = $this->_tpl_vars['specsBig']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['spec']):
?>
  <?php if ($this->_tpl_vars['rowCount'] == 0): ?><tr align="center"><?php endif; ?>
  <td><?php echo $this->_tpl_vars['key']; ?>
</td>
  <?php $this->assign('rowCount', ($this->_tpl_vars['rowCount']+1)); ?>
  <?php if ($this->_tpl_vars['rowCount'] == $this->_tpl_vars['rowLimit']): ?></tr><?php $this->assign('rowCount', 0);  endif; ?>
  <?php endforeach; endif; unset($_from); ?>
  <?php if ($this->_tpl_vars['rowCount'] < $this->_tpl_vars['rowLimit']): ?></tr><?php endif; ?>
  </table>
<?php endif; ?>