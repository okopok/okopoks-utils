<?php /* Smarty version 2.6.14, created on 2008-08-05 17:22:27
         compiled from D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/waiting_all.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/waiting_all.tpl', 30, false),)), $this); ?>
<?php $this->assign('model_id', 0);  $this->assign('brand_id', 0); ?>
<table width="100%">
<?php $_from = $this->_tpl_vars['waiting']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['brands'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['brands']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['arr']):
        $this->_foreach['brands']['iteration']++;
?>

<?php if ($this->_tpl_vars['arr']['pk_brands_id'] != $this->_tpl_vars['brand_id']): ?>
  <?php $this->assign('brand_id', ($this->_tpl_vars['arr']['pk_brands_id'])); ?>
  <tr class="brand_div">
    <td class="td" colspan="4">
      <?php if ($this->_tpl_vars['brands_images'][$this->_tpl_vars['arr']['pk_brands_id']]['small']): ?><img src="<?php echo $this->_tpl_vars['brands_images'][$this->_tpl_vars['arr']['pk_brands_id']]['small']; ?>
" align="right"/><?php endif; ?>
      <a href="/waiting/<?php echo $this->_tpl_vars['brandsbyid'][$this->_tpl_vars['arr']['pk_brands_id']]['brands_name_tag']; ?>
/"><?php echo $this->_tpl_vars['brandsbyid'][$this->_tpl_vars['arr']['pk_brands_id']]['brands_name']; ?>
</a>
    </td>
  </tr>
<?php endif;  if ($this->_tpl_vars['arr']['fk_models_id'] != $this->_tpl_vars['model_id']): ?>
  <?php $this->assign('model_id', ($this->_tpl_vars['arr']['fk_models_id'])); ?>
  <tr class="model_div">
    <td class="td" width="100%" colspan="4">
      <a href="/waiting/<?php echo $this->_tpl_vars['brandsbyid'][$this->_tpl_vars['arr']['pk_brands_id']]['brands_name_tag']; ?>
/<?php echo $this->_tpl_vars['modelsbyid'][$this->_tpl_vars['arr']['fk_models_id']]['models_name_tag']; ?>
/"><?php echo $this->_tpl_vars['modelsbyid'][$this->_tpl_vars['arr']['fk_models_id']]['models_name']; ?>
</a>
    </td>
  </tr>
  <tr class="th" id="table_borders">
    <td class="td" width="70%">������������</td>
    <td class="td" width="10%">�����</td>
    <td class="td" width="10%">���� �����</td>
    <td class="td" width="10%">���� ������</td>
  </tr>
<?php endif; ?>

  <tr class="tr_<?php echo smarty_function_cycle(array('values' => 'even,odd'), $this);?>
" id="table_borders" onmouseover="this.style.border = '1px solid #333333';" onmouseout="this.style.border = '0px'">
    <td class="td" width="70%">&nbsp;<?php echo $this->_tpl_vars['arr']['parts_name']; ?>
</td>
    <td class="td" width="10%">&nbsp;<?php echo $this->_tpl_vars['arr']['parts_uid']; ?>
</td>
    <td class="td" width="10%">&nbsp;<?php echo $this->_tpl_vars['arr']['parts_cost']; ?>
</td>
    <td class="td" width="10%">&nbsp;<?php echo $this->_tpl_vars['arr']['parts_cost_old']; ?>
</td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
</table>