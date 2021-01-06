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


<?php if ( $featured_blog_query->have_posts() ) : ?>
    <?php
        while ( $featured_blog_query->have_posts() ) :
            $featured_blog_query->the_post();

            get_template_part( 'template-parts/content', 'front-page-featured' );
        
        endwhile; 
    ?>
<?php endif; ?>

<?php if ( $blog_query->have_posts() ) : ?>
    <?php
        while ( $blog_query->have_posts() ) :
            $blog_query->the_post();
            
            get_template_part( 'template-parts/content', 'front-page-post' );
                        
        endwhile; 
    ?>
<?php endif; ?>

<!--         <div class="nav-previous alignleft"><?php next_posts_link( 'Older posts', $blog_query->max_num_pages ); ?></div> -->

