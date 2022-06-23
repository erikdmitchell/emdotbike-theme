<?php
/**
 * Post Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'emdb-post-nav-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$block_class_name = 'emdb-block-post-nav';

if ( ! empty( $block['className'] ) ) {
    $block_class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $block_class_name .= ' align' . $block['align'];
}

// layout class (theme).
$block_class_name .= ' emdb-layout-wrap';

// Load values and assign defaults.

// Don't print empty markup if there's nowhere to navigate.
$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
$next     = get_adjacent_post( false, '', false );

if ( ! $next && ! $previous ) {
    return;
}
?>
    
<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_class_name ); ?>">  
    <nav class="navigation post-navigation" role="navigation">
        <div class="nav-links">
            <?php
            if ( is_attachment() ) :
                previous_post_link( __( '<div class="published-in"><span class="meta-nav">Published In:</span> %link</div>', 'emdotbike' ), '%title' );
            else :
                previous_post_link( __( '<div class="prev-post"><span class="meta-nav">Previous Post:</span> %link</div>', 'emdotbike' ), '%title' );
                next_post_link( __( '<div class="next-post"><span class="meta-nav">Next Post:</span> %link</div>', 'emdotbike' ), '%title' );
            endif;
            ?>
        </div><!-- .nav-links -->
    </nav><!-- .navigation -->
</div>
