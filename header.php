<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header id="masthead" class="site-header clearfix">
        <div class="site-branding">
            <?php emdotbike_theme_navbar_brand(); ?>
        </div><!-- .site-branding -->

        <nav id="site-navigation" class="main-navigation">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'menu_id' => 'primary-menu',
                )
            );
            ?>
        </nav><!-- #site-navigation -->
        <a class="toggle-nav" href="#"><i class="fas fa-bars"></i></a>
    </header><!-- #masthead -->
    
    






