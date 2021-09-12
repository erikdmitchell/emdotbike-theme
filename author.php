<?php
/**
 * Author posts page
 **/
?>

<?php get_header(); ?>

<div class="author-header">
    <?php emdb_author_header(); ?>
</div>

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
    
    <!-- // Previous/next post navigation. NEEDS TO BE ADDED --> 
<?php endif; ?>

<?php
get_footer();
