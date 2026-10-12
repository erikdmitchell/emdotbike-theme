<?php
/**
 * Magazine Grid block render (see block.json "render").
 *
 * @package EMdotBike
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/class-renderer.php';

echo ( new \Emdotbike\Blocks\MagazineGrid\Renderer( $attributes ) )->render(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- block markup from the renderer.
