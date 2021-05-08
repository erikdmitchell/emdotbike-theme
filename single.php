<?php
/**
 * The template for displaying single pages
 *
 * @package WordPress
 * @subpackage emwptheme
 * @since emwptheme 0.1.0
 */

?>

<?php get_header(); ?>

    <?php
    while ( have_posts() ) :
        the_post();
        ?>
        <?php get_template_part( 'template-parts/content', 'single' ); ?>
        
        <div class="grid-wrapper">
            <div class="grid-row">
                <?php emdotbike_theme_post_nav(); ?>
            </div>
        </div>

        <div class="grid-wrapper">
            <div class="grid-row">
                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) {
                    comments_template();
                }
                ?>
            </div>
        </div>
    <?php endwhile; ?>

<?php
get_footer();
