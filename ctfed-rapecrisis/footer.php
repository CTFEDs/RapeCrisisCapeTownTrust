<?php
/**
 * @subpackage ctfed-rapecrisis
 *
 * @author ctfeds
 *
 * @link http://ctfeds.org/
 */
?>
        </div>

        <footer role="contentinfo">
            <nav id="nav" role="navigation" class="clearfix">
                <a id="close-nav" href="#top">Close</a>
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container' => false,
                    ));
                ?>
                <a id="back-to-top" href="#top">Top</a>
            </nav>
        </footer>
    </div>
    <?php wp_footer(); ?>
</body>
</html>
