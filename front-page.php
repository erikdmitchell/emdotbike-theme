<?php
/**
 * Template Name: Front Page
 **/
?>
<?php get_header(); ?>

    <div class="front-page-tagline">
        <div class="wrapper">
            <div class="image-wrap">
                <img src="<?php the_field( 'tagline_image' ); ?>" alt="emdotbike logo white" />
            </div>
            <div class="title-wrap">
                <h1><?php the_field( 'tagline_text' ); ?></h1>
            </div>
        </div>
    </div>
    
    <?php get_template_part( 'template-parts/content', 'home-grid' ); ?>
    
    <?php // get_template_part( 'template-parts/content', 'front-page' ); ?>
    
    <div class="front-page-about">
        <div class="image-wrap" style="background: url(<?php the_field( 'about_image' ); ?>) no-repeat center center;"></div>
        <div class="about-text-wrap"><?php the_field( 'about_text' ); ?></div>
    </div>

<?php
get_footer();
