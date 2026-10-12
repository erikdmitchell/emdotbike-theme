<?php
/**
 * EMdotBike: Block Patterns
 *
 * @since 0.2.0
 * @package EMdotBike
 */

/**
 * Registers block patterns and categories.
 *
 * @since 0.2.0
 *
 * @return void
 */
function emdb_register_block_patterns() {
    $block_pattern_categories = array(
        'header' => array( 'label' => __( 'Headers', 'emdotbike' ) ),
        'footer' => array( 'label' => __( 'Footers', 'emdotbike' ) ),
    );

    /**
     * Filters the theme block pattern categories.
     *
     * @since 0.2.0
     *
     * @param array[] $block_pattern_categories {
     *     An associative array of block pattern categories, keyed by category name.
     *
     *     @type array[] $properties {
     *         An array of block category properties.
     *
     *         @type string $label A human-readable label for the pattern category.
     *     }
     * }
     */
    $block_pattern_categories = apply_filters( 'emdb_block_pattern_categories', $block_pattern_categories );

    foreach ( $block_pattern_categories as $name => $properties ) {
        if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
            register_block_pattern_category( $name, $properties );
        }
    }

    $block_patterns = array(
        'header-default',
        'footer-default',
        'front-page-tagline',
        'posts-grid',
        'posts-grid-search',
    );

    /**
     * Filters the theme block patterns.
     *
     * @since 0.2.0
     *
     * @param array $block_patterns List of block patterns by name.
     */
    $block_patterns = apply_filters( 'emdb_block_patterns', $block_patterns );

    foreach ( $block_patterns as $block_pattern ) {
        $pattern_file = get_theme_file_path( '/inc/patterns/' . $block_pattern . '.php' );

        register_block_pattern(
            'emdb/' . $block_pattern,
            require $pattern_file
        );
    }
}
add_action( 'init', 'emdb_register_block_patterns', 9 );

/**
 * Block markup for the posts grid patterns.
 *
 * A two-column Query Loop that inherits the page's query (featured image,
 * title, excerpt), with pagination and a "no results" message.
 *
 * @param string[] $no_results Paragraphs shown when the query is empty.
 * @return string
 */
function emdb_posts_grid_markup( $no_results ) {
    $no_results_markup = '';

    foreach ( $no_results as $paragraph ) {
        $no_results_markup .= '<!-- wp:paragraph --><p>' . esc_html( $paragraph ) . '</p><!-- /wp:paragraph -->';
    }

    return '<!-- wp:query {"queryId":10,"query":{"inherit":true},"className":"emdb-block-posts-grid"} -->
<div class="wp-block-query emdb-block-posts-grid">
    <!-- wp:post-template {"style":{"spacing":{"blockGap":"1.75rem"}},"layout":{"type":"grid","columnCount":2}} -->
        <!-- wp:post-featured-image {"isLink":true} /-->
        <!-- wp:post-title {"level":2,"isLink":true,"className":"entry-title"} /-->
        <!-- wp:post-excerpt {"moreText":"' . esc_attr__( 'read more...', 'emdotbike' ) . '","showMoreOnNewLine":false,"excerptLength":55} /-->
    <!-- /wp:post-template -->

    <!-- wp:query-pagination {"paginationArrow":"none","layout":{"type":"flex","justifyContent":"center"}} -->
        <!-- wp:query-pagination-previous {"label":"' . esc_attr__( '« Previous', 'emdotbike' ) . '"} /-->
        <!-- wp:query-pagination-numbers {"midSize":1} /-->
        <!-- wp:query-pagination-next {"label":"' . esc_attr__( 'Next »', 'emdotbike' ) . '"} /-->
    <!-- /wp:query-pagination -->

    <!-- wp:query-no-results -->
        ' . $no_results_markup . '
    <!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->';
}
