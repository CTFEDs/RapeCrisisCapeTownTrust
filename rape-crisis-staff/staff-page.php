<?php
/*
Template Name: Staff
*/
?>
<?php get_header(); ?>

		<div role="main" class="staff-container">
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php //get_template_part('content'); ?>
				<ul class="list_profiles">
				<?php if(get_field('add_staff_details')): ?>
				<?php while(has_sub_field('add_staff_details')): ?>
					<li>
						<figure class="staff-profile">
				   			<img src="<?php the_sub_field('image'); ?>" alt="<?php the_sub_field('name'); ?>">
				   		</figure>
			   			<div class="staff-details">
			   				<h4><?php the_sub_field('name'); ?></h4>
			   				<p><?php the_sub_field('position'); ?></p>
			   				<p><?php the_sub_field('email'); ?></p>
			   			</div>
				   	</li>
				<?php endwhile; ?>
				<?php endif; ?>
				</ul>

			<?php endwhile; ?>
		</div>
<?php get_footer(); ?>
