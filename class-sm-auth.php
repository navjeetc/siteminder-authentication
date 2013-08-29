<?php
/**
 * Plugin Name.
 *
 * @package   SM_Auth
 * @author    Kevin Attfield <k.attfield@gmail.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Kevin Attfield
 */

/**
 * Plugin class.
 *
 * @package SM_Auth
 * @author  Kevin Attfield <k.attfield@gmail.com>
 */
class SM_Auth {

  const VERSION = '1.0.0';

  public $_isAuthenticated = false;
  public $plugin_slug = 'sm-auth';

  private static $instance = null;

  private $plugin_screen_hook_suffix = null;
  private $universalid = 'ROLARIU'; //fake it 'till we make it
  //private $universalid = $_SERVER[HTTP_SM_UNIVERSALID];

  /**
   * Return an instance of this class.
   *
   * @since     1.0.0
   *
   * @return    object    A single instance of this class.
   */
  public static function get_instance() {

    // If the single instance hasn't been set, set it now.
    if ( null == self::$instance ) {
      self::$instance = new self;
    }

    return self::$instance;
  }

  /**
   * If user not logged in, use SM login
   * 
   */
  public function authenticate() {
    if($this->is_user_logged_in() || !$this->universalid) {
      return;
    }

    $userid = username_exists($this->universalid);
    if(!$userid) {
      $userid = $this->create_user($this->universalid);
    }
    $this->login($userid);
  }

  private function is_user_logged_in() {
    return get_current_user_id() != 0;
  }

  private function login($userid) {
    wp_set_auth_cookie($userid);
  }

  /**
   * Create a new WordPress account for the specified username.
   * 
   * @param string $username
   * @return integer user_id
   */
  private function create_user($username) {
    $password = wp_generate_password( $length=12, $include_standard_special_chars=false );

    return wp_create_user($username, $password);
  }

  /**
   * Generate a random password.
   * 
   * @param int $length Length of the password
   * @return password as string
   */
  private function _get_password($length = 10) {
    return substr(md5(uniqid(microtime())), 0, $length);
  }

  private function __construct() {

    // Load plugin text domain
    add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

    // Add the options page and menu item.
    add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

    // Add an action link pointing to the options page.
    // $plugin_basename = plugin_basename( plugin_dir_path( __FILE__ ) . 'sm-auth.php' );
    // add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

    // Load admin style sheet and JavaScript.
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

    add_filter('init', array($this, 'authenticate'), 30);
  }

  /**
   * Fired when the plugin is activated.
   *
   * @since    1.0.0
   *
   * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
   */
  public static function activate( $network_wide ) {
    // TODO: Define activation functionality here
  }

  /**
   * Fired when the plugin is deactivated.
   *
   * @since    1.0.0
   *
   * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
   */
  public static function deactivate( $network_wide ) {
    // TODO: Define deactivation functionality here
  }

  /**
   * Load the plugin text domain for translation.
   *
   * @since    1.0.0
   */
  public function load_plugin_textdomain() {

    $domain = $this->plugin_slug;
    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

    load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
    load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
  }

  /**
   * Register and enqueue admin-specific style sheet.
   *
   * @since     1.0.0
   *
   * @return    null    Return early if no settings page is registered.
   */
  public function enqueue_admin_styles() {

    if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
      return;
    }

    $screen = get_current_screen();
    if ( $screen->id == $this->plugin_screen_hook_suffix ) {
      wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ), array(), $this->version );
    }

  }

  /**
   * Register and enqueue admin-specific JavaScript.
   *
   * @since     1.0.0
   *
   * @return    null    Return early if no settings page is registered.
   */
  public function enqueue_admin_scripts() {

    if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
      return;
    }

    $screen = get_current_screen();
    if ( $screen->id == $this->plugin_screen_hook_suffix ) {
      wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), $this->version );
    }

  }

  /**
   * Register the administration menu for this plugin into the WordPress Dashboard menu.
   *
   * @since    1.0.0
   */
  public function add_plugin_admin_menu() {

    $this->plugin_screen_hook_suffix = add_options_page(
      __( 'SiteMinder Authentication Page', $this->plugin_slug ),
      __( 'SiteMinder Authentication', $this->plugin_slug ),
      'read',
      $this->plugin_slug,
      array( $this, 'display_plugin_admin_page' )
    );
  }

  /**
   * Render the settings page for this plugin.
   *
   * @since    1.0.0
   */
  public function display_plugin_admin_page() {
    include_once( 'views/admin.php' );
  }

  /**
   * Add settings action link to the plugins page.
   *
   * @since    1.0.0
   */
  public function add_action_links( $links ) {

    return array_merge(
      array(
        'settings' => '<a href="' . admin_url( 'plugins.php?page=sm-auth' ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
      ),
      $links
    );
  }
}
