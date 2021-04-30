<?php
/**
 * The template for displaying posts list
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since 0.1.0
 */

$query_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$os_multiplyer = ( 2 === $query_page ) ? 7 : 10;
$os_diff = ( 2 === $query_page ) ? 0 : 3;
$offset = ( ( $query_page - 1 ) * $os_multiplyer ) - $os_diff;
$blog_query = new WP_Query(
    array(
        'posts_per_page' => 10,
        'offset' => $offset,
        'page' => $query_page,
    )
);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="content container">

        <?php if ( $blog_query->have_posts() ) : ?>
            <div class="row">
                <?php
                while ( $blog_query->have_posts() ) :
                    $blog_query->the_post();
                    ?>
                
                    <div class="col-12 col-md-6">
                        <div class="list-post-thumbnail">
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'blog-single' ); ?></a>
                        </div>
                        
                        <div class="title">
                            <a href="<?php the_permalink(); ?>"><?php the_title( '<h2 class="blog-list-post">', '</h2>' ); ?></a>
                        </div>
                        
                        <div class="excerpt">
                            <?php echo emdotnet_get_post_excerpt_by_id( get_the_ID(), 30, '', '<a href="' . get_permalink( get_the_ID() ) . '">... read more</a>' ); ?>
                        </div>
                    </div>
                                
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-12">
                <div class="nav-previous alignleft"><?php next_posts_link( 'Older posts', $blog_query->max_num_pages ); ?></div>
                <div class="nav-next alignright"><?php previous_posts_link( 'Newer posts' ); ?></div>
            </div>
        </div>

    </div>

</article>