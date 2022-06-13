<?php
/**
 * Home Grid Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'emdb-home-grid-' . $block['id'];

if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'emdb-block-home-grid';

if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$number_of_posts = get_field('number_of_posts') ? : 1;
$offset = get_field('offset') ? : 0; // really not needed
$columns = get_field('columns') ? : 2;

// get posts.
$post_ids = get_posts( array(
    'posts_per_page' => $number_of_posts,
    'offset' => $offset,
    'fields' => 'ids'
) );
?>
	
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php foreach($post_ids as $key => $post_id) : ?>
        <?php if (0 === $key) : ?>
            <article id="post-<?php echo esc_attr($post_id); ?>" class="post post-<?php echo esc_attr($post_id); ?>">
                <div class="image-wrap" style="background:url(<?php echo get_the_post_thumbnail_url($post_id, 'full'); ?>) no-repeat center center fixed"></div>
                <h2 class="post-title"><?php echo get_the_title( $post_id ); ?></h2>
                <p><?php emdotbike_post_excerpt( $post_id, 85, '', '... <a href="'.get_permalink( $post_id ).'">read more</a>' ); ?></p>
            </article>
        <?php else: ?>
            <?php if (1 === $key % $columns) : ?>
                <div class="wp-block-columns columns-<?php echo $columns; ?>">
            <?php endif; ?>
            
            <div class="wp-block-column">
                <article id="post-<?php echo esc_attr($post_id); ?>" class="post post-<?php echo esc_attr($post_id); ?>">
                    <figure class="post-featured-image">
                        <?php emdotbike_theme_post_thumbnail_custom( $post_id, 'home-latest-posts-large', true ); ?>
                    </figure>
                    <h2 class="post-title"><?php echo get_the_title( $post_id ); ?></h2>
                    <?php emdotbike_post_excerpt( $post_id, 35, '', '... <a href="'.get_permalink( $post_id ).'">read more</a>' ); ?>
                </article>
            </div>
            <?php if ((0 === $key % $columns) || ($key + 1 === count($post_ids))) : ?>
                </div><!-- .wp-block-columns -->
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <div class="more-articles"><a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">More Articles</a></div>
</div>

