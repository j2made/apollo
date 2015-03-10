<?php

namespace Apollo\InitConfig;

use Composer\Script\Event;

class Installer {
  public static $KEYS = array(
    'AUTH_KEY',
    'SECURE_AUTH_KEY',
    'LOGGED_IN_KEY',
    'NONCE_KEY',
    'AUTH_SALT',
    'SECURE_AUTH_SALT',
    'LOGGED_IN_SALT',
    'NONCE_SALT'
  );


  // SALT CREATION
  // ====================================================
  public static function addSalts(Event $event) {

    $root = dirname( dirname(__DIR__) );
    $app_config_file = "{$root}/lib/config/application.php";
    $composer = $event->getComposer();
    $io = $event->getIO();

    if (!$io->isInteractive()) {
      $generate_salts = $composer->getConfig()->get('generate-salts');
    } else {
      $generate_salts = $io->askConfirmation('<info>Generate salts and append to .env file?</info> [<comment>Y,n</comment>]? ', true);
    }

    // If salts should not be generated
    if (!$generate_salts) {
      // Create a default salt array
      $salts_array = array_map(function($key) {
        return sprintf("define('%s', 'put your unique phrase here');", $key, Installer::generateSalt());
      }, self::$KEYS);

    } else {
      // Create a randomized salt array
      $salts_array = array_map(function($key) {
        return sprintf("define('%s', '%s');", $key, Installer::generateSalt());
      }, self::$KEYS);
    }


    // Output array as a string of definitions
    // =----> $salt_string = '<?php ' . "\n";
    $salt_string = implode($salts_array, "\n");

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


  // DB DEFINITIONS VIA COMPOSER IO
  // ====================================================

  public static function addConfig(Event $event) {

    $root = dirname( dirname(__DIR__) );
    $theme_root = $root . '/app/themes/';
    $theme_init = $root . '/app/themes/mission-control';
    $db_config_file = "{$root}/env-config.php";
    $db_config_sample = "{$root}/lib/config/env-config-sample.php";
    $composer = $event->getComposer();
    $io = $event->getIO();


    // Get DB info as vars
    if (!$io->isInteractive()) {
      $env_var = 'development';
      $db_name = '';
      $db_user = '';
      $db_pass = '';
      $db_host = 'localhost';
      $theme_name = null;
      $home_url = 'http://example.com';
    } else {
      $io->write('** Enviornment Definitions **', true);
      $env_var = $io->ask('<info>WP Enviornment (development, staging, or production): </info>', 'development');
      $io->write('** Database Definitions **', true);
      $db_name = $io->ask('<info>DB_NAME: </info>', '');
      $db_user = $io->ask('<info>DB_USER: </info>', '');
      $db_pass = $io->ask('<info>DB_PASS: </info>', '');
      $db_host = $io->ask('<info>DB_HOST (Defaults to localhost): </info>', 'localhost');
      $io->write('** Site Definitions **', true);

      if(file_exists($theme_init)) {
        $theme_name = $io->ask('<info>THEME_NAME: </info>', false);
      } else {
        $theme_name = false;
      }
      $home_url = $io->ask('<info>HOME_URL: </info>', '');
    }

    if($theme_name) {
      define('APOLLO_THEME_NAME', $theme_name);
    }

    // FUTURE =--> Convert this to array/sprintf function
    $db_defs_string = PHP_EOL;
    $db_defs_string .= '// Enviornment Definitions' . PHP_EOL;
    $db_defs_string .= 'define("WP_ENV", "' . $env_var . '");' . PHP_EOL;
    $db_defs_string .= PHP_EOL;
    $db_defs_string .= '// Database Definitions' . PHP_EOL;
    $db_defs_string .= 'define("DB_NAME", "' . $db_name . '");' . PHP_EOL;
    $db_defs_string .= 'define("DB_USER", "' . $db_user . '");' . PHP_EOL;
    $db_defs_string .= 'define("DB_PASSWORD", "' . $db_pass . '");' . PHP_EOL;
    $db_defs_string .= 'define("DB_HOST", "' . $db_host . '");' . PHP_EOL;
    $db_defs_string .= PHP_EOL;
    $db_defs_string .= '// Site Definitions' . PHP_EOL;
    $db_defs_string .= 'define("WP_HOME", "' . $home_url . '");' . PHP_EOL;
    $db_defs_string .= 'define("WP_SITEURL", "' . $home_url . '/wp");' . PHP_EOL;

    // Append the defs to the db config file
    if (copy($db_config_sample, $db_config_file)) {
      file_put_contents( $db_config_file, $db_defs_string, FILE_APPEND | LOCK_EX );
    } else {
      $io->write("<error>An Error Occured while generating env_config</error>");
    }

    // Change the theme name if the theme is still the initial theme
    if(file_exists($theme_init)) {
      rename( realpath($theme_init), realpath($theme_root) . '/' . APOLLO_THEME_NAME );
    }

  }

  public static function runNPM(Event $event) {
    if(defined('APOLLO_THEME_NAME')) {
      // Run NPM Install in the Theme Directory
      $root = dirname( dirname(__DIR__) );
      $theme_root = $root . '/app/themes/' . APOLLO_THEME_NAME;
      $io->write("** Running NPM Install in Theme Directory **");
      exec("cd $theme_root && npm install");
    }
  }

}