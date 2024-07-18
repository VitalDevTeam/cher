<?php
/*
 * Plugin Name: Cher
 * Version: 2.2.0
 * Plugin URI: https://github.com/VitalDevTeam/cher/
 * Description: Easy management of social profiles and social share links for developers.
 * Author: Vital
 * Author URI: https://vitaldesign.com
 * Text Domain: cher
 * Requires at least: 4.0
 * Tested up to: 6.3.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require 'plugin-update-checker/plugin-update-checker.php';

$update_checker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/VitalDevTeam/cher',
	__FILE__,
	'cher'
);

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
function Cher() {
	$instance = Cher_Plugin_Template::instance( __FILE__, '1.0.0' );

	if ( is_null( $instance->settings ) ) {
		$instance->settings = Cher_Settings::instance( $instance );
	}

	return $instance;
}

Cher();