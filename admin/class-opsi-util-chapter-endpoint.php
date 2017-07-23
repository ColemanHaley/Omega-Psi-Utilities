<?php
/**
 * Functionality relating to the 'Chapter' custom post type.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since 1.0.2
 *
 * @package    Opsi_Util
 * @subpackage Opsi_Util/admin
 * @author     Coleman Haley <coleman.c.haley@gmail.com>
 */
class Opsi_Util_Chapter_Endpoint {
	/**
	 * Custom endpoint name.
	 *
	 * @since 1.0.2
	 * @access public
	 * @var string
	 */
	public static $endpoint = 'manage-chapter';

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.2
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.2
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.2
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	/**
	 * Register new endpoint to use inside My Account page.
	 *
	 * @see https://developer.wordpress.org/reference/functions/add_rewrite_endpoint/
	 */
	public function add_endpoints() {
		add_rewrite_endpoint( self::$endpoint, EP_ROOT | EP_PAGES );
	}
	/**
	 * Add new query var.
	 *
	 * @param array $vars
	 * @return array
	 */
	public function add_query_vars( $vars ) {
		$vars[] = self::$endpoint;
		return $vars;
	}
	/**
	 * Set endpoint title.
	 *
	 * @param string $title
	 * @return string
	 */
	public function endpoint_title( $title ) {
		if ( current_user_can( 'edit_chapters' ) ) {
		global $wp_query;
		$is_endpoint = isset( $wp_query->query_vars[ self::$endpoint ] );
		if ( $is_endpoint && ! is_admin() && is_main_query() && in_the_loop() && is_account_page() ) {
			// New page title.
			$title = esc_html__( 'Manage Chapter', $plugin_name );
			remove_filter( 'the_title', array( $this, 'endpoint_title' ) );
		}
	}
		return $title;
	
	}
	/**
	 * Insert the new endpoint into the My Account menu.
	 *
	 * @param array $items
	 * @return array
	 */
	public function new_menu_items( $items ) {
		if ( current_user_can( 'edit_chapters' ) ) {
		// Remove the logout menu item.
		$logout = $items['customer-logout'];
		unset( $items['customer-logout'] );
		// Insert your custom endpoint.
		$items[ self::$endpoint ] = esc_html__( 'Manage Chapter', $plugin_name );
		// Insert back the logout item.
		$items['customer-logout'] = $logout;
	}
		return $items;

	}
	/**
	 * Endpoint HTML content.
	 */
	public function endpoint_content() {
				if ( current_user_can( 'edit_chapters' ) ) {
		echo do_shortcode( '[contact-form-7 id="53" title="Untitled"]' );
		//echo '<p>Hello World!</p>';
	}
	}

}
