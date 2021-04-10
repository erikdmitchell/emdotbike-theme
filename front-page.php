<?php
/**
 * Template Name: Front Page
 **/
?>
<?php get_header(); ?>
    <div class="front-page-posts posts-wrapper">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <?php get_template_part( 'template-parts/content', 'front-page' ); ?>
    
        <?php endwhile; ?>
    </div>
<?php
get_footer();
