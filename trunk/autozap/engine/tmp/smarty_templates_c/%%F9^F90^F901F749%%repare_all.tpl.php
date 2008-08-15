<?php /* Smarty version 2.6.14, created on 2008-08-15 13:49:45
         compiled from D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/repare_all.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/repare_all.tpl', 30, false),)), $this); ?>
<div class="caption">Ремонт</div>
<?php $this->assign('model_id', 0);  $this->assign('brand_id', 0); ?>
<table width="100%"  id="repare_grid">
<?php $_from = $this->_tpl_vars['repare']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['brands'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['brands']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['arr']):
        $this->_foreach['brands']['iteration']++;
?>

<?php if ($this->_tpl_vars['arr']['pk_brands_id'] != $this->_tpl_vars['brand_id']): ?>
  <?php $this->assign('brand_id', ($this->_tpl_vars['arr']['pk_brands_id'])); ?>
  <tr class="brand_div">
    <td class="td" colspan="2">
      <?php if ($this->_tpl_vars['brands_images'][$this->_tpl_vars['arr']['pk_brands_id']]['small']): ?><img src="<?php echo $this->_tpl_vars['brands_images'][$this->_tpl_vars['arr']['pk_brands_id']]['small']; ?>
" align="right"/><?php endif; ?>
      <a href="/repare/<?php echo $this->_tpl_vars['brandsbyid'][$this->_tpl_vars['arr']['pk_brands_id']]['brands_name_tag']; ?>
/"><?php echo $this->_tpl_vars['brandsbyid'][$this->_tpl_vars['arr']['pk_brands_id']]['brands_name']; ?>
</a>
    </td>
  </tr>
<?php endif;  if ($this->_tpl_vars['arr']['fk_models_id'] != $this->_tpl_vars['model_id']): ?>
  <?php $this->assign('model_id', ($this->_tpl_vars['arr']['fk_models_id'])); ?>
  <tr class="model_div">
    <td class="td" width="100%" colspan="2">
      <?php if ($this->_tpl_vars['models_images'][$this->_tpl_vars['arr']['pk_models_id']]['small']): ?><img src="<?php echo $this->_tpl_vars['models_images'][$this->_tpl_vars['arr']['fk_models_id']]['small']; ?>
" align="right"/><?php endif; ?>
      <a href="/repare/<?php echo $this->_tpl_vars['brandsbyid'][$this->_tpl_vars['arr']['pk_brands_id']]['brands_name_tag']; ?>
/<?php echo $this->_tpl_vars['modelsbyid'][$this->_tpl_vars['arr']['fk_models_id']]['models_name_tag']; ?>
/"><?php echo $this->_tpl_vars['modelsbyid'][$this->_tpl_vars['arr']['fk_models_id']]['models_name']; ?>
</a>
    </td>
  </tr>
  <tr class="th" id="table_borders">
    <td class="td" width="70%">Наименование</td>
    <td class="td" width="10%">Стоимость</td>
  </tr>
<?php endif; ?>

  <tr class="tr_<?php echo smarty_function_cycle(array('values' => 'even,odd'), $this);?>
" id="table_borders" >
    <td class="td" width="70%">&nbsp;<?php echo $this->_tpl_vars['arr']['repare_name']; ?>
</td>
    <td class="td" width="10%">&nbsp;<?php echo $this->_tpl_vars['arr']['repare_cost']; ?>
</td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
</table>