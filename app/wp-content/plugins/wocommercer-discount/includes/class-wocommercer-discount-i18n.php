<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       github.com/silvergama
 * @since      1.0.0
 *
 * @package    Wocommercer_Discount
 * @subpackage Wocommercer_Discount/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wocommercer_Discount
 * @subpackage Wocommercer_Discount/includes
 * @author     Silver Gama <silver.mdg@gmail.com>
 */
class Wocommercer_Discount_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wocommercer-discount',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
