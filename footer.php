<?php
/**
 * The footer
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */

?>
        <footer>
            <div class="footer-widgets">
                <?php dynamic_sidebar( 'footer-1' ); ?>                
                <?php dynamic_sidebar( 'footer-2' ); ?>
                <?php dynamic_sidebar( 'footer-3' ); ?>
            </div>
            <div class="copyright"><?php echo get_bloginfo( 'name' ); ?> &copy; <?php echo gmdate( 'Y' ); ?></div>
        </footer>

        <?php wp_footer(); ?>
    </body>
</html>
