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
                        <nav id="site-navigation" class="main-navigation">' . get_sidebar( 'emdb-nav-sidebar' ) . '</nav><!-- #site-navigation -->
                        <a class="toggle-nav" href="#"><i class="dashicons dashicons-menu-alt"></i></a>                        
                    </div><!-- /wp:group -->',
);



/*

        <nav id="site-navigation" class="main-navigation">
            <?php dynamic_sidebar( 'emdb-nav-sidebar' ); ?>
        </nav><!-- #site-navigation -->
        <a class="toggle-nav" href="#"><i class="dashicons dashicons-menu-alt"></i></a>
*/
