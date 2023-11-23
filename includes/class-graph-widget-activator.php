<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.maciejziemichod.com
 * @since      1.0.0
 *
 * @package    Graph_Widget
 * @subpackage Graph_Widget/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Graph_Widget
 * @subpackage Graph_Widget/includes
 * @author     Maciej Ziemichód <devziemichod@gmail.com>
 */
class Graph_Widget_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if ( ! defined( 'GRAPH_WIDGET_OPTION_KEY' ) ) {
			wp_die( '"GRAPH_WIDGET_OPTION_KEY" constant wasn\'t found during activation' );
		}

		add_option( GRAPH_WIDGET_OPTION_KEY, [ [ 'time' => 123, 'value' => 1 ], [ 'time' => 123, 'value' => 1 ] ] );
	}

}
