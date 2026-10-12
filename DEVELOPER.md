# Developer Doc

This is a guide to the various scripts and functionality that can be used to compile and build out the theme.

## Build

Styles and scripts are compiled with `@wordpress/scripts` (webpack, see `webpack.config.js`).

Watch and compile (development) `npm start`

Compile (production, minified) `npm run build`

Entry points:

* `src/index.js` imports `src/sass/style.scss` and the blocks in `src/blocks/`, and outputs `build/index.js` and `build/style-index.css`
* `src/js/emdotbike.js` outputs `assets/js/emdotbike.js`

## Linting

JS (ESLint, WordPress config) `npm run lint:js`

SCSS (stylelint) `npm run lint:scss`, auto-fix `npm run lint:scss:fix`

PHP Code Sniffer `composer phpcs`

PHP Code Beautifier `composer phpcbf`

PHPStan `composer phpstan`

## Releases

Releases are automated with release-please (`.github/workflows/release.yml`). Use [Conventional Commits](https://www.conventionalcommits.org/) for PR titles (`feat:`, `fix:`, `chore:`, ...); PRs are squash-merged, so the title becomes the commit on `main`. Each `feat`/`fix` merged to `main` cuts a release, tags it (e.g. `0.4.0`), and attaches `emdotbike.zip`. Sites running the theme pick up the update through plugin-update-checker.

Files left out of the zip are listed as `export-ignore` in `.gitattributes`.
