<?php
/**
 * Template Name: Coming Soon
 **/
?>
<?php get_header( 'coming-soon' ); ?>
    <div class="cs-wrap">
        <div class="cs-inner-wrap">
            <div class="cs-logo">
                <img src="<?php echo get_template_directory_uri(); ?>/images/em-bike-logo.png" width="396px" height="263px" />
            </div>
            
            <?php
            while ( have_posts() ) :
                the_post();
                ?>
                <?php get_template_part( 'template-parts/content', 'coming-soon' ); ?>
        
            <?php endwhile; ?>
        </div>
    </div>
<?php
get_footer( 'coming-soon' );
