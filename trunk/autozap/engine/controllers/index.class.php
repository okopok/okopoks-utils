<?php

class controller_index implements controller_interface
{

  function run()
  {
    view_index::run();
    controller_articles::run();
    controller_articles::showPreviews();

  }

}