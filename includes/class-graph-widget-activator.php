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
	public static function activate(): void {
		if ( ! defined( 'GRAPH_WIDGET_OPTION_KEY' ) ) {
			wp_die( '"GRAPH_WIDGET_OPTION_KEY" constant wasn\'t found during activation' );
		}

		add_option( GRAPH_WIDGET_OPTION_KEY, self::generate_dummy_data() );
	}

	/**
	 * Used to generate dummy data for endpoint purposes.
	 *
	 * @return array
	 */
	private static function generate_dummy_data(): array {
		$current_date = new DateTime();
		$data         = array();

		for ( $i = 59; $i >= 0; $i-- ) {
			$timestamp = ( $current_date->getTimestamp() - $i * 24 * 60 * 60 ) * 1000;
			$value     = wp_rand( 1, 100 );

			$data[] = array(
				'timestamp' => $timestamp,
				'value'     => $value,
			);
		}

		return $data;
	}
}
