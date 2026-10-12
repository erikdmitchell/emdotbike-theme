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
npm run lint:js        # eslint on src/ (add -- --fix to auto-fix)
npm run lint:scss      # stylelint src/sass (lint:scss:fix to auto-fix); has ~160 known findings

composer phpcs         # WPCS 3 + PHPCompatibilityWP via phpcs.ruleset.xml (phpcbf to auto-fix); runs clean
composer phpstan       # phpstan 2, level 6, ACF via php-stubs/acf-pro-stubs; runs clean
```

There are no tests. Both PHP linters skip `vendor/`, `build/`, and the vendored `inc/acf-post-type-selector/`. stylelint has existing findings, so compare its count before and after a change rather than expecting a clean run.

## Build layout

- `webpack.config.js` extends the wp-scripts config with two entry points:
  - `src/index.js` imports `src/sass/style.scss` and `src/blocks/*`, and outputs `build/index.js` and `build/style-index.css`.
  - `src/js/emdotbike.js` outputs `assets/js/emdotbike.js` through a filename override.
- Compiled output in `build/` and `assets/js/` is committed. Rebuild after editing `src/`, and commit the output with the change.
- The root `style.css` is only the theme header (Theme Name, Version, …); the actual front-end CSS is `build/style-index.css`. Don't bump the version by hand (see Releases). At runtime, `EMDOTBIKE_VERSION` is read from the theme header and used to cache-bust enqueued assets.
- There is no separate editor stylesheet. `build/style-index.css` is enqueued on `enqueue_block_assets`, so it styles both the front end and the editor. `assets/css/login.css` is hand-written (no source in `src/`).
- Anything tracked in git ships in the release zip unless it's marked `export-ignore` in `.gitattributes`. Add dev-only top-level files there.
- SCSS uses `@use` (not `@import`). Shared partials go through `src/sass/global.scss`.
- PHP style: 4-space indentation, no tabs (this overrides the WPCS default), PHP 7.1+ compatibility.

## Releases

Commits and PR titles use [Conventional Commits](https://www.conventionalcommits.org/) (`feat:`, `fix:`, `chore:`, ...). PRs are squash-merged, so the PR title becomes the commit on `main`; `.github/workflows/pr-title.yml` checks it.

Releases are automated by release-please (`.github/workflows/release.yml`), the same setup as digiwatt-blocks. Each push to `main` opens a release PR, the workflow merges it straight away, then tags the release (no `v` prefix, e.g. `0.4.0`) and attaches `emdotbike.zip`. Only `feat`, `fix`, and breaking changes trigger a release; while below 1.0, `feat` and breaking changes bump the minor version. Don't bump versions or edit `CHANGELOG.md` by hand: release-please updates `package.json`/`package-lock.json` and the lines marked `x-release-please-version` in `style.css` and `README.md`. The zip is `git archive` of the tag (top-level folder `emdotbike/`) plus a `composer install --no-dev` `vendor/`. It needs that `vendor/` for plugin-update-checker, which `functions.php` loads to update installed sites from the release zip.

## Architecture

The front end renders through the block templates (`templates/*.html`, `parts/*.html`) styled by `theme.json`. The classic PHP templates (`front-page.php`, `home.php`, `index.php`, `template-parts/`) are legacy.

The theme uses three kinds of blocks and patterns, each registered differently:

1. **`emdotbike/magazine-grid`**: a native dynamic block.
   - Editor code is in `src/blocks/magazine-grid/`, and metadata is in `blocks/magazine-grid/block.json`.
   - `emdb_register_blocks()` registers it from block.json, and block.json's `render.php` echoes the output of `class-renderer.php` (namespace `Emdotbike\Blocks\MagazineGrid`).
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
