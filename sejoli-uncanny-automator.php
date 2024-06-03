<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sejoli.co.id
 * @since             1.0.0
 * @package           Sejoli_Uncanny_Automator
 *
 * @wordpress-plugin
 * Plugin Name:       Sejoli Uncanny Automator
 * Plugin URI:        https://sejoli.co.id
 * Description:       Integrate Sejoli Premium Membership plugin with Uncanny Automator.
 * Version:           1.1.2
 * Author:            Sejoli Team
 * Author URI:        https://sejoli.co.id
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sejoli-uncanny-automator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SEJOLI_UNCANNY_AUTOMATOR_VERSION', '1.1.2' );
define( 'SEJOLI_UNCANNY_AUTOMATOR_DIR', plugin_dir_path( __FILE__ ) );
define( 'SEJOLI_UNCANNY_AUTOMATOR_URL', plugin_dir_url( __FILE__ ) );

add_action('muplugins_loaded', 'sejoli_uncanny_automator_check_required_plugin');

function sejoli_uncanny_automator_check_required_plugin() {

	if(!defined('SEJOLISA_VERSION')) :

		add_action('admin_notices', 'sejoli_uncanny_automator_notice_functions');

		function sejoli_uncanny_automator_notice_functions() {
			?><div class='notice notice-error'>
			<p><?php _e('Anda belum menginstall atau mengaktifkan plugin SEJOLI!.', 'sejoli-uncanny-automator'); ?></p>
			</div><?php
		}

		return;

	endif;

	if(!defined('AUTOMATOR_PLUGIN_VERSION')) :

		add_action('admin_notices', 'sejoli_uncanny_automator_notice_functions');

		function sejoli_uncanny_automator_notice_functions() {
			?><div class='notice notice-error'>
			<p><?php _e('Anda belum menginstall atau mengaktifkan plugin UNCANNY AUTOMATOR!.', 'sejoli-uncanny-automator'); ?></p>
			</div><?php
		}

		return;

	endif;

}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sejoli-uncanny-automator-activator.php
 */
function activate_sejoli_uncanny_automator() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sejoli-uncanny-automator-activator.php';
	Sejoli_Uncanny_Automator_Activator::activate();

}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sejoli-uncanny-automator-deactivator.php
 */
function deactivate_sejoli_uncanny_automator() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sejoli-uncanny-automator-deactivator.php';
	Sejoli_Uncanny_Automator_Deactivator::deactivate();

}

register_activation_hook( __FILE__, 'activate_sejoli_uncanny_automator' );
register_deactivation_hook( __FILE__, 'deactivate_sejoli_uncanny_automator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sejoli-uncanny-automator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sejoli_uncanny_automator() {

	$plugin = new Sejoli_Uncanny_Automator();
	$plugin->run();

}

/**
 * Plugin update checker
 */
require_once(SEJOLI_UNCANNY_AUTOMATOR_DIR . 'vendor/yahnis-elsts/plugin-update-checker/plugin-update-checker.php');

$update_checker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/orangerdev/sejoli-uncanny-automator',
	__FILE__,
	'sejoli-uncanny-automator'
);

$update_checker->setBranch('master');

run_sejoli_uncanny_automator();
