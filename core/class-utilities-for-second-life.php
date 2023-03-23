<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! class_exists( 'Utilities_For_Second_Life' ) ) :

	/**
	 * Main Utilities_For_Second_Life Class.
	 *
	 * @package		UTILITIESF
	 * @subpackage	Classes/Utilities_For_Second_Life
	 * @since		1.0.0
	 * @author		Nolan Perry, LLC
	 */
	final class Utilities_For_Second_Life {

		/**
		 * The real instance
		 *
		 * @access	private
		 * @since	1.0.0
		 * @var		object|Utilities_For_Second_Life
		 */
		private static $instance;

		/**
		 * UTILITIESF helpers object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Utilities_For_Second_Life_Helpers
		 */
		public $helpers;

		/**
		 * UTILITIESF settings object.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @var		object|Utilities_For_Second_Life_Settings
		 */
		public $settings;

		/**
		 * Throw error on object clone.
		 *
		 * Cloning instances of the class is forbidden.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to clone this class.', 'utilities-for-second-life' ), '1.0.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @access	public
		 * @since	1.0.0
		 * @return	void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'You are not allowed to unserialize this class.', 'utilities-for-second-life' ), '1.0.0' );
		}

		/**
		 * Main Utilities_For_Second_Life Instance.
		 *
		 * Insures that only one instance of Utilities_For_Second_Life exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @access		public
		 * @since		1.0.0
		 * @static
		 * @return		object|Utilities_For_Second_Life	The one true Utilities_For_Second_Life
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Utilities_For_Second_Life ) ) {
				self::$instance					= new Utilities_For_Second_Life;
				self::$instance->base_hooks();
				self::$instance->includes();
				self::$instance->helpers		= new Utilities_For_Second_Life_Helpers();
				self::$instance->settings		= new Utilities_For_Second_Life_Settings();

				//Fire the plugin logic
				new Utilities_For_Second_Life_Run();
				new Utilities_For_Second_Life_Profile();

				/**
				 * Fire a custom action to allow dependencies
				 * after the successful plugin setup
				 */
				do_action( 'UTILITIESF/plugin_loaded' );
			}

			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function includes() {
			require_once UTILITIESF_PLUGIN_DIR . 'core/includes/classes/class-utilities-for-second-life-helpers.php';
			require_once UTILITIESF_PLUGIN_DIR . 'core/includes/classes/class-utilities-for-second-life-settings.php';
			require_once UTILITIESF_PLUGIN_DIR . 'core/includes/classes/class-utilities-for-second-life-profile.php';

			require_once UTILITIESF_PLUGIN_DIR . 'core/includes/classes/class-utilities-for-second-life-run.php';
		}

		/**
		 * Add base hooks for the core functionality
		 *
		 * @access  private
		 * @since   1.0.0
		 * @return  void
		 */
		private function base_hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'utilities-for-second-life', FALSE, dirname( plugin_basename( UTILITIESF_PLUGIN_FILE ) ) . '/languages/' );
		}

	}

endif; // End if class_exists check.