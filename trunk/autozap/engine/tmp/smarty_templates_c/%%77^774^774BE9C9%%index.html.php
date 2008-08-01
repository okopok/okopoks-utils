<?php /* Smarty version 2.6.14, created on 2008-07-04 12:25:39
         compiled from index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'index.html', 1, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => "index.conf"), $this);?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "meta.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<h3>Это index template</h3>

<a href="/repare/">починка</a> |
<a href="/parts/">Запчасти</a> |
<a href="/waiting/">Ожидаем</a> |
<a href="/articles/">Статьи</a>