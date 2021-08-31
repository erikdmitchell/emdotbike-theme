<?php
/**
 * Author posts page
 **/
?>

<?php get_header(); ?>

<div class="grid-wrapper author-header">
    <?php emdb_author_header(); ?>
</div>

<?php if ( have_posts() ) : ?>
    <div class="blog-page-posts grid-wrapper">
        <div class="grid-cols">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <div class="grid-col-6">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="entry-thumb">
                    <?php emdotbike_theme_post_thumbnail(); ?>
                    </div>
                    
                    <header class="entry-header">
                        <?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); ?>
                    </header><!-- .entry-header -->
                    
                    <div class="entry-excerpt">
                        <div class="excerpt"><?php emdotbike_post_excerpt( $post, 55, '', ' <a href="' . get_permalink() . '">read more...</a>' ); ?></div>
                    </div>
                </article>
            </div>
        <?php endwhile; ?>
        </div>
    </div>
    
    <!-- // Previous/next post navigation. NEEDS TO BE ADDED -->
    
<?php endif; ?>

<?php
get_footer();

function emdb_author_header() {
    $html = '';
    $name = get_the_author_meta('display_name');
    $image = get_avatar( get_the_author_meta( 'ID' ), 200 );
    $bio = get_the_author_meta('description');
    
    $html .= '<div class="author-column"><div class="author-image">'.$image.'</div></div>';
    $html .= '<div class="author-column">';
        $html .= '<div class="author-name"><h1>'.$name.'</h1></div>';
        $html .= '<div class="author-bio">'.$bio.'</div>';
    $html .= '</div>';
    
    echo wp_kses_post( $html );
}