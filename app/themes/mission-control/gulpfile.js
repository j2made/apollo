// Gulp Vars
var $ = require('gulp-load-plugins')();
var gulp = require('gulp');

// Global Vars

// Paths
var dist = './dist-dev/';     // Changes to dist on production


// SASS
gulp.task('styleTask', function() {
  gulp.src('./assets/styles/*.scss')  // main.scss
    .pipe($.sourcemaps.init())
      .pipe($.sass())
      .pipe($.autoprefixer())
    .pipe($.sourcemaps.write( 'maps' ))
    .pipe(gulp.dest( dist + 'styles' ));
});

