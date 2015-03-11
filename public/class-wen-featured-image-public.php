<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://wenthemes.com
 * @since      1.0.0
 *
 * @package    Wen_Featured_Image
 * @subpackage Wen_Featured_Image/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wen_Featured_Image
 * @subpackage Wen_Featured_Image/public
 * @author     WEN Themes <info@wenthemes.com>
 */
class Wen_Featured_Image_Public {

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
	 * @param      string    $wen_featured_image       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wen_featured_image, $version ) {

		$this->wen_featured_image = $wen_featured_image;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->wen_featured_image, plugin_dir_url( __FILE__ ) . 'css/wen-featured-image-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_script( $this->wen_featured_image, plugin_dir_url( __FILE__ ) . 'js/wen-featured-image-public.js', array( 'jquery' ), $this->version, false );

	}

}
