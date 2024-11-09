<header class="legacy-entry-header">  
    <div class="featured-columns">
        <div class="featured-column"> 
            <div class="header-content"> 
                <div class="title">
                    <?php
                    if ( is_single() ) :
                        the_title( '<h1 class="entry-title">', '</h1>' );
                    else :
                        the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
                    endif;
                    ?>
                        
                </div>
                <div class="meta">
                    <?php
                    if ( 'post' == get_post_type() ) {
                        emdotbike_theme_posted_on();
                    }
                    ?>
                </div>
            </div>              
        </div>
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="featured-column">
                <?php emdotbike_theme_post_thumbnail( 'single' ); ?>
        <?php else : ?>
            <div class="featured-column no-thumb">
        <?php endif; ?>
            
        </div>
    </div>
</header>
