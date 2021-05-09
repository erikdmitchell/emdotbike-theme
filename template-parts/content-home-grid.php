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
            <div class="post-item post-<?php echo $first_post->ID; ?>" style="background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url(<?php echo get_the_post_thumbnail_url( $first_post ); ?>) no-repeat center center;">
                <div class="title"><h3><?php echo get_the_title( $first_post ); ?></h3> </div>
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
                    <h3><?php echo get_the_title( $post ); ?></h3>
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
                    <h3><?php echo get_the_title( $post ); ?></h3>                    
                    <div class="excerpt"><?php emdotbike_post_excerpt( $post, 25, '', ' <a href="'. get_permalink( $first_post->ID ) . '">read more...</a>' ); ?></div>
                </div>
                
                <?php $post_counter++; ?>
            <?php endforeach; ?>
        </div>
    </div>
