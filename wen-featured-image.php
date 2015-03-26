<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://wenthemes.com
 * @since             1.0.0
 * @package           Wen_Featured_Image
 *
 * @wordpress-plugin
 * Plugin Name:       WEN Featured Image
 * Plugin URI:        https://wordpress.org/plugins/wen-featured-image/
 * Description:       Add featured image column in listings. You can easily add/change/remove featured image from the listing page.
 * Version:           1.0.0
 * Author:            WEN Themes
 * Author URI:        http://wenthemes.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wen-featured-image
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define
define( 'WEN_FEATURED_IMAGE_NAME', 'WEN Featured Image' );
define( 'WEN_FEATURED_IMAGE_SLUG', 'wen-featured-image' );
define( 'WEN_FEATURED_IMAGE_BASENAME', basename( dirname( __FILE__ ) ) );
define( 'WEN_FEATURED_IMAGE_BASE_FILE', plugin_basename( __FILE__ ) );
define( 'WEN_FEATURED_IMAGE_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'WEN_FEATURED_IMAGE_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );


//  Load WEN Addons
require_once WEN_FEATURED_IMAGE_DIR . '/wen-addons/wen_addons.php';


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wen-featured-image-activator.php
 */
function activate_wen_featured_image() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wen-featured-image-activator.php';
	Wen_Featured_Image_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wen-featured-image-deactivator.php
 */
function deactivate_wen_featured_image() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wen-featured-image-deactivator.php';
	Wen_Featured_Image_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wen_featured_image' );
register_deactivation_hook( __FILE__, 'deactivate_wen_featured_image' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wen-featured-image.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wen_featured_image() {

	$plugin = new Wen_Featured_Image();
	$plugin->run();

}
run_wen_featured_image();
