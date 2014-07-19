<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" media="screen, handheld"/>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

	<header id="header" class="site-header clearfix" role="banner">
		<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="Rape Crisis"></a></h1>
		<h3 class="site-tagline">Giving Support. Aiding Recovery. Seeking Justice.</h3>
	</header>

	<nav>nav goes here</nav>

	<div id="main" class="site-main">