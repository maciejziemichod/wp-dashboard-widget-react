<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.maciejziemichod.com
 * @since      1.0.0
 *
 * @package    Graph_Widget
 * @subpackage Graph_Widget/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Graph_Widget
 * @subpackage Graph_Widget/admin
 * @author     Maciej Ziemichód <devziemichod@gmail.com>
 */
class Graph_Widget_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private string $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private string $version;

	/**
	 * ID of the dashboard widget.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $widget_id ID of the dashboard widget.
	 */
	private string $widget_id;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 * @param string $widget_id ID of the dashboard widget.
	 *
	 * @since    1.0.0
	 */
	public function __construct( string $plugin_name, string $version, string $widget_id ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->widget_id   = $widget_id;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Graph_Widget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Graph_Widget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'build/index.css', [], $this->version );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Graph_Widget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Graph_Widget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'build/index.js', [], $this->version, [ 'strategy' => 'defer' ] );
	}

	public function register_rest_route(): void {
		register_rest_route( "{$this->plugin_name}/v1", '/data', array(
			'methods'  => 'GET',
			'callback' => [ $this, 'getData' ],
			'args'     => [
				'count' => [
					'validate_callback' => fn( mixed $param ): bool => is_numeric( $param )
				]
			]
		) );
	}

	public function getData( WP_REST_Request $request ): WP_REST_Response {
		$data = get_option( GRAPH_WIDGET_OPTION_KEY );
		if ( $data === false ) {
			return $this->getErrorRestResponse( 'Failed to retrieve data', 502 );
		}

		$requestedRange = $request->get_param( 'count' );
		if ( $requestedRange === null ) {
			return $this->getErrorRestResponse( 'Missing required "count" parameter' . $requestedRange, 400 );
		}

		$length = count( $data );
		if ( $length < $requestedRange ) {
			return $this->getErrorRestResponse( "Don't have enough data", 500 );
		}

		$requestedData = array_slice( $data, $length - $requestedRange );

		return new WP_REST_Response( $requestedData );
	}

	private function getErrorRestResponse( string $message, int $status ): WP_REST_Response {
		return new WP_REST_Response( [ 'message' => $message ], $status );
	}

	public function add_dashboard_widget(): void {
		wp_add_dashboard_widget(
			$this->widget_id,
			'Graph Widget',
			[ $this, 'render_widget' ]
		);
	}

	public function render_widget(): void {
		echo '<div class="root"></div>';
	}
}
