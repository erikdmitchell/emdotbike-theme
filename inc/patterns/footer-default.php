<?php
/**
 * Default footer block pattern
 *
 * Latest articles, social links and the copyright line (current year).
 *
 * @package EMdotBike
 */

return array(
    'title'      => __( 'Default footer', 'emdotbike' ),
    'categories' => array( 'footer' ),
    'blockTypes' => array( 'core/template-part/footer' ),
    'content'    => '<!-- wp:group {"className":"site-footer"} -->
<div class="wp-block-group site-footer">
    <!-- wp:group {"className":"emdb-footer-wrapper"} -->
    <div class="wp-block-group emdb-footer-wrapper">
        <!-- wp:columns -->
        <div class="wp-block-columns">
            <!-- wp:column -->
            <div class="wp-block-column">
                <!-- wp:heading {"level":3} -->
                <h3 class="wp-block-heading">' . esc_html__( 'Latest Articles', 'emdotbike' ) . '</h3>
                <!-- /wp:heading -->

                <!-- wp:latest-posts /-->
            </div>
            <!-- /wp:column -->

            <!-- wp:column -->
            <div class="wp-block-column"></div>
            <!-- /wp:column -->

            <!-- wp:column -->
            <div class="wp-block-column">
                <!-- wp:group {"className":"connect-social"} -->
                <div class="wp-block-group connect-social">
                    <!-- wp:heading {"level":3} -->
                    <h3 class="wp-block-heading">' . esc_html__( 'Connect with Me', 'emdotbike' ) . '</h3>
                    <!-- /wp:heading -->

                    <!-- wp:social-links {"iconColor":"white","iconColorValue":"#ffffff","openInNewTab":true,"className":"is-style-logos-only"} -->
                    <ul class="wp-block-social-links has-icon-color is-style-logos-only">
                        <!-- wp:social-link {"url":"https://facebook.com/erikdmitchell","service":"facebook"} /-->
                        <!-- wp:social-link {"url":"https://twitter.com/erikdmitchell","service":"twitter"} /-->
                        <!-- wp:social-link {"url":"https://instagram.com/erikdmitchell","service":"instagram"} /-->
                    </ul>
                    <!-- /wp:social-links -->
                </div>
                <!-- /wp:group -->
            </div>
            <!-- /wp:column -->
        </div>
        <!-- /wp:columns -->

        <!-- wp:paragraph {"className":"copyright"} -->
        <p class="copyright">EMdotBike &copy; ' . esc_html( wp_date( 'Y' ) ) . '</p>
        <!-- /wp:paragraph -->
    </div>
    <!-- /wp:group -->
</div>
<!-- /wp:group -->',
);
