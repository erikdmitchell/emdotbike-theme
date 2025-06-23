// Project configuration
const buildInclude = [
	// include common file types
	'**/*.php',
	'**/*.html',
	'**/*.css',
	'**/*.js',
	'**/*.svg',
	'**/*.ttf',
	'**/*.otf',
	'**/*.eot',
	'**/*.woff',
	'**/*.woff2',
	'**/*.png',
	'**/*.jpg',

	// include specific files and folders
	// 'screenshot.png',
	// 'readme.txt',

	// exclude files and folders
	'!./composer.json',
	'!./composer.lock',
	'!./gulpfile.js',
	'!./{node_modules,node_modules/**/*}',
	'!./package.json',
	'!./phpcs.ruleset.xml',
	'!./{sass,sass/**/*}',
	'!./src/**/*',
	'!./.stylelintrc',
	'!./{vendor,vendor/**/*}',
	'!svn/**',
];

// const cssInclude = [
// 	// include css
// 	'**/*.css',

// 	// exclude files and folders
// 	'!**/*.min.css',
// 	'!node_modules/**/*',
// 	'!style.css',
// 	'!inc/css/*',
// 	'!vendor/**',
// ];

const jsInclude = [
	// include js
	'**/*.js',

	// exclude files and folders
	'!**/*.min.js',
	'!./src/blocks/**/*.js',
	'!./src/index.js',
	'!src/js/**/*.js',
	'!node_modules/**/*',
	'!vendor/**',
	'!**/gulpfile.js',
	'!inc/js/html5shiv.js',
	'!inc/js/respond.js',
	'!./webpack.config.js',
];

// const sassFolder = './src/sass/**/*.scss';
// const cssFolder = './assets/css/';
const jsSrcFolder = './src/js/*.js';
// const jsSrcFolderWatch = './assets/src/js/**/*.js';
const jsFolder = './assets/js/';

// Load plugins
const gulp = require('gulp'),
	autoprefixer = require('gulp-autoprefixer'), // Autoprefixing magic
	concat = require('gulp-concat'),
	// gulpsass = require('gulp-sass')(require('sass')),
	gzip = require('gulp-zip'),
	// minifycss = require('gulp-uglifycss'),
	plumber = require('gulp-plumber'), // Helps prevent stream crashing on errors
	rename = require('gulp-rename'),
	sourcemaps = require('gulp-sourcemaps'),
	uglify = require('gulp-uglify');

/**
 * Styles
 */

// Compile SASS.
// function compileSass() {
// 	return gulp
// 		.src(['./src/sass/style.scss'])
// 		.pipe(plumber())
// 		.pipe(sourcemaps.init())
// 		.pipe(
// 			gulpsass({
// 				outputStyle: 'expanded',
// 			})
// 		)
// 		.pipe(
// 			autoprefixer({
// 				overrideBrowserslist: [
// 					'last 2 versions',
// 					'> 1%',
// 					'safari 5',
// 					'ie 8',
// 					'ie 9',
// 					'opera 12.1',
// 					'ios 6',
// 					'android 4',
// 				],
// 				cascade: false,
// 			})
// 		)
// 		.pipe(sourcemaps.write('.'))
// 		.pipe(plumber.stop())
// 		.pipe(gulp.dest('./'));
// }

// function compileEditorSass() {
// 	return gulp
// 		.src(['./src/sass/editor.scss'])
// 		.pipe(
// 			gulpsass({
// 				outputStyle: 'expanded',
// 			})
// 		)
// 		.pipe(
// 			autoprefixer({
// 				overrideBrowserslist: [
// 					'last 2 versions',
// 					'> 1%',
// 					'safari 5',
// 					'ie 8',
// 					'ie 9',
// 					'opera 12.1',
// 					'ios 6',
// 					'android 4',
// 				],
// 				cascade: false,
// 			})
// 		)
// 		.pipe(gulp.dest('./assets/css'));
// }

// minify all css
// function mincss() {
// 	return gulp
// 		.src(cssInclude)
// 		.pipe(plumber())
// 		.pipe(sourcemaps.init())
// 		.pipe(
// 			sourcemaps.write({
// 				includeContent: false,
// 			})
// 		)
// 		.pipe(
// 			sourcemaps.init({
// 				loadMaps: true,
// 			})
// 		)
// 		.pipe(sourcemaps.write('.'))
// 		.pipe(plumber.stop())
// 		.pipe(
// 			rename({
// 				suffix: '.min',
// 			})
// 		)
// 		.pipe(
// 			minifycss({
// 				maxLineLen: 80,
// 			})
// 		)
// 		.pipe(gulp.dest('./'));
// }

/**
 * Scripts
 */

// min all js files
function scripts() {
	return gulp
		.src(jsInclude)
		.pipe(
			rename({
				suffix: '.min',
			})
		)
		.pipe(uglify())
		.pipe(gulp.dest('./'));
}

// compile all single js files in src folder.
function jsSrcCompile() {
	return gulp
		.src(jsSrcFolder)
		.pipe(gulp.dest(jsFolder))
		.pipe(
			rename({
				suffix: '.min',
			})
		)
		.pipe(uglify())
		.pipe(gulp.dest(jsFolder));
}

/**
 * General
 */

// Watch files
function watchFiles() {
	// gulp.watch('./sass/**/*', gulp.series(compileSass, compileEditorSass));
	gulp.watch('./js/**/*.js', js);
}

// gulp zip
function zip() {
	return gulp
		.src(buildInclude)
		.pipe(gzip('emdotbike.zip'))
		.pipe(gulp.dest('./../'));
}

// define complex tasks
// const styles = gulp.series(compileSass, compileEditorSass, mincss); // Styles task
const js = gulp.series(scripts, jsSrcCompile); // compile and minimize js
const build = gulp.series(styles, scripts, zip); // Package Distributable
const watch = gulp.parallel(styles, scripts, watchFiles); // Watch Task

// export tasks
// exports.sass = compileSass;
// exports.editor = compileEditorSass;
// exports.styles = gulp.series(compileSass, compileEditorSass, mincss);
// exports.js = gulp.series(scripts, jsSrcCompile);
// exports.build = gulp.series(exports.styles, exports.js, zip);
// exports.watch = gulp.parallel(exports.styles, exports.js, watchFiles);
