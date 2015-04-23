# Apollo package.json Notes

Basic Flow:

Styles:
- Run Sass



## Keep
### Required
"browser-sync": "^2.0.1",
"gulp": "^3.8.11",
"gulp-changed": "^1.2.1",
"gulp-plumber": "^1.0.0",
"gulp-load-plugins": "^0.8.0",
"lazypipe": "^0.2.2",
"asset-builder": "^0.4.1", - Or similar, to keep a manifest of files to be created

### Development Level
"wiredep": "^2.1.0",

### Production Level
"del": "^1.1.1", - To delete the contents of dist on production run, replace with new
"gulp-rev": "^3.0.0",

### Image
"gulp-imagemin": "^2.0.0",
"imagemin-pngcrush": "^4.0.0",

### JS
"gulp-jshint": "^1.8.4",
"jshint-stylish": "^1.0.0",
"gulp-concat": "^2.3.4",
"gulp-uglify": "^1.0.1",

### STYLES
"gulp-sass": "^1.3.3",
"gulp-autoprefixer": "2.1.0 ",
"gulp-sourcemaps": "^1.1.1",



## Unsure
"gulp-flatten": "0.0.4",
"gulp-if": "^1.2.5",
"gulp-pleeease": "^1.1.0",
"gulp-rename": "^1.2.0",
"merge-stream": "^0.1.7",
"traverse": "^0.6.6",
"yargs": "^3.2.1" - vs - "minimist": "^1.1.1",



