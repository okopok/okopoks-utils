<?php /* Smarty version 2.6.14, created on 2008-07-31 17:40:55
         compiled from D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/articles_one_article.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/articles_one_article.tpl', 14, false),)), $this); ?>
  <table width="100%">
    <tr style="background-color:#eeeeee;">
      <td width="20">
        <font size="4"><?php echo $this->_tpl_vars['article']['article_name']; ?>
</font>
          &nbsp;&nbsp;&nbsp;
          <small>автор: <b><?php echo $this->_tpl_vars['article']['users_name']; ?>
</b></small>
        </font>
      </td>
    </tr>
    <tr>
      <td><?php echo $this->_tpl_vars['article']['article_text']; ?>
</td>
    </tr>
    <tr>
      <td align="right"><small><?php echo ((is_array($_tmp=$this->_tpl_vars['article']['article_timestamp'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</small></td>
    </tr>
  </table>