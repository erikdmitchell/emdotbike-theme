<div class="emdotbike-home-grid grid-wrapper">

    <?php if ( emdb_home_has_posts() ) : ?>
        <div class="flex-grid front-page-grid">
            <div class="flex-col">    
                <?php
                while ( emdb_home_posts() ) :
                    $post = emdb_home_post();
                    ?>
                    <?php echo 1 == $post->post_num % 2 ? '</div><div class="flex-col">' : ''; ?>
           
                    <div class="flex-item post-<?php echo $post->ID; ?>">
                        <?php emdotbike_theme_post_thumbnail_custom( $post, 'home-grid-large' ); ?>
                        <div class="title"><h3><?php echo get_the_title( $post ); ?></h3></div>
                        <div class="excerpt"><?php emdotbike_post_excerpt( $post, 35, '', ' <a href="' . get_permalink( $post->ID ) . '">read more...</a>' ); ?></div>
                    </div>          
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php wp_reset_postdata(); ?>
