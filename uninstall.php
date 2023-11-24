<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://www.maciejziemichod.com
 * @since      1.0.0
 *
 * @package    Graph_Widget
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Class responsible for handling actions on plugin uninstall
 *
 * @since      1.0.0
 * @package    Graph_Widget
 * @author     Maciej Ziemichód <devziemichod@gmail.com>
 */
class Graph_Widget_Uninstaller {
	/**
	 * Handles uninstall action
	 *
	 * @return void
	 */
	public static function uninstall(): void {
		delete_option( 'graph_widget_rest_data' );
	}
}

Graph_Widget_Uninstaller::uninstall();
