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
            <?php dynamic_sidebar( 'emdb-footer-sidebar' ); ?>
            <div class="copyright"><?php echo get_bloginfo( 'name' ); ?> &copy; <?php echo gmdate( 'Y' ); ?></div>
        </footer>

        <?php wp_footer(); ?>
    </body>
</html>
