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
		$first_count  = $this->attributes['firstPostCount'];
		$second_count = $this->attributes['secondSetCount'];
		$third_count  = $this->attributes['thirdSetCount'];
		$show_second  = $this->attributes['showSecondSet'];
		$show_third   = $this->attributes['showThirdSet'];

		$first_post = get_posts([
			'posts_per_page' => $first_count,
		]);

		$second_set_posts = $show_second
			? get_posts([ 'posts_per_page' => $second_count, 'offset' => $first_count ])
			: [];

		$third_set_posts = $show_third
			? get_posts([ 'posts_per_page' => $third_count, 'offset' => $first_count + $second_count ])
			: [];

		ob_start();
		?>
		<div class="magazine-grid-wrapper">
			<?php if ( ! empty( $first_post ) ) : ?>
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