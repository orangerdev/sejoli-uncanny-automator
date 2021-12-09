<?php
namespace Sejoli_Uncanny_Automator\Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://sejoli.co.id
 * @since      1.0.0
 *
 * @package    Sejoli_Uncanny_Automator
 * @subpackage Sejoli_Uncanny_Automator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sejoli_Uncanny_Automator
 * @subpackage Sejoli_Uncanny_Automator/admin
 * @author     Sejoli Team <admin@sejoli.co.id>
 */

class Uncanny_Sejowoo_Automator {

	/**
     * @var
     */
    public $integration_dir;

	/**
	 * @var string
	 */
	public $integration_code = 'sejowoo-automator';

	/**
	 * @var string
	 */
	public $directory;

	/**
	 * Uncanny_Sejowoo_Automator constructor.
	 */
	public function __construct() {

		$this->directory = __DIR__ . DIRECTORY_SEPARATOR . $this->integration_code;   
	
	}

	/**
	 * Add integration and all related files to Automator so that it shows up under Triggers / Actions
	 *
	 * @return bool|null
	 * @throws \Uncanny_Automator\Automator_Exception
	 */
	public function add_this_integration() {
		
		if ( ! function_exists( 'automator_add_integration' ) ) {
			wp_die( 'automator_add_integration() function not found. Please upgrade Uncanny Automator to version 3.0+' ); //phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error
		}

		if ( empty( $this->integration_code ) || empty( $this->directory ) ) {
			return false;
		}

		automator_add_integration_directory( $this->integration_code, $this->directory );
	
	}

}

new Uncanny_Sejowoo_Automator();