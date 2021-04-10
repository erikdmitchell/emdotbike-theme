<?php
/**
 * The template for displaying content on the front page
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */
?>

<?php
$featured_blog_query = new WP_Query(
    array(
        'posts_per_page' => 1,
    )
);

$blog_query = new WP_Query(
    array(
        'posts_per_page' => 6,
        'offset' => 1,
    )
);
?>
    
<div class="container front-page-posts posts-wrapper">
    <?php if ( $featured_blog_query->have_posts() ) : ?>
        <div class="row">
            <?php while ( $featured_blog_query->have_posts() ) : $featured_blog_query->the_post(); ?>
                <div class="col-12">
                    <?php get_template_part( 'template-parts/content', 'front-page-featured' ); ?>
                </div>          
            <?php endwhile; ?>
        </div>    
    <?php endif; ?>
    
    <?php if ( $blog_query->have_posts() ) : ?>
        <div class="row">
            <?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
                <div class="col-12 col-md-6">
                    <?php get_template_part( 'template-parts/content', 'front-page-post' ); ?>
                </div>          
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="nav-previous alignleft"><?php next_posts_link( 'Older posts', $blog_query->max_num_pages ); ?></div>
    </div>
</div>