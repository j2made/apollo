/** REQUIRES */
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

var sass = require('gulp-sass');
var mediaQuery  = require('gulp-group-css-media-queries');
var nano = require('gulp-cssnano');


// Paths
dest = config.paths.src;
base = config.paths.enter;

// Production
production = argv.production;
if(production) {
  dest = config.paths.dist;
}



/**
 * SASS TASK
 *
 * Runs foreach on every file in 'sass/main'
 */
gulp.task('build_sass', function() {
  gulp.src(base + 'sass/main/*.scss')
    .pipe(foreach( function(stream, file) {
      var name = node_path.basename(file.path, '.scss') + '.min';

      return stream
        .pipe( $if( !production, plumber() ) )
        .pipe( $if( !production, maps.init() ) )
          .pipe(sass().on('error', sass.logError))
          .pipe(mediaQuery())
          .pipe(nano())
          .pipe(rename(name))
        .pipe( $if( !production, maps.write('.') ) );
    }) )
    .pipe( gulp.dest( dest + 'css/' ) );
});
