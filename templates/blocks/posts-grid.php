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
$block_id = 'emdb-posts-grid-' . $block['id'];

if ( ! empty( $block['anchor'] ) ) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$block_class_name = 'emdb-block-posts-grid';

if ( ! empty( $block['className'] ) ) {
    $block_class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $block_class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
// $number_of_posts = get_field( 'posts_per_page' ) ? : 1;
$post_type       = get_field( 'post_type' ) ? : 'post';
$columns         = get_field( 'columns' ) ? : 2;
$order_by        = get_field( 'order_by' ) ? : 'date/desc';
$sticky_posts    = get_field( 'sticky_posts' ) ? : false; // not used yest.

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
// ^ combine? //
// this is a tag page.
if ( is_tag() ) {
    $tag = get_queried_object();

    $tax_query[] = array(
        'taxonomy' => 'post_tag',
        'field'    => 'slug',
        'terms'    => sanitize_title( $tag->slug ),
    );
}

// for pagination.
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
// echo 'p: ' . $paged . '<br>';
$args = array(
//     'posts_per_page' => $number_of_posts,
    'post_type'      => $post_type,
    'orderby'        => $order_by_arr[0],
    'order'          => $order_by_arr[1],
    'paged'         => $paged,
    'author'         => $author_id,
    'category'       => $category,
    'tax_query'      => $tax_query,
);    
// the query
$the_query = new WP_Query( $args ); 
$post_count = 0;
/*
echo "block ppp: $number_of_posts<br>";
echo $the_query->max_num_pages;
echo '<br>';
echo $the_query->post_count; // this should be 10?
echo '<br>';
echo $the_query->found_posts;
*/

?>
<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $block_class_name ); ?>">
 
    <?php if ( $the_query->have_posts() ) : ?>
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?> 
            <?php emdb_begin_column( $post_count, $columns ); ?>
            <div class="wp-block-column">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="entry-thumb">
                        <?php emdb_theme_post_thumbnail( 'home-grid-large' ); ?>
                    </div>
                    
                    <header>
                        <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title( '<h2 class="entry-title">', '</h2>' ); ?></a>
                    </header>
                    
                    <div class="entry-excerpt">
                        <div class="excerpt"><?php emdotbike_post_excerpt( get_the_ID(), 55, '', ' <a href="' . get_permalink() . '">read more...</a>' ); ?></div>
                    </div>
                </article>
            </div>
            <?php emdb_end_column( $post_count, $columns, $number_of_posts ); ?>
            <?php $post_count++; ?>
        <?php endwhile; ?>
     
        <?php emdb_theme_paging_nav(); // Previous/next post navigation. ?>

        <?php wp_reset_postdata(); ?>
     
    <?php else : ?>
        <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
    <?php endif; ?>

</div>