<?php

/*
  Plugin Name: Image Quality
  Plugin URI:  https://gagan0123.com/image-quality
  Description: Plugin to let you adjust compression ratio WordPress uses in media settings
  Version:     0.1
  Author:      Gagan Deep Singh
  Author URI:  https://gagan0123.com
  License:     GPL2
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
  Text Domain: gs_iq
  Domain Path: /languages
 */

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
	die;
}

define( 'GS_IQ_PREFIX', 'gs_iq' );
define( 'GS_IQ_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'GS_IQ_TEXTDOMAIN', GS_IQ_PREFIX );
define( 'GS_IQ_SETTINGS_SLUG', GS_IQ_PREFIX . '_image_quality' );

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