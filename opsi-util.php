<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.cch22.com
 * @since             1.0.0
 * @package           Opsi_Util
 *
 * @wordpress-plugin
 * Plugin Name:       Omega Psi Utilities
 * Plugin URI:        https://omegapsi.org
 * Description:       Adds needed functionality for managing chapters.
 * Version:           1.0.3
 * Author:            Coleman Haley
 * Author URI:        www.cch22.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * GitHub Plugin URI: https://github.com/ColemanHaley/opsi-util
 * Text Domain:       opsi-util
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-opsi-util-activator.php
 */
function activate_opsi_util() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-opsi-util-activator.php';
	Opsi_Util_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-opsi-util-deactivator.php
 */
function deactivate_opsi_util() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-opsi-util-deactivator.php';
	Opsi_Util_Deactivator::deactivate();
}

function opsi_set_id_default( $field_args, $field ) {
		return get_post_meta( $field->object_id, 'university', true );
	
}

add_filter('single_template', 'opsi_single_chapter_template');

function opsi_single_chapter_template( $template ) {

    	if ( 'opsi_chapter' == get_post_type(get_queried_object_id()) ) {
    		$template = dirname( __FILE__ ) . '/templates/single-opsi_chapter.php';
    	}
    	return $template;
}

register_activation_hook( __FILE__, 'activate_opsi_util' );
register_deactivation_hook( __FILE__, 'deactivate_opsi_util' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-opsi-util.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_opsi_util() {

	$plugin = new Opsi_Util();
	$plugin->run();

}
run_opsi_util();
