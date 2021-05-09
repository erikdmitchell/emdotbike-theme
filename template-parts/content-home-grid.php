<?php
$has_first_post = true;
$has_second_posts_set = true;
$has_third_posts_set = true;
$total_cols = 0;

$first_post = get_posts(
    array(
        'posts_per_page' => 1,
    )
);

if ( empty( $first_post ) ) {
    $has_first_post = false;
} else {
    $first_post = $first_post[0];
    $total_cols++;
}

$second_set_posts = get_posts(
    array(
        'posts_per_page' => 2,
        'offset' => 1,
    )
);

$third_set_posts = get_posts(
    array(
        'posts_per_page' => 2,
        'offset' => 3,
    )
);

if ( empty( $second_set_posts ) ) {
    $has_second_posts_set = false;
} else {
    $total_cols++;
}

if ( empty( $third_set_posts ) ) {
    $has_third_posts_set = false;
} else {
    $total_cols++;
}
?>

<?php
if ( ! $has_first_post ) {
    return; } // bail if no first post.
?>

<div class="emdotbike-home-grid grid-wrapper">
    <div class="first-col total-cols-<?php echo $total_cols; ?>">
        <div class="post-item post-<?php echo $first_post->ID; ?>" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url(<?php echo get_the_post_thumbnail_url( $first_post ); ?>) no-repeat center center;">
            <div class="title"><h3><?php echo get_the_title( $first_post ); ?></h3> </div>
            <div class="excerpt"><?php emdotbike_post_excerpt( $first_post, 55, '', ' <a href="' . get_permalink( $first_post->ID ) . '">read more...</a>' ); ?></div>
        </div>
    </div>
    
    <?php if ( $has_second_posts_set ) : ?>
        <div class="second-col total-cols-<?php echo $total_cols; ?> post-count-<?php echo count( $second_set_posts ); ?>">
            <?php $post_counter = 1; ?>
            <?php foreach ( $second_set_posts as $post ) : ?>
                <?php
                if ( $post_counter % 2 == 0 ) {
                    $classes = ' tall';
                    $image_size = 'home-grid-tall';
                } else {
                    $classes = '';
                    $image_size = 'home-grid';
                }
                
                $image_size = count( $second_set_posts ) == 1 ? 'home-grid-large' : $image_size;
                ?>
                <div class="post-item post-<?php echo $post->ID . $classes; ?>">
                    <?php emdotbike_theme_post_thumbnail_custom( $post, $image_size ); ?>
                    <h3><?php echo get_the_title( $post ); ?></h3>
                    <div class="excerpt"><?php emdotbike_post_excerpt( $post, 25, '', ' <a href="' . get_permalink( $first_post->ID ) . '">read more...</a>' ); ?></div>
                </div>
                
                <?php $post_counter++; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <?php if ( $has_third_posts_set ) : ?>
        <div class="third-col total-cols-<?php echo $total_cols; ?> post-count-<?php echo count( $third_set_posts ); ?>">
            <?php $post_counter = 1; ?>
            <?php foreach ( $third_set_posts as $post ) : ?>
                <?php
                if ( $post_counter % 2 == 0 ) {
                    $classes = '';
                    $image_size = 'home-grid';
                } else {
                    $classes = ' tall';
                    $image_size = 'home-grid-tall';
                }
                ?>
                <div class="post-item post-<?php echo $post->ID . $classes; ?>">
                    <?php emdotbike_theme_post_thumbnail_custom( $post, $image_size ); ?>
                    <h3><?php echo get_the_title( $post ); ?></h3>                    
                    <div class="excerpt"><?php emdotbike_post_excerpt( $post, 25, '', ' <a href="' . get_permalink( $first_post->ID ) . '">read more...</a>' ); ?></div>
                </div>
                
                <?php $post_counter++; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
