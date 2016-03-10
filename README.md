# Apollo

#### A WordPress craft launched with Composer, manned with automation.

## About

Apollo is a two stage unit: A WordPress Stack built with Composer, and a Starter Theme packed with Sass, Gulp, Bourbon, Bower, and a Theme Wrapper structure.


#### Minimum Requirements (Stack)
Versions listed are required to be equal to or greater than.

- PHP v5.4.3
- [Composer] (https://getcomposer.org/) v1.0.0-alpha8

#### Minimum Requirements (Theme)
Versions listed are required to be equal to or greater than.

- [Node] (https://nodejs.org/) v0.10.0
- [NPM] (https://www.npmjs.com/) v2.1.5
- PHP v5.4.3
- [Gulp] (http://gulpjs.com/) v3.8.10
- [Bower] (http://bower.io/) v1.3.12
- WordPress v4.1.0 (installed via stack)

## Installation

Make sure you have everything listed in the above requirements installed, and then clone this repo on your machine.

- Open your terminal, and `cd` into the directory you just cloned.
- Run `composer install`
- A series of prompts will collect information based on your environment, which will be used to generate a config file. See Prompts below for more information.
- If you choose not to run NPM from the composer prompt, cd to the theme and run `npm install`
- Run `bower update` and `gulp build` to complete theme initialization.
- Point local hosts to the directory you created (the folder should now have a file name `wp-config.php` inside of it.
- Change the remote repo location to your own damn repo.
- Start coding. Shoot for the moon.

## Stack Information
### Configuration

#### Site Configuration
Apollo only uses `wp-config.php` as an initializer file. The information that is typically configured in `wp-config.php` is instead spread throughout the stack. As such, you should never alter `wp-config.php` with site config information.

#### Theme eEnvironment Configuration
Theme environments are controlled via the `WP_ENV` definition in `wp-config.php` and should be one of the following options:

- `development`
- `staging`
- `production`

This definition controls how errors are output and whether or not certain functions should be ran. Local development? Use `development`. Site running live? Use `production`. Testing on a staging server?...I think you get it.

#### Want to change environmental attributes?
See `lib/config/apollo-config.php`.

#### WordPress Versions
Apollo uses [John Bloch Composer Repo] (https://github.com/johnpbloch/wordpress-core-installer) to install WordPress. To update WP, simply update the version of `"johnpbloch/wordpress"` to match the version of WordPress you would like.

#### Plugins
Apollo's composer.json is setup to connect with the [WordPress Packagist] (http://wpackagist.org/) library. If you want to use a plugin, find it in the WordPress plugin repo, and copy the slug. In `composer.json`, add the plugin slug prepended by `wpackagist-plugin/` and its version in the `require` array.

Example:
    `"wpackagist-plugin/duplicate-post": "~2.6",`

## Theme:
#### Mission Control

Theme docs are maintained [here](app/themes/mission-control/README.md).

## Contributing:
#### Issues

Report all issues [here] (https://github.com/j2made/apollo/issues)

#### Git Repo Branch Structure

The Apollo repo workflow utilizes Git Flow. Features branches should be named with the part of Apollo being worked on: `stack-` or `theme-`. Features should be merged into the `develop` branch, where they will wait to be merged into
`master`.


## Credits:
This project is heavily influenced by [Bedrock] (https://github.com/roots/bedrock) and [Sage] (https://github.com/roots/sage) by the [Roots] (https://roots.io/) team. A lot of the code here has been adopted from or inspired by those projects, including the gulp file and [the wrapper] (https://roots.io/sage/docs/theme-wrapper/).
