<?php get_header(); ?>

    <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'template-parts/content', 'single' ); ?>
        <?php emdotbike_theme_post_nav(); ?>

        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }
        ?>
    <?php endwhile; ?>

<?php
get_footer();
