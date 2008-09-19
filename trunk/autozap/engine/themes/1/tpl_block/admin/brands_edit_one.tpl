{literal}
<script type="text/javascript" src="/js/tiny_mce/tiny_mce_gzip.js"></script>
<script type="text/javascript">
tinyMCE_GZ.init({
	plugins : "safari,pagebreak,style,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
	themes : 'advanced',
	languages : 'en',
	disk_cache : true,
	debug : false
});
</script>
<script language="javascript" type="text/javascript" src="/js/tiny_mce/tiny_mce.js"> </script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	plugins : "safari,pagebreak,style,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",

	// Theme options
	theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	content_css : "/css/1/editor.css"
});
</script>
{/literal}

<form method="post" enctype="multipart/form-data">
  <input type="hidden" name="mode" value="edit" />
  <input type="hidden" name="field_brand_old_name" value="{$brands.brands_name}">
  NAME: <input type="text" name="field_brand_name" value="{$brands.brands_name}"><br />
  IMG:
  <input type="file" name="field_brand_img" /><br />
  {if $brandsImg.medium}
    
    <table>
    <tr>
        <th>удалить</th><th>средняя</th><th>маленькая</th>
    </tr>
    <tr align="center">
        <td><input type="checkbox" name="field_brand_del_img" value="1"></td>
        <td><img src="{$brandsImg.medium}" /></td
        <td><img src="{$brandsImg.small}" /></td>
    </tr>
    </table>

  {/if}
<br />

  INFO:<textarea name="field_brand_info">{$brands.brands_info}</textarea><br />
<br />

  <input type="submit" value="EDIT">
</form>
<form method="post" enctype="multipart/form-data" onsubmit="if(!confirm('уверен?!') return false;">
  <input type="hidden" name="mode" value="delete">
  <input type="submit" value="DELETE">
</form>