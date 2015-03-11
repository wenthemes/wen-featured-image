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

		wp_enqueue_script( $this->wen_featured_image, plugin_dir_url( __FILE__ ) . 'js/wen-featured-image-admin.js', array( 'jquery' ), $this->version, false );

	}
  function posts_column_head( $columns ){

    $columns['wfi_image'] = __( 'Featured Image', 'wen-featured-image' );

    return $columns;

  }
  function posts_column_content( $column, $post_ID ){

    if ( 'wfi_image' == $column ) {
        $post_featured_image = '';
        $post_thumbnail_id = get_post_thumbnail_id($post_ID);
        if ($post_thumbnail_id) {
            $post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );
            $post_featured_image = $post_thumbnail_img[0];
        }
        if ( $post_featured_image ) {
            echo '<img src="' . $post_featured_image . '" style="max-width:100px;"/>';
        }
    }

  }

}
