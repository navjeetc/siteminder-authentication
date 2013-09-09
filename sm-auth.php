<?php
/**
 * SiteMinder Authentication a Wordpress plugin.
 *
 * A wordpress plugin for login using SiteMinder credentials.
 *
 * @package   SM_Auth
 * @author    Kevin Attfield <k.attfield@gmail.com>
 * @license   GPL-2.0+
 * @link      https://github.com/TheWebShop/siteminder-authentication
 * @copyright ♡ Copying is an act of love. Please copy.
 *
 * @wordpress-plugin
 * Plugin Name: SiteMinder Authentication
 * Plugin URI:  https://github.com/TheWebShop/siteminder-authentication
 * Description: A wordpress plugin for login using SiteMinder credentials.
 * Version:     1.0.0
 * Author:      Kevin Attfield
 * Author URI:  https://github.com/Sinetheta
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

require_once( plugin_dir_path( __FILE__ ) . 'class-sm-auth.php' );

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook( __FILE__, array( 'SM_Auth', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'SM_Auth', 'deactivate' ) );

SM_Auth::get_instance();