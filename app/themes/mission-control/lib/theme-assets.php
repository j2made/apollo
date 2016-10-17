<?php

namespace Apollo\Assets;
use Apollo\Extend\Util;


/**
 * Add Custom Image Sizes
 *
 * @since  1.0.0
 */

// add_image_size($name, $width, $height, $hard_crop);



/**
 * Get Assets based on enviornment
 *
 * @param  $revpath  The path of the original file in the rev manifest.
 * @since  1.0.0
 */
function get_asset( $revpath ) {

  $home_path = get_bloginfo( 'stylesheet_directory' );
  $src_path  = $asset_path = $home_path . '/src/' . $revpath;

  if ( WP_ENV === 'development' ) {

    $asset_path = $home_path . DIST_DIR . $revpath;

  } else {

    // Get revisioned assets from Rev Manifest
    if ( $manifest = json_decode( Util\Fetch_Url( dirname(__DIR__) . '/dist/_rev-manifest.json', 'r' ) ) ) {

      $asset_path = $manifest->$revpath ? $home_path . DIST_DIR . $manifest->$revpath : $src_path;

    } else {

      // Use src if manifest is unavailable
      $asset_path = $src_path;

    }
  }

  return $asset_path;

}



/**
 * Register and Enqueue Assets
 *
 * @since 1.0.0
 */
function enqueue_assets() {

  /**
   * Enqueue jQuery
   *
   * Get version from jquery dependency in pacakge.json
   * Check for the Google CDN, if available, use.
   * If unavailable, use local fallback.
   * https://gist.github.com/wpsmith/4083811
   *
   * @since  1.0.0
   */
  if ( !is_admin() ) {

    $pkg_json     = json_decode( file_get_contents( TEMPLATEPATH . '/package.json', "r" ) );
    $jquery_ver   = str_replace('^', '', $pkg_json->dependencies->jquery);
    $url          = 'https://ajax.googleapis.com/ajax/libs/jquery/' . $jquery_ver . '/jquery.min.js';
    $local_jquery = get_bloginfo( 'stylesheet_directory' ) . '/dist/js/vendor/jquery.min.js';
    // $jquery_ver = '2.2.0';

    wp_deregister_script( 'jquery' );
    delete_transient( 'google_jquery' );

    if ( 'false' == ( $google = get_transient( 'google_jquery' ) ) ) {

      // Transient failed, set to local jquery
      $url = $local_jquery;

    } elseif ( false === $google ) {

      // Test for Google url
      $resp = wp_remote_head( $url );

      if ( !is_wp_error( $resp ) && 200 == $resp['response']['code'] ) {

        // Things are good, set transient for 5 minutes
        set_transient( 'google_jquery', 'true', 60 * 5 );

      } else {

        // Error, use WP version and set transient for 5 minutes
        set_transient( 'google_jquery', 'false', 60 * 5 );
        $url = $local_jquery;
        $jquery_ver = '1.11.3'; // Set jQuery Version, as of 4.3

      }
    }

    wp_register_script( 'jquery', $url, array(), $jquery_ver, true );

  }


  /**
   * Enqueue Apollo Scripts
   *
   * @since  1.0.0
   */
  wp_enqueue_script( 'jquery' );
  wp_enqueue_script( 'apollo-js', get_asset('js/bundle.js'), ['jquery'], null, true );


  /**
   * Enqueue Apollo CSS
   *
   * @since  1.0.0
   */
  $css = WP_ENV === 'development' ? 'css/main.css' : 'css/main.min.css';
  wp_enqueue_style( 'apollo-css', get_asset($css), false, null );


  /**
   * Enqueue Comment Scripts
   *
   * @since  1.0.0
   */
  if ( is_single() && comments_open() && get_option('thread_comments') ) {

    wp_enqueue_script( 'comment-reply' );

  }



  /**
   * Enqueue Fonts
   *
   * @since  1.0.0
   */
  if ( GOOGLE_FONTS !== false ) {

    $url = 'https://fonts.googleapis.com/css?family=' . GOOGLE_FONTS;
    wp_enqueue_style( 'google-fonts', $url );

  }

  if ( FONTAWESOME ) {

    wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );

  }

}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets', 100 );



/**
 * Add Typekit to head if ID is added
 *
 * @since 1.0.0
 */
function typekit() {

  echo '<script type="text/javascript" src="//use.typekit.net/' . TYPEKIT_ID . '.js"></script>';
  echo '<script type="text/javascript">try{Typekit.load();}catch(e){}</script>';

}

if ( TYPEKIT_ID ) {

  add_action('wp_head', __NAMESPACE__ . '\\typekit', 1);

}



/**
 * Google Analytics ID Field to WP Settings
 * ----------------------------------------
 * Add a new section to the General Settings Page
 *
 * @since  1.0.0
 */
add_action( 'admin_init', __NAMESPACE__ . '\\apollo_ga_id_settings_section' );

function apollo_ga_id_settings_section() {
  add_settings_section('ga_id_section', 'Google Analytics', __NAMESPACE__ . '\\ga_id_callback', 'general');

  // Add an analytics Form Field
  add_settings_field( 'ga_id', 'Google Analytics ID', __NAMESPACE__ . '\\ga_id_textbox_callback', 'general', 'ga_id_section', array('ga_id'));

  // Register the field
  register_setting('general','ga_id', 'esc_attr');
}


/**
 * Callback for Google Analytics ID field
 *
 * @since  1.0.0
 */
function ga_id_callback() {

  echo  '<p>Enter your '.
        '<a href="https://support.google.com/analytics/answer/1032385?hl=en" target="blank">' .
        'Google Analytics UA ID'.
        '</a> number to allow tracking.</p>';

}


/**
 * Save Analytics Field
 *
 * @since 1.0.0
 */
function ga_id_textbox_callback( $args ) {

  $option = get_option($args[0]);
  echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';

}



/**
 * Add Google Analytics to Site Footer
 *
 * Returns analytics in wp_head if enviornment is production
 * and user is not admin AND Google Analytics is setup in options
 *
 * @since 1.0.0
 *
 */
if ( get_option('ga_id') && WP_ENV === 'production' ) {

  add_action('wp_head', __NAMESPACE__ . '\\Google_Analytics_Script');

}

function Google_Analytics_Script() {

  if ( !current_user_can('manage_options') ) : ?>
    <script>
      !function(F,A,L,C,O,N){F.GoogleAnalyticsObject=L;F[L]||(F[L]=function(){
      (F[L].q=F[L].q||[]).push(arguments)});F[L].l=+new Date;O=A.createElement(C);
      N=A.getElementsByTagName(C)[0];O.src='//www.google-analytics.com/analytics.js';
      N.parentNode.insertBefore(O,N)}(window,document,'ga','script');
      ga('create', '<?= get_option('ga_id') ?>', 'auto');
      ga('send', 'pageview');
    </script>
  <?php endif;

}
