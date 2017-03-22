<?php

// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
	die;
}

if ( !class_exists( 'GS_Image_Quality' ) ) {

	class GS_Image_Quality {

		protected static $instance = null;

		/**
		 * @var int Image quality setting value
		 */
		private $image_quality;

		public function __construct() {
			add_action( 'init', array( $this, 'init' ) );
			add_filter( 'jpeg_quality', array( $this, 'get_image_quality' ) );
		}

		/**
		 * @return GS_Image_Quality Returns the current instance of the class
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		public function init() {
			$this->image_quality = get_option( GS_IQ_SETTINGS_SLUG, 90 );
		}

		public function get_image_quality() {
			return get_option( GS_IQ_SETTINGS_SLUG, $this->image_quality );
		}

	}

	GS_Image_Quality::get_instance();
}