<?php
/**
 * Template Name: Front Page v2
 **/
?>
<?php get_header(); ?>
  
<?php $posts = get_posts( array( 'posts_per_page' => 4 ) ); ?>
<?php $total_posts = count($posts); ?>
<?php $col_counter = 1; ?>

<?php if ( !empty($posts) ) : ?>

    <div class="flex-grid-fp total-posts-<?php echo $total_posts; ?>">


            <?php foreach ($posts as $key => $post) : ?>
    

                
                <?php
                    $classes = '';
                    $image_size = 'home-grid';
                ?>           
                <div class="post-item post-item-<?php echo $key; ?> post-<?php echo $post->ID . $classes; ?>">
                    <?php emdotbike_theme_post_thumbnail_custom( $post, $image_size ); ?>
                    <h3><?php echo get_the_title( $post ); ?></h3>
                    <div class="excerpt"><?php emdotbike_post_excerpt( $post, 25, '', ' <a href="' . get_permalink( $post->ID ) . '">read more...</a>' ); ?></div>
                </div>
            <?php endforeach; ?>

        
    </div>

<?php endif; ?>

<?php
    get_footer();