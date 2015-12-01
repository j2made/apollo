// All them Vars
var gulp          = require('gulp');
var browserSync  = require('browser-sync');
var del          = require('del');
var autoprefix   = require('gulp-autoprefixer');
var changed      = require('gulp-changed');
var concat       = require('gulp-concat');
var gulpIf           = require('gulp-if');
var imagemin     = require('gulp-imagemin');
var jshint       = require('gulp-jshint');
var minifyCss    = require('gulp-minify-css');
var plumber      = require('gulp-plumber');
var gulpRev          = require('gulp-rev');
var sass         = require('gulp-sass');
var sourcemaps   = require('gulp-sourcemaps');
var ugly         = require('gulp-uglify');
var yaml         = require('gulp-yaml');
var lazypipe     = require('lazypipe');
var yargs        = require('yargs').argv;
var runSeq       = require('run-sequence');
var bowerFiles   = require('main-bower-files');
var mediaQueries = require('gulp-group-css-media-queries');
var gutil         = require('gulp-util');
var modernizr    = require('gulp-modernizr');

// Production Vars
var proBuild = yargs.production;

var args = {
  maps: !proBuild
};



// Manifest Vars
var manifest = require('asset-builder')('./assets/config/manifest.json');
var path = manifest.paths;
var globs = manifest.globs;                       ///////// CPD
var project = manifest.getProjectGlobs();         ///////// CPD
var buildSrc = proBuild ? manifest.config.shipDest : path.dist;

gutil.log(proBuild);


// Theme assets file
var assetsManifest = manifest.config.shipDest + 'assets.json';





/**
 * Config
 * ------
 * Builds a `.json` config file from a yaml file.
 */
gulp.task('config', function() {
  gulp.src('./assets/manifest.yml')
    .pipe( yaml({space: 2}) )
    .pipe(gulp.dest('./assets/config/'));
});


/**
 * Modernizr
 * ---------
 * Build a custom moderinzr file. Outputs to deps folder.
 */
gulp.task('modernizr', function() {
  gulp.src(path.source + 'scripts/*.js')
    .pipe(modernizr('modernizr-custom.js'))
    .pipe(gulp.dest(path.modernizr));
});


/**
 * Sass Lazypipe
 * Run these pipes on each dependency
 */
var lazypipe_styles = lazypipe()
  .pipe( plumber )
  .pipe( function() { return gulpIf( args.maps, sourcemaps.init ); } )
    .pipe( function() { return sass({ errLogToConsole: true }); })
    .pipe( autoprefix, {
      browsers: ['last 2 versions', 'ie 8', 'ie 9', 'android 2.3', 'android 4', 'opera 12']
    } )
  .pipe( function() { return gulpIf( args.maps, sourcemaps.write() ); })
  .pipe( function() { return gulpIf( !args.maps, minifyCss() ); })
  .pipe( function() { return gulp.dest( buildSrc + 'styles' ); })
  .pipe( function() { return browserSync.stream(); } );

/**
 * Sass
 * ----
 * Build sass files.
 */
 gulp.task('styles', function() {
  // return gulp.src(path.source + 'styles/main.scss').pipe(lazypipe_styles);
  gulp.src(path.source + 'styles/main.scss').pipe(lazypipe_styles)
 });









