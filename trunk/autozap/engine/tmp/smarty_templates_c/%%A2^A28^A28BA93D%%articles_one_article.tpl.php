<?php /* Smarty version 2.6.14, created on 2008-08-13 12:08:43
         compiled from D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/articles_one_article.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_block/public/articles_one_article.tpl', 7, false),)), $this); ?>
<div class="caption" ><?php echo $this->_tpl_vars['article']['article_name']; ?>
</div>
<div class="padding">
  <p><?php echo $this->_tpl_vars['article']['article_text']; ?>
</p>
  <div align="right">
    <small>
      автор: <b><?php echo $this->_tpl_vars['article']['users_name']; ?>
</b><br />
      <?php echo ((is_array($_tmp=$this->_tpl_vars['article']['article_timestamp'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

    </small>
  </div>
</div>