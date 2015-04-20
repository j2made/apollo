// Gulp Vars
var $ = require('gulp-load-plugins')();
var gulp = require('gulp');

// Global Vars
var config = require('./assets/config/_gulp-manifest.json');

// Paths
var dist = './dist-dev/';     // Changes to dist on production



// Convert yaml file to json.
// ** Run on init, start of watch, and if changes are made to _gulp-manifest **
gulp.task('config', function() {
  gulp.src('./assets/_gulp-manifest.yml')
    .pipe( $.yaml({space: 2}) )
    .pipe(gulp.dest('./assets/config/'));
});



// SASS
// All sass files should be imported in main.scss
var sassFile = config.sass.main;
gulp.task('sassTask', function() {
  gulp.src(sassFile)
    .pipe($.sourcemaps.init())
      .pipe($.sass())
      .pipe($.autoprefixer())
    .pipe($.sourcemaps.write( 'maps' ))
    .pipe(gulp.dest( dist + 'styles' ));
});





