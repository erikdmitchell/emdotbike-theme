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

if ( ! empty( $block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'emdb-block-posts-grid';

if ( ! empty( $block['className'] ) ) {
    $className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$number_of_posts = get_field( 'posts_per_page' ) ? : 1;
$post_type       = get_field( 'post_type' ) ? : 'post';
$columns         = get_field( 'columns' ) ? : 2;
$order_by        = get_field( 'order_by' ) ? : 'date/desc';
$sticky_posts    = get_field( 'sticky_posts' ) ? : false; // not used yest.

// sets up offset for pagination.
$paged  = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 0;
$offset = $paged * $number_of_posts;
echo "paged: $paged | offset: $offset | $number_of_posts";

// get order arr.
$order_by_arr = emdb_parse_grid_order( $order_by );

// check for specific authoer
$author_login = get_field( 'authors' ) ? get_field( 'authors' ) : '';

if ( $author_login ) {
    $author_data = get_user_by( 'login', $author_login );
    $author_id   = $author_data->ID;
} else {
    $author_id = '';
}

$category = ''; // not setup lol.

// check for tag.
$tax_query = array();
$tags      = get_field( 'tags' );

if ( '' !== $tags ) {
    $tax_query = array(
        'taxonomy' => 'post_tag',
        'fields'   => 'slug',
        'terms'    => sanitize_title( $tags ),
    );
}

// this is a tag page.
if ( is_tag() ) {
    $tag = get_queried_object();

    $tax_query[] = array(
        'taxonomy' => 'post_tag',
        'field'    => 'slug',
        'terms'    => sanitize_title( $tag->slug ),
    );
}

// get posts.
$posts = get_posts(
    array(
        'posts_per_page' => $number_of_posts,
        'post_type'      => $post_type,
        'orderby'        => $order_by_arr[0],
        'order'          => $order_by_arr[1],
        'offset'         => $offset,
        'author'         => $author_id,
        'category'       => $category,
        'tax_query'      => $tax_query,
    )
);
?>

<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?>">
    <?php foreach ( $posts as $key => $post ) : ?>
        <?php emdb_begin_column( $key, $columns ); ?>
        <div class="wp-block-column">
            <article id="post-<?php echo $post->ID; ?>" class="<?php echo esc_attr( implode( ' ', get_post_class( '', $post ) ) ); ?>">
                <div class="entry-thumb">
                    <?php emdb_theme_post_thumbnail( 'home-grid-large', $post ); ?>
                </div>
                
                <header>
                    <h2 class="entry-title"><a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>" rel="bookmark"><?php echo get_the_title( $post ); ?></a></h2>
                </header>
                
                <div class="entry-excerpt">
                    <div class="excerpt"><?php emdotbike_post_excerpt( $post, 55, '', ' <a href="' . get_permalink( $post->ID ) . '">read more...</a>' ); ?></div>
                </div>
            </article>
        </div>
        <?php emdb_end_column( $key, $columns, count( $posts ) ); ?>
    <?php endforeach; ?>
</div>

<?php emdotbike_theme_paging_nav(); // Previous/next post navigation. ?>
