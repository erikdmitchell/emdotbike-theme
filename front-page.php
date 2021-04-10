<?php
/**
 * Template Name: Front Page
 **/
?>
<?php get_header(); ?>
    <div class="container front-page-posts posts-wrapper">
        <?php get_template_part( 'template-parts/content', 'front-page' ); ?>
    </div>
<?php
get_footer();
