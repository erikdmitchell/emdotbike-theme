<?php
/**
 * The template for displaying Archive pages
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

    <header class="archive-header">
        <h1 class="archive-title page-title">
            <?php
            if ( is_day() ) :
                printf( __( 'Daily Archives: %s', 'emdotbike' ), get_the_date() );
                elseif ( is_month() ) :
                    printf( __( 'Monthly Archives: %s', 'emdotbike' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'emdotbike' ) ) );
                elseif ( is_year() ) :
                    printf( __( 'Yearly Archives: %s', 'emdotbike' ), get_the_date( _x( 'Y', 'yearly archives date format', 'emdotbike' ) ) );
                else :
                    _e( 'Archives', 'emdotbike' );
                endif;
                ?>
        </h1>
    </header>


        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                ?>
                <?php get_template_part( 'template-parts/content' ); ?>
            <?php endwhile; ?>

            <?php // emdotbike_theme_paging_nav(); // Previous/next post navigation. ?>
            <?php // emdotbike_theme_post_nav(); ?>

    <?php else : ?>
        <?php get_template_part( 'template-parts/content', 'none' ); ?>
    <?php endif; ?>
            

<?php
get_footer();
