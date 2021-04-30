<?php get_header(); ?>

    <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'template-parts/content', 'single' ); ?>
        
        <div class="container">
            <?php emdotbike_theme_post_nav(); ?>
        </div>

        <div class="container">
            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
                comments_template();
            }
            ?>
        </div>
    <?php endwhile; ?>

<?php
get_footer();
