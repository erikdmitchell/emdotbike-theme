<?php
/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */
?>
<?php get_header(); ?>

    <?php if ( have_posts() ) : ?>
        <header class="archive-header">
            <h1 class="archive-title"><?php printf( __( 'Tag Archives: %s', 'emdotbike' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>

            <?php if ( tag_description() ) : // Show an optional tag description ?>
                <div class="archive-meta"><?php echo tag_description(); ?></div>
            <?php endif; ?>
        </header><!-- .archive-header -->

        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <?php get_template_part( 'template-parts/content', get_post_format() ); ?>
        <?php endwhile; ?>

        <?php emdotbike_theme_paging_nav(); // Previous/next post navigation. ?>

    <?php else : ?>
        <?php get_template_part( 'template-parts/content', 'none' ); ?>
    <?php endif; ?>

<?php
get_footer();
