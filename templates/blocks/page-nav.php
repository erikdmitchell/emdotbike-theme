<?php
/**
 * Page Nav Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'emdb-page-nav-' . $block['id'];

if( !empty($block['anchor']) ) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$block_class_name = 'emdb-block-page-nav';

if( !empty($block['className']) ) {
    $block_class_name .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $block_class_name .= ' align' . $block['align'];
}

// layout class (theme).
$block_class_name .= ' emdb-layout-wrap';

// Load values and assign defaults.

// Don't print empty markup if there's only one page.
/*
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
        'base'     => $pagenum_link,
        'format'   => $format,
        'total'    => $GLOBALS['wp_query']->max_num_pages,
        'current'  => $paged,
        'mid_size' => 1,
        'add_args' => array_map( 'urlencode', $query_args ),
        'prev_text' => __( '&laquo; Previous', 'emdotbike' ),
        'next_text' => __( 'Next &raquo;', 'emdotbike' ),
    )
);
*/
?>
	
<div id="<?php echo esc_attr($block_id); ?>" class="<?php echo esc_attr($block_class_name); ?>">  
    <nav class="navigation paging-navigation" role="navigation">
        <div class="pagination loop-pagination">
            <?php //echo wp_kses_post( $links ); ?>
        </div><!-- .pagination -->
    </nav><!-- .navigation -->
</div>