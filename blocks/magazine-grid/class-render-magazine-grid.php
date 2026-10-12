<?php
namespace Emdotbike\Blocks\MagazineGrid;

class Renderer {
	protected $attributes;

	public function __construct( $attributes = [] ) {
		$this->attributes = wp_parse_args( $attributes, [
			'postCount'  => 4,
			'postType'  => 'post',
		] );
	}

    public function render() {
        $wrapper_attributes = get_block_wrapper_attributes();        
        $post_count  = isset( $this->attributes['postCount'] ) ? (int) $this->attributes['postCount'] : 4;
        $post_type  = isset( $this->attributes['postType'] ) ? $this->attributes['postType'] : 'post';

        $posts = get_posts( [
            'posts_per_page' => $post_count,
            'post_type'      => $post_type,
            'post_status'    => 'publish',
        ] );

        ob_start();
        ?>
        <div <?php echo $wrapper_attributes; ?>>
            <div class="mag-grid">
                <?php foreach ( $posts as $key => $post ) : ?>
                    <?php
                        $classes        = 'mag-post-image';
                        $image_size     = 'home-grid';
                        $excerpt_length = 50;

                    if ( 0 === $key ) {
                        $image_size     = 'home-grid-featured';
                        $excerpt_length = 110;
                    } elseif ( 1 === $key ) {
                        $classes       .= ' tall';
                        $image_size     = 'home-grid-tall';
                        $excerpt_length = 120;
                    }
                    ?>

                    <div class="mag-grid-post mag-post-<?php echo $key; ?>">
                        <div class="<?php echo $classes; ?>"><?php emdotbike_theme_post_thumbnail_custom( $post, $image_size ); ?></div>
                        <div class="mag-post-title"><h2><a href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_the_title( $post ); ?></a></h2></div>
                        <div class="mag-post-excerpt"><?php emdotbike_post_excerpt( $post->ID, $excerpt_length, '', ' <a href="' . get_permalink( $post->ID ) . '">read more...</a>' ); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }
}