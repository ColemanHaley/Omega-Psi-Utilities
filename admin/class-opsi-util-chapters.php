<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
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
	 * Add chapter associated roles.
	 *
	 * @since    1.0.0
	 */
	public function add_chapter_roles() {
		add_role( ' opsi_chapter_member', esc_html__('Chapter Member', $this->plugin_name) );
		add_role( 'opsi_chapter_faculty', esc_html__('Faculty', $this->plugin_name) ); //TODO: is this the right name?
		add_role( 'ospi_chapter', esc_html__('Chapter', $this->plugin_name), array('can_view_member_pages' => true) ); //TODO: chapter account or chapter admin account?
		add_role( 'opsi_admin', esc_html__('National Board Account', $this->plugin_name) );
	}

	public function remove_chapter_roles() {
		remove_role( ' opsi_chapter_member' );
		remove_role( 'opsi_chapter_faculty' );
		remove_role( 'ospi_chapter' );
		remove_role( 'opsi_admin' );
	}

	public function remove_chapter_capabilities() {
		$role = get_role( 'administrator' );
		$role->remove_cap( 'edit_chapters' );
		$role->remove_cap( 'edit_others_chapters' );
		$role->remove_cap( 'publish_chapters' );
		$role->remove_cap( 'read_private_chapters' );
		$role->remove_cap( 'delete_chapters' );
		$role->remove_cap( 'create_chapters' );
		$role->remove_cap( 'can_view_member_pages' );
	}

	/**
	 * Add chapter associated capabilities to the appropriate roles.
	 *
	 * @since    1.0.0
	 */
	public function add_chapter_capabilities() {
		$chapter_capabilites = [
								'edit_chapters',
								'edit_published_chapters',
								'edit_private_chapters',
								'read_private_chapters', 
								'edit_others_chapters', 
								'publish_chapters', 
								'read_private_chapters', 
								'delete_chapters', 
								'delete_others_chapters',
								'delete_published_chapters',
								'delete_private_chapters',
								'create_chapters'
								];
		$admin_role = get_role('administrator');
		$natl_role = get_role('opsi_admin');

		$roles = array($admin_role, $natl_role);
		foreach ($roles as $role) {
			foreach ($chapter_capabilites as $cap) {
				$role->add_cap($cap);
			}
			$role->add_cap('can_view_member_pages');
		}

		$chapter_role = get_role('ospi_chapter');
		$chapter_role->add_cap('edit_chapters');
		$chapter_role->add_cap('publish_chapters');
		$chapter_role->add_cap('edit_published_chapters');
		$chapter_role->add_cap('edit_private_chapters');
	}

	/**
	 * Register the chapter post type.
	 *
	 * @since    1.0.0
	 */
	public function register_chapter_type() {

		$args = array();

		$labels = array();
		$labels['name'] = esc_html__('Chapters', $this->plugin_name);
		$labels['singular_name'] = esc_html__('Chapter', $this->plugin_name);
		$labels['all_items'] = esc_html__('All Chapters', $this->plugin_name);

		$args['labels'] = $labels;
		$args['public'] = true;
		$args['menu_icon'] = 'dashicons-book';
		$args['rewrite'] = array( 'slug' => 'chapters');
		$args['capability_type'] = 'chapter';
		$args['capabilites'] = array('create_posts'=>'create_chapters');
		$args['map_meta_cap'] = true;
		$args['supports'] = ['title', 'editor'];

    	register_post_type( 'opsi_chapter', $args );
 
	}

	public function register_metabox() {
		  $prefix = 'opsi_chapter_';

		  /**
		   * Sample metabox to demonstrate each field type included
		   */
		  $cmb_demo = new_cmb2_box( array(
		    'id'            => $prefix . 'metabox',
		    'title'         => esc_html__( 'Chapter Info', $this->plugin_name ),
		    'object_types'  => array( 'opsi_chapter', ), // Post type
		  ) );

		  $cmb_demo->add_field( array(
		    'name'          => esc_html__( 'Chapter ID', $this->plugin_name ),
		    'id'            => $prefix . 'id',
		    'type'          => 'text',
		    'default_cb'    => 'opsi_set_id_default'
		  ) );
	}

	/**
	 * Put the label 'Chapter History' on the editor for the chapter post type.
	 *
	 * @since    1.0.0
	 */
	public function label_chapter_history() {

		if (get_post_type() == 'opsi_chapter') {
			echo '<h1>' . esc_html__('Chapter History', $this->plugin_name) . '</h1>';
		}

	}

}
