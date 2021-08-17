<?php
/**
 * Template Name: Front Page v2
 **/
?>
<?php get_header(); ?>
  
<?php $posts = get_posts( array( 'posts_per_page' => 4 ) ); ?>

<?php if ( !empty($posts) ) : ?>

    <div class="flex-grid front-page-grid">

        <div class="flex-col">
            <?php foreach ($posts as $key => $post) : ?>
    
                <?php emdotbike_insert_flex_col( $key ); ?>
                
                <?php
                    $classes = '';
                    $image_size = 'home-grid';
                ?>           
                <div class="flex-item post-<?php echo $post->ID . $classes; ?>">
                    <?php emdotbike_theme_post_thumbnail_custom( $post, $image_size ); ?>
                    <h3><?php echo get_the_title( $post ); ?></h3>
                    <div class="excerpt"><?php emdotbike_post_excerpt( $post, 25, '', ' <a href="' . get_permalink( $post->ID ) . '">read more...</a>' ); ?></div>
                </div>
               
            <?php endforeach; ?>
        </div>
        
    </div>

<?php endif; ?>

<?php
    get_footer();
    
function emdotbike_insert_flex_col($number = 0) {
    $html = '';
    
    if (1 == $number % 3) {
        $html .= '</div><div class="flex-col">';
    }
    
    echo $html;   
}