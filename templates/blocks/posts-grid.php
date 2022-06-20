<?php
/**
 * Posts Grid Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'emdb-posts-grid-' . $block['id'];

if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'emdb-block-posts-grid';

if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$number_of_posts = get_field('posts_per_page') ? : 1;
$post_type = get_field('post_type') ? : 'post';
$columns = get_field('columns') ? : 2;
$order_by = get_field('order_by') ? : 'date/desc';

$sticky_posts = get_field('sticky_posts') ? : false;

$offset = get_field('offset') ? : 0; // really not needed ?

// get order arr.
$order_by_arr = emdb_parse_grid_order($order_by);

/*
6
Filters
filtersGroup
7
Color
Accordion
8
Text Color
text_colorColor Picker
9
Background Color
background_colorColor Picker
*/

/*
        'category'         => 0,
        'include'          => array(),
        'exclude'          => array(),
        'meta_key'         => '',
        'meta_value'       => '',
        'suppress_filters' => true,
*/

// get posts.
$posts = get_posts( array(
    'posts_per_page' => $number_of_posts,
    'post_type' => $post_type,
    'orderby' => $order_by_arr[0],
    'order' => $order_by_arr[1],
    'offset' => $offset,
    // $sticky_posts = get_field('sticky_posts') ? : false;   
) );
?>

<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php foreach ($posts as $key => $post) : ?>
        <?php emdb_begin_column($key, $columns); ?>
        <article id="post-<?php echo $post->ID; ?>" class="<?php echo esc_attr( implode( ' ', get_post_class( '', $post ) ) ); ?>">
            <div class="entry-thumb">
                <?php emdb_theme_post_thumbnail( 'home-grid-large', $post ); ?>
            </div>
            
            <header class="entry-header">
                <h2 class="entry-title"><a href="<?php esc_url( get_permalink() ); ?>" rel="bookmark"><?php echo get_the_title( $post ); ?></a></h2>
            </header><!-- .entry-header -->
            
            <div class="entry-excerpt">
                <div class="excerpt"><?php emdotbike_post_excerpt( $post, 55, '', ' <a href="' . get_permalink() . '">read more...</a>' ); ?></div>
            </div>
        </article>
        <?php emdb_end_column($key, $columns, count($posts)); ?>
    <?php endforeach; ?>
</div>

<?php emdotbike_theme_paging_nav(); // Previous/next post navigation. ?>
