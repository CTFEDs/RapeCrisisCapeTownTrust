<?php

/**
 * @subpackage ctfed-rapecrisis
 *
 * @author ctfeds
 *
 * @link http://ctfeds.org/
 */


/**
 * Set up theme defaults and registers support for various WordPress features.
 *
 * @since 1.0.0
 *
 * @uses add_theme_support
 * @uses register_nav_menus
 * @uses __
 * @uses add_theme_support
 *
 * @return void
 */
function ctfed_rapecrisis_setup() {

    /**
     * Ensure that the theme supports post thumbnails
     */
    add_theme_support('post-thumbnails');

    /**
     * Register menu locations
     */
    register_nav_menus(array('primary' => __('Primary navigation', 'ctfed-rapecrisis'),));

    /*
     * Switch default core markup for search form to output valid HTML5.
    */
    add_theme_support('html5', array('search-form', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'ctfed_rapecrisis_setup');
