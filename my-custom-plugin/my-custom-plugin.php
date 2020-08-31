<?php

/**
 * @link https://github.com/silvergama/wp-to-test
 * @since 0.0.1
 * @package My_Custom_Plugin
 *
 * @wordpress-plugin
 * Plugin Name: My Custom Plugin
 * Plugin URI: https://github.com/silvergama/wp-to-test
 * Description:
 * Version: 0.0.1
 * Author: Silver Gama
 * Author URI: https://github.com/silvergama
 * License: 
 * License URI:
 * Text Domain: my-custom-plugin
 * Domain Path: /languages/
 */

if ( ! defined( 'WPINC' ) ) {
    wp_die();
}

// Plugin Version
if ( ! defined( 'MY_CUSTOM_PLUGIN_VERSION' ) ) {
    define( 'MY_CUSTOM_PLUGIN_VERSION', '0.0.1' );
}

// Plugin Name
if ( ! defined( 'MY_CUSTOM_PLUGIN_NAME' ) ) {
    define( 'MY_CUSTOM_PLUGIN_NAME', 'My Custom Plugin Name' );
}

// Plugin Slug
if ( ! defined( 'MY_CUSTOM_PLUGIN_SLUG' ) ) {
    define( 'MY_CUSTOM_PLUGIN_SLUG', 'my-custom-plugin' );
}

// Plugin Basename
if ( ! defined( 'MY_CUSTOM_PLUGIN_BASENAME' ) ) {
    define( 'MY_CUSTOM_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}

// Plugin Basename
if ( ! defined( 'MY_CUSTOM_PLUGIN_DIR' ) ) {
    define( 'MY_CUSTOM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Plugin Basename
if ( ! defined( 'MY_CUSTOM_PLUGIN_JSON' ) ) {
    define( 'MY_CUSTOM_PLUGIN_JSON', 'my-yt-rec.json' );
}

require_once MY_CUSTOM_PLUGIN_DIR . 'includes/my-custom-plugin.php';
require_once MY_CUSTOM_PLUGIN_DIR . 'includes/my-custom-plugin-json.php';
require_once MY_CUSTOM_PLUGIN_DIR . 'includes/my-custom-plugin-shortcode.php';
require_once MY_CUSTOM_PLUGIN_DIR . 'includes/my-custom-plugin-widget.php';

if (is_admin()) {
    require_once MY_CUSTOM_PLUGIN_DIR . 'includes/my-custom-plugin-admin.php';
    $a = new MyCustomPluginAdmin(
        MY_CUSTOM_PLUGIN_BASENAME,
        MY_CUSTOM_PLUGIN_SLUG,
        MY_CUSTOM_PLUGIN_JSON,
        MY_CUSTOM_PLUGIN_VERSION
    );
}
