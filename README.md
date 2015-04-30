# Apollo

#### A Worpress craft launched with Composer, manned with automation.

## About

Apollo is a two stage unit: A Wordpress Stack built with Composer, and a Starter Theme packed with Sass, Gulp, Bourbon, Bower, and a Theme Wrapper structure.


### Minimum Requirements (Stack)
Versions listed are required to be equal to or greater than.

- PHP v5.4.3
- [Composer] (https://getcomposer.org/) v1.0.0-alpha8

### Minimum Requirements (Theme)
Versions listed are required to be equal to or greater than.

- [Node] (https://nodejs.org/) v0.10.0
- [NPM] (https://www.npmjs.com/) v2.1.5
- PHP v5.4.3
- [Gulp] (http://gulpjs.com/) v3.8.10
- [Bower] (http://bower.io/) v1.3.12
- Wordpress v4.1.0 (installed via stack)

## Installation

Make sure you have everything listed in the above requirements installed, and then clone this repo on your machine. 

- Open your terminal, and `cd` into the directory you just cloned.
- Run `composer create-project`
- A series of prompts will collect information based on your enviornment, which will be used to generate a config file. See Prompts below for more information.
- If you choose not to run NPM from the composer prompt, cd to the theme and run `npm install`
- Run `bower update` and `gulp build` to complete theme initialization.
- Point local hosts to the directory you created (the folder should now have a file name `env-config.php` inside of it.
- Change the remote repo location to your own damn repo.
- Start coding. Shoot for the moon.

## Stack Information
### Configuration

#### Site Configuration
Apollo only uses `wp-config.php` as an initializer file. The information that is typically configured in `wp-config.php` is instead spread throughout the stack. As such, you should never alter `wp-config.php` with site confing information.

All neccessary config information, such as database info, salts, theme enviornment, host url, etc., is stored in the generated `env-config.php` file. This should file should be ignored in git, because you should keep your creds to your own damn self.

#### Theme Enviornment Configuration
Theme enviornments are controlled via the `WP_ENV` definition in `eng-config.php` and should be one of the following options:

- `development`
- `staging`
- `production`

This definition controls how errors are output and whether or not certain functions should be ran. Local development? Use `development`. Site running live? Use `production`. Testing on a staging server?...I think you get it.

#### Want to change enviornmental attributes?
See `lib/config/application.php`.

### Composer

#### Prompts
Running `create-project` will use prompts to setup your config files. If you just press enter, the default value for each will be rendered in the file(s).

| Prompt | Info | Default |
| ------ | ---- | ------- |
| `WP Enviornment:` | Enviornment definition for project | `development` |
| `DB_NAME:` | Name of your database | `db_name` |
| `DB_USER:` | Database user name | `db_user` |
| `DB_PASSWORD:` | Database password | `db_pass` |
| `DB_HOST:` | Database host | `localhost` |
| `HOME_URL:` | Host url for project. **Do not** include `http://` as it will be appended programatically. | `example.com` |

If this is the first time the project is being initialized, such as a clean clone from this repo, you will also see the following prompts:

| Prompt | Info | Default |
| ------ | ---- | ------- |
| `THEME_NAME:` | Enter a new theme name. | `mission-control` |

This will change the name of the theme directory, as well as values in other config files.

If you or another developer has already ran create-project or changed the default name, this prompt will not be present, as the theme name has already been defined.

You will also be asked some boolean questions:

| Prompt | Info | Default |
| ------ | ---- | ------- |
| `Run NPM after dependencies have been installed?` | Enter `Y` or `N` | `N` |
| `Generate salts and append to the env-config.php file?` | Enter `Y` or `N` | `N` |

If you have an issue with the prompts, or a `env-config.php` cannot be created, open an issue on the [project repo] (http://github.com/j2made/apollo/issues). You can copy the file `lib/config/env-config-default.php` to the root of the project and rename it `env-config.php`. Then change the values of the definitions.

#### Wordpress Versions
Apollo uses [John Bloch Composer Repo] (https://github.com/johnpbloch/wordpress-core-installer) to install Wordpress. To update WP, simply update the version of `"johnpbloch/wordpress"` to match the version of Wordpress you would like.

#### Plugins
Apollo's composer.json is setup to connect with the [Wordpress Packagist] (http://wpackagist.org/) library. If you want to use a plugin, find it in the Wordpress plugin repo, and copy the slug. In `composer.json`, add the plugin slug prepended by `wpackagist-plugin/` and its verion in the `require` array. 

Example:
    `"wpackagist-plugin/duplicate-post": "~2.6",`

## Theme Configuration

Coming Soon, dawg.


## Contributing:
### Issues

Report all issues [here] (https://github.com/j2made/apollo/issues)

### Git Repo Branch Structure

The Apollo repo workflow utilizes Git Flow. Features branches should be named with the part of Apollo being worked on: `stack-` or `theme-`. Features should be merged into the `develop` branch, where they will wait to be merged into 
`master`.

## Credits:
This project is heavily influenced by [Bedrock] (https://github.com/roots/bedrock) and [Sage] (https://github.com/roots/sage) by the [Roots] (https://roots.io/) team. A lot of the code here has been adoted from or inspired by those projects, including the gulpfile and the wrapper.