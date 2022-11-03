<?php

/**
 * @link              upentreprise.com/prabch
 * @since             1.0.0
 * @package           Woo_Virtual_Fiton
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Virtual FitOn
 * Plugin URI:        upentreprise.com
 * Description:       Let shoppers try your products virtually before they buy.
 * Version:           1.0.1
 * Author:            UPentreprise
 * Author URI:        upentreprise.com/prabch
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-virtual-fiton
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
define( 'WOO_VIRTUAL_FITON_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-virtual-fiton-activator.php
 */
function activate_woo_virtual_fiton() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-virtual-fiton-activator.php';
	Woo_Virtual_Fiton_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-virtual-fiton-deactivator.php
 */
function deactivate_woo_virtual_fiton() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-virtual-fiton-deactivator.php';
	Woo_Virtual_Fiton_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_virtual_fiton' );
register_deactivation_hook( __FILE__, 'deactivate_woo_virtual_fiton' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-virtual-fiton.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_virtual_fiton() {

	$plugin = new Woo_Virtual_Fiton();
	$plugin->run();

}
run_woo_virtual_fiton();
