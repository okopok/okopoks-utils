<?php
class view_parts implements view_interface
{
  function run()
  {

  }
  function brandParts($data)
  {
    Base::print_ar($data);
  }
  function modelParts($data)
  {
    Base::print_ar($data);
  }

  function allParts($data)
  {
    Base::print_ar($data);
  }
}
?>