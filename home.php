<?php
/**
 * Blog posts page
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */

?>

<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
    <div class="blog-page-posts">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
                        
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-thumb">
                <?php emdotbike_theme_post_thumbnail( 'home-grid-large' ); ?>
                </div>
                
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); ?>
                </header><!-- .entry-header -->
                
                <div class="entry-excerpt">
                    <div class="excerpt"><?php emdotbike_post_excerpt( $post, 55, '', ' <a href="' . get_permalink() . '">read more...</a>' ); ?></div>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
    
    <?php emdotbike_theme_paging_nav(); // Previous/next post navigation. ?>
    
<?php endif; ?>

<?php
get_footer();
