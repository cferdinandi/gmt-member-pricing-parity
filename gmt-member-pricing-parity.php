<?php

/**
 * Plugin Name: GMT Member Pricing Parity
 * Plugin URI: https://github.com/cferdinandi/gmt-member-pricing-parity/
 * GitHub Plugin URI: https://github.com/cferdinandi/gmt-member-pricing-parity/
 * Description: Provide custom discounts based on geographic location
 * Version: 1.0.0
 * Author: Chris Ferdinandi
 * Author URI: http://gomakethings.com
 * License: GPLv3
 */

require_once( plugin_dir_path( __FILE__ ) . 'includes/settings.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/helpers.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/checkout.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/payments.php' );