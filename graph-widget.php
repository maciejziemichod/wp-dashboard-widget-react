<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.maciejziemichod.com
 * @since             1.0.0
 * @package           Graph_Widget
 *
 * @wordpress-plugin
 * Plugin Name:       Graph Widget
 * Plugin URI:        https://www.maciejziemichod.com
 * Description:       React + REST
 * Version:           1.0.0
 * Author:            Maciej Ziemichód
 * Author URI:        https://www.maciejziemichod.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       graph-widget
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
define( 'GRAPH_WIDGET_VERSION', '1.0.0' );
define( 'GRAPH_WIDGET_OPTION_KEY', 'graph_widget_rest_data' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-graph-widget-activator.php
 */
function activate_graph_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-graph-widget-activator.php';
	Graph_Widget_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-graph-widget-deactivator.php
 */
function deactivate_graph_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-graph-widget-deactivator.php';
	Graph_Widget_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_graph_widget' );
register_deactivation_hook( __FILE__, 'deactivate_graph_widget' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-graph-widget.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_graph_widget() {

	$plugin = new Graph_Widget();
	$plugin->run();

}

run_graph_widget();
