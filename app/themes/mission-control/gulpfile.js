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

var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');

var sass = require('gulp-sass');
var mediaQuery = require('gulp-group-css-media-queries');
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
var dest_base = config.paths.src;
var rev_name = './lib/_rev-manifest.json';
var rev_path = './lib';

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
  'js_single': dest_base + 'js/single',
  'js_vendor': dest_base + 'js/vendor',
  'img': dest_base + 'images/',
  'fonts': dest_base + 'fonts/',
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
gulp.task('clean_dist', function () {del(config.paths.dist); });



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
  .pipe( gulp.dest( dest.js_single ) )              // Ship it
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
      .pipe( $if( production, uglify() ) )
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
  var vendor_path = dest_base + 'js/vendor/';
  return gulp.src('./node_modules/jquery/dist/jquery.min.js')
    .pipe( gulp.dest( vendor_path ) )
});



/****************** REVISIONING ******************/

/**
 * REVISION CSS AND JS ASSETS
 *
 * Clean the distribution folder
 * Take all css and js files in src, revision
 * them, send them to a clean dist folder.
 *
 * This task should only be used within a `sequence` task.
 * Run `build_dest` if you need to revision anything.
 */
gulp.task('build_rev', ['clean_dist'], function () {
  if(production) {
    var cssPath = config.paths.src + '**/*.css';
    var jsPath = config.paths.src + '**/*.js';

    return gulp.src([cssPath, jsPath])
      .pipe(rev())
      .pipe(gulp.dest(config.paths.dist))
      .pipe(rev.manifest('_rev-manifest.json'))
      .pipe(gulp.dest('./lib'));
  }
});



/****************** IMAGES ******************/

/**
 * IMAGE TASK
 *
 * Process images in src folder, move to dist folder
 */
gulp.task('build_images', function () {
  return gulp.src( base.img )
    .pipe(imagemin({
      progressive: true,
      svgoPlugins: [
          {removeViewBox: false},
          {cleanupIDs: false}
      ],
      use: [pngquant()]
    }))
    .pipe(gulp.dest(config.paths.dist + 'images'));
});





/****************** FONTS ******************/


/**
 * FONT TASK
 *
 * Copy images to dist folder so the ship
 */
gulp.task('copy_fonts', function () {
  return gulp.src( base.fonts )
    .pipe(gulp.dest(config.paths.dist + 'fonts/'));
});



/****************** BUILD DIST ******************/

/**
 * BUILD DIST
 *
 * Revision assets, then run images and fonts.
 */
gulp.task('build_dist', sequence(
  'build_rev',
  'build_images',
  'copy_fonts'
));


/****************** DEFAULTS ******************/

/**
 * DEFAULT TASK
 *
 * Start the whole show. Run to start a project up.
 */
gulp.task('default', sequence(
  'copy_static',
  'build_sass',
  'build_bundle',
  'build_single_js',
  'build_dist'
));



/****************** BROWSERSYNC ******************/


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
  gulp.watch([base.fonts], ['copy_fonts']);
  gulp.watch([base.img], ['build_images']);
  gulp.watch('**/*.php', ['watch_reload']);
  gulp.watch('**/*.html', ['watch_reload']);
});


