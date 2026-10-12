<?php
/**
 * Theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */

// define some vars.
$theme = wp_get_theme();
define( 'EMDOTBIKE_VERSION', $theme->version );

// Check GitHub releases for theme updates.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';

    $emdotbike_update_checker = YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
        'https://github.com/erikdmitchell/emdotbike-theme/',
        __FILE__,
        'emdotbike'
    );
    // Install the emdotbike.zip attached to each release, not GitHub's source zipball.
    // getVcsApi() is typed as the base Api, but for a GitHub repo it's the GitHubApi.
    /* @phpstan-ignore method.notFound */
    $emdotbike_update_checker->getVcsApi()->enableReleaseAssets();
}

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since emdotbike 0.1.0
 */
if ( ! isset( $content_width ) ) {
    $content_width = 1200;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since emdotbike 0.1.0
 * @return void
 */
function emdotbike_theme_setup() {
    /**
     * Add our theme support options
     */
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );

    /**
     * Add our image size(s).
     */
    add_image_size( 'single', 9999, 480, true );
    add_image_size( 'home-grid', 650, 300, true );
    add_image_size( 'home-grid-featured', 9999, 550, true );
    add_image_size( 'home-grid-tall', 650, 760, true );
    add_image_size( 'posts-grid', 650, 375, true );
}
add_action( 'after_setup_theme', 'emdotbike_theme_setup' );

/**
 * Enqueue scripts and styles.
 *
 * @since emdotbike 0.1.0
 * @return void
 */
function emdotbike_theme_scripts() {
    wp_enqueue_script( 'emdotbike-theme-script', get_template_directory_uri() . '/assets/js/emdotbike.js', array(), EMDOTBIKE_VERSION, true );

    if ( is_singular() ) :
        wp_enqueue_script( 'comment-reply' );
    endif;

    wp_enqueue_style( 'dashicons' );
    wp_enqueue_style( 'emdotbike-theme-style', get_stylesheet_uri(), array(), EMDOTBIKE_VERSION );
}
add_action( 'wp_enqueue_scripts', 'emdotbike_theme_scripts' );

/**
 * Custom post thumbnail.
 *
 * @access public
 * @param WP_Post|int|string $post (default: '').
 * @param string             $size (default: 'full').
 * @param bool               $link (default: true).
 * @return void
 */
function emdotbike_theme_post_thumbnail_custom( $post = '', $size = 'full', $link = true ) {
    echo wp_kses_post( emdotbike_theme_get_post_thumbnail_custom( $post, $size, $link ) );
}

/**
 * Get custom post thumbnail.
 *
 * @access public
 * @param WP_Post|int|string $post (default: '').
 * @param string             $size (default: 'full').
 * @param bool               $link (default: true).
 * @return string
 */
function emdotbike_theme_get_post_thumbnail_custom( $post = '', $size = 'full', $link = true ) {
    if ( is_int( $post ) ) {
        // get the post object of the passed ID.
        $post = get_post( $post );
    }

    if ( ! $post instanceof WP_Post ) {
        return '';
    }

    $html = null;

    $image_id   = get_post_thumbnail_id( $post->ID );
    $image_src  = wp_get_attachment_image_url( $image_id, $size );
    $image_meta = wp_get_attachment_metadata( $image_id );
    $image_base = '<img src="' . $image_src . '" class="img-responsive" />';
    $image      = wp_image_add_srcset_and_sizes( $image_base, $image_meta, $image_id );

    if ( post_password_required( $post ) || ! has_post_thumbnail( $post ) ) {
        return '';
    }

    if ( $link ) :
        $html     .= '<a class="post-thumbnail" href="' . get_permalink( $post->ID ) . '">';
            $html .= $image;
        $html     .= '</a>';
    else :
        $html     .= '<div class="post-thumbnail">';
            $html .= $image;
        $html     .= '</div>';
    endif;

    $image = apply_filters( 'emdotbike_theme_post_thumbnail_custom', $html, $size, $image );

    return $image;
}

/**
 * Back to top function.
 *
 * @access public
 * @return void
 */
function emdotbike_back_to_top() {
    $html = null;

    $html .= '<a href="#0" class="emdotbike-back-to-top"></a>';

    echo wp_kses_post( $html );
}
add_action( 'wp_footer', 'emdotbike_back_to_top' );

/**
 * Gets the excerpt of a specific post ID or object.
 *
 * @access public
 * @param mixed  $post object.
 * @param int    $length (default: 10).
 * @param string $tags (default: '<a><em><strong>').
 * @param string $extra (default: ' . . .').
 * @return string
 */
function emdotbike_get_post_excerpt_by_id( $post, $length = 10, $tags = '<a><em><strong>', $extra = ' . . .' ) {
    if ( is_int( $post ) ) {
        // get the post object of the passed ID.
        $post = get_post( $post );
    }

    if ( ! $post instanceof WP_Post ) {
        return '';
    }

    if ( has_excerpt( $post->ID ) ) {
        $the_excerpt = $post->post_excerpt;
        return apply_filters( 'the_content', $the_excerpt );
    } else {
        $the_excerpt = $post->post_content;
    }

    $the_excerpt   = strip_shortcodes( wp_strip_all_tags( $the_excerpt ) );
    $the_excerpt   = preg_split( '/\b/', $the_excerpt, $length * 2 + 1 );
    $excerpt_waste = array_pop( $the_excerpt );
    $the_excerpt   = implode( $the_excerpt );
    $the_excerpt  .= $extra;

    return apply_filters( 'emdotbike_get_post_excerpt_by_id', $the_excerpt );
}

/**
 * Display post excerpt.
 *
 * @access public
 * @param mixed  $post Post ID or object.
 * @param int    $length (default: 10).
 * @param string $tags (default: '<a><em><strong>').
 * @param string $extra (default: ' . . .').
 * @return void
 */
function emdotbike_post_excerpt( $post, $length = 10, $tags = '<a><em><strong>', $extra = ' . . .' ) {
    echo wp_kses_post( emdotbike_get_post_excerpt_by_id( $post, $length, $tags, $extra ) );
}

/**
 * Custom read more excerpt.
 *
 * @access public
 * @param string $more The default "more" string (unused).
 * @return string
 */
function emdotbike_custom_excerpt_more( $more ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found -- excerpt_more filter signature.
    return sprintf(
        '... <a href="%1$s" class="more-link">%2$s</a>',
        esc_url( get_permalink( get_the_ID() ) ),
        /* translators: %s: post title, visible to screen readers only. */
        sprintf( __( 'read more %s', 'emdotbike' ), '<span class="screen-reader-text">' . esc_html( get_the_title( get_the_ID() ) ) . '</span>' )
    );
}
add_filter( 'excerpt_more', 'emdotbike_custom_excerpt_more' );

/**
 * Login page scripts and styles.
 *
 * @access public
 * @return void
 */
function emdotbike_login_scripts_styles() {
    wp_enqueue_style( 'emdotbike-login-style', get_template_directory_uri() . '/assets/css/login.css', array(), EMDOTBIKE_VERSION );
}
add_action( 'login_enqueue_scripts', 'emdotbike_login_scripts_styles' );

/**
 * Login header URL.
 *
 * @access public
 * @return string
 */
function emdotbike_login_headerurl() {
    return home_url();
}
add_filter( 'login_headerurl', 'emdotbike_login_headerurl' );

require get_template_directory() . '/inc/block-patterns.php';

/**
 * Register blocks.
 *
 * @access public
 * @return void
 */
function emdb_register_blocks() {
    register_block_type( get_template_directory() . '/blocks/magazine-grid' );
}
add_action( 'init', 'emdb_register_blocks' );

/**
 * Enqueue theme styles on the front end and in the editor.
 *
 * Versioned by the theme version, not index.asset.php: that hash only
 * covers the editor JS, so CSS-only releases kept the same URL.
 *
 * @access public
 * @return void
 */
function emdb_enqueue_block_assets() {
    wp_enqueue_style(
        'emdb-styles',
        get_template_directory_uri() . '/build/style-index.css',
        array(),
        EMDOTBIKE_VERSION
    );
}
add_action( 'enqueue_block_assets', 'emdb_enqueue_block_assets' );

/**
 * Archive title prefix for category and tag pages.
 *
 * Shown by the core/query-title block in templates/archive.html, e.g.
 * "Articles related to: Racing".
 *
 * @access public
 * @param string $prefix Default prefix ("Category:", "Tag:", ...).
 * @return string
 */
function emdb_archive_title_prefix( $prefix ) {
    if ( is_category() || is_tag() ) {
        return __( 'Articles related to:', 'emdotbike' );
    }

    return $prefix;
}
add_filter( 'get_the_archive_title_prefix', 'emdb_archive_title_prefix' );

/**
 * Search results: posts only, newest first.
 *
 * The search template's Query Loop inherits the main query; keep it to
 * blog posts sorted by date, as the old posts grid did, instead of
 * WordPress's default of all post types sorted by relevance.
 *
 * @access public
 * @param WP_Query $query The query being set up.
 * @return void
 */
function emdb_search_posts_only( $query ) {
    if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) {
        return;
    }

    $query->set( 'post_type', 'post' );
    $query->set( 'orderby', 'date' );
    $query->set( 'order', 'DESC' );
}
add_action( 'pre_get_posts', 'emdb_search_posts_only' );

/**
 * Hide dwb/post-header blocks left in post content.
 *
 * Single posts get their header from templates/single.html, so a
 * dwb/post-header saved in a post's content would render a second one.
 *
 * @access public
 * @param string $block_content Rendered block markup.
 * @return string
 */
function emdb_hide_content_post_header( $block_content ) {
    return is_singular( 'post' ) ? '' : $block_content;
}
add_filter( 'render_block_dwb/post-header', 'emdb_hide_content_post_header' );

/**
 * Enqueue block editor scripts (editor only).
 *
 * @access public
 * @return void
 */
function emdb_enqueue_block_editor_assets() {
    $asset_file = include get_template_directory() . '/build/index.asset.php';

    wp_enqueue_script(
        'emdb-blocks',
        get_template_directory_uri() . '/build/index.js',
        $asset_file['dependencies'],
        $asset_file['version'],
        true
    );
}
add_action( 'enqueue_block_editor_assets', 'emdb_enqueue_block_editor_assets' );
