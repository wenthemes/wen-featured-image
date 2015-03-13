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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $wen_featured_image       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wen_featured_image, $version ) {

		$this->wen_featured_image = $wen_featured_image;
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

		wp_enqueue_script( $this->wen_featured_image, plugin_dir_url( __FILE__ ) . 'js/wen-featured-image-admin.js', array( 'jquery' ), $this->version, false );

	}

  function posts_column_head( $columns ){

    $columns['wfi_image'] = __( 'Featured Image', 'wen-featured-image' );

    return $columns;

  }

  function get_image_block_template(){

    $template = '{{image}}';
    $template .= '<div class="wfi-button-bar">';
    $template .= '{{preview}}';
    $template .= '{{add}}';
    $template .= '{{change}}';
    $template .= '{{remove}}';
    $template .= '</div>';

    $template = apply_filters( 'wen_featured_image_filter_block_template', $template );
    return $template;

  }
  function get_image_block_html( $attachment_id ){

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
      $image_start = '<a href="' .  ( ( $attachment_id ) ? esc_url( $full_url ) : '' ) . '" class="wfi-btn-preview thickbox" ' .  ( ( $attachment_id ) ? '' : ' style="display:none;" ' ) . ' title="' . esc_attr( $img_detail['title'] ) . '">';
      $image_end   = '</a>';
    }
    $image_html = $image_start . '<img src="' . esc_url( $thumbnail_url ). '" style="max-width:100px;"/>' . $image_end;
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
    $remove_html = '<a href="#" class="wfi-btn-remove" ' .  ( ( $attachment_id ) ? '' : ' style="display:none;" ' ) . '><span class="dashicons dashicons-trash"></span></a>';
    $value = str_replace( '{{remove}}', $remove_html, $value );

    // Change
    $change_html = '<a href="#" class="wfi-btn-change" ' .  ( ( $attachment_id ) ? '' : ' style="display:none;" ' ) . '><span class="dashicons dashicons-update"></span></a>';
    $value = str_replace( '{{change}}', $change_html, $value );

    // Add
    $add_html = '<a href="#" class="wfi-btn-add" ' .  ( ( $attachment_id ) ? ' style="display:none;" ' : '' ) . '><span class="dashicons dashicons-plus-alt"></span></a>';
    $value = str_replace( '{{add}}', $add_html, $value );

    return $value;

  }

  function posts_column_content( $column, $post_ID ){

    if ( 'wfi_image' == $column ) {

        $post_thumbnail_id = get_post_thumbnail_id( $post_ID );
        echo $this->get_image_block_html( $post_thumbnail_id );

    }// end if wfi_column

  } //end function

}
