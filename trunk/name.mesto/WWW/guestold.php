<?
$title="Наша гостевая!";

require("start_page.php");
require('gb/func.php');
?>

<table width="100%">
<tr>
<td class="GTForms" align="right">
<a href="javascript:void(0)"ONCLICK="open('gbook.php','miniwin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=1,width=450,height=270')"><b>добавить сообщение</b></a>
</td>
</tr>
</table>

<?
gb_show($page);
gb_showpages($page);
require("end_page.php");
?>
