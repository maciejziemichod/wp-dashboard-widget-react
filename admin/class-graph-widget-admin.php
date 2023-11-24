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
	 * @param string $hook_suffix Current admin page hook.
	 *
	 * @return void
	 * @since    1.0.0
	 */
	public function enqueue_styles( string $hook_suffix ): void {

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
		if ( ! $this->is_admin_dashboard_page( $hook_suffix ) ) {
			return;
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'build/index.css', array(), $this->version );
	}

	/**
	 * Checks if page hook is for admin dashboard page.
	 *
	 * @param string $hook Admin page hook.
	 *
	 * @return bool
	 */
	private function is_admin_dashboard_page( string $hook ): bool {
		return 'index.php' === $hook;
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @param string $hook_suffix Current admin page hook.
	 *
	 * @return void
	 * @since    1.0.0
	 */
	public function enqueue_scripts( string $hook_suffix ): void {

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

		if ( ! $this->is_admin_dashboard_page( $hook_suffix ) ) {
			return;
		}

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'build/index.js', array(), $this->version, array( 'strategy' => 'defer' ) );
	}

	/**
	 * Registers plugin REST route.
	 *
	 * @return void
	 */
	public function register_rest_route(): void {
		register_rest_route(
			"{$this->plugin_name}/v1",
			'/data',
			array(
				'methods'  => 'GET',
				'callback' => array( $this, 'get_data' ),
				'args'     => array(
					'count' => array(
						'validate_callback' => fn( mixed $param ): bool => is_numeric( $param ),
					),
				),
			)
		);
	}

	/**
	 * Controller for /data endpoint.
	 *
	 * @param WP_REST_Request $request REST request object.
	 *
	 * @return WP_REST_Response
	 */
	public function get_data( WP_REST_Request $request ): WP_REST_Response {
		$data = get_option( GRAPH_WIDGET_OPTION_KEY );
		if ( false === $data ) {
			return $this->get_error_rest_response( 'Failed to retrieve data', 502 );
		}

		$requested_range = $request->get_param( 'count' );
		if ( null === $requested_range ) {
			return $this->get_error_rest_response( 'Missing required "count" parameter' . $requested_range, 400 );
		}

		$length = count( $data );
		if ( $length < $requested_range ) {
			return $this->get_error_rest_response( "Don't have enough data", 500 );
		}

		$requested_data = array_slice( $data, $length - $requested_range );

		return new WP_REST_Response( $requested_data );
	}

	/**
	 * Used to retrieve uniformed error REST response.
	 *
	 * @param string $message Error message.
	 * @param int    $status Response status code.
	 *
	 * @return WP_REST_Response
	 */
	private function get_error_rest_response( string $message, int $status ): WP_REST_Response {
		return new WP_REST_Response( array( 'message' => $message ), $status );
	}

	/**
	 * Register plugin dashboard widget.
	 *
	 * @return void
	 */
	public function add_dashboard_widget(): void {
		wp_add_dashboard_widget(
			$this->widget_id,
			'Graph Widget',
			array( $this, 'render_widget' )
		);
	}

	/**
	 * Renders widget container.
	 *
	 * @return void
	 */
	public function render_widget(): void {
		echo '<div class="root"></div>';
	}
}
