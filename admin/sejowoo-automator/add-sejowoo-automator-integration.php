<?php
use Uncanny_Automator\Recipe;

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

class Add_Sejowoo_Automator_Integration {

	use Recipe\Integrations;

	/**
	 * Add_Integration constructor.
	 */
	public function __construct() {

		$this->setup();

	}

	/**
	 *
	 */
	protected function setup() {

		$this->set_integration( 'SEJOWOO' );
		$this->set_name( 'Sejoli WooCommerce' );
		$this->set_icon( 'default-logo.png' );
		$this->set_icon_path( '../sejoli-automator/img/' );
		$this->set_plugin_file_path( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'admin/uncanny-sejoli-automator.php' );
		$this->set_external_integration( true );
	
	}

	/**
	 * Explicitly return true because this plugin code will only run if it's active.
	 * Add your own plugin active logic here, for example, check for a specific function exists before integration is
	 * returned as active.
	 *
	 * This is an option override. By default Uncanny Automator will check $this->get_plugin_file_path() to validate
	 * if plugin is active.
	 *
	 * @return bool
	 */
	public function plugin_active() {

		return true;
	
	}

}