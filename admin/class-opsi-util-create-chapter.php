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
		$options = file_get_contents('chapter_post_settings.txt');
		$user_roles = $user_meta->roles;
		if ( in_array( "ospi_chapter", $user_roles ) ) {
			$chapter_page = array(
					'post_author'    => $user_id,
					'post_title'     => $user_meta->university,
					'post_status'    => 'publish',
					'post_type'      => 'opsi_chapter', 
					'comment_status' => 'closed',
					'meta_input'     => array( 'university' => $user_id.
					'insight_post_options' => $options )
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