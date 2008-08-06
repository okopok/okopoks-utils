<?php /* Smarty version 2.6.14, created on 2007-11-21 14:16:37
         compiled from login.html */ ?>
<form name="loginForm" action="<?php echo @ADMIN_URL_ROOT; ?>
login/" method="post">
  <table>
    <tr><td>Логин</td>  <td><input type="text" name="adminLogin" value="">       </td></tr>
    <tr><td>Пароль</td> <td><input type="password" name="adminPassword" value=""></td></tr>
    <tr><td colspan="2"><input type="submit" value="войти"></td></tr>
  </table>
</form>