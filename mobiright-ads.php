<?php

/**
 * @link              http://example.com
 * @since             1.0.0
 * @package           Plugin_Name
 *
 * @wordpress-plugin
 * Plugin Name:       Better Mobile Ads by Mobiright
 * Plugin URI:        http://mobiright.com
 * Description:       Better ads, made for mobile. Improve your readers' interactions with ads on mobile devices and lift your revenue with our easy to use plugin.
 * Version:           1.0.0
 * Author:            Mobiright
 * Author URI:        http://mobiright.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
require plugin_dir_path( __FILE__ ) . 'includes/class-mobiright-ads.php';
require plugin_dir_path( __FILE__ ) . 'includes/config.php';

function run_mobiright_ads() {

	$plugin = new Mobiright_Ads();
	$plugin->run();

}
run_mobiright_ads();
