<?php
/**
 * Template Name: Front Page
 **/
?>
<?php get_header(); ?>

    <div class="front-page-tagline">
        <div class="wrapper">
            <div class="image-wrap">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/em-bike-logo-small-white.png" />
            </div>
            <div class="title-wrap">
                <h1>Training insights, race reports and general musings about the world of cycling</h1>
            </div>
        </div>
    </div>

    <?php
    $first_post = get_posts(
        array(
            'posts_per_page' => 1,
        )
    );

    $first_post = $first_post[0];

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
    ?>

    <div class="emdotbike-home-grid grid-wrapper">
        <div class="first-col">
            <div class="post-item post-<?php echo $first_post->ID; ?>" style="background: url(<?php echo get_the_post_thumbnail_url( $first_post ); ?>) no-repeat center center fixed;;">
                <div class="excerpt"><?php emdotbike_post_excerpt( $first_post, 55, '', ' <a href="'. get_permalink( $first_post->ID ) . '">read more...</a>' ); ?></div>
            </div>
        </div>

        <div class="second-col">
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
                ?>
                <div class="post-item post-<?php echo $post->ID . $classes; ?>">
                    <?php emdotbike_theme_post_thumbnail_custom( $post, $image_size ); ?>
                    <div class="excerpt"><?php emdotbike_post_excerpt( $post, 25, '', ' <a href="'. get_permalink( $first_post->ID ) . '">read more...</a>' ); ?></div>
                </div>
                
                <?php $post_counter++; ?>
            <?php endforeach; ?>
        </div>
        <div class="third-col">
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
                    <div class="excerpt"><?php emdotbike_post_excerpt( $post, 25, '', ' <a href="'. get_permalink( $first_post->ID ) . '">read more...</a>' ); ?></div>
                </div>
                
                <?php $post_counter++; ?>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php get_template_part( 'template-parts/content', 'front-page' ); ?>

<?php
get_footer();
