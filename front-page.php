<?php
/**
 * Template Name: Front Page
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */

?>
<?php get_header(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'main-content' ); ?>>

    <div class="entry-content">
        <?php get_template_part('template-parts/content', 'front-page') ?>
    </div><!-- .entry-content -->

</article>

<?php
get_footer();
