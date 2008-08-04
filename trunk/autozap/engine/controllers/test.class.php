<?php
class controller_test implements controller_interface
{
  function run()
  {
    print_r(func_get_args());
    print func_num_args();
  }
}

?>