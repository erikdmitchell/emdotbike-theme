<?php
/**
 * Template Name: Front Page
 **/
?>
<?php get_header(); ?>

    <div class="front-page-tagline">
        <div class="wrapper">
            <div class="image-wrap">
                <?php //echo the_field('tagline_image'); ?>
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/em-bike-logo-small-white.png" alt="emdotbikelogo white" />
            </div>
            <div class="title-wrap">
                <h1><?php the_field('tagline_text'); ?></h1>
            </div>
        </div>
    </div>
    
    <?php get_template_part( 'template-parts/content', 'home-grid' ); ?>
    
    <?php // get_template_part( 'template-parts/content', 'front-page' ); ?>
    
    <div class="front-page-about">
        <div class="image-wrap"></div>
        <?php //the_field('about_image'); ?>
        <div class="about-text-wrap"><?php the_field('about_text'); ?></div>
    </div>

<?php
get_footer();
