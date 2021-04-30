<?php
/**
 * Template Name: Front Page
 **/
?>
<?php get_header(); ?>
<?php $query_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; ?>

    <?php
    if ( 1 === $query_page ) :
        get_template_part( 'template-parts/content', 'front-page' );
    else :
        get_template_part( 'template-parts/content', 'posts' );
    endif;
    ?>

<?php
get_footer();
