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
            <div class="top-menu-button"><a href="/repare/" {if $controller_action=='repare'}class="active"{/if}>Ремонт</a></div>
            <div class="top-menu-button"><a href="/parts/" {if $controller_action=='parts'}class="active"{/if}>Запчасти</a></div>
            <div class="top-menu-button"><a href="/articles/kontakty-2/" {if $controller_action=='articles' and $controller_action_id=='2'}class="active"{/if}>Контакты</a></div>
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
              <div class="left-menu-button"><img src="/img/1/dis.pack.png" align="absmiddle" /> <a href="/parts/" {if $controller_action=='parts'}class="active"{/if}>Запчасти</a></div>
              <div class="left-menu-button"><img src="/img/1/dis.tools.png" align="absmiddle" /> <a href="/repare/" {if $controller_action=='repare'}class="active"{/if}>Ремонт</a></div>
              {if $blocks.left_top.path}    {include file="`$blocks.left_top.path`"}{/if}
            </div>
            {if $blocks.left_center.path}
            <div id="left-center">
               {include file="`$blocks.left_center.path`"}
            </div>
            {/if}
            {if $blocks.left_bottom.path}
            <div id="left-bottom">
               {include file="`$blocks.left_bottom.path`"}
            </div>
            {/if}
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
            {if $blocks.center_top.path}
            <div class="center-top">
            {include file="`$blocks.center_top.path`"}
            </div>
            {/if}
            {if $blocks.center_center.path}
            <div class="center-content">
           {include file="`$blocks.center_center.path`"}
            </div>
            {/if}
            {if $blocks.center_bottom.path}
            <div class="center-bottom">
           {include file="`$blocks.center_bottom.path`"}
            </div>
            {/if}
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