<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.cch22.com
 * @since      1.0.0
 *
 * @package    Opsi_Util
 * @subpackage Opsi_Util/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Opsi_Util
 * @subpackage Opsi_Util/admin
 * @author     Coleman Haley <coleman.c.haley@gmail.com>
 */
class Opsi_Util_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
		 * defined in Opsi_Util_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Opsi_Util_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/opsi-util-admin.css', array(), $this->version, 'all' );

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
		 * defined in Opsi_Util_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Opsi_Util_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/opsi-util-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the chapter post type.
	 *
	 * @since    1.0.0
	 */
	public function register_chapter_type() {
    	register_post_type('opsi_chapter',
        				array(
                        	'labels'      => array(
                            	'name'           => __('Chapters'),
                            	'singular_name'  => __('Chapter'),
                            	'all_items'      => __('All Chapters'),

                        	),
	                        'public'               => true,
	                        'show_ui'              => true,
	                        'menu_icon'            => 'dashicons-book',
	                        'has_archive'          => false,
	                        'rewrite'              => array( 'slug' => 'chapter' ),
	                        'capability_type'      => 'post',
	                        'supports'             => ['title', 'editor'], 
                       )
		);
	}

	/**
	 * Put the label 'Chapter History' on the editor for the chapter post type.
	 *
	 * @since    1.0.0
	 */
	public function label_chapter_history() {

		if (get_post_type() == 'opsi_chapter') {
			echo __('<h1>Chapter History</h1>', $plugin_name);
		}

	}

}
