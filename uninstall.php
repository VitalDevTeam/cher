<?php

/**
 *
 * This file runs when the plugin in uninstalled (deleted).
 * This will not run when the plugin is deactivated.
 * Ideally you will add all your clean-up scripts here
 * that will clean-up unused meta, options, etc. in the database.
 *
 */

// If plugin is not being uninstalled, exit (do nothing)
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}

function cher_delete_options() {
    global $wpdb;
    $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE 'cher_%'");
}

$cher_delete_options = get_option('cher_delete_options', false);

if ($cher_delete_options === 'on') {
    cher_delete_options();
}

// Do something here if plugin is being uninstalled.
