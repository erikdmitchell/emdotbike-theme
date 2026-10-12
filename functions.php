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
    wp_enqueue_script( 'emdotbike-theme-script', get_template_directory_uri() . '/assets/js/emdotbike.js', array( 'jquery' ), EMDOTBIKE_VERSION, true );

    if ( is_singular() ) :
        wp_enqueue_script( 'comment-reply' );
    endif;

    wp_enqueue_style( 'dashicons' );
    wp_enqueue_style( 'emdotbike-theme-style', get_stylesheet_uri(), array(), EMDOTBIKE_VERSION );
}
add_action( 'wp_enqueue_scripts', 'emdotbike_theme_scripts' );


/**
 * Display an optional post thumbnail.
 *
 * @access public
 * @param string $size (default: 'full').
 * @return void
 */
function emdotbike_theme_post_thumbnail( $size = 'full' ) {
    global $post;

    $html = null;

    if ( post_password_required() ) {
        return;
    }

    if ( has_post_thumbnail( $post ) ) {
        $thumb_id      = get_post_thumbnail_id( $post->ID );
        $thumb_src_url = wp_get_attachment_image_url( $thumb_id, $size );
        $thumb_meta    = wp_get_attachment_metadata( $thumb_id );
        $thumb_meta    = is_array( $thumb_meta ) ? $thumb_meta : array();
        $thumb_base    = '<img src="' . $thumb_src_url . '" class="img-responsive" />';
        $thumb         = wp_image_add_srcset_and_sizes( $thumb_base, $thumb_meta, $thumb_id );
    } else {
        $thumb = '<img src="' . get_template_directory_uri() . '/assets/images/em-bike-logo-gray-bg-650x375.png" class="img-responsive" />';
    }

    if ( is_singular() ) :
        $html     .= '<div class="post-thumbnail">';
            $html .= $thumb;
        $html     .= '</div>';
    else :
        $html     .= '<a class="post-thumbnail" href="' . get_permalink( $post->ID ) . '">';
            $html .= $thumb;
        $html     .= '</a>';
    endif;

    $image = apply_filters( 'emdotbike_theme_post_thumbnail', $html, $size );

    echo wp_kses_post( $image );
}

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
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since emdotbike 1.0
 * @based on twentyfourteen
 *
 * @return void
 */
function emdotbike_theme_paging_nav() {
    // Don't print empty markup if there's only one page.
    if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
        return;
    }

    $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
    $pagenum_link = html_entity_decode( get_pagenum_link() );
    $query_args   = array();
    $url_parts    = explode( '?', $pagenum_link );

    if ( isset( $url_parts[1] ) ) {
        wp_parse_str( $url_parts[1], $query_args );
    }

    $pagenum_link = remove_query_arg( array_keys( $query_args ), esc_url( $pagenum_link ) );
    $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

    $format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
    $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

    // Set up paginated links.
    $links = paginate_links(
        array(
            'base'      => $pagenum_link,
            'format'    => $format,
            'total'     => $GLOBALS['wp_query']->max_num_pages,
            'current'   => $paged,
            'mid_size'  => 1,
            'add_args'  => array_map( 'urlencode', $query_args ),
            'prev_text' => __( '&laquo; Previous', 'emdotbike' ),
            'next_text' => __( 'Next &raquo;', 'emdotbike' ),
        )
    );

    if ( $links ) :
        ?>
        <nav class="navigation paging-navigation" role="navigation">
            <div class="pagination loop-pagination">
                <?php echo wp_kses_post( $links ); ?>
            </div><!-- .pagination -->
        </nav><!-- .navigation -->
        <?php
    endif;
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

/**
 * Parse grid order string into array.
 *
 * @access public
 * @param string $order Order string, e.g. 'date/desc' (default: '').
 * @return array
 */
function emdb_parse_grid_order( $order = '' ) {
    if ( empty( $order ) ) {
        $order_arr = array( 'date', 'desc' );
    } else {
        $order_arr = explode( '/', $order );
    }

    return $order_arr;
}

/**
 * Open a columns wrapper at the start of each grid row.
 *
 * @access public
 * @param int $key (default: 0).
 * @param int $columns (default: 0).
 * @return void
 */
function emdb_begin_column( $key = 0, $columns = 0 ) {
    if ( ( 0 === $key % $columns ) || 0 === $key ) {
        echo '<div class="wp-block-columns columns-' . $columns . '">'; // @codingStandardsIgnoreLine WordPress.Security.EscapeOutput.OutputNotEscaped.
    }
}

/**
 * Close the columns wrapper at the end of each grid row.
 *
 * @access public
 * @param int $key (default: 0).
 * @param int $columns (default: 0).
 * @param int $max (default: 0).
 * @return void
 */
function emdb_end_column( $key = 0, $columns = 0, $max = 0 ) {
    if ( ( 1 === $key % $columns ) || ( $key + 1 === $max ) ) {
        echo '</div><!-- .wp-block-columns -->'; // @codingStandardsIgnoreLine WordPress.Security.EscapeOutput.OutputNotEscaped.
    }
}

/**
 * ACF Functions.
 */

/**
 * Register custom ACF field: post type selector.
 *
 * @access public
 * @return void
 */
function emdb_acf_register_fields() {
    include_once get_template_directory() . '/inc/acf-post-type-selector/post-type-selector-v5.php';
}
add_action( 'acf/include_fields', 'emdb_acf_register_fields' );

/**
 * Initialize custom ACF blocks.
 *
 * @access public
 * @return void
 */
function emdb_init_block_types() {
    if ( ! function_exists( 'acf_register_block_type' ) ) {
        return;
    }

    // register archive title block.
    acf_register_block_type(
        array(
            'name'            => 'archive-title',
            'title'           => __( 'Archive Title', 'emdotbike' ),
            'render_template' => 'templates/blocks/archive-title.php',
            'category'        => 'theme',
            'icon'            => 'editor-textcolor',
            'keywords'        => array( 'archive', 'title' ),
        )
    );

    // register author bio block.
    acf_register_block_type(
        array(
            'name'            => 'author-bio',
            'title'           => __( 'Author Bio', 'emdotbike' ),
            'description'     => __( 'An author bio block.', 'emdotbike' ),
            'render_template' => 'templates/blocks/author-bio.php',
            'category'        => 'theme',
            'icon'            => 'id',
            'keywords'        => array( 'author', 'bio' ),
        )
    );

    // register page nav block.
    acf_register_block_type(
        array(
            'name'            => 'page-nav',
            'title'           => __( 'Page Nav', 'emdotbike' ),
            'description'     => __( 'A page navigation block.', 'emdotbike' ),
            'render_template' => 'templates/blocks/page-nav.php',
            'category'        => 'formatting',
            'icon'            => 'ellipsis',
            'keywords'        => array( 'navigation', 'page' ),
        )
    );

    // register posts grid block.
    acf_register_block_type(
        array(
            'name'            => 'posts-grid',
            'title'           => __( 'Posts Grid', 'emdotbike' ),
            'description'     => __( 'A posts grid block.', 'emdotbike' ),
            'render_template' => 'templates/blocks/posts-grid.php',
            'category'        => 'query',
            'icon'            => 'grid-view',
            'keywords'        => array( 'query', 'grid', 'posts' ),
        )
    );

    // register posts nav block.
    acf_register_block_type(
        array(
            'name'            => 'post-nav',
            'title'           => __( 'Post Nav', 'emdotbike' ),
            'description'     => __( 'A post navigation block.', 'emdotbike' ),
            'render_template' => 'templates/blocks/post-nav.php',
            'category'        => 'formatting',
            'icon'            => 'ellipsis',
            'keywords'        => array( 'navigation', 'post' ),
        )
    );

    // register tagline block.
    acf_register_block_type(
        array(
            'name'            => 'tagline',
            'title'           => __( 'Tagline', 'emdotbike' ),
            'description'     => __( 'A tagline block.', 'emdotbike' ),
            'render_template' => 'templates/blocks/tagline.php',
            'category'        => 'formatting',
            'icon'            => 'format-status',
            'keywords'        => array( 'tagline', 'quote' ),
        )
    );
}
add_action( 'acf/init', 'emdb_init_block_types' );

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