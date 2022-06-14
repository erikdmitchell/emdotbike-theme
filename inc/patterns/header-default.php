<?php
/**
 * Default header block pattern
 */
return array(
	'title'      => __( 'Default header', 'emdotbike' ),
	'categories' => array( 'header' ),
	'blockTypes' => array( 'core/template-part/header' ),
	'content'    => '<!-- wp:group {"align":"full","layout":{"inherit":true}} -->
					<div class="wp-block-group">
					    <div class="site-branding">
                            <div class="wp-block-image">
                                <a href="' . home_url() . '">
                                    <figure class="aligncenter size-full is-resized"><img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/em-bike-logo.png" alt="logo" width="100"/></figure>
                                </a>
                            </div>
                        </div><!-- ./site-branding -->
                        <nav id="site-navigation" class="main-navigation">
                        
                        
<!-- wp:search {"label":"Search","showLabel":false,"placeholder":"Search","width":100,"widthUnit":"%","buttonText":"Search","buttonUseIcon":true} /-->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"latest-posts"} -->
<div class="wp-block-group latest-posts"><!-- wp:heading {"level":3} -->
<h3>Latest Articles</h3>
<!-- /wp:heading -->

<!-- wp:latest-posts /--></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p><a href="http://bike.test/blog/" data-type="page" data-id="703">More Articles</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"connect-social"} -->
<div class="wp-block-group connect-social"><!-- wp:heading {"level":3} -->
<h3>Connect With Me</h3>
<!-- /wp:heading -->

<!-- wp:social-links {"iconColor":"white","iconColorValue":"#ffffff","openInNewTab":true,"className":"is-style-logos-only"} -->
<ul class="wp-block-social-links has-icon-color is-style-logos-only"><!-- wp:social-link {"service":"facebook"} /-->

<!-- wp:social-link {"service":"twitter"} /-->

<!-- wp:social-link {"service":"instagram"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->                        
                        
                        
                        </nav><!-- #site-navigation -->
                        <a class="toggle-nav" href="#"><i class="dashicons dashicons-menu-alt"></i></a>                        
                    </div><!-- /wp:group -->',
);
