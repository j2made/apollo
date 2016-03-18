/** NPM Modules */
var gulp = require('gulp');
var gutil = require('gulp-util');
var config = require('./assets/config.json');
var node_path = require('path');
var foreach = require('gulp-foreach');
var plumber = require('gulp-plumber');
var $if  = require('gulp-if');
var argv = require('yargs').argv;
var rename = require('gulp-rename');

var maps = require('gulp-sourcemaps');
var changed = require('gulp-changed');
var sequence = require('gulp-sequence');

var sass = require('gulp-sass');
var mediaQuery  = require('gulp-group-css-media-queries');
var nano = require('gulp-cssnano');

var uglify = require('gulp-uglify');




// Production flag
var production = argv.production;

// Paths
var enter = config.paths.enter;
var dest_base = production ? config.paths.dist : config.paths.src;

// Enter paths for file types
var base = {
  'sass': enter + 'sass/main/*.scss',
  'js': {
    'single': enter + 'js/single/*.js',
    'main': enter + 'js/main.js',
    'modules': enter + 'js/modules'
  }
}

// Destination paths for file types
var dest = {
  'css': dest_base + 'css/',
  'js': dest_base + 'js/'
};



/**
 * SASS TASK
 *
 * Runs foreach on every file in 'sass/main'
 */
gulp.task('build_sass', function() {
  gulp.src( base.sass )
    .pipe(foreach( function(stream, file) {
      // Get base file name, rename it to `.min.css`
      var name = node_path.basename(file.path, '.scss') + '.min.css';

      return stream
        .pipe( $if( !production, plumber() ) )
        .pipe( changed( dest.css) )                     // Only run on changed files
        .pipe( $if( !production, maps.init() ) )        // If no production flag, generate maps
          .pipe(sass().on('error', sass.logError))      // Compile sass
          .pipe( $if( production, mediaQuery() ) )      // Reorg media queries
          .pipe(nano({ autoprefixer: { add: true } }))  // Shrink that css
          .pipe(rename(name))                           // Rename
        .pipe( $if( !production, maps.write('.') ) );   // If no production flag, write maps
    }) )
    .pipe( gulp.dest( dest.css ) );                     // Ship it
});





/**
 * LINT TASK
 *
 * Run js through the linter
 */



/**
 * BROWSERIFY TASK
 *
 *
 */


/**
 * JS TASK
 *
 * For non browserified files saved in `single`
 */
gulp.task('build_single_js', function(){
  gulp.src( base.js.single )
    .pipe(foreach( function(stream, file) {
      // Get base file name, rename it to `.min.css`
      var name = node_path.basename(file.path, '.js') + '.min.js';

      return stream
        .pipe( $if( !production, plumber() ) )
        .pipe( $if( !production, maps.init() ) )      // If no production flag, generate maps
          .pipe( changed( dest.js) )                  // Only run on changed files
          .pipe( uglify() )
        .pipe( $if( !production, maps.write('.') ) );   // If no production flag, write maps

    }) )
  .pipe( gulp.dest( dest.css ) );                     // Ship it
});





/**
 * COPY JQUERY
 *
 * Copy jQuery for local fallback
 */
gulp.task('copy_jquery', function() {
  return gulp.src('./node_modules/jquery/dist/jquery.min.js')
    .pipe( gulp.dest( dest.js ) );
});





/**
 * BUILD TASK
 *
 * Start the whole show. Run to start a project up.
 */
gulp.task('build', sequence(
  'copy_jquery',
  'build_sass',

);


