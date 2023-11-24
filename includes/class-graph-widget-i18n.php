<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.maciejziemichod.com
 * @since      1.0.0
 *
 * @package    Graph_Widget
 * @subpackage Graph_Widget/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Graph_Widget
 * @subpackage Graph_Widget/includes
 * @author     Maciej Ziemichód <devziemichod@gmail.com>
 */
class Graph_Widget_I18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'graph-widget',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
