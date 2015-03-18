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
    $db_config_file = "{$root}/env-config.php";
    $db_config_sample = "{$root}/lib/config/env-config-sample.php";
    $composer = $event->getComposer();
    $io = $event->getIO();

    $db_key_array = array(
      'com_env',
      'WP_ENV',
      'com_dev',
      'DB_NAME',
      'DB_USER',
      'DB_PASSWORD',
      'DB_HOST',
      'com_site',
      'WP_HOME',
      'WP_SITEURL'
    );

    // Empty array for definitions
    $db_defs = array();

    // Get DB info as vars
    if (!$io->isInteractive()) {
      $db_defs[] = '// Enviornment Definitions';
      $db_defs[] = 'development';
      $db_defs[] = '// Database Definitions';
      $db_defs[] = 'db_name';
      $db_defs[] = 'db_user';
      $db_defs[] = 'db_pass';
      $db_defs[] = 'localhost';
      $theme_name = false;
      $db_defs[] = '// Site Definitions';
      $home_url = 'http://example.com';
      $db_defs[] = $home_url;
      $db_defs[] = $home_url . '/wp';

    } else {
      $io->write('** Enviornment Definitions **', true);
      $db_defs[] = '// Enviornment Definitions';
      $db_defs[] = $io->ask('<info>WP Enviornment (development, staging, or production): </info>', 'development');
      $io->write('** Database Definitions **', true);
      $db_defs[] = '// Database Definitions';
      $db_defs[] = $io->ask('<info>DB_NAME: </info>', 'db_name');
      $db_defs[] = $io->ask('<info>DB_USER: </info>', 'db_user');
      $db_defs[] = $io->ask('<info>DB_PASS: </info>', 'db_pass');
      $db_defs[] = $io->ask('<info>DB_HOST (Defaults to localhost): </info>', 'localhost');
      $io->write('** Site Definitions **', true);

      // Ask to define new theme name if the original theme name has not already been changed
      if(file_exists($theme_init)) {
        $theme_name = $io->ask('<info>THEME_NAME: </info>', false);
      } else {
        $theme_name = false;
      }

      $db_defs[] = '// Site Definitions';
      $home_url = $io->ask('<info>HOME_URL: </info>', 'http://example.com');
      $db_defs[] = $home_url;
      $db_defs[] = $home_url . '/wp';
    }

    // =---> ROUND UP VARS

    // Combine $db_key_array as key, $db_defs as value
    $db_key_defs = array_combine($db_key_array, $db_defs);
    $db_defs_array = array();
    foreach ($db_key_defs as $key => $def) {
      if(strpos($def, '// ') === 0) { // If the value is a comment
        $db_defs_array[] = $def;
      } else {
        $db_defs_array[] = 'define("' . $key . '", "' . $def . '");';
      }
    }

    $db_defs_string = "\n" . "\n" . implode($db_defs_array, "\n");

    // Append the defs to the db config file
    if (copy($db_config_sample, $db_config_file)) {
      file_put_contents( $db_config_file, $db_defs_string, FILE_APPEND | LOCK_EX );
    } else {
      $io->write("<error>An Error Occured while generating env_config</error>");
    }

    // =---> CHANGE THEME NAME

    // If a theme name exists
    $mission_name = $theme_init_name;
    if($theme_name) {
      $mission_name = $theme_name;
    }

    // Change the theme name if the theme is still the initial theme
    if(file_exists($theme_init)) {
      rename( realpath($theme_init), realpath($theme_root) . '/' . $mission_name );
    }

  }

  // SALT CREATION
  // ====================================================
  public static function addSalts(Event $event) {

    $root = dirname( dirname(__DIR__) );
    $app_config_file = "{$root}/env-config.php";
    $composer = $event->getComposer();
    $io = $event->getIO();

    if (!$io->isInteractive()) {
      $generate_salts = $composer->getConfig()->get('generate-salts');
    } else {
      $generate_salts = $io->askConfirmation('<info>Generate salts and append to the env-config.php file?</info> [<comment>Y,n</comment>]? ', true);
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
    if(defined('APOLLO_THEME_NAME')) {
      // Run NPM Install in the Theme Directory
      $root = dirname( dirname(__DIR__) );
      $theme_root = $root . '/app/themes/' . APOLLO_THEME_NAME;
      $io = $event->getIO();

      $io->write("** Running NPM Install in Theme Directory **");
      exec("cd $theme_root && npm install");
    }
  }

}