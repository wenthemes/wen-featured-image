<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://wenthemes.com
 * @since      1.0.0
 *
 * @package    Wen_Featured_Image
 * @subpackage Wen_Featured_Image/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wen_Featured_Image
 * @subpackage Wen_Featured_Image/admin
 * @author     WEN Themes <info@wenthemes.com>
 */
class Wen_Featured_Image_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wen_featured_image    The ID of this plugin.
	 */
	private $wen_featured_image;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
  private $version;
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $wen_featured_image       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wen_featured_image, $version, $options ) {

		$this->wen_featured_image = $wen_featured_image;
    $this->version = $version;
		$this->options = $options;

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
		 * defined in Wen_Featured_Image_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wen_Featured_Image_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

    wp_enqueue_style('thickbox');

		wp_enqueue_style( $this->wen_featured_image, plugin_dir_url( __FILE__ ) . 'css/wen-featured-image-admin.css', array(), $this->version, 'all' );

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
		 * defined in Wen_Featured_Image_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wen_Featured_Image_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

    wp_enqueue_script('thickbox');

    wp_enqueue_media();

		wp_register_script( $this->wen_featured_image, plugin_dir_url( __FILE__ ) . 'js/wen-featured-image-admin.js', array( 'jquery' ), $this->version, false );
    $extra_array = array(
      'ajaxurl' => admin_url( 'admin-ajax.php' ),
      );
    wp_localize_script( $this->wen_featured_image, 'WFI_OBJ', $extra_array );
    wp_enqueue_script( $this->wen_featured_image );

	}

  function setup_menu(){
    if( class_exists( 'WEN_Addons' ) ){
      add_submenu_page( WEN_Addons::$menu_name, __( 'WEN Featured Image', 'wen-featured-image' ), __( 'WEN Featured Image', 'wen-featured-image' ), 'manage_options', 'wen-featured-image', array( &$this,'option_page_init' ) );
    }
    // add_action( 'admin_init', array(&$this,'register_settings' ));
  }

  function option_page_init(){
    include( sprintf( "%s/partials/wen-featured-image-admin-display.php", dirname( __FILE__ ) ) );
  }

  function register_settings(){

    register_setting( 'wfi-plugin-options-group', 'wen_featured_image_options', array( $this, 'plugin_options_validate' ) );

    ////

    // Column Settings
    add_settings_section( 'wfi_column_settings', __( 'Image Column Settings', 'wen-featured-image' ) , array( $this, 'plugin_section_column_text_callback' ), 'wen-featured-image-column' );

    add_settings_field( 'wfi_field_image_column_cpt', __( 'Enable for', 'wen-featured-image' ), array( $this, 'wfi_field_image_column_cpt_callback' ), 'wen-featured-image-column', 'wfi_column_settings' );

    // Message Settings
    add_settings_section( 'wfi_message_settings', __( 'Message Settings', 'wen-featured-image' ) , array( $this, 'plugin_section_message_text_callback' ), 'wen-featured-image-message' );

    add_settings_field( 'wfi_field_message_before', __( 'Before Image', 'wen-featured-image' ), array( $this, 'wfi_field_message_before_callback' ), 'wen-featured-image-message', 'wfi_message_settings' );

    add_settings_field( 'wfi_field_message_after', __( 'After Image', 'wen-featured-image' ), array( $this, 'wfi_field_message_after_callback' ), 'wen-featured-image-message', 'wfi_message_settings' );

    ////

  }
  function plugin_section_column_text_callback(){

    echo sprintf( __( 'Enable / Disable %s column in listings.', 'wen-featured-image' ), '<strong>' . __( 'Featured Image', 'wen-featured-image' ) . '</strong>' );

  }

  function plugin_section_message_text_callback(){

    echo sprintf( __( 'These messages will be displayed in the %s metabox.', 'wen-featured-image' ), '<strong>' . __( 'Featured Image', 'wen-featured-image' ) . '</strong>' );

  }

  function plugin_options_validate( $input ){

    // Validate now
    if ( current_user_can( 'unfiltered_html' ) ){
      $input['message_before'] = $input['message_before'];
      $input['message_after']  = $input['message_after'];
    }
    else{
      $input['message_before'] = stripslashes( wp_filter_post_kses( addslashes( $input['message_before'] ) ) );
      $input['message_after']  = stripslashes( wp_filter_post_kses( addslashes( $input['message_after'] ) ) );
    }

    return $input;
  }

  function wfi_field_message_before_callback(){
    // Field option
    $message_before = '';
    if ( isset( $this->options['message_before'] ) ) {
      $message_before = $this->options['message_before'];
    }
    ?>
    <textarea name="wen_featured_image_options[message_before]" rows="3" class="large-text"><?php echo esc_textarea( $message_before ); ?></textarea>
    <?php
  }

  function wfi_field_message_after_callback(){
    // Field option
    $message_after = '';
    if ( isset( $this->options['message_after'] ) ) {
      $message_after = $this->options['message_after'];
    }
    ?>
    <textarea name="wen_featured_image_options[message_after]" rows="3" class="large-text"><?php echo esc_textarea( $message_after ); ?></textarea>
    <?php
  }

  function wfi_field_image_column_cpt_callback(){

    $post_types_list = get_post_types( array(
      'public'   => true,
      ) , 'objects' );

    // Remove attachment
    if ( isset( $post_types_list['attachment'] ) ) {
      unset( $post_types_list['attachment'] );
    }

    // Field option
    $post_types = array();
    if ( isset( $this->options['image_column_cpt'] ) ) {
      $post_types = $this->options['image_column_cpt'];
    }

    foreach ( $post_types_list as $key => $post_type ){
      ?>
      <label>
      <input type="checkbox" name="wen_featured_image_options[image_column_cpt][]" value="<?php echo esc_attr( $key ); ?>" <?php checked( true, in_array( $key, $post_types ) ) ; ?>/><span><?php echo esc_html( $post_type->labels->singular_name ); ?>&nbsp;<em>(<?php echo esc_html( $key ); ?>)</em></span></label><br/>
      <?php
    }

  } //end function


  function posts_column_head( $columns ){

    $columns['wfi_image'] = __( 'Featured Image', 'wen-featured-image' );

    return $columns;

  }

  function get_image_block_template(){

    $template = '';
    $template .= '{{image}}';
    $template .= '<div class="wfi-button-bar">';
    $template .= '{{preview}}';
    $template .= '{{add}}';
    $template .= '{{change}}';
    $template .= '{{remove}}';
    $template .= '</div>';

    $template = apply_filters( 'wen_featured_image_filter_block_template', $template );
    return $template;

  }

  function custom_block_template( $template ){

    global $post;
    if ( ! current_user_can( 'upload_files', $post->ID ) ) {
      $search_arr  = array( '{{add}}', '{{change}}', '{{remove}}' );
      $replace_arr = array( '', '', '' );
      $template = str_replace( $search_arr, $replace_arr, $template );
    }
    return $template;
  }

  function get_image_block_html( $attachment_id, $post_id = null ){

    global $post;
    if ( null != $post_id ) {
      $post = get_post( $post_id );
    }

    if ( $attachment_id ) {
      // Image detail
      $img_detail = wp_prepare_attachment_for_js( $attachment_id );
      // nspre($img_detail);
      // Image URLs
      $thumbnail_url = $img_detail['sizes']['thumbnail']['url'];
      $full_url      = $img_detail['sizes']['full']['url'];

    }
    else{
      $thumbnail_url = WEN_FEATURED_IMAGE_URL . '/admin/images/no-image.png';
    }
    // Template
    $template = $this->get_image_block_template();

    // Replacement
    $value = $template;

    // Image
    $image_start = '';
    $image_end   = '';
    if ( $attachment_id ) {
      $image_start = '<a href="' .  ( ( $attachment_id ) ? esc_url( $full_url ) : '' ) . '" class="wfi-image thickbox" ' .  ( ( $attachment_id ) ? '' : ' style="display:none;" ' ) . ' title="' . esc_attr( $img_detail['title'] ) . '">';
      $image_end   = '</a>';
    }
    $image_html = $image_start . '<img src="' . esc_url( $thumbnail_url ). '" style="max-width:80px;"/>' . $image_end;
    $value = str_replace( '{{image}}', $image_html, $value );

    // Preview
    if ( $attachment_id ) {
      $preview_html = '<a href="' .  ( ( $attachment_id ) ? esc_url( $full_url ) : '' ) . '" class="wfi-btn-preview thickbox" ' .  ( ( $attachment_id ) ? '' : ' style="display:none;" ' ) . ' title="' . esc_attr( $img_detail['title'] ) . '"><span class="dashicons dashicons-visibility"></span></a>';
    }
    else{
      $preview_html = '';
    }
    $value = str_replace( '{{preview}}', $preview_html, $value );

    // Remove
    $remove_html = '<a href="#"  data-post="' . esc_attr( $post->ID ) . '" class="wfi-btn-remove" ' .  ( ( $attachment_id ) ? '' : ' style="display:none;" ' ) . '><span class="dashicons dashicons-trash"></span></a>';
    $value = str_replace( '{{remove}}', $remove_html, $value );

    // Change
    $change_html = '<a href="#"  data-post="' . esc_attr( $post->ID ) . '" class="wfi-btn-change" ' .  ( ( $attachment_id ) ? '' : ' style="display:none;" ' ) . '><span class="dashicons dashicons-update"></span></a>';
    $value = str_replace( '{{change}}', $change_html, $value );

    // Add
    $add_html = '<a href="#" data-post="' . esc_attr( $post->ID ) . '" class="wfi-btn-add" ' .  ( ( $attachment_id ) ? ' style="display:none;" ' : '' ) . '><span class="dashicons dashicons-plus-alt"></span></a>';
    $value = str_replace( '{{add}}', $add_html, $value );

    return $value;

  }

  function posts_column_content( $column, $post_id ){

    if ( 'wfi_image' == $column ) {

        $post_thumbnail_id = get_post_thumbnail_id( $post_id );
        echo '<div id="wfi-block-wrap-'. esc_attr( $post_id ) . '" class="wfi-block-wrap">';
        echo $this->get_image_block_html( $post_thumbnail_id );
        echo '</div>';

    }// end if wfi_column

  } //end function

  function ajax_add_featured_image(){

    $output = array();
    $output['status'] = 0;

    $post_id       = absint( $_POST['post_id'] );
    $attachment_ID = absint( $_POST['attachment_ID'] );
    if ( $post_id < 1 || $attachment_ID < 0) {
      wp_send_json( $output );
    }
    $update = update_post_meta( $post_id, '_thumbnail_id', $attachment_ID );
    if ( $update) {
      $output['status'] = 1;
      $output['post_id'] = $post_id;
      $output['html']    = $this->get_image_block_html( $attachment_ID, $post_id );
    }
    wp_send_json( $output );

  }
  function ajax_change_featured_image(){

    $output = array();
    $output['status'] = 0;

    $post_id       = absint( $_POST['post_id'] );
    $attachment_ID = absint( $_POST['attachment_ID'] );
    if ( $post_id < 1 || $attachment_ID < 0) {
      wp_send_json( $output );
    }
    $update = update_post_meta( $post_id, '_thumbnail_id', $attachment_ID );
    if ( $update) {
      $output['status']  = 1;
      $output['post_id'] = $post_id;
      $output['html']    = $this->get_image_block_html( $attachment_ID, $post_id );
    }
    wp_send_json( $output );

  }

  function ajax_remove_featured_image(){

    $output = array();
    $output['status'] = 0;

    $post_id       = absint( $_POST['post_id'] );

    if ( $post_id < 1 ) {
      wp_send_json( $output );
    }
    $delete = delete_post_meta( $post_id, '_thumbnail_id' );
    if ( $delete ) {
      $output['status']  = 1;
      $output['post_id'] = $post_id;
      $output['html']    = $this->get_image_block_html( 0, $post_id );
    }
    wp_send_json( $output );

  }

  function custom_message_admin_featured_box( $html ){

    // Message Before
    $message_before = $this->options['message_before'];
    if ( ! empty( $message_before ) ) {
      $message_before = sprintf( '<div class="wfi-message-before">%s</div>', $message_before );
      $html = $message_before .  $html;
    }
    // Message After
    $message_after = $this->options['message_after'];
    if ( ! empty( $message_after ) ) {
      $message_after = sprintf( '<div class="wfi-message-after">%s</div>', $message_after );
      $html .= $message_after;
    }
    return $html;

  }

}
