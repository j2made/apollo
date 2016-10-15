# Apollo — Mission Control


## Workflow

Mission Control uses an opionated workflow for development. It uses Gulp to automate asset production, NPM for js package management, SASS for css preprocessing, and Browserify/Babel to compile modern js. 

When working in a `development` enviornment, js and css assets are fed from the `src` directory. When working in a `staging` or `production` enviornment, js and css assets are fed from the `dist` directory. Images and fonts are always served from the `dist` directory.

The reason for this? JS and CSS files files in `src` are not tracked in git as they are constantly built in development. `src` files also contain source maps to make developing easier. `dist` files _are_ tracked in git, as they are necessary to staging and production deployments.


## `base.php`

Mission Control uses a Theme Wrapper (ala [Scribu](http://scribu.net/wordpress/theme-wrappers.html)). This means _one file_, `base.php`, that determines the overall structure. No `get_header()` in one file and `get_footer()` in another. Any _global_ changes to the overarching structure can be made in `base.php`. Luckily, we have built in conditionals that make it easier to control layout. See [Templates](#templates) below.


## Gulp Tasks and Workflow

When working locally, `cd` to your theme directory and run `gulp serve`. This will start Watchify, spin up Browsersync, and watch theme files for changes and auto-reload/inject styles.

To build out the site for production deployment, simply run `gulp --production`. The `--production` flag can be used with almost any task to run the production version.

Additional helpful tasks:

```
gulp build_sass     // convert SASS to CSS
gulp build_bundle   // creates a bundled js file
gulp build_images   // optimizes images and copies them to `dist`
gulp copy_fonts     // copy fonts to `dist`
gulp clean          // remove existing `dist` and `src` files
```


## SCSS
`assets/sass` is structured into two primary directories: `main` and `partials`. Any file that live in the `main` directory will be output to a file when the `gulp sass` task runs. These files should only contain scss `@import` directives. Use these files to import files living in `partials` or elsewhere.


## JS
`assets/js` is structured into two primary directories: `modules` and `single`, with `main.js` living in there too.

`main.js` and the `modules` directory are connected with Browserify. Any custom common js modules imported to `main.js` with a `require()` statement should live in the `modules` directory.

Any files that live in `single` with be linted and scrubbed, but not ran through Babel or Browserify.

_Note:_ Browserify will sniff the `modules` directory as well as `node_modules`, so files in either directory can be required. `browserify-shim` is used if you need to add custom global modules. `bowerify` is install in case you need to use [Bower](bower.io) to get a package.


## `lib`
Many aspects of theme output are controlled via files in the `lib` directory. `lib` files tries to follow a naming convention based on file content. `config-` means the file sets up configuration, so definitions, conditions related to presentaion, etc.

Here are some typical needs and the file to edit:

- `lib/config-settings`
  - Setup default Sidebar layout
  - Register Nav Menus
  - Add Typekit, Google Fonts, or FontAwesome
  - Add/Remove Emoji Support, Theme Support, Widget (ugh) Support
- `lib/config-conditionals`
  - Hide the Page Header for a post type
  - Hide the Sidebar for a post type (or entirely)
  - Flip the Sidebar for a post type
- `lib/extend-core`:
  - Add an image size
- `lib/extend-utilities`
  - Add a body class
- `lib/theme-structure`
  - Add, remove, or change wp_nav classes & ids (see `custom_wp_nav_menu_classes()` and `current_to_active`)
- `lib/misc/extend-post-types`
  - Add Custom Post Types
- `lib/misc/extend-taxonomy`
  - Add Custom Taxonomies
- `lib/misc/extend-queries`
  - Adjust default query settings for post types

## Templates
Template files are subdivided into folders based on usage/location.

The header and footer files live in `templates/global`. Page Header files in `templates/page-header`, blog template parts in `templates/blog`.

Templates such as page header and sidebar are conditionally displayed. These settings can be configured in `lib/config-conditionals`: 

### Sidebar
To hide the sidebar, create an `if` statement in the `hide_sidebar` function that will return `true`.
To hide the sidebar site-wide, simple set `hide_sidebar` to always return `true`
To switch the sidebar layout (display it opposite the default), create an `if` statement in the `sidebar_switch` function that will return `true`.

### Page Header
To hide the page header, create an `if` statement in the `hide_page_header` function that will return `true`.
To hide the page header site-wide, simple set `hide_page_header` to always return `true`



