<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>

    <h2 class="comments-title">
        <?php
        if ( 1 === (int) get_comments_number() ) {
            printf(
                /* translators: %s: post title. */
                esc_html__( 'One thought on &ldquo;%s&rdquo;', 'emdotbike' ),
                esc_html( get_the_title() )
            );
        } else {
            printf(
                /* translators: 1: number of comments, 2: post title. */
                esc_html( _n( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'emdotbike' ) ),
                esc_html( number_format_i18n( get_comments_number() ) ),
                esc_html( get_the_title() )
            );
        }
        ?>
    </h2>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
    <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
        <h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'emdotbike' ); ?></h1>
        <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'emdotbike' ) ); ?></div>
        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'emdotbike' ) ); ?></div>
    </nav><!-- #comment-nav-above -->
    <?php endif; // Check for comment navigation. ?>

    <ol class="comment-list">
        <?php
            wp_list_comments(
                array(
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 34,
                )
            );
        ?>
    </ol><!-- .comment-list -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
    <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
        <h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'emdotbike' ); ?></h1>
        <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'emdotbike' ) ); ?></div>
        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'emdotbike' ) ); ?></div>
    </nav><!-- #comment-nav-below -->
    <?php endif; // Check for comment navigation. ?>

        <?php if ( ! comments_open() ) : ?>
    <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'emdotbike' ); ?></p>
    <?php endif; ?>

    <?php endif; // End have_comments check. ?>

    <?php comment_form(); ?>

</div><!-- #comments -->
