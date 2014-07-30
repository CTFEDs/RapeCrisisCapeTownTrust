<?php
/**
 * @subpackage ctfed-rapecrisis
 *
 * @author ctfeds
 *
 * @link http://ctfeds.org/
 */

get_header(); ?>

    <div id="content" class="site-content" role="main">
    <?php
    if ( have_posts() ) {

        while ( have_posts() ) {

            the_post();

            get_template_part( 'content' );

        }

    } else {

        get_template_part( 'content', 'none' );

    }
    ?>
    </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
