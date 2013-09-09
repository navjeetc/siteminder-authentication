<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   SM_Auth
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
