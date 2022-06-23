<?php
/**
 * Archive Title Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'emdb-archive-title-' . $block['id'];

if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'emdb-block-archive-title';

if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$before_text = get_field('before_text') ? get_field('before_text') . ' ' : '';
?>
	
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <header class="archive-header">
        <h1 class="archive-title"><?php single_tag_title( __( $before_text, 'emdotbike' ) ); ?></h1>
        <?php if ( tag_description() ) : // Show an optional tag description. ?>
            <div class="archive-meta"><?php echo tag_description(); ?></div>
        <?php endif; ?>
    </header>
</div>



