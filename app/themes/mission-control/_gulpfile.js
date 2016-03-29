// The Gulpfile
// -----------------------------------------------------------
// Slightly altered version of the Sage gulpfile.

// GULP VARS
// -----------------------------------------------------------
var $           = require('gulp-load-plugins')();
var argv        = require('minimist')(process.argv.slice(2));
var browserSync = require('browser-sync');
var gulp        = require('gulp');
var lazypipe    = require('lazypipe');
var merge       = require('merge-stream');
var runSequence = require('run-sequence');
var cssnano     = require('gulp-cssnano');
var mediaQuery  = require('gulp-group-css-media-queries');
var neat        = require('node-neat').includePaths;


// MANIFEST VARS
// ---------------------------------------------------------------------------------------
// See https://github.com/austinpray/asset-builder

// JSON file created from yaml file after `config` task is ran :
var manifest = require('asset-builder')('./assets/config/manifest.json');
var path = manifest.paths;                // See `paths:` in `mainfest.yml`
var config = manifest.config || {};
var globs = manifest.globs;               // `globs.js`, etc.
var project = manifest.getProjectGlobs(); // `project` - paths to first-party assets.

// Path to the compiled assets manifest in the dist directory
var revManifest = config.shipDest + 'assets.json';

// Change distribution folder on --production so that it can be tracked for git deployment
if(argv.production) { path.dist = config.shipDest; }


// CLI OPTIONS
// -------------------------------------------------------------------------------------
var enabled = {
  rev: argv.production,           // Enable static asset revisioning when `--production`
  maps: !argv.production,         // Disable source maps when `--production`
  failStyleTask: argv.production  // Fail styles task on error when `--production`
};


// ==============================================================================
// REUSABLE PIPELINES
// See https://github.com/OverZealous/lazypipe
// ==============================================================================

// CSS
// --------------------------------------------------
var cssTasks = function(filename) {
  return lazypipe()
    .pipe( function() { return $.if(!enabled.failStyleTask, $.plumber()); } )
    .pipe( function() { return $.if(enabled.maps, $.sourcemaps.init()); } )
      .pipe(function() {
        return $.if('*.scss', $.sass({
          outputStyle: 'expanded',
          precision: 10,
          includePaths: neat,
          errLogToConsole: !enabled.failStyleTask
        }));
      })
      .pipe($.concat, filename)
      .pipe( function() { return $.if( enabled.rev, mediaQuery() ); } )
      .pipe($.cssnano)
    .pipe(function() {return $.if(enabled.rev, $.rev());})
    .pipe(function() {return $.if(enabled.maps, $.sourcemaps.write('.'));})();
};

// JS
// --------------------------------------------------
var jsTasks = function(filename) {
  return lazypipe()
    .pipe(function() {
      return $.if(enabled.maps, $.sourcemaps.init());
    })
    .pipe($.concat, filename)
    .pipe($.uglify)
    .pipe(function() {
      return $.if(enabled.rev, $.rev());
    })
    .pipe(function() {
      return $.if(enabled.maps, $.sourcemaps.write('.'));
    })();
};

// WRITE TO REV MANIFEST
// --------------------------------------------
// See https://github.com/sindresorhus/gulp-rev
var writeToManifest = function(directory) {
  return lazypipe()
    .pipe(gulp.dest, path.dist + directory)
    .pipe(function() {
      return $.if('**/*.{js,css}', browserSync.reload({stream:true}));
    })
    .pipe($.rev.manifest, revManifest, {
      base: path.dist,
      merge: true
    })
    .pipe(gulp.dest, path.dist)();
};



// ==============================================================================
// GULP TASKS
// Run `gulp -T` for a task summary
// ==============================================================================


// CONFIG TASK
// ------------------------------------------------------------------------------
// Convert manifest.yml file to json.
// ** Run on init, start of watch, and if changes are made to _gulp-manifest ***
gulp.task('config', function() {
  gulp.src('./assets/manifest.yml')
    .pipe( $.yaml({space: 2}) )
    .pipe(gulp.dest('./assets/config/'));
});

// STYLES TASK
// ----------------------------------------------------------------------------
// `gulp styles` - Compiles, combines, and optimizes Bower CSS and project CSS.
// By default this task will only log a warning if a precompiler error is
// raised. If the `--production` flag is set: this task will fail outright.
gulp.task('styles', function() {
  var merged = merge();
  manifest.forEachDependency('css', function(dep) {
    var cssTasksInstance = cssTasks(dep.name);
    if (!enabled.failStyleTask) {
      cssTasksInstance.on('error', function(err) {
        console.error(err.message);
        this.emit('end');
      });
    }
    merged.add(gulp.src(dep.globs, {base: 'styles'})
      .pipe(cssTasksInstance));
  });
  return merged
    .pipe(writeToManifest('styles'));
});

// SCRIPTS TASK
// ----------------------------------------------------------------------------
// `gulp scripts` - Runs JSHint then compiles, combines, and optimizes Bower JS
// and project JS.
gulp.task('scripts', ['jshint'], function() {
  var merged = merge();
  manifest.forEachDependency('js', function(dep) {
    merged.add(
      gulp.src(dep.globs, {base: 'scripts'})
        .pipe(jsTasks(dep.name))
    );
  });
  return merged
    .pipe(writeToManifest('scripts'));
});

// FONTS TASK
// ----------------------------------------------------------------------------
// `gulp fonts` - Grabs all the fonts and outputs them in a flattened directory
// structure. See: https://github.com/armed/gulp-flatten
gulp.task('fonts', function() {
  return gulp.src(globs.fonts)
    .pipe($.flatten())
    .pipe(gulp.dest(path.dist + 'fonts'));
});

// IMAGES
// -----------------------------------------------------------
// `gulp images` - Run lossless compression on all the images.
gulp.task('images', function() {
  return gulp.src(globs.images)
    .pipe($.imagemin({
      progressive: true,
      interlaced: true,
      svgoPlugins: [{removeUnknownsAndDefaults: false}]
    }))
    .pipe(gulp.dest(path.dist + 'images'));
});

// JSHINT
// --------------------------------------------------------
// `gulp jshint` - Lints configuration JSON and project JS.
gulp.task('jshint', function() {
  return gulp.src([
    'bower.json'
  ].concat(project.js))
    .pipe($.jshint())
    .pipe($.jshint.reporter('jshint-stylish'))
    .pipe($.jshint.reporter('fail'));
});

// CLEAN
// --------------------------------------------------------
// `gulp clean` - Deletes the build folder entirely.
gulp.task('clean', require('del').bind(null, [path.dist]));



// ----------------------------------------------------------------------------
// WATCH TASK
// ----------------------------------------------------------------------------
// `gulp watch` - Use BrowserSync to proxy your dev server and synchronize code
// changes across devices. Specify the hostname of your dev server at
// `manifest.config.devUrl`. When a modification is made to an asset, run the
// build step for that asset and inject the changes into the page.
// See: http://www.browsersync.io
gulp.task('watch', ['config'], function() {
  browserSync({
    proxy: config.devUrl,
    snippetOptions: {
      whitelist: ['/wp-admin/admin-ajax.php'],
      blacklist: ['/wp-admin/**']
    }
  });
  gulp.watch([path.source + 'styles/**/*'], ['styles']);
  gulp.watch([path.source + 'scripts/**/*'], ['jshint', 'scripts']);
  gulp.watch([path.source + 'fonts/**/*'], ['fonts']);
  gulp.watch([path.source + 'images/**/*'], ['images']);
  gulp.watch(['bower.json', 'assets/manifest.yml'], ['config', 'build']);
  gulp.watch('**/*.php', function() {
    browserSync.reload();
  });
});


// ---------------------------------------------------------------------
// BUILD TASK
// ---------------------------------------------------------------------
// `gulp build` - Run all the build tasks but don't clean up beforehand.
// Generally you should be running `gulp` instead of `gulp build`.
gulp.task('build', ['config'], function(callback) {
  runSequence('styles',
              'scripts',
              ['fonts', 'images'],
              callback);
});


// ---------------------------------------------------------------------------------
// GULP TASK (DEFAULT)
// ---------------------------------------------------------------------------------
// `gulp` - Run a complete build. To compile for production run `gulp --production`.
gulp.task('default', ['config', 'clean'], function() {
  gulp.start('build');
});