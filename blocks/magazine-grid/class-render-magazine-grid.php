<?php
namespace Emdotbike\Blocks\MagazineGrid;

class Renderer {
	protected $attributes;

	public function __construct( $attributes = [] ) {
		$this->attributes = wp_parse_args( $attributes, [
			'firstPostCount'  => 1,
			'secondSetCount'  => 2,
			'thirdSetCount'   => 2,
			'showSecondSet'   => true,
			'showThirdSet'    => true,
		] );
	}

    public function render() {
        $first_count  = isset( $this->attributes['firstPostCount'] ) ? (int) $this->attributes['firstPostCount'] : 1;
        $second_count = isset( $this->attributes['secondSetCount'] ) ? (int) $this->attributes['secondSetCount'] : 2;
        $third_count  = isset( $this->attributes['thirdSetCount'] ) ? (int) $this->attributes['thirdSetCount'] : 2;
        $show_second  = ! empty( $this->attributes['showSecondSet'] );
        $show_third   = ! empty( $this->attributes['showThirdSet'] );

        $first_post = get_posts([
            'posts_per_page' => $first_count,
            'post_status'    => 'publish',
        ]);

        $second_set_posts = $show_second
            ? get_posts([
                'posts_per_page' => $second_count,
                'offset'         => $first_count,
                'post_status'    => 'publish',
            ])
            : [];

        $third_set_posts = $show_third
            ? get_posts([
                'posts_per_page' => $third_count,
                'offset'         => $first_count + $second_count,
                'post_status'    => 'publish',
            ])
            : [];

        ob_start();
        ?>
        <div class="mag-grid">
            <?php if ( ! empty( $first_post ) && isset( $first_post[0] ) ) : ?>
                <div class="first-col">
                    <h2><?php echo esc_html( get_the_title( $first_post[0] ) ); ?></h2>
                </div>
            <?php endif; ?>

            <?php if ( $show_second && ! empty( $second_set_posts ) ) : ?>
                <div class="second-col">
                    <?php foreach ( $second_set_posts as $post ) : ?>
                        <h3><?php echo esc_html( get_the_title( $post ) ); ?></h3>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ( $show_third && ! empty( $third_set_posts ) ) : ?>
                <div class="third-col">
                    <?php foreach ( $third_set_posts as $post ) : ?>
                        <h3><?php echo esc_html( get_the_title( $post ) ); ?></h3>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php

        return ob_get_clean();
    }
}
/*
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
*/