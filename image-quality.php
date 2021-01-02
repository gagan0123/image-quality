<?php
/**
 * Plugin Name: Image Quality
 * Plugin URI:  https://wordpress.org/plugins/image-quality/
 * Description: Plugin to let you adjust compression ratio WordPress uses in media settings
 * Version:     1.5.2
 * Author:      Gagan Deep Singh
 * Author URI:  https://gagan0123.com
 * License:     GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: image-quality
 * Domain Path: /languages
 *
 * @package Image_Quality
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! defined( 'GS_IQ_PREFIX' ) ) {
	/**
	 * Prefix for most of the things in this plugin
	 *
	 * @since 1.0
	 */
	define( 'GS_IQ_PREFIX', 'gs_iq' );
}
if ( ! defined( 'GS_IQ_PATH' ) ) {
	/**
	 * Path to the plugin directory
	 *
	 * @since 1.0
	 */
	define( 'GS_IQ_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( ! defined( 'GS_IQ_SETTINGS_SLUG' ) ) {
	/**
	 * Settings slug
	 *
	 * @since 1.0
	 */
	define( 'GS_IQ_SETTINGS_SLUG', GS_IQ_PREFIX . '_image_quality' );
}

if ( ! defined( 'GS_IQ_BASENAME' ) ) {
	/**
	 * Basename of the plugin
	 *
	 * @since 1.5
	 */
	define( 'GS_IQ_BASENAME', plugin_basename( __FILE__ ) );
}

/**
 * The core plugin class
 */
require_once GS_IQ_PATH . 'includes/class-gs-image-quality.php';

/**
 * Load the admin class if its the admin dashboard
 */
if ( is_admin() ) {
	require_once GS_IQ_PATH . 'admin/class-gs-image-quality-admin.php';
}
