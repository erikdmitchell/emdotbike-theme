<?php
/**
 * Front page tagline banner block pattern
 *
 * White logo and the site description on a blue band, as the classic
 * front-page.php rendered it.
 *
 * @package EMdotBike
 */

return array(
    'title'      => __( 'Front page tagline', 'emdotbike' ),
    'categories' => array( 'header' ),
    'inserter'   => false,
    'content'    => '<!-- wp:html -->
<div class="front-page-tagline alignfull">
    <div class="wrapper">
        <div class="image-wrap">
            <img src="' . esc_url( get_template_directory_uri() . '/assets/images/em-bike-logo-small-white.png' ) . '" alt="' . esc_attr__( 'EMdotBike logo', 'emdotbike' ) . '" />
        </div>
        <div class="title-wrap">
            <h1>' . esc_html( get_bloginfo( 'description' ) ) . '</h1>
        </div>
    </div>
</div>
<!-- /wp:html -->',
);
