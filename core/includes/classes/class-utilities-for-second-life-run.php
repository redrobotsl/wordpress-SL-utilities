<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Utilities_For_Second_Life_Run
 *
 * Thats where we bring the plugin to life
 *
 * @package		UTILITIESF
 * @subpackage	Classes/Utilities_For_Second_Life_Run
 * @author		Nolan Perry, LLC
 * @since		1.0.0
 */
class Utilities_For_Second_Life_Run{

	/**
	 * Our Utilities_For_Second_Life_Run constructor 
	 * to run the plugin logic.
	 *
	 * @since 1.0.0
	 */
	function __construct(){
		$this->add_hooks();
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOKS
	 * ###
	 * ######################
	 */

	/**
	 * Registers all WordPress and plugin related hooks
	 *
	 * @access	private
	 * @since	1.0.0
	 * @return	void
	 */
	private function add_hooks(){
	
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_frontend_scripts_and_styles' ), 20 );
	
	}

	/**
	 * ######################
	 * ###
	 * #### WORDPRESS HOOK CALLBACKS
	 * ###
	 * ######################
	 */


	/**
	 * Enqueue the frontend related scripts and styles for this plugin.
	 *
	 * @access	public
	 * @since	1.0.0
	 *
	 * @return	void
	 */
	public function enqueue_frontend_scripts_and_styles() {
		wp_enqueue_style( 'utilitiesf-frontend-styles', UTILITIESF_PLUGIN_URL . 'core/includes/assets/css/frontend-styles.css', array(), UTILITIESF_VERSION, 'all' );
		wp_enqueue_script( 'utilitiesf-frontend-scripts', UTILITIESF_PLUGIN_URL . 'core/includes/assets/js/frontend-scripts.js', array( 'jquery' ), UTILITIESF_VERSION, false );
		wp_localize_script( 'utilitiesf-frontend-scripts', 'utilitiesf', array(
			'demo_var'   		=> __( 'This is some demo text coming from the backend through a variable within javascript.', 'utilities-for-second-life' ),
		));
	}

}
