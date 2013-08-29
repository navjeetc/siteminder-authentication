<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package   SM_Auth
 * @author    Kevin Attfield <k.attfield@gmail.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Kevin Attfield or Company Name
 */

// If uninstall, not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// TODO: Define uninstall functionality here