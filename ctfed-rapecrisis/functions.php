<?php

/**
 * @subpackage ctfed-rapecrisis
 *
 * @author ctfeds
 *
 * @link http://ctfeds.org/
 */

define('CTFEDS_RAPECRISIS_VERSION', '1.0.0');

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


/**
 * Enqueue the theme's scripts
 *
 * @since 1.0.0
 *
 * @uses wp_enqueue_script
 * @uses get_template_directory_uri
 *
 * @return void
 */
function ctfed_rapecrisis_enqueue_scripts(){

    wp_enqueue_script('rapecrisis-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), CTFEDS_RAPECRISIS_VERSION, true);

}
// add_action('wp_enqueue_scripts', 'ctfed_rapecrisis_enqueue_scripts');


/**
 * Enqueue the theme's stylesheet
 *
 * @since 1.0.0
 *
 * @uses wp_enqueue_style
 * @uses get_stylesheet_directory_uri
 *
 * @return void
 */
function ctfed_rapecrisis_enqueue_styles(){

    wp_enqueue_style('rapecrisis-styles', get_stylesheet_directory_uri() . '/assets/css/style.css', false, CTFEDS_RAPECRISIS_VERSION, 'all');

}
// add_action('wp_enqueue_scripts', 'ctfed_rapecrisis_enqueue_styles');
