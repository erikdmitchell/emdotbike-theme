<?php
/**
 * Author Bio Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'emdb-author-bio-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$block_class_name = 'emdb-block-author-bio';

if ( ! empty( $block['className'] ) ) {
    $block_class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $block_class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$author_id = get_the_author_meta( 'ID' );
$avatar    = get_avatar( $author_id, 200 );
$name      = get_the_author_meta( 'display_name' );
$bio       = get_field( 'show_bio' ) ? '<div class="author-bio">' . get_the_author_meta( 'description' ) . '</div>' : '';
?>
    
<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_class_name ); ?>">
    <div class="author-header">
        <div class="author-column"><div class="author-image"><?php echo $avatar; ?></div></div>
        <div class="author-column">
            <div class="author-name"><h1><?php echo $name; ?></h1></div>
            <?php echo $bio; ?>
        </div>
    </div>
</div>
