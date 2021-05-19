<?php
/**
 * Theme meta functions.
 *
 * @package WordPress
 * @subpackage emwptheme
 * @since emwptheme 0.1.0
 */

/**
 * Theme meta function.
 *
 * Adds default theme meta to header
 * Hooks directly after meta robots
 *
 * @access public
 * @return void
 */
function emdotbike_theme_meta() {

    echo apply_filters( 'emdotbike_meta_charset', '<meta charset="' . get_bloginfo( 'charset' ) . '" />' . "\n" );
    echo apply_filters( 'emdotbike_meta_http-equiv', '<meta http-equiv="X-UA-Compatible" content="IE=edge">' . "\n" );
    echo apply_filters( 'emdotbike_meta_viewport', '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n" );
    echo apply_filters( 'emdotbike_meta_description', '<meta name="description" content="' . display_meta_description() . '">' . "\n" );
    echo apply_filters( 'emdotbike_meta_author', '<meta name="author" content="">' . "\n" );

}
add_action( 'wp_head', 'emdotbike_theme_meta', 1 );

/**
 * Disable Yoast SEO meta.
 *
 * Checks for Yoast SEO and removes description meta
 * Fires on 0 so that's it's before our meta
 *
 * @access public
 * @return void
 */
function emdotbike_disable_seo_meta() {
    if ( defined( 'WPSEO_VERSION' ) ) :
        add_filter( 'emdotbike_meta_description', 'disable_emdotbike_meta_description', 10, 1 );
    endif;
}
add_action( 'wp_head', 'emdotbike_disable_seo_meta', 0 );

/**
 * disable_emdotbike_meta_description function.
 *
 * simply returns a null value so no description is output
 *
 * @access public
 * @param mixed $meta
 * @return null
 */
function disable_emdotbike_meta_description( $meta ) {
    return null;
}

