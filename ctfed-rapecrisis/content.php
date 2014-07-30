<?php
/**
 * @subpackage ctfed-rapecrisis
 *
 * @author ctfeds
 *
 * @link http://ctfeds.org/
 */
?>
<article <?php post_class(); ?>>

    <header class="entry-header">
        <h1 class="entry-title">
            <?php if (is_single()){?>
                <?php the_title(); ?>
            <?php } else { ?>
                <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
            <?php } ?>
        </h1>

        <div class="entry-meta">
            <?php
                edit_post_link('Edit');
            ?>
        </div>
    </header>

    <?php if ( is_single() ) { ?>
    <div class="entry-content">
        <?php
            the_content();
            wp_link_pages();
        ?>
    </div>
    <?php } else { ?>
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>
    <?php } ?>
    <footer class="entry-meta"></footer>

</article>
