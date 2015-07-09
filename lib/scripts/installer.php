<?php

namespace Apollo\InitConfig;

use Composer\Script\Event;

class Installer {

  public static $salt_keys = array(
    'AUTH_KEY',
    'SECURE_AUTH_KEY',
    'LOGGED_IN_KEY',
    'NONCE_KEY',
    'AUTH_SALT',
    'SECURE_AUTH_SALT',
    'LOGGED_IN_SALT',
    'NONCE_SALT'
  );

  // DB DEFINITIONS VIA COMPOSER IO
  // ====================================================

  public static function addConfig(Event $event) {
    $root = dirname( dirname(__DIR__) );
    $theme_root = $root . '/app/themes/';
    $theme_init_name = 'mission-control';
    $theme_init = $root . '/app/themes/' . $theme_init_name;
    $db_config_file = "{$root}/env.php";
    $db_config_sample = "{$root}/lib/config/env-sample.php";
    $wp_config_no_track = "{$root}/wp-config.php";
    $wp_config_sample = "{$root}/lib/config/wp-config-sample.php";
    $composer = $event->getComposer();
    $io = $event->getIO();

    $def_key_array = array(
      'com_env' => '// Enviornment Definitions',
      'WP_ENV' => 'development',
      'com_dev' => '// Database Definitions',
      'DB_NAME' => 'db_name',
      'DB_USER' => 'db_user',
      'DB_PASSWORD' => 'db_user',
      'DB_HOST' => 'db_pass',
      'com_site' => '// Site Definitions',
      'WP_HOME' => 'http://example.com',
      'WP_SITEURL' => 'http://example.com/wp'
    );

    // Get DB info as vars
    if (!$io->isInteractive()) {
      $theme_name = false;
      $run_npm = false;
    } else {
      $io->write('** Enviornment Definitions **', true);
      $def_key_array['WP_ENV'] = $io->ask('<info>WP Enviornment (development, staging, or production): </info>', 'development');
      $io->write('** Database Definitions **', true);
      $def_key_array['DB_NAME'] = $io->ask('<info>DB_NAME: </info>', 'db_name');
      $def_key_array['DB_USER'] = $io->ask('<info>DB_USER: </info>', 'db_user');
      $def_key_array['DB_PASSWORD'] = $io->ask('<info>DB_PASS: </info>', 'db_pass');
      $def_key_array['DB_HOST'] = $io->ask('<info>DB_HOST (Defaults to localhost): </info>', 'localhost');
      $io->write('** Site Definitions **', true);
      $home_url = $io->ask('<info>HOME_URL (domain level only, http:// automatically appended): </info>', 'example.com');
      $def_key_array['WP_HOME'] = 'http://' . $home_url;
      $def_key_array['WP_SITEURL'] = 'http://' . $home_url . '/wp';

      // Ask to define new theme name if the original theme name has not already been changed
      if(file_exists($theme_init)) {
        $theme_name = $io->ask('<info>THEME_NAME: </info>', false);
      } else {
        $theme_name = false;
      }
      $run_npm = $io->askConfirmation('<info>Build project (npm and bower install, gulp build) after dependencies have been installed?</info> [<comment>Y,n</comment>]? ', true);
    }

    // =---> ROUND UP VARS
    $db_defs = array();
    // Convert Key/Value array into Definition string
    foreach ($def_key_array as $key => $def) {
      if(strpos($def, '// ') === 0) { // If the value is a comment
        $db_defs[] = $def;
      } else {
        $db_defs[] = 'define("' . $key . '", "' . $def . '");';
      }
    }

    $db_defs_string = "\n" . "\n" . implode($db_defs, "\n");

    // Append the defs to the db config file and create env.php
    if (copy($db_config_sample, $db_config_file)) {
      file_put_contents( $db_config_file, $db_defs_string, FILE_APPEND | LOCK_EX );
    } else {
      $io->write("<error>An Error Occured while generating env_config</error>");
    }

    // Create wp-config.php
    if ( copy($wp_config_sample, $wp_config_no_track) ) {
      copy($wp_config_sample, $wp_config_no_track);
    } else {
      $io->write("<error>An Error Occured while generating wp-config.php</error>");
    }



    // =---> CHANGE THEME NAME

    // If a theme name exists
    $mission_name = $theme_init_name;
    if($theme_name) {
      $mission_name = $theme_name;
    }

    define('APOLLO_THEME_NAME', $mission_name);

    // Change the theme name if the theme is still the initial theme
    if(file_exists($theme_init)) {
      rename( realpath($theme_init), realpath($theme_root) . '/' . $mission_name );
    }

    // Change the value in the manifest.yml file
    if(file_exists($theme_root . '/' . $mission_name . '/assets/manifest.yml')) {
      $yml_file = $theme_root . '/' . $mission_name . '/assets/manifest.yml';
      $file_contents = file_get_contents($yml_file);
      $file_contents = str_replace("CONFIG_THIS!", $home_url, $file_contents);
      file_put_contents($yml_file, $file_contents);
    }

    // Replace Style.css Line
    if(file_exists($theme_root . '/' . $mission_name . '/style.css')) {
      $yml_file = $theme_root . '/' . $mission_name . '/style.css';
      $file_contents = file_get_contents($yml_file);
      $file_contents = str_replace("Mission Control by J2", $mission_name, $file_contents);
      file_put_contents($yml_file, $file_contents);
    }

    // Setup for NPM
    if($run_npm) {
      define('APOLLO_LANUCH', 'contact');
    } else {
      define('APOLLO_LANUCH', 'no go');
    }

  }

  // SALT CREATION
  // ====================================================
  public static function addSalts(Event $event) {

    $root = dirname( dirname(__DIR__) );
    $app_config_file = "{$root}/env.php";
    $composer = $event->getComposer();
    $io = $event->getIO();

    if (!$io->isInteractive()) {
      $generate_salts = $composer->getConfig()->get('generate-salts');
    } else {
      $generate_salts = $io->askConfirmation('<info>Generate salts and append to the env.php file?</info> [<comment>Y,n</comment>]? ', true);
    }

    // If salts should not be generated
    if (!$generate_salts) {
      // Create a default salt array
      $salts_array = array_map(function($key) {
        return sprintf("define('%s', 'put your unique phrase here');", $key, Installer::generateSalt());
      }, self::$salt_keys);

    } else {
      // Create a randomized salt array
      $salts_array = array_map(function($key) {
        return sprintf("define('%s', '%s');", $key, Installer::generateSalt());
      }, self::$salt_keys);
    }

    // Output array as a string of definitions
    $salt_string = "\n" . '// Salts' . "\n" . implode($salts_array, "\n");

    // Append the salts to
    if( file_exists($app_config_file) ) {
      file_put_contents( $app_config_file, $salt_string, FILE_APPEND | LOCK_EX );
    } else {
      $io->write("<error>An Error Occured while generating salts</error>");
    }
  }

  /**
   * Slightly modified/simpler version of wp_generate_password
   * https://github.com/WordPress/WordPress/blob/cd8cedc40d768e9e1d5a5f5a08f1bd677c804cb9/wp-includes/pluggable.php#L1575
   */
  public static function generateSalt($length = 64) {
    $chars  = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $chars .= '!@#$%^&*()';
    $chars .= '-_ []{}<>~`+=,.;:/?|';

    $salt = '';
    for ($i = 0; $i < $length; $i++) {
      $salt .= substr($chars, rand(0, strlen($chars) - 1), 1);
    }

    return $salt;
  }

  // RUN NPM INSTALL
  // ====================================================
  public static function runNPM(Event $event) {

    if ( APOLLO_LANUCH === 'contact' ) {
      // Run NPM Install in the Theme Directory
      $root = dirname( dirname(__DIR__) );
      $theme_root = realpath($root . '/app/themes/' . APOLLO_THEME_NAME);
      $io = $event->getIO();

      $io->write("** Running Build (npm and bower installs) in Theme Directory **");
      exec("cd $theme_root && npm install"); // Note: Bower and Gulp Build should in npm (see package.json->scripts->postinstall)
    }
  }

}
