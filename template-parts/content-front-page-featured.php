<?php
/**
 * The template for displaying the featured post on the front page
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */
?>
                
<article id="post-<?php the_ID(); ?>" <?php post_class('featured-post'); ?>>
    <?php emdotbike_theme_post_thumbnail( 'landing' ); ?>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php
            $link = '...<a href="' . get_permalink( get_the_ID() ) . '">read more</a>';
            emdotnet_post_excerpt( get_the_ID(), 25, '<a><em><strong>', $link );
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
                        
</article><!-- #post-## -->