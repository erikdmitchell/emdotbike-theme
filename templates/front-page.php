<?php
/**
 * Template Name: Front Page
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */

?>
<?php get_header(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'main-content' ); ?>>

    <div class="entry-content">
        <?php
            the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'emdotbike' ) );
            wp_link_pages(
                array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'emdotbike' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                )
            );
            ?>
    </div><!-- .entry-content -->

</article>

<?php
get_footer();
