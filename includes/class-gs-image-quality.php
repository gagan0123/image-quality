<?php
/**
 * Handles plugin's interaction with WordPress
 *
 * @package Image_Quality
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'GS_Image_Quality' ) ) {

	/**
	 * Handles most of the interaction of the plugin with WordPress
	 *
	 * @since 1.0
	 */
	class GS_Image_Quality {

		/**
		 * The current instance of the class GS_Image_Quality
		 *
		 * @access protected
		 *
		 * @static
		 *
		 * @since 1.0
		 *
		 * @var GS_Image_Quality
		 */
		protected static $instance = null;

		/**
		 * Image quality setting value
		 *
		 * @access private
		 *
		 * @since 1.0
		 *
		 * @var int
		 */
		private $image_quality;

		/**
		 * Hooks the actions and filters
		 *
		 * @access public
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'init' ) );
			add_filter( 'jpeg_quality', array( $this, 'get_image_quality' ) );
		}

		/**
		 * Returns the current instance of the class
		 *
		 * @access public
		 *
		 * @static
		 *
		 * @since 1.0
		 *
		 * @return GS_Image_Quality Returns the current instance of the class
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Loads the setting of the plugin at init
		 *
		 * @access public
		 *
		 * @since 1.0
		 *
		 * @return void
		 */
		public function init() {
			// Lets set up our image_quality variable from settings.
			$this->image_quality = (int) get_option( GS_IQ_SETTINGS_SLUG, 90 );
		}

		/**
		 * Returns the image quality setting
		 *
		 * @access public
		 *
		 * @since 1.0
		 *
		 * @return int Returns the image quality setting
		 */
		public function get_image_quality() {
			return $this->image_quality;
		}

	}

	GS_Image_Quality::get_instance();
}
