<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-RWPQXY8T2F"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        
        gtag('config', 'G-RWPQXY8T2F');
    </script>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header id="masthead" class="site-header clearfix">
        <div class="site-branding">
            <img src="<?php echo get_template_directory_uri(); ?>/images/em-bike-logo.png" width="100" alt="logo" />
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
    
    






