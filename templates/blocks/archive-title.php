<?php
/**
 * Archive Title Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 * @package EMdotBike
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'emdb-archive-title-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$block_class_name = 'emdb-block-archive-title';

if ( ! empty( $block['className'] ) ) {
    $block_class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $block_class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$before_text = get_field( 'before_text' ) ? get_field( 'before_text' ) . ' ' : '';
?>
    
<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_class_name ); ?>">
    <header class="archive-header">
        <h1 class="archive-title"><?php single_tag_title( __( $before_text, 'emdotbike' ) ); ?></h1>
        <?php if ( tag_description() ) : // Show an optional tag description. ?>
            <div class="archive-meta"><?php echo tag_description(); ?></div>
        <?php endif; ?>
    </header>
</div>



