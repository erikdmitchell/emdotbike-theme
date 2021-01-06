<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search. -- Currently page.php and index.php
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php emdotbike_theme_post_thumbnail(); ?>
    <header class="entry-header">
        <?php
        if ( is_single() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
        endif;
        ?>

        <div class="entry-meta">
            <?php
            if ( 'post' == get_post_type() ) {
                emdotbike_theme_posted_on();
            }

            if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
                ?>
                    <span class="comments-link"></span><?php comments_popup_link( __( 'Leave a comment', 'emdotbike' ), __( '1 Comment', 'emdotbike' ), __( '% Comments', 'emdotbike' ) ); ?></span>
                <?php
                endif;

                edit_post_link( __( 'Edit', 'emdotbike' ), '<span class="edit-link">', '</span>' );
            ?>
        </div><!-- .entry-meta -->
    </header><!-- .entry-header -->

    <?php if ( is_search() ) : ?>
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div><!-- .entry-summary -->
    <?php else : ?>
    <div class="entry-content">
        <?php
            the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'emdotbike' ) );
            wp_link_pages(
                array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'emdotbike' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                )
            );
        ?>
    </div><!-- .entry-content -->
    <?php endif; ?>

    <div class="entry-meta">
        <?php if ( has_tag() ) : ?>
            <div class="tags-list">
                <div class="tags-title">Tags</div>
                
                <?php the_tags( '<div class="tag-links">', ' ', '</div>' ); ?>
            </div>
        <?php endif; ?>
        <?php if ( emdotbike_has_categories() ) : ?>
            <div class="categories-list">
                <div class="categories-title">Categories</div>
            
                <div class="categories-link">
                    <?php emdotbike_post_categories( ' ', 1 ); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
                        
</article><!-- #post-## -->
