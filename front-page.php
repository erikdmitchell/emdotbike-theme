<?php
/**
 * Template Name: Front Page
 **/
?>
<?php get_header(); ?>

    <div class="front-page-tagline">
        <div class="wrapper">
            <div class="image-wrap">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/em-bike-logo-small-white.png" />
            </div>
            <div class="title-wrap">
                <h1>Training insights, race reports and general musings about the world of cycling</h1>
            </div>
        </div>
    </div>
    
    <?php get_template_part( 'template-parts/content', 'home-grid' ); ?>
    
    <?php get_template_part( 'template-parts/content', 'front-page' ); ?>

<?php
get_footer();
