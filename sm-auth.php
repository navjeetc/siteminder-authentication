<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that also follow
 * WordPress coding standards and PHP best practices.
 *
 * @package   SM_Auth
 * @author    Kevin Attfield <k.attfield@gmail.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Kevin Attfield or Company Name
 *
 * @wordpress-plugin
 * Plugin Name: SiteMinder Authentication
 * Plugin URI:  TODO
 * Description: TODO
 * Version:     1.0.0
 * Author:      Kevin Attfield
 * Author URI:  TODO
 * Text Domain: sm-auth-locale
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /lang
 */

require_once( plugin_dir_path( __FILE__ ) . 'class-sm-auth.php' );

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook( __FILE__, array( 'SM_Auth', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'SM_Auth', 'deactivate' ) );

SM_Auth::get_instance();