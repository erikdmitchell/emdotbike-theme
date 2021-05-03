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
    
    <?php get_template_part( 'template-parts/content', 'front-page' ); ?>
    
    <div class="container-fluid front-page-about-section">
        <div class="image-wrapper">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/em-cx-action-shot.jpeg" />
        </div>
        <div class="text-wrapper">
            <div class="text-inner">
                Text
            </div>
        </div>
    </div>

<?php
get_footer();
