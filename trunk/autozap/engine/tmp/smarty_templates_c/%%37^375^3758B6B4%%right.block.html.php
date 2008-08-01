<?php /* Smarty version 2.6.14, created on 2008-07-04 12:25:43
         compiled from right.block.html */ ?>
<?php if (count ( $this->_tpl_vars['BrandsModelsByTable'] ) > 0): ?>
  <?php $this->assign('brand_id', 0); ?>
  <h2><a href="/<?php echo $this->_tpl_vars['_VIRT'][0]; ?>
/">Все</a></h2>

  <?php $_from = $this->_tpl_vars['BrandsModelsByTable']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['brandsModels'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['brandsModels']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['arr']):
        $this->_foreach['brandsModels']['iteration']++;
?>
    <?php if ($this->_tpl_vars['brand_id'] != $this->_tpl_vars['arr']['pk_brands_id']): ?>
      <?php $this->assign('brand_id', ($this->_tpl_vars['arr']['pk_brands_id'])); ?>
      <?php if (! ($this->_foreach['brandsModels']['iteration'] <= 1)): ?></div><?php endif; ?>
      <div><h3><a href="/<?php echo $this->_tpl_vars['_VIRT'][0]; ?>
/<?php echo $this->_tpl_vars['arr']['brands_name_tag']; ?>
/"><?php echo $this->_tpl_vars['arr']['brands_name']; ?>
</a></h3></div>
      <div id="div_<?php echo $this->_tpl_vars['arr']['brands_name_tag']; ?>
">
    <?php endif; ?>
    <a href="/<?php echo $this->_tpl_vars['_VIRT'][0]; ?>
/<?php echo $this->_tpl_vars['arr']['brands_name_tag']; ?>
/<?php echo $this->_tpl_vars['arr']['models_name_tag']; ?>
/"><?php echo $this->_tpl_vars['arr']['models_name']; ?>
</a><br />
    <?php if (($this->_foreach['brandsModels']['iteration'] == $this->_foreach['brandsModels']['total'])): ?></div><?php endif; ?>
  <?php endforeach; endif; unset($_from);  endif; ?>