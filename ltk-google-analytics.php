<?php
/**
 * Plugin Name: LTK Google Analytics
 * Plugin URI: https://wordpress.org/plugins/ltk-google-analytics/
 * Description: Add the Google Analytics code to your website to get stats and track variables.
 * Version: 1.0.0
 * Author: Mootex
 * Author URI: https://mootex.co/
 */

if ( ! defined('LTK_DS') ) {
	define( 'LTK_DS', DIRECTORY_SEPARATOR );
}

require __DIR__ . LTK_DS . 'autoload.php';
// require __DIR__ . LTK_DS . 'vendor' . LTK_DS . 'autoload.php';
require __DIR__ . LTK_DS . 'autoload-vendor-wp.php';

define( 'LTK_GOOGLE_ANALYTICS_PATH', dirname( __FILE__ ) . LTK_DS );
define( 'LTK_GOOGLE_ANALYTICS_URL', plugin_dir_url( __FILE__ ) );
define( 'LTK_GOOGLE_ANALYTICS_VERSION', '1.0.0' );

use LTK\WordPress\GoogleAnalytics\GoogleAnalytics;
use LTK\WordPress\GoogleAnalytics\GoogleAnalytics_Admin;

/* Translations */

$locale = apply_filters( 'plugin_locale', get_locale(), 'ltk-google-analytics' );

load_textdomain('ltk-google-analytics',
	WP_LANG_DIR . LTK_DS . 'ltk-google-analytics' . LTK_DS . 'ltk-google-analytics-' . $locale . '.mo'
);

load_plugin_textdomain('ltk-google-analytics', false,
	dirname( plugin_basename( __FILE__ ) ) . LTK_DS . 'languages' . LTK_DS
);

/* Initialization */

$LTK_GoogleAnalytics = null;

if ( is_admin() ) {
	$LTK_GoogleAnalytics = new GoogleAnalytics_Admin();
} else {
	$LTK_GoogleAnalytics = new GoogleAnalytics();
}

$LTK_GoogleAnalytics->init();
