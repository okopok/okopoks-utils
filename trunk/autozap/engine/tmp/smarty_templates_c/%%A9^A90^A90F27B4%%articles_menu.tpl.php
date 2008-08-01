<?php /* Smarty version 2.6.14, created on 2008-07-31 17:38:00
         compiled from D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/articles_menu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/articles_menu.tpl', 15, false),array('function', 'cycle', 'D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/articles_menu.tpl', 21, false),)), $this); ?>

  <table width="100%">
    <tr style="background-color:#eeeeee;">
      <td width="20">
        <font size="4"><?php echo $this->_tpl_vars['article'][0]['article_name']; ?>
</font>
          &nbsp;&nbsp;&nbsp;
          <small>автор: <b><?php echo $this->_tpl_vars['article'][0]['users_name']; ?>
</b></small>
        </font>
      </td>
    </tr>
    <tr>
      <td><?php echo $this->_tpl_vars['article'][0]['article_text']; ?>
</td>
    </tr>
    <tr>
      <td align="right"><small><?php echo ((is_array($_tmp=$this->_tpl_vars['article'][0]['article_timestamp'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</small></td>
    </tr>
  </table>

  <table width="100%">
  <?php $_from = $this->_tpl_vars['articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
    <tr class="tr_<?php echo smarty_function_cycle(array('values' => 'even,odd'), $this);?>
" id="table_borders" onmouseover="this.style.border = '1px solid #333333';" onmouseout="this.style.border = '0px'">
      <td class="td" width="40%">&nbsp;<a href="/articles/<?php echo $this->_tpl_vars['arr']['article_name_tag']; ?>
-<?php echo $this->_tpl_vars['arr']['pk_article_id']; ?>
/"><?php echo $this->_tpl_vars['arr']['article_name']; ?>
</a></td>
      <td class="td" width="50%">&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['arr']['article_timestamp'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</td>
      <td class="td" width="10%">&nbsp;<?php echo $this->_tpl_vars['arr']['users_name']; ?>
</td>
    </tr>
  <?php endforeach; endif; unset($_from); ?>
  </table>