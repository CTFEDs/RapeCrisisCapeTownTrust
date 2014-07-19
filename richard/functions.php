<?php

class RapeCrisisManager
{

  public function __construct(){
    $this->initWordpress();
  }

  private function initWordpress(){
    // nothing for now
  }

  public function getRandomHeaderImageHtml(){
    $shortCode = "[ngg_images gallery_id='1' source='random' order_by='rand()' display_type='photocrati-nextgen_basic_singlepic']";
    return do_shortcode($shortCode);
  }

}

