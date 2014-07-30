<?php
/**
 * @subpackage ctfed-rapecrisis
 *
 * @author ctfeds
 *
 * @link http://ctfeds.org/
 */
?><!DOCTYPE html>
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
    <![endif]-->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="page" class="hfeed site">

        <header role="banner">
            <h1 class="site-title">
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php echo bloginfo('name'); ?></a>
            </h1>
            <p class="tagline"><?php echo bloginfo('description'); ?></p>
            <a href="#nav">Menu</a>
        </header>

        <div id="main" class="site-main">
