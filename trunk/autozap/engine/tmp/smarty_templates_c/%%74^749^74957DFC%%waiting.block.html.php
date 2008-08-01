<?php /* Smarty version 2.6.14, created on 2008-07-04 12:25:43
         compiled from waiting.block.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'waiting.block.html', 25, false),)), $this); ?>
<?php $this->assign('model_id', 0);  $this->assign('brand_id', 0); ?>
<table width="100%">
<?php $_from = $this->_tpl_vars['waiting']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
  <?php if ($this->_tpl_vars['arr']['pk_brands_id'] != $this->_tpl_vars['brand_id']): ?>
    <?php $this->assign('brand_id', ($this->_tpl_vars['arr']['pk_brands_id'])); ?>
    <tr class="brand_div">
      <td class="td" width="100%">
        <a href="/parts/<?php echo $this->_tpl_vars['arr']['brands_name_tag']; ?>
/"><?php echo $this->_tpl_vars['arr']['brands_name']; ?>
</a>
      </td>
    </tr>
  <?php endif; ?>
  <?php if ($this->_tpl_vars['arr']['fk_models_id'] != $this->_tpl_vars['model_id']): ?>
    <?php $this->assign('model_id', ($this->_tpl_vars['arr']['fk_models_id'])); ?>
    <tr class="model_div">
      <td class="td" width="100%">
        <a href="/parts/<?php echo $this->_tpl_vars['arr']['brands_name_tag']; ?>
/<?php echo $this->_tpl_vars['arr']['models_name_tag']; ?>
/"><?php echo $this->_tpl_vars['arr']['models_name']; ?>
</a>
      </td>
    </tr>
    <tr class="th" id="table_borders">
      <td class="td" width="100%">Наименование</td>
    </tr>
  <?php endif; ?>

  <tr class="tr_<?php echo smarty_function_cycle(array('values' => 'even,odd'), $this);?>
" id="table_borders" onmouseover="this.style.border = '1px solid #333333';" onmouseout="this.style.border = '0px'">
    <td class="td" width="100%">&nbsp;<?php echo $this->_tpl_vars['arr']['parts_name']; ?>
</td>
  </tr>
<?php endforeach; endif; unset($_from); ?>
</table>