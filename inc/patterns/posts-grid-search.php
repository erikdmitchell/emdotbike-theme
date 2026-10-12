<?php
/**
 * Search results posts grid block pattern
 *
 * The posts grid with the search page's "no results" message.
 *
 * @package EMdotBike
 */

return array(
    'title'      => __( 'Posts grid (search results)', 'emdotbike' ),
    'categories' => array( 'query' ),
    'blockTypes' => array( 'core/query' ),
    'inserter'   => false,
    'content'    => emdb_posts_grid_markup(
        array(
            __( 'Remember the days when your computer was fancy if it told you cadence?', 'emdotbike' ),
            __( 'Whether you made a wrong turn, got dropped, or bonked - you need a little help to find where you are going.', 'emdotbike' ),
            __( 'Like a wise old veteran racer, or that guy at the local gas station, try the search to get going again!', 'emdotbike' ),
        )
    ),
);
