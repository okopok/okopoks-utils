<?

// Validate IP Address with PHP
function validate_ip($ip){
   $return = TRUE;
   $tmp = explode(".", $ip);
   if(count($tmp) < 4):
      $return = FALSE;
     else:
      foreach($tmp AS $sub){
         if($return != FALSE){
            if(!eregi("^([0-9])", $sub)):
               $return = FALSE;
              else:
               $return = TRUE;
            endif;
         }
     }
    endif;
   return $return;
}

$ip = "123.125.35.654";
$val = validate_ip($ip);
if(!$val){
   echo "IP is not valid";
} else {
   echo "IP is valid";
}


/* Description:

Simply call
valide_ip($ip);
*/
?>
