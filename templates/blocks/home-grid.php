<?php
/**
 * Home Grid Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $postid The post ID this block is saved to.
 * @package EMdotBike
 */

// Create id attribute allowing for custom "anchor" value.
$block_id = 'emdb-home-grid-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$block_class_name = 'emdb-block-home-grid';

if ( ! empty( $block['className'] ) ) {
    $block_class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $block_class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
$number_of_posts = get_field( 'number_of_posts' ) ? get_field( 'number_of_posts' ) : 1;
$offset          = get_field( 'offset' ) ? get_field( 'offset' ) : 0; // really not needed.
$columns         = get_field( 'columns' ) ? get_field( 'columns' ) : 2;

// get posts.
$postids = get_posts(
    array(
        'posts_per_page' => $number_of_posts,
        'offset'         => $offset,
        'fields'         => 'ids',
    )
);
?>
    
<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_class_name ); ?>">
    <?php foreach ( $postids as $key => $postid ) : ?>
        <?php if ( 0 === $key ) : ?>
            <article id="post-<?php echo esc_attr( $postid ); ?>" class="post post-<?php echo esc_attr( $postid ); ?>">
                <div class="image-wrap" style="background:url(<?php echo esc_url( get_the_post_thumbnail_url( $postid, 'full' ) ); ?>) no-repeat center center fixed"><a href="<?php echo esc_url( get_permalink( $postid ) ); ?>"></a></div>
                <h2 class="post-title"><?php echo get_the_title( $postid ); ?></h2>
                <p><?php emdotbike_post_excerpt( $postid, 85, '', '... <a href="' . get_permalink( $postid ) . '">read more</a>' ); ?></p>
            </article>
        <?php else : ?>
            <?php if ( 1 === $key % $columns ) : ?>
                <div class="wp-block-columns columns-<?php echo $columns; ?>">
            <?php endif; ?>
            
            <div class="wp-block-column">
                <article id="post-<?php echo esc_attr( $postid ); ?>" class="post post-<?php echo esc_attr( $postid ); ?>">
                    <figure class="post-featured-image">
                        <?php emdotbike_theme_post_thumbnail_custom( $postid, 'home-latest-posts-large', true ); ?>
                    </figure>
                    <h2 class="post-title"><?php echo get_the_title( $postid ); ?></h2>
                    <?php emdotbike_post_excerpt( $postid, 35, '', '... <a href="' . get_permalink( $postid ) . '">read more</a>' ); ?>
                </article>
            </div>
            <?php if ( ( $key % $columns === 0 ) || ( $key + 1 === count( $postids ) ) ) : ?>
                </div><!-- .wp-block-columns -->
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <div class="more-articles"><a href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">More Articles</a></div>
</div>

