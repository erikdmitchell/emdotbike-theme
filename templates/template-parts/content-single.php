<?php
/**
 * The template for displaying single posts
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>  
    <?php if ( ! emdb_has_header_block() ) : ?>
        <?php get_template_part( 'template-parts/legacy', 'content-post-header' ); ?>
    <?php endif; ?>
         
    <div class="entry-content">
        <?php
            the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'emdotbike' ) );
            wp_link_pages(
                array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Posts:', 'emdotbike' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                )
            );
            ?>
    </div><!-- .entry-content -->

    <div class="entry-meta">
        <?php if ( has_tag() ) : ?>
            <div class="tags-list">
                <div class="tags-title">Tags</div>
                
                <?php the_tags( '<div class="tag-links">', ' ', '</div>' ); ?>
            </div>
        <?php endif; ?>
        <?php if ( emdotbike_has_categories( 'Uncategorized' ) ) : ?>
            <div class="categories-list">
                <div class="categories-title">Categories</div>
            
                <div class="categories-link">
                    <?php emdotbike_post_categories( ' ', 1 ); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
               
</article><!-- #post-## -->