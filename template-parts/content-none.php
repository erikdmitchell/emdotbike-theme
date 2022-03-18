<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */

?>

<div class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php _e( 'Keep on Riding', 'emdotbike' ); ?>...</h1>
    </header><!-- .entry-header -->

    <div class="entry-content">

        <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

            <p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'emdotbike' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

        <?php elseif ( is_search() ) : ?>

            <p><?php esc_html_e( 'Try searching again...it will make you faster in the end!', 'emdotbike' ); ?></p>
            <?php get_search_form(); ?>

        <?php else : ?>

            <p><?php esc_html_e( 'Remember the days when your computer was fancy if it told you cadence?', 'emdotbike' ); ?></p> 
            <p><?php esc_html_e( 'Whether you made a wrong turn, got dropped, or bonked - you need a little help to find where you are going.', 'emdotbike' ); ?></p> 
            <p><?php esc_html_e( 'Like a wise old veteran racer, or that guy at the local gas station, try the search to get going again:', 'emdotbike' ); ?></p>
            <?php get_search_form(); ?>

        <?php endif; ?>

    </div><!-- .page-content -->
</div><!-- .not-found -->










