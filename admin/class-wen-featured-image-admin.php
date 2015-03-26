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
      'lang' => array(
          'are_you_sure' => __( 'Are you sure?', 'wen-featured-image' ),
        ),
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

    add_settings_field( 'wfi_field_image_column_cpt', __( 'Enable For', 'wen-featured-image' ), array( $this, 'wfi_field_image_column_cpt_callback' ), 'wen-featured-image-column', 'wfi_column_settings' );

    // Required Settings
    add_settings_section( 'wfi_required_settings', __( 'Required Featured Image Settings', 'wen-featured-image' ) , array( $this, 'plugin_section_required_text_callback' ), 'wen-featured-image-required' );

    add_settings_field( 'wfi_field_image_required_cpt', __( 'Make Required For', 'wen-featured-image' ), array( $this, 'wfi_field_image_required_cpt_callback' ), 'wen-featured-image-required', 'wfi_required_settings' );

    add_settings_field( 'wfi_field_image_required_message', __( 'Required Message', 'wen-featured-image' ), array( $this, 'wfi_field_image_required_message_callback' ), 'wen-featured-image-required', 'wfi_required_settings' );

    // Message Settings
    add_settings_section( 'wfi_message_settings', __( 'Message Settings', 'wen-featured-image' ) , array( $this, 'plugin_section_message_text_callback' ), 'wen-featured-image-message' );

    add_settings_field( 'wfi_field_image_message_cpt', __( 'Show Message For', 'wen-featured-image' ), array( $this, 'wfi_field_image_message_cpt_callback' ), 'wen-featured-image-message', 'wfi_message_settings' );

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

  function plugin_section_required_text_callback(){

    echo sprintf( __( 'Make %s required.', 'wen-featured-image' ), '<strong>' . __( 'Featured Image', 'wen-featured-image' ) . '</strong>' );

  }

  function plugin_options_validate( $input ){

    // Validate now
    $input['required_message'] = sanitize_text_field( $input['required_message'] );
    if ( empty( $input['required_message'] ) ) {
      $input['required_message'] = __( 'Featured Image is required to publish.', 'wen-featured-image' );
    }
    if ( current_user_can( 'unfiltered_html' ) ){
      $input['message_before'] = $input['message_before'];
      $input['message_after']  = $input['message_after'];
    }
    else{
      $input['message_before'] = stripslashes( wp_filter_post_kses( addslashes( $input['message_before'] ) ) );
      $input['message_after']  = stripslashes( wp_filter_post_kses( addslashes( $input['message_after'] ) ) );
    }

    // CPTS
    if ( ! isset( $input['image_column_cpt'] ) ) {
      $input['image_column_cpt'] = array();
    }
    if ( ! isset( $input['required_cpt'] ) ) {
      $input['required_cpt'] = array();
    }
    if ( ! isset( $input['message_cpt'] ) ) {
      $input['message_cpt'] = array();
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

  function wfi_field_image_required_message_callback(){
    // Field option
    $required_message = '';
    if ( isset( $this->options['required_message'] ) ) {
      $required_message = $this->options['required_message'];
    }
    ?>
    <input name="wen_featured_image_options[required_message]" class="large-text" type="text" value="<?php echo esc_attr( $required_message ); ?>">
    <?php
  }

  protected function get_post_types_options(){

    $post_types_list = array();

    $post_types_list = get_post_types( array(
      'public'   => true,
      ) , 'objects' );

    // Remove attachment
    if ( isset( $post_types_list['attachment'] ) ) {
      unset( $post_types_list['attachment'] );
    }
    return $post_types_list;
  }

  protected function render_post_types_field( $field_name ){

    $post_types_list = $this->get_post_types_options();

    // Field option
    $post_types = array();
    if ( isset( $this->options[ $field_name ] ) ) {
      $post_types = $this->options[ $field_name ];
    }

    $input_name = 'wen_featured_image_options[' . $field_name . '][]';
    foreach ( $post_types_list as $key => $post_type ){
      ?>
      <label>
      <input type="checkbox" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php checked( true, in_array( $key, $post_types ) ) ; ?>/><span><?php echo esc_html( $post_type->labels->singular_name ); ?>&nbsp;<em>(<?php echo esc_html( $key ); ?>)</em></span></label><br/>
      <?php
    }

  }

  function wfi_field_image_column_cpt_callback(){

    $field_name = 'image_column_cpt';
    $this->render_post_types_field( $field_name );


  } //end function

  function wfi_field_image_required_cpt_callback(){

    $field_name = 'required_cpt';
    $this->render_post_types_field( $field_name );

  } //end function

  function wfi_field_image_message_cpt_callback(){

    $field_name = 'message_cpt';
    $this->render_post_types_field( $field_name );

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

    // Remove button as per user role
    if ( ! current_user_can( 'upload_files', $post->ID ) ) {
      $search_arr  = array( '{{add}}', '{{change}}', '{{remove}}' );
      $replace_arr = array( '', '', '' );
      $template = str_replace( $search_arr, $replace_arr, $template );
    }

    // Check post type for required
    $post_types = array();
    if ( isset( $this->options['required_cpt'] ) ) {
      $post_types = $this->options['required_cpt'];
    }
    if( in_array( get_post_type( $post ), $post_types ) ) {
      $search_arr  = array( '{{remove}}' );
      $replace_arr = array( '' );
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
      $image_start = '<a href="' .  ( ( $attachment_id ) ? esc_url( $full_url ) : '' ) . '" class="wfi-image thickbox" ' .  ( ( $attachment_id ) ? '' : ' style="display:none;" ' ) . ' title="' . esc_attr( $img_detail['title'] ) . '" data-uploader_title="asdf">';
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
    $ajax_nonce = wp_create_nonce( 'wfi-delete-' .  $post->ID );
    $nonce_data = ' data-security="' . esc_attr( $ajax_nonce ) . '" ';
    $remove_html = '<a href="#"  data-post="' . esc_attr( $post->ID ) . '" ' . $nonce_data . 'class="wfi-btn-remove" ' .  ( ( $attachment_id ) ? '' : ' style="display:none;" ' ) . '><span class="dashicons dashicons-trash"></span></a>';
    $value = str_replace( '{{remove}}', $remove_html, $value );

    // Change
    $ajax_nonce = wp_create_nonce( 'wfi-change-' .  $post->ID );
    $nonce_data = ' data-security="' . esc_attr( $ajax_nonce ) . '" ';

    $prev_data = '';
    if ( $attachment_id) {
      $prev_data = ' data-previous_attachment="' . $attachment_id . '" ';
    }
    $change_html = '<a href="#"  data-post="' . esc_attr( $post->ID ) . '" data-uploader_title="' . __( 'Select Image', 'wen-featured-image' ) . '" data-uploader_button_text="' . __( 'Set As Featured', 'wen-featured-image' ) . '" class="wfi-btn-change" ' . $nonce_data . $prev_data .  ( ( $attachment_id ) ? '' : ' style="display:none;" ' ) . '><span class="dashicons dashicons-update"></span></a>';
    $value = str_replace( '{{change}}', $change_html, $value );

    // Add
    $ajax_nonce = wp_create_nonce( 'wfi-add-' .  $post->ID );
    $nonce_data = ' data-security="' . esc_attr( $ajax_nonce ) . '" ';

    $add_html = '<a href="#" data-post="' . esc_attr( $post->ID ) . '" data-uploader_title="' . __( 'Select Image', 'wen-featured-image' ) . '" data-uploader_button_text="' . __( 'Set As Featured', 'wen-featured-image' ) . '"  class="wfi-btn-add" ' . $nonce_data . ( ( $attachment_id ) ? ' style="display:none;" ' : '' ) . '><span class="dashicons dashicons-plus-alt"></span></a>';
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

    // Check nonce
    $nonce_check = check_ajax_referer( 'wfi-add-' . $post_id, 'security', false );
    if ( true != $nonce_check ) {
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
  function ajax_change_featured_image(){

    $output = array();
    $output['status'] = 0;

    $post_id       = absint( $_POST['post_id'] );
    $attachment_ID = absint( $_POST['attachment_ID'] );
    if ( $post_id < 1 || $attachment_ID < 0) {
      wp_send_json( $output );
    }

    // Check nonce
    $nonce_check = check_ajax_referer( 'wfi-change-' . $post_id, 'security', false );
    if ( true != $nonce_check ) {
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

    // Check nonce
    $nonce_check = check_ajax_referer( 'wfi-delete-' . $post_id, 'security', false );
    if ( true != $nonce_check ) {
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

  function custom_message_admin_featured_box( $html, $post_id ){

    $post_types = array();
    if ( isset( $this->options['message_cpt'] ) ) {
      $post_types = $this->options['message_cpt'];
    }

    if ( ! in_array( get_post_type( $post_id ), $post_types ) ) {
      return $html;
    }

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

  function wfi_admin_notices(){

    if( ! current_theme_supports( 'post-thumbnails' ) ) {
      echo '<div id="message" class="error"><p>';
      echo '<strong>' . __( 'WEN Featured Image', 'wen-featured-image' ) .':</strong> '. __( 'Current theme does not support post thumbnails.', 'wen-featured-image' );
      echo '</p></div>';
    }
    // check if the transient is set, and display the error message
    if ( 'no' == get_transient( 'wfi_req_check' ) ) {
      echo '<div id="message" class="error"><p><strong>';
      echo $this->options['required_message'];
      echo '</strong></p></div>';
      delete_transient( 'wfi_req_check' );
    }

  }

  function check_theme_support(){

    if( ! current_theme_supports( 'post-thumbnails' ) ) {
      add_theme_support( 'post-thumbnails' );
    }

  }

  function custom_redirect_post_location( $location, $post_id ){

    global $post;

    if ( ( $post->ID == $post_id ) &&  ( 'no' == get_transient( 'wfi_req_check' ) ) ) {
      $new_url = remove_query_arg( 'message', $location );
      $new_url = add_query_arg( array( 'message'=> 8 ), $new_url );
      $location = $new_url;
    }

    return $location;

  }

  function wfi_required_thumbnail_check( $post_id ){

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
      return;
    }

    // Field option
    $post_types = array();
    if ( isset( $this->options['required_cpt'] ) ) {
      $post_types = $this->options['required_cpt'];
    }

    // Bail if not selected post type
    if ( ! in_array( get_post_type( $post_id ), $post_types ) ) {
      return;
    }

    if ( ! has_post_thumbnail( $post_id ) ) {

      // set a transient to show the users an admin message
      set_transient( 'wfi_req_check', 'no' );

      // Change status to draft
      global $wpdb, $post;

      if ( $post = get_post( $post ) ) {

        // Update post
        $wpdb->update( $wpdb->posts, array( 'post_status' => 'draft' ), array( 'ID' => $post->ID ) );

        // Clean post cache
        clean_post_cache( $post->ID );

        // Manage post transition
        $old_status = $post->post_status;
        $post->post_status = 'draft';
        wp_transition_post_status( 'draft', $old_status, $post );

      }

    }
    else{
      delete_transient( 'wfi_req_check' );
    }


  }

  function add_links_in_plugin_listing( $links ){

    $url = add_query_arg( array(
        'page' => $this->wen_featured_image
      ),
      admin_url( 'admin.php' )
    );
    $settings_link = '<a href="' . esc_url( $url ) . '">'. esc_html( __( 'Settings', 'wen-featured-image' ) ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;

  }


}
