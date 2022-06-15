<?php
/**
 * Grid of posts block pattern
 */
return array(
	'title'      => __( 'Grid of posts', 'emdotbike' ),
	'categories' => array( 'query' ),
	'blockTypes' => array( 'core/query' ),
	'content'    => '<!-- wp:query {"queryId":0,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"tagName":"main","displayLayout":{"type":"flex","columns":2},"layout":{"inherit":true}} -->
                    
                    <main class="wp-block-query emdb-query-grid">
                        <!-- wp:post-template {"align":"wide"} -->
                        
                        <!-- wp:group {"layout":{"inherit":true}} -->
                        <div class="wp-block-group">

                            <!-- wp:columns {"align":"wide"} -->
                            <div class="wp-block-columns alignwide">
                    
                                <!-- wp:column {"width":"50%"} -->
                                <div class="wp-block-column" style="flex-basis:50%">
                                    <!-- wp:post-featured-image {"isLink":true,"style":{"spacing":{"margin":{"top":"calc(1.75 * var(\u002d\u002dwp\u002d\u002dstyle\u002d\u002dblock-gap))"}}}} /-->
                                    '. emdotbike_theme_post_thumbnail( 'home-grid-large' ) .'
                                    <!-- wp:post-title {"isLink":true,"fontSize":"var(\u002d\u002dwp\u002d\u002dcustom\u002d\u002dtypography\u002d\u002dfont-size\u002d\u002dhuge, clamp(2.25rem, 4vw, 2.75rem))"} /-->
                                    
                                    <div class="excerpt">' . emdotbike_get_post_excerpt_by_id( get_the_id(), 55, '', ' <a href="' . get_permalink() . '">read more...</a>' ) . '</div>
                                </div><!-- /wp:column -->
                            </div><!-- /wp:columns -->
                        </div><!-- /wp:group -->
                    
                        <!-- /wp:post-template -->
                    
                    <!-- wp:query-pagination {"paginationArrow":"arrow","align":"wide","layout":{"type":"flex","justifyContent":"space-between"}} -->
                    <!-- wp:query-pagination-previous {"fontSize":"small"} /-->
                    
                    <!-- wp:query-pagination-numbers /-->
                    
                    <!-- wp:query-pagination-next {"fontSize":"small"} /-->
                    <!-- /wp:query-pagination --></main>
                    <!-- /wp:query -->',
);



/*
    <!-- wp:post-excerpt /-->

/*                        
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-thumb">
                <?php emdotbike_theme_post_thumbnail( 'home-grid-large' ); ?>
                </div>
                

                
                <div class="entry-excerpt">
                    <div class="excerpt"><?php emdotbike_post_excerpt( $post, 55, '', ' <a href="' . get_permalink() . '">read more...</a>' ); ?></div>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
    
    <?php emdotbike_theme_paging_nav(); // Previous/next post navigation. ?>

<!-- wp:pattern {"slug":"emdb/query-grid"} /-->