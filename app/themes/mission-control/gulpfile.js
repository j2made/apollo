var gulp = require('gulp');
var sass = require('gulp-sass');
var del = require('del');
var sourcemaps = require('gulp-sourcemaps');
var rev = require('gulp-rev');
var cssnano = require('gulp-cssnano');
var gulpif = require('gulp-if');
var argv = require('minimist')(process.argv.slice(2));
var browserSync = require('browser-sync').create();
var neat = require('node-neat').includePaths;


/* Register some tasks to expose to the cli */
gulp.task('build', gulp.series(
  clean,
  gulp.parallel(styles)
));

gulp.task(watch);
gulp.task(clean);

// The default task (called when you run `gulp` from cli)
gulp.task('default', gulp.series('build'));


// Clean
function clean() {
  return del([
    './src'
  ]);
}

// Styles
function styles() {
   return gulp.src('./assets/styles/main.scss')
    .pipe(sourcemaps.init())
    .pipe(sass({
      outputStyle: 'expanded',
      precision: 10,
      includePaths: neat
    }).on('error', sass.logError))
    .pipe(gulpif(argv.production, rev()))
    .pipe(gulpif(argv.production, cssnano()))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('./src/styles'))
    .pipe(browserSync.stream());
}

function watch() {
  browserSync.init({
    proxy: 'apollo.dev',
    snippetOptions: {
      whitelist: ['/wp-admin/admin-ajax.php'],
      blacklist: ['/wp-admin/**']
    }
  });
  gulp.watch('./assets/styles/**/*.scss', styles);
  gulp.watch('./**/*.php').on('change', browserSync.reload);
}
