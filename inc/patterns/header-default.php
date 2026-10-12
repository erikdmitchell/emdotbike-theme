<?php
/**
 * Default header block pattern
 *
 * Logo, menu toggle and the menu panel (search, latest articles, social
 * links). assets/js/emdotbike.js opens and closes the panel.
 *
 * @package EMdotBike
 */

$posts_page_id = (int) get_option( 'page_for_posts' );
$blog_url      = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );

return array(
    'title'      => __( 'Default header', 'emdotbike' ),
    'categories' => array( 'header' ),
    'blockTypes' => array( 'core/template-part/header' ),
    'content'    => '<!-- wp:group {"className":"site-header"} -->
<div class="wp-block-group site-header">
    <!-- wp:group {"className":"site-branding"} -->
    <div class="wp-block-group site-branding">
        <!-- wp:image {"width":"100px","sizeSlug":"full","linkDestination":"custom"} -->
        <figure class="wp-block-image size-full is-resized"><a href="' . esc_url( home_url( '/' ) ) . '"><img src="' . esc_url( get_template_directory_uri() . '/assets/images/em-bike-logo.png' ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" style="width:100px"/></a></figure>
        <!-- /wp:image -->
    </div>
    <!-- /wp:group -->

    <!-- wp:group {"tagName":"nav","anchor":"site-navigation","className":"main-navigation","ariaLabel":"' . esc_attr__( 'Site menu', 'emdotbike' ) . '"} -->
    <nav id="site-navigation" class="wp-block-group main-navigation" aria-label="' . esc_attr__( 'Site menu', 'emdotbike' ) . '">
        <!-- wp:group {"className":"nav-inner"} -->
        <div class="wp-block-group nav-inner">
            <!-- wp:search {"label":"' . esc_attr__( 'Search', 'emdotbike' ) . '","showLabel":false,"placeholder":"' . esc_attr__( 'Search', 'emdotbike' ) . '","width":100,"widthUnit":"%","buttonText":"' . esc_attr__( 'Search', 'emdotbike' ) . '","buttonUseIcon":true} /-->

            <!-- wp:columns -->
            <div class="wp-block-columns">
                <!-- wp:column -->
                <div class="wp-block-column">
                    <!-- wp:group {"className":"latest-posts"} -->
                    <div class="wp-block-group latest-posts">
                        <!-- wp:heading {"level":3} -->
                        <h3 class="wp-block-heading">' . esc_html__( 'Latest Articles', 'emdotbike' ) . '</h3>
                        <!-- /wp:heading -->

                        <!-- wp:latest-posts /-->
                    </div>
                    <!-- /wp:group -->

                    <!-- wp:paragraph -->
                    <p><a href="' . esc_url( $blog_url ) . '">' . esc_html__( 'More Articles', 'emdotbike' ) . '</a></p>
                    <!-- /wp:paragraph -->
                </div>
                <!-- /wp:column -->

                <!-- wp:column -->
                <div class="wp-block-column"></div>
                <!-- /wp:column -->

                <!-- wp:column -->
                <div class="wp-block-column">
                    <!-- wp:group {"className":"connect-social"} -->
                    <div class="wp-block-group connect-social">
                        <!-- wp:heading {"level":3} -->
                        <h3 class="wp-block-heading">' . esc_html__( 'Connect With Me', 'emdotbike' ) . '</h3>
                        <!-- /wp:heading -->

                        <!-- wp:social-links {"iconColor":"white","iconColorValue":"#ffffff","openInNewTab":true,"className":"is-style-logos-only"} -->
                        <ul class="wp-block-social-links has-icon-color is-style-logos-only">
                            <!-- wp:social-link {"url":"https://facebook.com/erikdmitchell","service":"facebook"} /-->
                            <!-- wp:social-link {"url":"https://twitter.com/erikdmitchell","service":"twitter"} /-->
                            <!-- wp:social-link {"url":"https://instagram.com/erikdmitchell","service":"instagram"} /-->
                        </ul>
                        <!-- /wp:social-links -->
                    </div>
                    <!-- /wp:group -->
                </div>
                <!-- /wp:column -->
            </div>
            <!-- /wp:columns -->
        </div>
        <!-- /wp:group -->
    </nav>
    <!-- /wp:group -->

    <!-- wp:html -->
    <button type="button" class="toggle-nav" aria-controls="site-navigation" aria-expanded="false" aria-label="' . esc_attr__( 'Open menu', 'emdotbike' ) . '" data-label-open="' . esc_attr__( 'Open menu', 'emdotbike' ) . '" data-label-close="' . esc_attr__( 'Close menu', 'emdotbike' ) . '"><span class="dashicons dashicons-menu-alt" aria-hidden="true"></span></button>
    <!-- /wp:html -->
</div>
<!-- /wp:group -->',
);
