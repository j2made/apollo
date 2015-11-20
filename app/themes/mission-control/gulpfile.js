// All them Vars
var gulp          = require('gulp');
var $browserSync  = require('browser-sync');
var $del          = require('del');
var $autoprefix   = require('gulp-autoprefixer');
var $changed      = require('gulp-changed');
var $concat       = require('gulp-concat');
var $if           = require('gulp-if');
var $imagemin     = require('gulp-imagemin');
var $jshint       = require('gulp-jshint');
var $minify       = require('gulp-minify-css');
var $plumber      = require('gulp-plumber');
var $rev          = require('gulp-rev');
var $sass         = require('gulp-sass');
var $sourcemaps   = require('gulp-sourcemaps');
var $ugly         = require('gulp-uglify');
var $yaml         = require('gulp-yaml');
var $lazypipe     = require('lazypipe');
var $yargs        = require('yargs');
var $runSeq       = require('run-sequence');
var $bowerFiles   = require('main-bower-files');
var $mediaQueries = require('gulp-group-css-media-queries');
var gutil         = require('gulp-util');
var $modernizr    = require('gulp-modernizr');


// Manifest Vars
var manifest = require('asset-builder')('./assets/config/manifest.json');
var path = manifest.paths;



// CONFIG
// Builds a json file from the yml config file.
gulp.task('config', function() {
  gulp.src('./assets/manifest.yml')
    .pipe( $yaml({space: 2}) )
    .pipe(gulp.dest('./assets/config/'));
});

// Modernizr
gulp.task('modernizr', function() {
  gulp.src(path.source + 'scripts/*.js')
    .pipe($modernizr('modernizr-custom.js'))
    .pipe(gulp.dest(path.modernizr));
});


// SASS
gulp.task('log', function() {
  gutil.log('hi');
});


