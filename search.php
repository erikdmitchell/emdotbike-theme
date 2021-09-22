<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */

?>
<?php get_header(); ?>

    <?php if ( have_posts() ) : ?>
        <header class="page-header">
            <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'emdotbike' ), get_search_query() ); ?></h1>
        </header><!-- .page-header -->

        <div class="search-results-posts">
            <?php
            while ( have_posts() ) :
                the_post();
                ?>
                <?php get_template_part( 'template-parts/content', 'search' ); ?>
            <?php endwhile; ?>
        </div>

        <?php emdotbike_theme_paging_nav(); // Previous/next post navigation. ?>

    <?php else : ?>
        <?php get_template_part( 'template-parts/content', 'none' ); ?>
    <?php endif; ?>

<?php
get_footer();
