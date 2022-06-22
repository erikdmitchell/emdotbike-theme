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
$id = 'emdb-author-bio-' . $block['id'];

if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'emdb-block-author-bio';

if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$author_id = get_the_author_meta( 'ID' );
$avatar = get_avatar( $author_id , 200 );
$name = get_the_author_meta( 'display_name' );
$bio = get_field('show_bio') ? '<div class="author-bio">' . get_the_author_meta( 'description' ) . '</div>' : '';
?>
	
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="author-header">
        <div class="author-column"><div class="author-image"><?php echo $avatar; ?></div></div>
        <div class="author-column">
            <div class="author-name"><h1><?php echo $name; ?></h1></div>
            <?php echo $bio; ?>
        </div>
    </div>
</div>