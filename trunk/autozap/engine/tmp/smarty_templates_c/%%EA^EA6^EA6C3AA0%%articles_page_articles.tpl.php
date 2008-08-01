<?php /* Smarty version 2.6.14, created on 2008-07-31 17:43:57
         compiled from D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/articles_page_articles.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/articles_page_articles.tpl', 3, false),array('modifier', 'date_format', 'D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/articles_page_articles.tpl', 5, false),)), $this); ?>
<table width="100%">
<?php $_from = $this->_tpl_vars['articles']->result; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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