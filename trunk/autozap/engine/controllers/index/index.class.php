<?php

class controller_index implements controller_interface
{

  function run()
  {
    view_index::run();
    controller_public_articles::run();
    controller_public_articles::showPreviews();

  }

}