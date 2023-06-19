// Project configuration
var buildInclude = [
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
        '!./.stylelintrc',
        '!./{vendor,vendor/**/*}',
        '!svn/**'
    ];

var cssInclude = [
        // include css
        '**/*.css',

        // exclude files and folders
        '!**/*.min.css',
        '!node_modules/**/*',
        '!style.css',
        '!inc/css/*',
        '!vendor/**'
    ];

var jsInclude = [
        // include js
        '**/*.js',

        // exclude files and folders
        '!**/*.min.js',
        '!node_modules/**/*',
        '!vendor/**',
        '!**/gulpfile.js',
        '!inc/js/html5shiv.js',
        '!inc/js/respond.js',
    ];

// Load plugins
const gulp     = require( 'gulp' ),
  autoprefixer = require( 'gulp-autoprefixer' ), // Autoprefixing magic
  concat       = require( 'gulp-concat' ),
  gulpsass     = require( 'gulp-sass' )( require( 'sass' ) ),
  gzip         = require( 'gulp-zip' ),
  minifycss    = require( 'gulp-uglifycss' ),
  plumber      = require( 'gulp-plumber' ), // Helps prevent stream crashing on errors
  rename       = require( 'gulp-rename' ),
  sourcemaps   = require( 'gulp-sourcemaps' ),
  uglify       = require( 'gulp-uglify' );

/**
 * Styles
 */

// compile sass
function sass(done) {
    return (
    gulp.src( './sass/*.scss' )
        .pipe( plumber() )
        .pipe( sourcemaps.init() )
        .pipe(
            gulpsass(
                {
                    errLogToConsole: true,
                    outputStyle: 'expanded',
                }
            )
        )
        .pipe(
            sourcemaps.write(
                {
                    includeContent: false
                }
            )
        )
        .pipe(
            sourcemaps.init(
                {
                    loadMaps: true
                }
            )
        )
        .pipe( autoprefixer( 'last 2 version', '> 1%', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4' ) )
        .pipe( sourcemaps.write( '.' ) )
        .pipe( plumber.stop() )
        .pipe( gulp.dest( './' ) )

    );
    done();
}

// minify all css
function mincss(done) {
    return (
    gulp.src( cssInclude )
        .pipe( plumber() )
        .pipe( sourcemaps.init() )
        .pipe(
            sourcemaps.write(
                {
                    includeContent: false
                }
            )
        )
        .pipe(
            sourcemaps.init(
                {
                    loadMaps: true
                }
            )
        )
        .pipe( sourcemaps.write( '.' ) )
        .pipe( plumber.stop() )
        .pipe(
            rename(
                {
                    suffix: '.min'
                }
            )
        )
        .pipe(
            minifycss(
                {
                    maxLineLen: 80
                }
            )
        )
        .pipe( gulp.dest( './' ) )

    );
    done();
}

/**
 * Scripts
 */

// min all js files
function scripts() {
    return (
    gulp.src( jsInclude )
    .pipe(
        rename(
            {
                suffix: '.min'
            }
        )
    )
      .pipe( uglify() )
      .pipe( gulp.dest( "./" ) )
    );
}

// js linting with JSHint.
// function lintjs(done) {
// return (
// gulp.src(jsInclude)
// .pipe(jshint())
// .pipe(jshint.reporter(stylish))
// );
// done();
// }

// make pretty
// function beautifyjs(done) {
// return (
// gulp.src(jsInclude)
// .pipe(beautify())
// .pipe(gulp.dest('./'))
// );
// done();
// }

/**/

// Watch files
function watchFiles() {
    gulp.watch( './sass/**/*', sass );
    gulp.watch( './js/**/*.js', js );
}

// gulp zip
function zip(done) {
    return (
    gulp.src( buildInclude )
        .pipe( gzip( 'emdotbike.zip' ) )
        .pipe( gulp.dest( './../' ) )
    );
    done();
}

// define complex tasks
const styles = gulp.series( sass, mincss ); // Styles task
const js     = gulp.series( scripts ); // compile and minimize js
const build  = gulp.series( styles, scripts, zip ); // Package Distributable
const watch  = gulp.parallel( styles, scripts, watchFiles ); // Watch Task

// export tasks
exports.sass   = sass;
exports.mincss = mincss;
exports.styles = styles;
exports.js     = js;
// exports.lintjs = lintjs;
// exports.beautifyjs = beautifyjs;
exports.zip   = zip;
exports.build = build;
exports.watch = watch;
