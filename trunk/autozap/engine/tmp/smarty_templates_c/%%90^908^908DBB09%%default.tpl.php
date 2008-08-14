<?php /* Smarty version 2.6.14, created on 2008-08-13 12:28:53
         compiled from D:/HTDOCS/autozap.local/www/engine/themes/1/tpl_theme/public/default.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
   <title>Диз</title>
   <link rel="shortcut icon" href="favicon.ico">
   <link href="/css/1/global.css" rel="stylesheet" type="text/css" media="all">
   <!--script type='text/javascript'
        src='http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js'></script-->
   <!--[if IE]><link href="/css/1/ie_only.css" rel="stylesheet" type="text/css"> <![endif]-->
  </head>
  <body >
    <div id="header">
      <table class="grid" cellpadding="0" cellspacing="0">
        <tr>
          <td class="left" style="background: #481832 url('/img/1/dis.fon_02.png') repeat-x;">
            <div align="center">
              <a href="/"><img src="/img/1/dis.greenroadauto.png"/></a>
            </div><br clear="all" />
            <div align="center">
              <a href="/"><img src="/img/1/dis.yellow_car.png" /></a>
            </div>
          </td>
          <td class="center">
            <div class="top-menu-button"><a href="#">О компании</a></div>
            <div class="top-menu-button"><a href="/repare/" <?php if ($this->_tpl_vars['controller_action'] == 'repare'): ?>class="active"<?php endif; ?>>Ремонт</a></div>
            <div class="top-menu-button"><a href="/parts/" <?php if ($this->_tpl_vars['controller_action'] == 'parts'): ?>class="active"<?php endif; ?>>Запчасти</a></div>
            <div class="top-menu-button"><a href="/articles/kontakty-2/" <?php if ($this->_tpl_vars['controller_action'] == 'articles' && $this->_tpl_vars['controller_action_id'] == '2'): ?>class="active"<?php endif; ?>>Контакты</a></div>
          </td>
          <td class="right" valign="top" style="background: #481832 url('/img/1/dis.fon_02.png') repeat-x;">
            <br />
            <div style="background:url('/img/1/dis.black.pane.png'); padding:10px;" align="center">
              <a href="/"><img src="/img/1/dis.ico.home.png" align="absmiddle"/></a>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <img src="/img/1/dis.ico.search.png" align="absmiddle"/>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <img src="/img/1/dis.ico.mail.png" align="absmiddle"/>
            </div>
            <br />
            <br /><br />
            <div align="center">
              <a href="/"><img src="/img/1/dis.phones.png" /></a>
            </div>
          </td>
        </tr>
      </table>
    </div>


    <div id="content">
      <table cellpadding="0" cellspacing="0" class="grid">
        <tr valign="top">
          <td class="left">

            <div id="left-top">
              <div class="left-menu-button"><img src="/img/1/dis.pack.png" align="absmiddle" /> <a href="/parts/" <?php if ($this->_tpl_vars['controller_action'] == 'parts'): ?>class="active"<?php endif; ?>>Запчасти</a></div>
              <div class="left-menu-button"><img src="/img/1/dis.tools.png" align="absmiddle" /> <a href="/repare/" <?php if ($this->_tpl_vars['controller_action'] == 'repare'): ?>class="active"<?php endif; ?>>Ремонт</a></div>
              <?php if ($this->_tpl_vars['blocks']['left_top']['path']): ?>    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['blocks']['left_top']['path']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endif; ?>
            </div>
            <?php if ($this->_tpl_vars['blocks']['left_center']['path']): ?>
            <div id="left-center">
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['blocks']['left_center']['path']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['blocks']['left_bottom']['path']): ?>
            <div id="left-bottom">
               <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['blocks']['left_bottom']['path']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
            <?php endif; ?>
          </td>
          <td class="center">

            <div id="search-fields">
              <table class="grid">
                <tr>
                  <td width="25%">
                    <select name="parts" >
                      <option value="1" >asdasd</option>
                    </select>
                  </td>
                  <td width="25%">
                    <select name="parts" >
                      <option value="1">asdasd</option>
                    </select>
                  </td>
                  <td width="25%">
                    <select name="parts" >
                      <option value="1">asdasd</option>
                    </select>
                  </td>
                  <td width="25%">
                    <select name="parts" >
                      <option value="1">asdasd</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="3" width="75%"><input type="text" value="" name=""/></td>
                  <td><input type="submit" value="aha " /></td>
                </tr>
              </table>
            </div>
            <?php if ($this->_tpl_vars['blocks']['center_top']['path']): ?>
            <div class="center-top">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['blocks']['center_top']['path']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['blocks']['center_center']['path']): ?>
            <div class="center-content">
           <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['blocks']['center_center']['path']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['blocks']['center_bottom']['path']): ?>
            <div class="center-bottom">
           <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['blocks']['center_bottom']['path']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
            <?php endif; ?>
          </td>
        </tr>
      </table>
    </div>
    <div id="fotter">
      а тут типа всякие копирайты<br />
      а тут типа всякие копирайты
    </div>
  </body>
</html>