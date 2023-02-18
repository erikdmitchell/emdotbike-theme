<?php
/**
 * The template part for our magazine grid
 *
 * @package emdotbike
 * @since 0.3.0
 * @version 0.1.0
 */

$posts = get_posts( array(
    'posts_per_page' => 4,
) );
?>

<div class="mag-grid">
    <?php foreach ($posts as $key => $post) : ?>
        <?php
            $classes = 'mag-post-image';
            $image_size = 'home-grid';

            if ( 1 === $key ) {
                $classes .= ' tall';
                $image_size = 'home-grid-tall';
            }
        ?>  

        <div class="mag-grid-post mag-post-<?php echo $key; ?>">
            <div class="<?php echo $classes; ?>"><?php emdotbike_theme_post_thumbnail_custom( $post, $image_size ); ?></div>
            <div class="mag-post-title"><h2><a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_the_title( $post ); ?></a></h2></div>
            <div class="mag-post-excerpt"><?php emdotbike_post_excerpt( $post->ID, 55, '', ' <a href="' . get_permalink( $post->ID ) . '">read more...</a>' ); ?></div>
        </div>
    <?php endforeach; ?>
</div>

<!-- <div class="mag-grid-post mag-post-<?php echo $key; ?>" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url(<?php echo get_the_post_thumbnail_url( $post->ID ); ?>) no-repeat center center;"> -->