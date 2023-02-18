<?php
/**
 * Template Name: Front Page
 **/
?>
<?php get_header(); ?>

    <div class="front-page-tagline">
        <div class="wrapper">
            <div class="image-wrap">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/em-bike-logo-small-white.png" alt="emdotbike logo white" />
            </div>
            <div class="title-wrap">
                <h1>TRAINING TIPS, INSIGHTS AND GENERAL MUSINGS ABOUT THE WORLD OF CYCLING</h1>
            </div>
        </div>
    </div>

    <div class="entry-content">
        <?php get_template_part( 'template-parts/content', 'magazine-grid' ); ?>
    </div>
    
    <?php the_content(); ?>

<?php
get_footer();
