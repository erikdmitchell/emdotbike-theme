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

<div class="page-header">
    <?php emdotbike_theme_post_thumbnail(); ?>

    <header class="entry-header">
        <?php
        if ( is_single() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
        endif;
        ?>
    </header><!-- .entry-header -->
    </div>
</div>

<?php
if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if ( is_search() ) : ?>
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
        <?php else : ?>
        <div class="entry-content">
            <?php
                the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'wpbootstrap' ) );
                wp_link_pages(
                    array(
                        'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'wpbootstrap' ) . '</span>',
                        'after'       => '</div>',
                        'link_before' => '<span>',
                        'link_after'  => '</span>',
                    )
                );
            ?>
        </div><!-- .entry-content -->
        <?php endif; ?>

                        <?php the_tags( '<footer class="entry-meta"><span class="tag-links">', '', '</span></footer>' ); ?>
    </article><!-- #post-## -->
    <!-- // Previous/next post navigation. NEEDS TO BE ADDED -->
                <?php endwhile; else : ?>
    <p><?php _e( 'Sorry, this page does not exist.', 'emdotbike' ); ?></p>
<?php endif; ?>
        

<?php
get_footer();
