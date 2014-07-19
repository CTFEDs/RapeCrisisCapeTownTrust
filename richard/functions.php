<?php

class RapeCrisisManager
{

  public function __construct(){
    $this->initWordpress();
  }

  private function initWordpress(){

    add_filter("attachment_fields_to_edit", array($this, "add_image_attachment_fields_to_edit"), null, 2);
    add_filter("attachment_fields_to_save", array($this, "add_image_attachment_fields_to_save"), null , 2);

  }

  function add_image_attachment_fields_to_edit($form_fields, $post) {
    $isRandom = (bool) get_post_meta($post->ID, '_randomSlider', true);

    $form_fields["credit"] = array(
      "label" => __("Show in random images on each page?"),
      'input' => 'html',
      'html' => '<label for="attachments-'.$post->ID.'-randomSlider"> '.
          '<input type="checkbox" id="attachments-'.$post->ID.'-randomSlider" name="attachments['.$post->ID.'][randomSlider]" value="1"'.($isRandom ? ' checked="checked"' : '').' /> Yes</label>  ',
      "value" => get_post_meta($post->ID, "_random", true)
    );
    return $form_fields;
  }

  function add_image_attachment_fields_to_save($post, $attachment) {

    if( isset($attachment['randomSlider']) ){
      update_post_meta($post['ID'], '_randomSlider', $attachment['randomSlider']);
    }
    return $post;
  }

  public function getRandomHeaderImageHtml(){

    $args = array(
      'post_type' => 'attachment',
      'numberposts' => 1,
      'post_status' => null,
      'meta_key' => "_randomSlider",
      'meta_value' => "1",
      'orderby' => "rand"
    );
    $randomImage = reset(get_posts( $args ));

    return wp_get_attachment_image( $randomImage->ID, "full" );

    //$shortCode = "[ngg_images gallery_id='1' source='randomSlider' order_by='rand()' display_type='photocrati-nextgen_basic_singlepic']";
    //return do_shortcode($shortCode);
  }

}

$RapeCrisisManager = new RapeCrisisManager();
