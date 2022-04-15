<?php
/**
 * Home Featured Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'emdb-home-featured-' . $block['id'];

if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'emdb-block-home-featured';

if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$number_of_posts = get_field('number_of_posts') ?: 1;
$offset = get_field('offset') ?: 0;

// get posts.
$post_ids = get_posts( array(
    'posts_per_page' => $number_of_posts,
    'offset' => $offset,
    'fields' => 'ids'
) );
?>
	
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php foreach($post_ids as $post_id) : ?>
        <article id="post-<?php echo esc_attr($post_id); ?>" class="post post-<?php echo esc_attr($post_id); ?>">
                <div class="image-wrap" style="background:url(<?php echo get_the_post_thumbnail_url($post_id, 'full'); ?>) no-repeat center center fixed"></div>
            <h2 class="post-title"><?php echo get_the_title( $post_id ); ?></h2>
            <p><?php emdotbike_post_excerpt( $post_id, 85, '', '... <a href="'.get_permalink( $post_id ).'">read more</a>' ); ?></p>
        </article>
    <?php endforeach; ?>
</div>