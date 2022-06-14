<?php
/**
 * EMdotBike: Block Patterns
 *
 * @since 0.2.0
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
// 		'featured' => array( 'label' => __( 'Featured', 'emdotbike' ) ),
		'header'   => array( 'label' => __( 'Headers', 'emdotbike' ) ),
// 		'query'    => array( 'label' => __( 'Query', 'emdotbike' ) ),
// 		'pages'    => array( 'label' => __( 'Pages', 'emdotbike' ) ),
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
/*
		'general-subscribe',
		'general-featured-posts',
*/
		'header-default',
/*		
		'hidden-404',
		'hidden-bird',
		'hidden-heading-and-bird',
		'page-about-media-left',
		'page-layout-two-columns',
		'page-sidebar-grid-posts',
		'query-default',
		'query-simple-blog',
		'query-grid',
*/
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
