<?php
/**
 * Handles admin side interactions of the plugin with WordPress
 *
 * @package Image_Quality
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'GS_Image_Quality_Admin' ) ) {

	/**
	 * Handles the admin side interactions of the plugin
	 *
	 * @since 1.0
	 */
	class GS_Image_Quality_Admin {

		/**
		 * Holds the instance of the GS_Image_Quality_Admin
		 *
		 * @access protected
		 *
		 * @static
		 *
		 * @since 1.0
		 *
		 * @var GS_Image_Quality_Admin
		 */
		protected static $instance = null;

		/**
		 * Hooks the actions
		 *
		 * @access public
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'admin_init', array( $this, 'page_init' ) );
			add_action( 'plugins_loaded', array( $this, 'init_localization' ) );
			add_action( 'plugin_action_links_' . GS_IQ_BASENAME, array( $this, 'plugin_action_link' ) );
		}

		/**
		 * Returns the instance of the class GS_Image_Quality_Admin
		 *
		 * @access public
		 *
		 * @static
		 *
		 * @since 1.0
		 *
		 * @return GS_Image_Quality_Admin Instance of the class GS_Image_Quality_Admin
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Initialize localization
		 *
		 * @access public
		 *
		 * @since 1.0
		 *
		 * @return void
		 */
		public function init_localization() {
			load_plugin_textdomain( 'image-quality' );
		}

		/**
		 * Register and add settings
		 *
		 * @access public
		 *
		 * @since 1.0
		 *
		 * @return void
		 */
		public function page_init() {

			// Image Quality Setting Field ID.
			$setting_id = GS_IQ_PREFIX . '_image_quality';

			// Image Quality Setting Label.
			$label = '<label for="' . $setting_id . '">' . esc_html__( 'Image Quality', 'image-quality' ) . '</label>';

			// This function will render the input field.
			$callback = array( $this, 'render_image_quality_field' );

			// Adding the setting field.
			add_settings_field( $setting_id, $label, $callback, 'media', 'default' );

			// Registering the setting.
			register_setting( 'media', GS_IQ_PREFIX . '_image_quality', array( $this, 'sanitize' ) );
		}

		/**
		 * Sanitize the input value.
		 *
		 * @access public
		 *
		 * @since 1.0
		 *
		 * @param string $input Contains the value entered by the user in options page.
		 *
		 * @return int Sanitized input value for image quality setting.
		 */
		public function sanitize( $input ) {

			$setting_id = GS_IQ_PREFIX . '_image_quality';

			$sanitized_input = intval( $input );

			$is_error = false;

			$message = '';

			if ( $sanitized_input > 0 && $sanitized_input <= 100 ) {
				// Input field is correctly set.
				return $sanitized_input;
			} elseif ( empty( $input ) ) {
				// Input is empty.
				$is_error = true;
				$message  = esc_html__( 'Image Quality cannot be empty.', 'image-quality' );
			} else {
				// Input field is containing something else.
				$is_error = true;
				$message  = esc_html__( 'Image Quality can only be a number between 1 to 100.', 'image-quality' );
			}

			if ( $is_error ) {
				add_settings_error( $setting_id, 'settings_updated', $message, 'error' );
				return GS_Image_Quality::get_instance()->get_image_quality();
			}

			// I know this line will never execute, but still feel like keeping it here :) .
			return $sanitized_input;
		}

		/**
		 * Output the Image Quality setting field in Dashboard.
		 *
		 * @access public
		 *
		 * @since 1.0
		 *
		 * @return void
		 */
		public function render_image_quality_field() {
			// Lets initialize our variables.
			$setting_id       = GS_IQ_PREFIX . '_image_quality';
			$gs_image_quality = GS_Image_Quality::get_instance();
			$quality          = esc_attr( $gs_image_quality->get_image_quality() );

			echo "<input type='number' name='" . esc_attr( $setting_id ) . "' id='" . esc_attr( $setting_id ) . "' min='1' max='100' value='" . esc_attr( $quality ) . "' />";
			?> <span class="description"><?php esc_html_e( 'Set value between 1 to 100', 'image-quality' ); ?></span>
			<?php /* translators: %s: Number 90 */ ?>
			<p class="description"><?php printf( esc_html__( 'By default WordPress uses %s', 'image-quality' ), '<b>90</b>' ); ?></p>
			<?php
		}

		/**
		 * Adds the settings action link on the plugins page for Image Quality plugin.
		 *
		 * @access public
		 *
		 * @since 1.5
		 *
		 * @param array $actions An array of plugin action links.
		 *
		 * @return array Returns the array of plugin action links with settings link.
		 */
		public function plugin_action_link( $actions ) {
			$setting_id = GS_IQ_PREFIX . '_image_quality';
			$path       = 'options-media.php#' . $setting_id;
			$url        = admin_url( $path );

			$settings_tag = '<a href="' . esc_url( $url ) . '" aria-label="'
			. esc_attr__( 'Image Quality Setting', 'image-quality' ) . '">'
			. esc_html__( 'Settings', 'image-quality' ) . '</a>';

			$new_actions = array_merge(
				array(
					'settings' => $settings_tag,
				),
				$actions
			);
			return $new_actions;
		}

	}

	GS_Image_Quality_Admin::get_instance();
}
