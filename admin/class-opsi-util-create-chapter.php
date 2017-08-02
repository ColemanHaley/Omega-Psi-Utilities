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
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Opsi_Util
 * @subpackage Opsi_Util/admin
 * @author     Coleman Haley <coleman.c.haley@gmail.com>
 */
class Opsi_Util_Create_Chapter {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $this->plugin_name    The ID of this plugin.
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
	 * @param      string    $this->plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function insert_chapter_post( $user_id ) {

		if ( ! empty( $_POST['university'] ) ) {
			update_user_meta( $user_id, 'university', trim( $_POST['university'] ) );
		}
		$user_meta = get_userdata($user_id);
		$user_roles = $user_meta->roles;
		if ( in_array( "ospi_chapter", $user_roles ) ) {
			$chapter_page = array(
					'post_author'    => $user_id,
					'post_title'     => $user_meta->university,
					'post_status'    => 'publish',
					'post_type'      => 'opsi_chapter', 
					'comment_status' => 'closed',
					'meta_input'     => array( 'university' => $user_id,
					'insight_post_options' => 'a:47:{s:12:"post_gallery";N;s:10:"post_video";s:0:"";s:10:"post_audio";s:0:"";s:15:"post_quote_text";s:0:"";s:15:"post_quote_name";s:0:"";s:14:"post_quote_url";s:0:"";s:9:"post_link";s:0:"";s:11:"site_layout";s:0:"";s:10:"site_width";s:0:"";s:21:"site_background_color";s:0:"";s:21:"site_background_image";s:0:"";s:22:"site_background_repeat";s:9:"no-repeat";s:24:"site_background_position";s:0:"";s:24:"content_background_color";s:0:"";s:24:"content_background_image";s:0:"";s:25:"content_background_repeat";s:9:"no-repeat";s:27:"content_background_position";s:0:"";s:14:"top_bar_enable";s:1:"2";s:13:"header_preset";s:10:"classic_dt";s:15:"header_position";s:5:"above";s:12:"menu_display";s:7:"default";s:13:"menu_one_page";s:1:"0";s:11:"custom_logo";s:0:"";s:21:"page_title_bar_enable";s:1:"2";s:25:"page_title_bar_background";s:0:"";s:33:"page_title_bar_background_overlay";s:0:"";s:29:"page_title_bar_custom_heading";s:0:"";s:14:"page_sidebar_1";s:7:"default";s:14:"page_sidebar_2";s:7:"default";s:21:"page_sidebar_position";s:7:"default";s:17:"revolution_slider";s:0:"";s:13:"footer_enable";s:1:"2";s:13:"footer_preset";s:2:"-1";s:16:"footer_widget_01";s:7:"default";s:16:"footer_widget_02";s:7:"default";s:16:"footer_widget_03";s:7:"default";s:16:"footer_widget_04";s:7:"default";s:16:"footer_widget_05";s:7:"default";s:16:"footer_widget_06";s:7:"default";s:17:"footer_background";s:0:"";s:25:"footer_background_overlay";s:0:"";s:16:"copyright_enable";s:1:"2";s:16:"copyright_preset";s:2:"-1";s:19:"copyright_widget_01";s:7:"default";s:19:"copyright_widget_02";s:7:"default";s:19:"copyright_widget_03";s:7:"default";s:26:"copyright_background_color";s:0:"";}')
				);
			wp_insert_post( $chapter_page );
		}

	}

	public function add_university_field() {
	   $university = ( ! empty( $_POST['university'] ) ) ? $_POST['university'] : '';
    	?>
    	<table class="form-table">
    		<tr class="form-field form-required">
    				<th scope="row"><label for="university"><?php _e( 'University', $this->plugin_name ); ?><span class="description" id="uni_descrip">
    					<script>
    						function requiredQ() {
	    						form = document.getElementByID("createuser");
	    						el = document.getElementByID("uni_descrip");
	    						role = form.elements["role"];
	    						if (role.value == 'ospi_chapter') {
	    							el.innerHTML = '(required)';
	    						} else {
	    							el.innerHTML = 'best';
	    						}
	    					}
	    					form = document.getElementByID("createuser");
	    					role = form.elements["role"];
	    					role.onchange =  requiredQ();
    					</script></span></label></th>
    				<td><input type="text" name="university" id="university" class="input" value="<?php echo esc_attr( stripslashes( $university ) ); ?>" /></td>
    		</tr>
    	</table>
    	<?php
	}

    public function register_errors( $errors, $update, $user ) {
       if( isset($_POST['role']) && $_POST['role'] == 'ospi_chapter' ) {
	  	 if ( empty( $_POST['university'] ) || ! empty( $_POST['university'] ) && trim( $_POST['university'] ) == '' ) {
	    	    $errors->add( 'university_error', __( '<strong>ERROR</strong>: You must include a university.', $this->plugin_name ) );
	        }
    	}

        return $errors;
    }

    public function init_global_variable() {
    	global $insight_page_options;
    	if( is_singular( 'opsi_chapter' ) ) {
    		$insight_page_options = unserialize( get_post_meta( get_the_ID(), 'insight_post_options', true) );
    	}
    }

}