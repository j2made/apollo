/**
 * Install Watchify globally:
 * npm install -g watchify         ????????
 *
 *
 */



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
var del = require('del');

var maps = require('gulp-sourcemaps');
var changed = require('gulp-changed');
var sequence = require('gulp-sequence');
var rev = require('gulp-rev');

var sass = require('gulp-sass');
var mediaQuery  = require('gulp-group-css-media-queries');
var nano = require('gulp-cssnano');

var jshint = require('gulp-jshint');
var uglify = require('gulp-uglify');
var buffer = require('vinyl-buffer');
var source = require('vinyl-source-stream');
var assign = require('lodash.assign');
var watchify = require('watchify');
var browserify = require('browserify');
var browsersync = require('browser-sync');


// Production flag
var production = argv.production;

// Paths
var enter = config.paths.enter;
var dest_base = production ? config.paths.dist : config.paths.src;

// Enter paths for file types
var base = {
  'img':      enter + 'images/**/*',
  'fonts':    enter + 'fonts/**/*',
  'sass':     enter + 'sass',
  'sassMain': enter + 'sass/main/*.scss',
  'js': {
    'single':  enter + 'js/single/*.js',
    'main':    enter + 'js/main.js',
    'modules': enter + 'js/modules'
  }
}

// Destination paths for file types
var dest = {
  'css': dest_base + 'css/',
  'js': dest_base + 'js/',
  'img': dest_base + 'images/',
  'fonts': dest_base + 'fonts/'
};




/**
 * CLEAN TASKS
 *
 * Remove css files in distribution directory
 * Remove js files in distribution directory
 */
gulp.task('clean_css', function () { del(dest.css); });
gulp.task('clean_js', function () { del(dest.js); });
gulp.task('clean_img', function () { del(dest.img); });
gulp.task('clean_fonts', function () { del(dest.img); });
gulp.task('clean_dest', function () { del(dest_base); });



/****************** SASS AND CSS ******************/

/**
 * SASS TASK
 *
 * Runs foreach on every file in 'sass/main'
 */
gulp.task('build_sass', function() {
  gulp.src( base.sassMain )
    .pipe(foreach( function(stream, file) {
      // Get base file name, rename it based on argv
      var namebase = node_path.basename(file.path, '.scss');
      var name = production ? namebase + '.min.css' : namebase + '.css';

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
    .pipe( gulp.dest( dest.css ) )                      // Ship it
    .pipe( browsersync.stream() );                      // Beam it to browsersync
});




/****************** JS ******************/


/**
 * LINT TASKS
 *
 * Run single js through the linter
 * Run main browserify file through the linter
 */
gulp.task('lint_single', function(){
  return gulp.src( base.js.single )
    .pipe( jshint() )
    .pipe( jshint.reporter('jshint-stylish-source') );
});

gulp.task('lint_bundle', function(){
  return gulp.src([
    base.js.main, base.js.modules + '/**/*.js'
  ])
    .pipe( jshint() )
    .pipe( jshint.reporter('jshint-stylish-source') );
});





/**
 * SINGLE JS TASK
 *
 * For non browserified files saved in `single`
 */
gulp.task('build_single_js', ['lint_single'], function(){
  gulp.src( base.js.single )
    .pipe(foreach( function(stream, file) {
      // Get base file name, rename it based on argv
      var namebase = node_path.basename(file.path, '.js');
      var name = production ? namebase + '.min.js' : namebase + '.js';

      return stream
        .pipe( $if( !production, plumber() ) )
        .pipe( changed( dest.js) )                  // Only run on changed files
        .pipe( uglify() )
    }) )
  .pipe( gulp.dest( dest.js ) )                      // Ship it
  .pipe( browsersync.reload({stream: true}) );
});





/****************** JS: BROWSERIFY ******************/


/**
 * Browserify Bundler
 */
var b = function() {
  return browserify({
    entries: base.js.main,
    debug: true,
    cache: {},
    paths: ['./node_modules', base.js.modules]
  });
};

/**
 * Watchify Bundler
 */
var w = watchify(b());

/**
 * Process Bundler
 */
function bundle(pkg) {
  return pkg.bundle()
    .on('error', gutil.log.bind(gutil, 'Browserify Error'))
    .pipe( source('bundle.js') )
    .pipe( buffer() )
    .pipe( $if( !production, plumber() ) )
    .pipe( $if( !production, maps.init( {loadMaps: true} ) ) )
    .pipe( $if( !production, maps.write('.') ) )
    .pipe( gulp.dest(dest.js) )
    .pipe( browsersync.stream( {once: true} ) );
}

/**
 * Bundle Tasks
 *
 * Build bundle (once and done)
 * Watch bundle (enable watchify)
 */
gulp.task('build_bundle', function() { bundle(b()) });

gulp.task('watch_bundle', function() {
  bundle(w);
  w.on('update', bundle.bind(null, w) );
  w.on('log', gutil.log);
});




/**
 * COPY STATIC FILES
 *
 * Copy jQuery for local fallback
 */
gulp.task('copy_static', function() {
  return gulp.src('./node_modules/jquery/dist/jquery.min.js')
    .pipe( gulp.dest( config.paths.dist + 'js/' ) );
});





/****************** BROWSERSYNC ******************/

// Watchify, single.js, css, php, html

/**
 * Watch Tasks
 *
 */
gulp.task('watch_js', ['build_single_js'], browsersync.reload);
gulp.task('watch_reload', function(){ browsersync.reload(); });

/**
 * SERVE TASK
 *
 * Initialize browsersync
 * Watch for file changes
 */
gulp.task('serve', ['watch_bundle'], function(){
  browsersync({
    proxy: config.devUrl
  });

  // Watch tasks
  gulp.watch([base.sass + '/**/*.scss'], ['build_sass']);
  gulp.watch([base.js.single], ['build_single_js']);
  // // gulp.watch([base.fonts], ['fonts']);
  // // gulp.watch([base.img], ['images']);
  gulp.watch('**/*.php', ['watch_reload']);
  gulp.watch('**/*.html', ['watch_reload']);
});


/**
 * BUILD TASK
 *
 * Start the whole show. Run to start a project up.
 */
gulp.task('default', sequence(
  'clean_dest',
  'copy_static',
  'build_sass',
  'build_bundle',
  'build_single_js'
));



/**
 * TK TODO:
 *
 * Build
 * Default
 * Images/SVG
 * Fonts
 *
 * Improve Comments
 */
