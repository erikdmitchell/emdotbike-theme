<?php
/**
 * The template for a page
 *
 * @package WordPress
 * @subpackage emwptheme
 * @since emwptheme 0.1.0
 */

?>

<?php get_header(); ?>
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <div class="entry-content">
                    
                    <header class="entry-header">
                        <?php
                        if ( is_single() ) :
                            the_title( '<h1 class="entry-title">', '</h1>' );
                        else :
                            the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
                        endif;
                        ?>
                    </header>
                    
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

            </article><!-- #post-## -->

        <?php endwhile; else : ?>
            <p><?php esc_html_e( 'Sorry, this page does not exist.', 'emdotbike' ); ?></p>
    <?php endif; ?>
        
<?php
get_footer();
