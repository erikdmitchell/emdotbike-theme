<?php
/**
 * Posts grid block pattern
 *
 * Used by the home, archive and author templates; the query inherits from
 * the page, so each one lists its own posts.
 *
 * @package EMdotBike
 */

return array(
    'title'      => __( 'Posts grid', 'emdotbike' ),
    'categories' => array( 'query' ),
    'blockTypes' => array( 'core/query' ),
    'inserter'   => false,
    'content'    => emdb_posts_grid_markup(
        array( __( 'Sorry, no posts matched your criteria.', 'emdotbike' ) )
    ),
);
