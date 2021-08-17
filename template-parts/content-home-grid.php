<div class="emdotbike-home-grid grid-wrapper">
    <?php $posts = get_posts( array( 'posts_per_page' => 3 ) ); ?>
    
    <?php if ( !empty($posts) ) : ?>
    
        <div class="flex-grid front-page-grid">
    
            <div class="flex-col">
                <?php foreach ($posts as $key => $post) : ?>
        
                    <?php echo 1 == $key % 2 ? '</div><div class="flex-col">' : ''; ?>
           
                    <div class="flex-item post-<?php echo $post->ID; ?>">
                        <?php emdotbike_theme_post_thumbnail_custom( $post, 'home-grid-large' ); ?>
                        <div class="title"><h3><?php echo get_the_title( $post ); ?></h3></div>
                        <div class="excerpt"><?php emdotbike_post_excerpt( $post, 35, '', ' <a href="' . get_permalink( $post->ID ) . '">read more...</a>' ); ?></div>
                    </div>
                   
                <?php endforeach; ?>
            </div>
            
        </div>
    
    <?php endif; ?>
</div>

<?php wp_reset_postdata(); ?>
