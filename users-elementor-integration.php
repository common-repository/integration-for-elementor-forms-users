<?php

/**
 * Plugin Name: Integration for Elementor forms - Users
 * Description: Easily create users when submitting a Elementor form
 * Author: Webtica
 * Author URI: https://webtica.be/
 * Version: 1.0.0
 * Elementor tested up to: 3.6.7
 * Elementor Pro tested up to: 3.7.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

//load plugins functionallity and settings
require dirname(__FILE__).'/init-users-integration-action.php';
require dirname(__FILE__).'/includes/settings.php';

//Check if Elementor pro is installed
function webtica_users_integration_check_elementor_pro_is_active() {

	if ( !is_plugin_active('elementor-pro/elementor-pro.php') ) {
		echo "<div class='error'><p><strong>Users Elementor integration</strong> requires <strong> Elementor Pro plugin to be installed and activated</strong> </p></div>";
	}
}
add_action('admin_notices', 'webtica_users_integration_check_elementor_pro_is_active');