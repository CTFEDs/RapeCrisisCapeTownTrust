<?php get_header(); ?>

	<div role="main" id="main">
		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part('content'); ?>
		<?php endwhile; ?>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
