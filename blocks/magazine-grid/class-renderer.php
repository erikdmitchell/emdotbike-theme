<?php
/**
 * Magazine Grid block renderer.
 *
 * @package EMdotBike
 */

namespace Emdotbike\Blocks\MagazineGrid;

/**
 * Renders the emdotbike/magazine-grid block.
 */
class Renderer {
    /**
     * Block attributes, merged with defaults.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Constructor.
     *
     * @param array $attributes Block attributes.
     */
    public function __construct( $attributes = array() ) {
        $this->attributes = wp_parse_args(
            $attributes,
            array(
                'postCount' => 4,
                'postType'  => 'post',
            )
        );
    }

    /**
     * Render the block markup.
     *
     * @return string
     */
    public function render() {
        $wrapper_attributes = get_block_wrapper_attributes();
        $post_count         = isset( $this->attributes['postCount'] ) ? (int) $this->attributes['postCount'] : 4;
        $post_type          = isset( $this->attributes['postType'] ) ? $this->attributes['postType'] : 'post';

        $posts = get_posts(
            array(
                'posts_per_page' => $post_count,
                'post_type'      => $post_type,
                'post_status'    => 'publish',
            )
        );

        ob_start();
        ?>
        <div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() escapes its output. ?>>
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

                    <div class="mag-grid-post mag-post-<?php echo (int) $key; ?>">
                        <div class="<?php echo esc_attr( $classes ); ?>"><?php emdotbike_theme_post_thumbnail_custom( $post, $image_size ); ?></div>
                        <div class="mag-post-title"><h2><a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"><?php echo esc_html( get_the_title( $post ) ); ?></a></h2></div>
                        <div class="mag-post-excerpt"><?php emdotbike_post_excerpt( $post->ID, $excerpt_length, '', ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '">read more...</a>' ); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }
}