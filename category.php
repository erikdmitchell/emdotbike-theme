<?php
/**
 * The template for displaying Category pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */

?>
<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
    <header class="archive-header">
        <h1 class="archive-title"><?php single_cat_title( __( 'Articles related to: ', 'emdotbike' ) ); ?></h1>
    </header><!-- .archive-header -->

    <div class="page-posts-grid">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <?php get_template_part( 'template-parts/content', 'grid' ); ?>
        <?php endwhile; ?>
    </div>
    
    <?php emdotbike_theme_paging_nav(); // Previous/next post navigation. ?>

<?php else : ?>
    <?php get_template_part( 'template-parts/content', 'none' ); ?>
<?php endif; ?>

<?php
get_footer();
