# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

The WordPress block theme for ErikMitchell.bike (text domain `emdotbike`, function prefixes `emdotbike_` and `emdb_`). It runs inside a Local by Flywheel site (`~/LocalSites/bike`), and this directory is the theme the local site loads. The theme depends on two plugins in `../../plugins/`:

- `advanced-custom-fields-pro` registers the `acf/*` blocks.
- `digiwatt-blocks` provides the `dwb/*` blocks, such as `dwb/post-header`, and has its own CLAUDE.md.

## Commands

```sh
npm start              # wp-scripts watch build (unminified; this is what's committed in build/)
npm run build          # wp-scripts production build (minified, no source maps)
npm run lint:js:src    # eslint --fix on src/
npm run lint:scss      # stylelint src/sass (lint:scss:fix to auto-fix)

composer phpcs         # WPCS via phpcs.ruleset.xml (phpcbf to auto-fix)
composer phpstan       # level 6, scans ../../plugins/advanced-custom-fields-pro
```

There are no tests. `php -l <file>` is the only PHP check that currently works. On PHP 8.4, phpcs (WPCS 2) aborts and phpstan 1.x hits a fatal error, so those tools need upgrading before they're useful. The gulp tasks are all commented out in `gulpfile.js`, including `zip`, so `npx gulp` errors.

## Build layout

- `webpack.config.js` extends the wp-scripts config with two entry points:
  - `src/index.js` imports `src/sass/style.scss` and `src/blocks/*`, and outputs `build/index.js` and `build/style-index.css`.
  - `src/js/emdotbike.js` outputs `assets/js/emdotbike.js` through a filename override.
- Compiled output in `build/` and `assets/js/` is committed. Rebuild after editing `src/`, and commit the output with the change.
- The root `style.css` is only the theme header (Theme Name, Version, …); the actual front-end CSS is `build/style-index.css`. Keep the version in sync across `style.css`, `package.json`, `README.md`, and `CHANGELOG.md`. At runtime, `EMDOTBIKE_VERSION` is read from the theme header and used to cache-bust enqueued assets.
- `assets/css/editor.css` is enqueued in the editor, but no build step produces it anymore. `src/sass/editor.scss` was compiled by the now-disabled gulp task.
- SCSS uses `@use` (not `@import`). Shared partials go through `src/sass/global.scss`.
- PHP style: 4-space indentation, no tabs (this overrides the WPCS default), PHP 7.1+ compatibility.

## Architecture

The front end renders through the block templates (`templates/*.html`, `parts/*.html`) styled by `theme.json`. The classic PHP templates (`front-page.php`, `home.php`, `index.php`, `template-parts/`) are legacy.

The theme uses three kinds of blocks and patterns, each registered differently:

1. **`emdotbike/magazine-grid`**: a native dynamic block.
   - Editor code is in `src/blocks/magazine-grid/`, and metadata is in `blocks/magazine-grid/block.json`.
   - `emdb_register_blocks()` in `functions.php` renders it through `class-render-magazine-grid.php` (namespace `Emdotbike\Blocks\MagazineGrid`). That `render_callback` takes precedence over the `render.php` named in block.json.
   - `emdb_enqueue_block_assets()` loads `build/index.js` and `build/style-index.css` on `enqueue_block_assets`, so they load in both the editor and the front end.
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
