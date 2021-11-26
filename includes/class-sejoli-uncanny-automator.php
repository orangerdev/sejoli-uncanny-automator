<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://sejoli.co.id
 * @since      1.0.0
 *
 * @package    Sejoli_Uncanny_Automator
 * @subpackage Sejoli_Uncanny_Automator/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Sejoli_Uncanny_Automator
 * @subpackage Sejoli_Uncanny_Automator/includes
 * @author     Sejoli Team <admin@sejoli.co.id>
 */
class Sejoli_Uncanny_Automator {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Sejoli_Uncanny_Automator_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		
		if ( defined( 'SEJOLI_UNCANNY_AUTOMATOR_VERSION' ) ) {
			$this->version = SEJOLI_UNCANNY_AUTOMATOR_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'sejoli-uncanny-automator';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Sejoli_Uncanny_Automator_Loader. Orchestrates the hooks of the plugin.
	 * - Sejoli_Uncanny_Automator_i18n. Defines internationalization functionality.
	 * - Sejoli_Uncanny_Automator_Admin. Defines all hooks for the admin area.
	 * - Sejoli_Uncanny_Automator_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once SEJOLI_UNCANNY_AUTOMATOR_DIR . 'includes/class-sejoli-uncanny-automator-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once SEJOLI_UNCANNY_AUTOMATOR_DIR . 'includes/class-sejoli-uncanny-automator-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once SEJOLI_UNCANNY_AUTOMATOR_DIR . 'admin/class-sejoli-uncanny-automator-admin.php';
		require_once SEJOLI_UNCANNY_AUTOMATOR_DIR . 'admin/uncanny-sejoli-automator.php';

		/**
		 * The class Uncanny Automator Integration.
		 */
		// require_once SEJOLI_UNCANNY_AUTOMATOR_DIR . 'admin/sejoli-automator/add-sejoli-automator-integration.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once SEJOLI_UNCANNY_AUTOMATOR_DIR . 'public/class-sejoli-uncanny-automator-public.php';

		$this->loader = new Sejoli_Uncanny_Automator_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sejoli_Uncanny_Automator_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Sejoli_Uncanny_Automator_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$admin = new Sejoli_Uncanny_Automator\Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts' );

		$sejoli_automator = new Sejoli_Uncanny_Automator\Admin\Uncanny_Sejoli_Automator();

		// $this->loader->add_action( 'plugins_loaded', $sejoli_automator, 'setup_integration' );
		$this->loader->add_action( 'automator_configuration_complete', $sejoli_automator, 'add_this_integration' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Sejoli_Uncanny_Automator\Front( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
	
		$this->loader->run();
	
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		
		return $this->plugin_name;
	
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Sejoli_Uncanny_Automator_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
	
		return $this->loader;
	
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
	
		return $this->version;
	
	}

}
