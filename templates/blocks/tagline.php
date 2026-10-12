<?php
/**
 * Tagline Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 * @package EMdotBike
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'emdb-tagline-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$block_class_name = 'emdb-block-tagline';

if ( ! empty( $block['className'] ) ) {
    $block_class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $block_class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$text             = get_field( 'text' ) ? get_field( 'text' ) : get_bloginfo( 'tagline' );
$image            = get_field( 'image' ) ? get_field( 'image' ) : '';
$background_color = get_field( 'background_color' );
?>
    
<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_class_name ); ?>">
    <div class="tagline-wrapper">
        <div class="image-wrapper">
            <?php echo wp_get_attachment_image( $image, 'full' ); ?>
        </div>
        <div class="title-wrap">
            <?php echo wp_kses_post( $text ); ?>
        </div>
    </div>
    
    <style type="text/css">
        #<?php echo esc_attr( $block_id ); ?> {
            background: <?php echo esc_attr( $background_color ); ?>;
        }
    </style>
</div>
