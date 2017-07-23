<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}
class Opsi_MergeTags extends NF_Abstracts_MergeTags
{
  /*
   * The $id property should match the array key where the class is registered.
   */
  protected $id = 'opsi_merge_tags';
  
  public function __construct()
  {
    parent::__construct();
    
    /* Translatable display name for the group. */
    $this->title = esc_html__( 'Omega Psi', 'opsi-util' );
    
    /* Individual tag registration. */
    $this->merge_tags = array(
      
        'chapter_history' => array(
          'id' => 'chapter_history',
          'tag' => '{opsi:chapter_history}', // The tag to be  used.
          'label' => esc_html__( 'Chapter History', 'opsi-util' ), // Translatable label for tag selection.
          'callback' => 'chapter_history' // Class method for processing the tag. See below.
      ),
    );
  }
  
  /**
   * The callback method for the {opsi:chapter_history} merge tag.
   * @return string
   */
  public function chapter_history()
  {
    $user_id = get_current_user_id();
    return wp_kses_post( get_user_meta( $user_id, 'chapter_history', true ) );
  }
}