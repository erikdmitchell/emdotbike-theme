<?php
/**
 * Theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @package EMdotBike
 * @since 0.1.0
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since 0.2.0
 *
 * @return void
 */
function emdb_support() {

    add_theme_support( 'block-templates' );

    // Add support for block styles.
    add_theme_support( 'wp-block-styles' );

    // Enqueue editor styles.
    add_editor_style( 'style.css' );

    // Support title tag.
    add_theme_support( 'title-tag' );

    /**
     * Add our image size(s).
     */
    add_image_size( 'navbar-logo', 163, 100, true );
    add_image_size( 'single', 9999, 480, true );
    add_image_size( 'home-latest-posts-large', 9999, 680, true );

}
add_action( 'after_setup_theme', 'emdb_support' );

/**
 * Enqueue styles.
 *
 * @since 0.2.0
 *
 * @return void
 */
function emdb_scripts_styles() {
    $theme_version  = wp_get_theme()->get( 'Version' );
    $version_string = is_string( $theme_version ) ? $theme_version : false;

    global $wp_scripts;

    wp_enqueue_script( 'emdb-script', get_template_directory_uri() . '/assets/js/emdotbike.min.js', array( 'jquery' ), $version_string, true );

    if ( is_singular() ) :
        wp_enqueue_script( 'comment-reply' );
    endif;

    wp_enqueue_style( 'dashicons' );

    wp_register_style(
        'emdb-style',
        get_template_directory_uri() . '/style.css',
        array(),
        $version_string
    );

    // Enqueue theme stylesheet.
    wp_enqueue_style( 'emdb-style' );

}
add_action( 'wp_enqueue_scripts', 'emdb_scripts_styles' );

// Add block patterns.
require get_template_directory() . '/inc/block-patterns.php';

/**
 * Display custom image sizes in media panel.
 *
 * @access public
 * @param array $sizes (array of image sizes).
 * @return array
 */
function emdb_custom_image_sizes( $sizes ) {
    return array_merge(
        $sizes,
        array(
            'home-latest-posts-large' => __( 'Home Posts Large', 'emdotbike' ),
        )
    );
}
add_filter( 'image_size_names_choose', 'emdb_custom_image_sizes' );

/**
 * Display an optional post thumbnail.
 *
 * @access public
 * @param string $size (default: 'full').
 * @param array  $post (default: null).
 * @param bool   $parallax (default: false).
 * @return void
 */
function emdb_theme_post_thumbnail( $size = 'full', $post = null, $parallax = false ) {
    if ( ! $post ) {
        global $post;
    }

    $html = null;

    if ( post_password_required() ) {
        return;
    }

    if ( has_post_thumbnail( $post ) ) {
        $thumb_id      = get_post_thumbnail_id( $post->ID );
        $thumb_src_url = wp_get_attachment_image_url( $thumb_id, $size );
        $thumb_meta    = wp_get_attachment_metadata( $thumb_id );
        $thumb_base    = '<img src="' . $thumb_src_url . '" class="img-responsive" />';
        $thumb         = wp_image_add_srcset_and_sizes( $thumb_base, $thumb_meta, $thumb_id );
    } else {
        $thumb = '<img src="' . get_template_directory_uri() . '/images/em-bike-logo-gray-bg-650x375.png" class="img-responsive" />';
    }

    // for parallax images.
    if ( $parallax ) {
        $attr  = array(
            'height' => $thumb_meta['sizes'][ $size ]['height'] . 'px',
        );
        $thumb = emdotbike_get_parallax_image( $thumb_url, $attr );
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
 * Setup parallax image.
 *
 * @access public
 * @param string $image_url (default: '').
 * @param array  $styles (default: array()).
 * @return image div
 */
function emdotbike_get_parallax_image( $image_url = '', $styles = array() ) {
    if ( empty( $image_url ) ) {
        return;
    }

    $default_styles = array(
        'background-image' => 'url(' . $image_url . ')',
        'height'           => '400px',
    );
    $styles         = wp_parse_args( $styles, $default_styles );
    $styles_arr     = array();

    // setup styles.
    foreach ( $styles as $name => $style ) {
        $styles_arr[] = "$name: $style";
    }
    $styles = implode( ';', $styles_arr );

    return '<div class="parallax-image" style="' . $styles . '"></div>';
}

/**
 * Custom post thumbnail.
 *
 * @access public
 * @param string $post (default: '').
 * @param string $size (default: 'full').
 * @param bool   $link (default: true).
 * @return void
 */
function emdotbike_theme_post_thumbnail_custom( $post = '', $size = 'full', $link = true ) {
    echo wp_kses_post( emdotbike_theme_get_post_thumbnail_custom( $post, $size, $link ) );
}

/**
 * Get custom post thumbnail.
 *
 * @access public
 * @param string $post (default: '').
 * @param string $size (default: 'full').
 * @param bool   $link (default: true).
 * @return image
 */
function emdotbike_theme_get_post_thumbnail_custom( $post = '', $size = 'full', $link = true ) {
    if ( is_int( $post ) ) {
        // get the post object of the passed ID.
        $post = get_post( $post );
    } elseif ( ! is_object( $post ) ) {
        return false;
    }

    $html = null;

    $image_id   = get_post_thumbnail_id( $post->ID );
    $image_src  = wp_get_attachment_image_url( $image_id, $size );
    $image_meta = wp_get_attachment_metadata( $image_id );
    $image_base = '<img src="' . $image_src . '" class="img-responsive" />';
    $image      = wp_image_add_srcset_and_sizes( $image_base, $image_meta, $image_id );

    if ( post_password_required( $post ) || ! has_post_thumbnail( $post ) ) {
        return;
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
 * Custom parse args function.
 *
 * Similar to wp_parse_args() just a bit extended to work with multidimensional arrays
 *
 * @access public
 * @param mixed $a (array).
 * @param mixed $b (array).
 * @return array
 */
function emdotbike_wp_parse_args( &$a, $b ) {
    $a      = (array) $a;
    $b      = (array) $b;
    $result = $b;
    foreach ( $a as $k => &$v ) {
        if ( is_array( $v ) && isset( $result[ $k ] ) ) {
            $result[ $k ] = emdotbike_wp_parse_args( $v, $result[ $k ] );
        } else {
            $result[ $k ] = $v;
        }
    }
    return $result;
}

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
    } elseif ( ! is_object( $post ) ) {
        return false;
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
 * @param mixed  $post (post object).
 * @param int    $length (default: 10).
 * @param string $tags (default: '<a><em><strong>').
 * @param string $extra (default: ' . . .').
 * @return void
 */
function emdotbike_post_excerpt( $post, $length = 10, $tags = '<a><em><strong>', $extra = ' . . .' ) {
    echo emdotbike_get_post_excerpt_by_id( $post, $length, $tags, $extra ); // @codingStandardsIgnoreLine WordPress.Security.EscapeOutput.OutputNotEscaped.
}

/**
 * Custom read more excerpt.
 *
 * @access public
 * @param mixed $more string.
 * @return string
 */
function emdotbike_custom_excerpt_more( $more ) {
    return sprintf( '...' );
}
add_filter( 'excerpt_more', 'emdotbike_custom_excerpt_more' );

/**
 * Login page scripts and styles.
 *
 * @access public
 * @return void
 */
function emdotbike_login_scripts_styles() {
    wp_enqueue_style( 'emdotbike-login-style', get_template_directory_uri() . '/assets/css/login.min.css', array(), '0.1.0' );
}
add_action( 'login_enqueue_scripts', 'emdotbike_login_scripts_styles' );

/**
 * Login header URL.
 *
 * @access public
 * @return url
 */
function emdotbike_login_headerurl() {
    return home_url();
}
add_filter( 'login_headerurl', 'emdotbike_login_headerurl' );

/**
 * Parse grid order string into array.
 *
 * @access public
 * @param string $string (default: ' ').
 * @return array
 */
function emdb_parse_grid_order( $string = '' ) {
    if ( empty( $string ) ) {
        $order_arr = array( 'date', 'desc' );
    } else {
        $order_arr = explode( '/', $string );
    }

    return $order_arr;
}

/**
 * Parse grid order string into array.
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
 * Parse grid order string into array.
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
    include_once 'inc/acf-post-type-selector/post-type-selector-v5.php';
}
add_action( 'acf/include_fields', 'emdb_acf_register_fields' );

/**
 * Initialize custom ACF blocks.
 *
 * @access public
 * @return bool
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

    // register home featured block.
    acf_register_block_type(
        array(
            'name'            => 'home-grid',
            'title'           => __( 'Home Grid', 'emdotbike' ),
            'description'     => __( 'A home grid block.', 'emdotbike' ),
            'render_template' => 'templates/blocks/home-grid.php',
            'category'        => 'formatting',
            'icon'            => 'editor-table',
            'keywords'        => array( 'home', 'featured' ),
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

/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * There's an ACF block for this, but it is used inside the Posts Grid block.
 *
 * @since emdotbike 1.0
 * @based on twentyfourteen
 *
 * @return void
 */
function emdb_theme_paging_nav() {
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
 * Block template for posts.
 *
 * @access public
 * @return void
 */
function emdb_post_block_template() {
    $post_type_object           = get_post_type_object( 'post' );
    $post_type_object->template = array(
        array( 'dwb/post-header' ),
        array( 'dwb/read-time' ),
        array( 'core/paragraph' ),
    );
}
add_action( 'init', 'emdb_post_block_template' );
