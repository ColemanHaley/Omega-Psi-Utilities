<?php

/**
 * Fired during plugin deactivation
 *
 * @link       www.cch22.com
 * @since      1.0.0
 *
 * @package    Opsi_Util
 * @subpackage Opsi_Util/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Opsi_Util
 * @subpackage Opsi_Util/includes
 * @author     Coleman Haley <coleman.c.haley@gmail.com>
 */
class Opsi_Util_Deactivator {

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Opsi_Util_Chapters. Defines chapter-related functionality.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private static function load_dependencies() {

		/**
		 * The class responsible for defining all actions that occur relating to chapters.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-opsi-util-chapters.php';

	}

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		$chapters = new Opsi_Util_Chapters('opsi_util', '1.0.3');
		$chapters->remove_chapter_roles();
		$chapters->remove_chapter_capabilities();
	}

}
