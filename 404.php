<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */
 
?>
<?php get_header(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header">
        <h1 class="page-title"><?php _esc_html_e( 'Not Found', 'emdotbike' ); ?></h1>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <h2><?php _esc_html_e( "This is somewhat embarrassing, isn't it?", 'emdotbike' ); ?></h2>
        <p><?php _esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'emdotbike' ); ?></p>

        <?php get_search_form(); ?>
    </div><!-- .entry-content -->

</article><!-- #post-## -->

<?php
get_footer();
