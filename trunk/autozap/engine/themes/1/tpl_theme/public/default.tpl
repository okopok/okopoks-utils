<!--DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" >
<html>
  <head>
    <title>{if $title}{$title} - {/if}Заголовок</title>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
    {literal}

    <style>
     body
     {
       font-size: 14px;
       font-family: tahoma, arial, verdana;
     }

     #table_borders .td{
       font-size: 14px;
       border: 1px solid #cccccc;
     }
     .brand_div
     {
        background-color: #333333;
        font-size: 25px;
        font-weight:bold;

        color: #ffffff;
        width:99%;
     }
     .brand_div td { padding:10px; }
     .fl{float:left;}
     .brand_div a{color: #ffffff;}
     .model_div
     {
       background-color: #cccccc;
       font-size: 18px;
       font-weight:bold;
       padding:5px;
       padding-left:30px;
       color: #333333;
       border-top: 2px solid #333333;
       border-bottom: 2px solid #333333;
       width:99%;
     }
     .model_div td { padding:5px; padding-left:30px; }
     .model_div a{color: #333333; }
     a:hover {color:red;}


     .th
     {
        font-weight:bold;
        text-align:center;
        border-bottom: 1px solid #333333;
     }

     .td          { height: 20px; }
     .th .td      { background-color: #eeeeee;  }
     .tr_even .td { background-color: #ffffff; }
     .tr_odd .td  { background-color: #eeeeee; }

    </style>
    {/literal}
  </head>
  <body>

    <h3>Это index template</h3>

    <div class="fl" style=" width:10%; border: 1px solid #cccccc; border-right:0px;padding: 10px;">
      <ul>
        <li><a href="/">Главная</a></li>
        <li><a href="/repare/">починка</a></li>
        <li><a href="/parts/">Запчасти</a></li>
        <li><a href="/waiting/">Ожидаем</a></li>
        <li><a href="/articles/">Статьи</a></li>
      </ul>
      {if $blocks.left_top.path}    {include file="`$blocks.left_top.path`"}{/if}
      {if $blocks.left_center.path} {include file="`$blocks.left_center.path`"}{/if}
      {if $blocks.left_bottom.path} {include file="`$blocks.left_bottom.path`"}{/if}
    </div>
    <div class="fl" style=" width:75%; border: 1px solid #cccccc; border-bottom:0px;padding: 10px; min-height:500px;">
      {if $blocks.center_top.path}    {include file="`$blocks.center_top.path`"}{/if}
      {if $blocks.center_center.path} {include file="`$blocks.center_center.path`"}{/if}
      {if $blocks.center_bottom.path} {include file="`$blocks.center_bottom.path`"}{/if}
    </div>
    <div style="float:left; width:10%; border: 1px solid #cccccc; border-left:0px;padding: 10px;">
      {if $blocks.right_top.path}   {include file="`$blocks.right_top.path`"}{/if}
      {if $blocks.right_center.path}{include file="`$blocks.right_center.path`"}{/if}
      {if $blocks.right_bottom.path}{include file="`$blocks.right_bottom.path`"}{/if}
    </div>
    <br style="clear:both;" />
    <div style="border:1px solid #cccccc; width:99%;">
      <a href="/articles/kontakty-2/">Контакты</a>
    </div>

  </body>
</html>
