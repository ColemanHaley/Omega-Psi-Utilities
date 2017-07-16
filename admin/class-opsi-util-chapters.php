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
 * Functionality relating to the 'Chapter' custom post type.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Opsi_Util
 * @subpackage Opsi_Util/admin
 * @author     Coleman Haley <coleman.c.haley@gmail.com>
 */
class Opsi_Util_Chapters {

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
	 * Register the chapter post type.
	 *
	 * @since    1.0.0
	 */
	public function register_chapter_type() {
    	register_post_type('opsi_chapter',
        				array(
                        	'labels'      => array(
                            	'name'           => __('Chapters', $plugin_name),
                            	'singular_name'  => __('Chapter', $plugin_name),
                            	'all_items'      => __('All Chapters', $plugin_name),

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
