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

JS (ESLint, WordPress config) `npm run lint:js:src`

SCSS (stylelint) `npm run lint:scss`, auto-fix `npm run lint:scss:fix`

PHP Code Sniffer `composer phpcs`

PHP Code Beautifier `composer phpcbf`

PHPStan `composer phpstan`

## Distribution

Create `emdotbike.zip` (contents set by `files` in `package.json`) `npm run build && npm run zip`
