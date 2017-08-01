<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       www.cch22.com
 * @since      1.0.0
 *
 * @package    Opsi_Util
 * @subpackage Opsi_Util/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Opsi_Util
 * @subpackage Opsi_Util/includes
 * @author     Coleman Haley <coleman.c.haley@gmail.com>
 */
class Opsi_Util {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Opsi_Util_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'opsi-util';
		$this->version = '1.0.3';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_chapter_hooks();
		$this->define_public_hooks();
		$this->define_chapter_update_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Opsi_Util_Loader. Orchestrates the hooks of the plugin.
	 * - Opsi_Util_i18n. Defines internationalization functionality.
	 * - Opsi_Util_Admin. Defines all hooks for the admin area.
	 * - Opsi_Util_Chapters. Defines hooks for chapter-related functionality.
	 * - Opsi_Util_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-opsi-util-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-opsi-util-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-opsi-util-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-opsi-util-public.php';

		/**
		 * The class responsible for defining all actions that occur relating to chapters.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-opsi-util-chapters.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-opsi-util-chapter-endpoint.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-opsi-util-chapter-update.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-opsi-util-create-chapter.php';

		$this->loader = new Opsi_Util_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Opsi_Util_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Opsi_Util_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Opsi_Util_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the chapter post type functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_chapter_update_hooks() {


		$plugin_ninja = new Opsi_Util_Chapter_Update( $this->get_plugin_name(), $this->get_version() );


			// Actions used to insert a new endpoint in the WordPress.
			$this->loader->add_action( 'my_ninja_forms_processing', $plugin_ninja, 'ninja_submit_chapter_info_callback' );
			$this->loader->add_action( 'ninja_forms_loaded', $plugin_ninja, 'my_register_merge_tags' );

	}

	private function define_chapter_hooks() {

		$plugin_admin = new Opsi_Util_Chapters( $this->get_plugin_name(), $this->get_version() );
		$plugin_create = new Opsi_Util_Create_Chapter( $this->get_plugin_name(), $this->get_version() );
		$plugin_cend = new Opsi_Util_Chapter_Endpoint( $this->get_plugin_name(), $this->get_version() );


			// Actions used to insert a new endpoint in the WordPress.
			$this->loader->add_action( 'cmb2_admin_init', $plugin_admin, 'register_metabox' );
			$this->loader->add_action( 'init', $plugin_cend, 'add_endpoints' );
			$this->loader->add_filter( 'query_vars', $plugin_cend, 'add_query_vars', 0 );
			// Change the My Accout page title.
		//if (current_user_can('edit_chapters')) {
			$this->loader->add_action( 'user_register', $plugin_create, 'insert_chapter_post' );
			$this->loader->add_action( 'register_form', $plugin_create, 'add_university_field' );
			$this->loader->add_action( 'registration_errors', $plugin_create, 'register_errors' );
			$this->loader->add_filter( 'the_title', $plugin_cend, 'endpoint_title', 0 );
			// Insering your new tab/page into the My Account page.
			$this->loader->add_filter( 'woocommerce_account_menu_items', $plugin_cend, 'new_menu_items', 0 );
			$this->loader->add_action( 'woocommerce_account_' . Opsi_Util_Chapter_Endpoint::$endpoint .  '_endpoint', $plugin_cend, 'endpoint_content' );
		//}

	}


	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Opsi_Util_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Opsi_Util_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
