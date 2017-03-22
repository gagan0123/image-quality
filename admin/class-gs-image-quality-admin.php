<?php
// If this file is called directly, abort.
if ( !defined( 'ABSPATH' ) ) {
	die;
}

if ( !class_exists( 'GS_Image_Quality_Admin' ) ) {

	class GS_Image_Quality_Admin {

		/**
		 * Holds the values to be used in the fields callbacks
		 */
		protected static $instance = null;

		/**
		 * Start up
		 */
		public function __construct() {
			add_action( 'admin_init', array( $this, 'page_init' ) );
		}

		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Register and add settings
		 */
		public function page_init() {

			//Image Quality Setting Field ID
			$setting_id = GS_IQ_PREFIX . '_image_quality';

			//Image Quality Setting Label
			$label = '<label for="' . $setting_id . '">' . __( 'Image Quality', GS_IQ_TEXTDOMAIN ) . '</label>';

			// This function will render the input field
			$callback = array( $this, 'render_image_quality_field' );

			//Arguments to pass to the settings rendering function
			$args = array(
				'id' => $setting_id
			);

			//Adding the setting field
			add_settings_field( $setting_id, $label, $callback, 'media', 'default', $args );

			//Registering the setting
			register_setting( 'media', GS_IQ_PREFIX . '_image_quality', array( $this, 'sanitize' ) );
		}

		/**
		 * Sanitize the input values
		 *
		 * @param array $input Contains all settings fields as array keys
		 */
		public function sanitize( $input ) {

			$setting_id = GS_IQ_PREFIX . '_image_quality';

			$sanitized_input = intval( $input );

			$is_error = false;

			$message = '';

			if ( $sanitized_input > 0 && $sanitized_input <= 100 ) {
				//Input field is correctly set
			} else if ( empty( $input ) ) {
				//Input is empty
				$is_error	 = true;
				$message	 = __( 'Image Quality cannot be empty.', GS_IQ_TEXTDOMAIN );
			} else {
				//Input field is containing something else
				$is_error	 = true;
				$message	 = __( 'Image Quality can only be a number between 1 to 100.', GS_IQ_TEXTDOMAIN );
			}

			if ( $is_error ) {
				add_settings_error( $setting_id, 'settings_updated', $message, 'error' );
				return GS_Image_Quality::get_instance()->get_image_quality();
			}

			return $sanitized_input;
		}

		public function render_image_quality_field( $args ) {
			$setting_id			 = GS_IQ_PREFIX . '_image_quality';
			$gs_image_quality	 = GS_Image_Quality::get_instance();
			$quality			 = $gs_image_quality->get_image_quality();

			echo '<input type="number" name="' . $setting_id . '" min="0" max="100" value="' . $quality . '" />';
			?> <span class="description"><?php _e( 'Set value between 0 to 100', 'google_tag_manager' ); ?></span><?php
		}

	}

	GS_Image_Quality_Admin::get_instance();
}