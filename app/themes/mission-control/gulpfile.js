/**
 * CONFIGURATION VARIABLES
 *
 */
var devUrl = 'apollo.dev';



/**
 * NPM MODULES
 *
 */
var node_path = require('path');
var argv = require('yargs').argv;
var del = require('del');
var pngquant = require('imagemin-pngquant');
var buffer = require('vinyl-buffer');
var source = require('vinyl-source-stream');
var assign = require('lodash.assign');
var watchify = require('watchify');
var browserify = require('browserify');
var browsersync = require('browser-sync');

var gulp = require('gulp');
var gutil = require('gulp-util');
var $p = require('gulp-load-plugins')();
var $if  = require('gulp-if');
var maps = require('gulp-sourcemaps');
var sequence = require('gulp-sequence');
var rev = require('gulp-rev');
var mediaQuery = require('gulp-group-css-media-queries');



/**
 * PRODUCTION FLAG
 *
 * Run --production after any Gulp task to perform a production build
 */
var production = argv.production;

/**
 * PATH VARIABLES
 *
 */

/** Paths */
var enter     = './assets/';
var src_base  = './src/';
var dist_base = './dist/';

/** Base (entry) paths */
var base = {
  'img':       enter + 'images/**/*',
  'fonts':     enter + 'fonts/**/*',
  'sass':      enter + 'sass',
  'sassMain':  enter + 'sass/main/*.scss',
  'js': {
    'single':  enter + 'js/single/*.js',
    'main':    enter + 'js/main.js',
    'modules': enter + 'js/modules'
  }
}

/** Destination (to) paths */
var dest = {
  'css':      src_base + 'css/',
  'js': {
    'all':    src_base + 'js/',
    'single': src_base + 'js/single',
    'vendor': dist_base + 'js/vendor'
  },
  'img':      dist_base + 'images/',
  'fonts':    dist_base + 'fonts/'
};





/**
 * CLEAN TASK
 *
 * Remove `./src` & `/dest`
 */
gulp.task('clean', function() {
  del([src_base, dist_base]);
});





/**
 * SASS TASK
 *
 * Runs foreach on every file in 'sass/main'
 */
gulp.task('build_sass', function() {
  gulp.src( base.sassMain )
    .pipe($p.flatmap( function(stream, file) {
      // Get base file name, rename it based on argv
      var ext = production ? '.min.css' : '.css';
      var name = node_path.basename(file.path, '.scss') + ext;

      return stream
        .pipe( $if( !production, $p.plumber() ) )
        .pipe( $p.changed( dest.css) )                        // Only run on changed files
        .pipe( $if( !production, maps.init() ) )              // If no production flag, generate maps
          .pipe($p.sass().on('error', $p.sass.logError))      // Compile sass
          .pipe( $if( production, mediaQuery() ) )            // Reorg media queries
          .pipe( $if( !production, $p.autoprefixer() ) )
          .pipe( $if( production, $p.cssnano({
            autoprefixer: { add: true }
          }) ) )
          .pipe($p.rename(name))                              // Rename
        .pipe( $if( !production, maps.write('.') ) );         // If no production flag, write maps
    }) )
    .pipe( gulp.dest( dest.css ) )                            // Ship it
    .pipe( browsersync.stream({match: '**/*.css'}) );         // Beam it to browsersync
});





/**
 * LINT TASKS
 *
 * Run single js through the linter
 * Run main browserify file through the linter
 */
gulp.task('lint_single', function(){
  return gulp.src( base.js.single )
    .pipe( $p.jshint() )
    .pipe( $p.jshint.reporter('jshint-stylish-source') );
});

gulp.task('lint_bundle', function(){
  return gulp.src([ base.js.main, base.js.modules + '/**/*.js' ])
    .pipe( $p.jshint() )
    .pipe( $p.jshint.reporter('jshint-stylish-source') );
});





/**
 * SINGLE JS TASK
 *
 * For non browserified files saved in `single`
 */
gulp.task('build_single_js', ['lint_single'], function(){
  gulp.src( base.js.single )
    .pipe($p.flatmap( function(stream, file) {
      // Get base file name, rename it based on argv
      var name = node_path.basename(file.path, '.js') + '.min.js';

      return stream
        .pipe( $if( !production, $p.plumber() ) )
        .pipe( $p.changed( dest.js.all ) )                  // Only run on changed files
        .pipe( $if( production, $p.uglify() ) )
        .pipe($p.rename(name))
    }) )
  .pipe( gulp.dest( dest.js.single ) )                  // Ship it
  .pipe( browsersync.reload({stream: true}) );
});





/**
 * BROWSERIFY
 *
 */

/** Browserify Bundler */
var b = function() {
  return browserify({
    entries: base.js.main,
    debug: true,
    cache: {},
    paths: ['./node_modules', base.js.modules]
  });
};

/** Watchify Bundler */
var w = watchify(b());

/**
 * Process Bundler
 *
 * Pass either a build or watchify bundler
 */
function bundle(pkg) {
  return pkg.bundle()
    .on('error', gutil.log.bind(gutil, 'Browserify Error'))
    .pipe( source('bundle.js') )
    .pipe( buffer() )
    .pipe( $if( !production, $p.plumber() ) )
    .pipe( $if( !production, maps.init( {loadMaps: true} ) ) )
      .pipe( $if( production, $p.uglify() ) )
    .pipe( $if( !production, maps.write('.') ) )
    .pipe( gulp.dest(dest.js.all) )
    .pipe( browsersync.stream( {once: true} ) );
}





/**
 * BROWSERIFY TASKS
 *
 * Build bundle (once and done)
 * Watch bundle (enable watchify)
 */
gulp.task('build_bundle', function() {
  return bundle(b())
});

gulp.task('watch_bundle', function() {
  bundle(w);
  w.on('update', bundle.bind(null, w) );
  w.on('log', gutil.log);
});





/**
 * REVISION CSS AND JS ASSETS
 *
 * Clean the distribution folder
 * Take all css and js files in src, revision
 * them, send them to a clean dist folder.
 *
 * This task should only be used within a `sequence` task,
 * otherwise image and font assets will be deleted without
 * being re-generated.
 * Run `build_dest` if you need to revision anything.
 */
gulp.task('build_rev', function () {
  if(production) {
    var cssPath = src_base + '**/*.css';
    var jsPath = src_base + '**/*.js';

    return gulp.src([cssPath, jsPath])
      .pipe(rev())
      .pipe(gulp.dest(dist_base))
      .pipe(rev.manifest('_rev-manifest.json'))
      .pipe(gulp.dest(dist_base));
  }
});





/**
 * IMAGE TASK
 *
 * Process images in src folder, move to dist folder
 */
gulp.task('build_images', function () {
  return gulp.src( base.img )
    .pipe($p.imagemin({
      progressive: true,
      svgoPlugins: [
          {removeViewBox: false},
          {cleanupIDs: false}
      ],
      use: [pngquant()]
    }))
    .pipe(gulp.dest(dest.img));
});





/**
 * COPY STATIC FILES
 *
 * Copy jQuery for local fallback
 * Copy Fonts to distribution folder
 */
gulp.task('copy_jquery', function() {
  return gulp.src('./node_modules/jquery/dist/jquery.min.js')
    .pipe( gulp.dest( dest.js.vendor ) )
});
gulp.task('copy_fonts', function () {
  return gulp.src( base.fonts ).pipe(gulp.dest(dest.fonts));
});





/**
 * WATCH RELATED TASKS
 *
 */
gulp.task('watch_js', ['build_single_js'], browsersync.reload);
gulp.task('watch_reload', function(){ browsersync.reload(); });





/**
 * SERVE TASK
 * --------------------------------------------------------
 * Initialize browsersync, watch for file changes
 */
gulp.task('serve', ['watch_bundle'], function(){
  browsersync({
    proxy: devUrl
  });

  // Watch tasks
  gulp.watch([base.sass + '/**/*.scss'], ['build_sass']);
  gulp.watch([base.js.single], ['build_single_js']);
  gulp.watch([base.fonts], ['copy_fonts']);
  gulp.watch([base.img], ['build_images']);
  gulp.watch('**/*.php', ['watch_reload']);
  gulp.watch('**/*.html', ['watch_reload']);
});





/**
 * DEFAULT TASK
 * --------------------------------------------------------
 * Start the whole show. Run to start a project up.
 */
var req = production ? ['clean'] : '';

gulp.task('default', sequence(
  req,
  'build_sass',
  'build_bundle',
  'build_single_js',
  'build_images',
  'copy_jquery',
  'copy_fonts',
  'build_rev'
));



