<?php
require_once __DIR__ . '/class-render-magazine-grid.php';

return ( new \Emdotbike\Blocks\MagazineGrid\Renderer( $attributes ) )->render();

/*
function emdotbike_render_magazine_grid( $attributes ) {
    $first_count  = $attributes['firstPostCount'] ?? 1;
    $second_count = $attributes['secondSetCount'] ?? 2;
    $third_count  = $attributes['thirdSetCount'] ?? 2;
    $show_second  = $attributes['showSecondSet'] ?? true;
    $show_third   = $attributes['showThirdSet'] ?? true;

    // Use these vars to control your query logic and output...
    ob_start();
    include get_theme_file_path( 'template-parts/content-home-grid.php' );
    return ob_get_clean();
}
    */