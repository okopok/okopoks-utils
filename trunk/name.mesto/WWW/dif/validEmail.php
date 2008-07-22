<?
function validEmail($email) {
if (eregi("^[a-z0-9]+([-_\.]?[a-z0-9])+@[a-z0-9]+([-_\.]?[a-z0-9])+\.[a-z]{2,4}", $email)) {
   return TRUE;
} else {
       return FALSE;
  }
}
$mail="lamo";
if (validEmail($mail)==1):
echo "ДА";
else:
echo "NO";
endif;
?>