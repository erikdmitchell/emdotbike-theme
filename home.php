<?php
/**
 * Blog page
 **/
?>

<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
    <div class="blog-page-posts grid-wrapper">
        <div class="grid-cols">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <div class="grid-col-6">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="entry-thumb">
                    <?php emdotbike_theme_post_thumbnail(); ?>
                    </div>
                    
                    <header class="entry-header">
                        <?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); ?>
                    </header><!-- .entry-header -->
                    
                    <div class="entry-excerpt">
                        <div class="excerpt"><?php emdotbike_post_excerpt( $post, 55, '', ' <a href="' . get_permalink() . '">read more...</a>' ); ?></div>
                    </div>
                </article>
            </div>
        <?php endwhile; ?>
        </div>
    </div>
    
    <!-- // Previous/next post navigation. NEEDS TO BE ADDED -->
    
<?php endif; ?>

<?php
get_footer();
