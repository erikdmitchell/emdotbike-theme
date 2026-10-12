# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

The WordPress block theme for ErikMitchell.bike (text domain `emdotbike`, function prefixes `emdotbike_` and `emdb_`). It runs inside a Local by Flywheel site (`~/LocalSites/bike`), and this directory is the theme the local site loads. The theme depends on two plugins in `../../plugins/`:

- `advanced-custom-fields-pro` registers the `acf/*` blocks.
- `digiwatt-blocks` provides the `dwb/*` blocks, such as `dwb/post-header`, and has its own CLAUDE.md.

## Commands

```sh
npm start              # wp-scripts watch build (unminified, with source maps)
npm run build          # wp-scripts production build (minified); commit this output, not npm start's
npm run zip            # emdotbike.zip from the package.json "files" list (run build first)
npm run lint:js        # eslint on src/ (add -- --fix to auto-fix)
npm run lint:scss      # stylelint src/sass (lint:scss:fix to auto-fix); has ~160 known findings

composer phpcs         # WPCS 3 + PHPCompatibilityWP via phpcs.ruleset.xml (phpcbf to auto-fix); ~85 known errors
composer phpstan       # phpstan 2, level 6, ACF via php-stubs/acf-pro-stubs; ~37 known errors
```

There are no tests. Both PHP linters skip `vendor/`, `build/`, and the vendored `inc/acf-post-type-selector/`. The linters have existing findings, so compare counts before and after a change rather than expecting a clean run.

## Build layout

- `webpack.config.js` extends the wp-scripts config with two entry points:
  - `src/index.js` imports `src/sass/style.scss` and `src/blocks/*`, and outputs `build/index.js` and `build/style-index.css`.
  - `src/js/emdotbike.js` outputs `assets/js/emdotbike.js` through a filename override.
- Compiled output in `build/` and `assets/js/` is committed. Rebuild after editing `src/`, and commit the output with the change.
- The root `style.css` is only the theme header (Theme Name, Version, …); the actual front-end CSS is `build/style-index.css`. Keep the version in sync across `style.css`, `package.json`, `README.md`, and `CHANGELOG.md`. At runtime, `EMDOTBIKE_VERSION` is read from the theme header and used to cache-bust enqueued assets.
- There is no separate editor stylesheet. `build/style-index.css` is enqueued on `enqueue_block_assets`, so it styles both the front end and the editor. `assets/css/login.css` is hand-written (no source in `src/`).
- When adding a top-level file or folder the theme needs at runtime, add it to `files` in `package.json` too, or it won't be in the zip.
- SCSS uses `@use` (not `@import`). Shared partials go through `src/sass/global.scss`.
- PHP style: 4-space indentation, no tabs (this overrides the WPCS default), PHP 7.1+ compatibility.

## Architecture

The front end renders through the block templates (`templates/*.html`, `parts/*.html`) styled by `theme.json`. The classic PHP templates (`front-page.php`, `home.php`, `index.php`, `template-parts/`) are legacy.

The theme uses three kinds of blocks and patterns, each registered differently:

1. **`emdotbike/magazine-grid`**: a native dynamic block.
   - Editor code is in `src/blocks/magazine-grid/`, and metadata is in `blocks/magazine-grid/block.json`.
   - `emdb_register_blocks()` registers it from block.json, and block.json's `render.php` echoes the output of `class-render-magazine-grid.php` (namespace `Emdotbike\Blocks\MagazineGrid`).
   - `build/style-index.css` loads on `enqueue_block_assets` (front end and editor). `build/index.js`, the editor bundle, loads only on `enqueue_block_editor_assets`. Don't move it back, because it pulls in React and the block-editor packages.
2. **`acf/*` blocks** (`archive-title`, `author-bio`, `page-nav`, `post-nav`, `posts-grid`, `tagline`).
   - `emdb_init_block_types()` registers them on `acf/init`, with render templates in `templates/blocks/<name>.php`.
   - Their field groups live in the ACF database (the field keys appear in the block markup in `templates/*.html`), not in this repo.
   - `posts-grid.php` depends on the grid helpers `emdb_parse_grid_order()`, `emdb_begin_column()`, and `emdb_end_column()`.
   - `inc/acf-post-type-selector/` is a vendored ACF field type used by these blocks' fields.
3. **`emdb/*` block patterns**.
   - `inc/block-patterns.php` registers each pattern from `inc/patterns/<name>.php`, which returns a pattern array. The list is filterable via `emdb_block_patterns` and `emdb_block_pattern_categories`.
   - `parts/header.html` is just the `emdb/header-default` pattern.

Everything else lives in `functions.php`:

- theme supports and the `primary` nav menu
- custom image sizes (`home-grid*`, `posts-grid`, `single`, `navbar-logo`), which templates and blocks reference by name
- two sidebars (`emdb-footer-sidebar`, `emdb-nav-sidebar`)
- login page customization
- template-tag helpers (`emdotbike_theme_post_thumbnail`, `emdotbike_theme_paging_nav`, `emdotbike_post_excerpt`, …)

`emdb_has_header_block()` checks for `dwb/post-header`. The single-post header falls back to the theme's own version only when that block is absent.

## History worth knowing

The `release/0.3.0` merge into `main` (`3801f18`, 2023) dropped about 290 lines from `functions.php`, including the ACF block registration that the templates rely on. If something referenced by a template or block seems to be missing, check `git show f394e64:functions.php`, the pre-merge version, before rewriting it.
