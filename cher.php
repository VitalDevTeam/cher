<?php
/*
 * Plugin Name: Cher
 * Version: 2.0
 * Plugin URI: https://github.com/VitalDevTeam/cher/
 * Description: Easy management of social profiles and social share links for developers.
 * Author: Vital
 * Author URI: https://vtldesign.com
 * Text Domain: cher
 * Requires at least: 4.0
 * Tested up to: 4.7.1
 */

if (! defined( 'ABSPATH' )) {
	exit;
}

// Load plugin class files
require_once( 'includes/class-plugin.php' );
require_once( 'includes/class-settings.php' );

// Load plugin libraries
require_once( 'includes/lib/class-admin-api.php' );

// Load public plugin functions
require_once( 'public/functions.php' );

/**
 * Returns the main instance of the plugin to prevent the need to use globals.
 */
function _bootstrap_cher() {
	$instance = Cher_Plugin_Template::instance( __FILE__, '1.0.0' );

	if (is_null( $instance->settings)) {
		$instance->settings = Cher_Settings::instance( $instance );
	}

	return $instance;
}

_bootstrap_cher();
