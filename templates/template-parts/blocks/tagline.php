<?php

/**
 * Tagline Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'emdb-tagline-' . $block['id'];

if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'emdb-block-tagline';

if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$text = get_field('text') ?: get_bloginfo('tagline');
$image = get_field('image') ?: '';
$background_color = get_field('background_color');
?>
	
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="tagline-wrapper">
        <div class="image-wrapper">
            <?php echo wp_get_attachment_image( $image, 'full' ); ?>
        </div>
        <div class="title-wrap">
            <?php echo $text; ?>
        </div>
    </div>
    
    <style type="text/css">
        #<?php echo $id; ?> {
            background: <?php echo $background_color; ?>;
        }
    </style>
</div>