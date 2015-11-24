<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class tsrb {
    /**
     * The single instance of tste.
     * @var    object
     * @access  private
     * @since    1.0.0
     */
    private static $_instance = null;
    /**
     * Settings class object
     * @var     object
     * @access  public
     * @since   1.0.0
     */
    public $settings = null;
    /**
     * The version number.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $_version;
    /**
     * The token.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $_token;
    /**
     * The main plugin file.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $_file;
    /**
     * The main plugin directory.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $dir;
    /**
     * The main plugin URL.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $url;
    /**
     * The URL of current plugin file.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $current_url;
    /**
     * The plugin assets directory.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $assets_dir;
    /**
     * The plugin assets URL.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $assets_url;
    /**
     * Suffix for Javascripts.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $script_suffix;


    /**
     * Constructor
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    public function __construct( $file = '', $token = 'token', $version = '1.0.0' ) {

        global $post;

        // On Activation

        $this->_file = $file;
        $this->_token = $token;
        $this->_version = $version;

        register_activation_hook($this->_file, array($this, 'install'));
        
        // Variables

        $this->dir = dirname($this->_file);
        $this->url = plugins_url('', $this->_file);
        $this->current_url = plugin_dir_path(__FILE__);
        $this->assets_dir = trailingslashit($this->dir) . 'assets/'; 
        $this->assets_url = esc_url(trailingslashit(plugins_url('/assets/', $this->_file)));
        $this->script_suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        $this->module_dir =  trailingslashit($this->dir) . 'includes/modules/'; 
        // $this->assets_js = $this->assets_url . 'js/';
        // $this->assets_css = $this->assets_url . 'css/';
        // $this->assets_img = $this->assets_url . 'img/';

        // Intializations

        $this->init(); // Init B/F 
        if (is_admin()) $this->init_admin(); // Init B
        if (!is_admin()) $this->init_frontend(); // Init F

    } // End __construct ()


    /* --------------------------------------
     *
     * Intializations
     * 
     * --------------------------------------*/
    /**
     * Init B/F (Backend: Admin + Frontend)
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    public function init() {
        // activate addons one by one from modules directory
        /*foreach(glob($this->module_dir."/*.php") as $module){
            require_once($module);
        }*/
    } // End init()

    /**
     * Init B (Backend: Admin)
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    public function init_admin() {

        // Load admin JS & CSS
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 10, 1, 999);
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_styles'), 10, 1, 999);
    } // End init_admin()

    /**
     * Init F (Frontend)
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    public function init_frontend() {

        // Load frontend JS & CSS
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 10, 999);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'), 10, 999);
    } // End init_frontend() 


    /* --------------------------------------
     *
     * Functions Used in Initializations
     *
     * --------------------------------------*/

    /**
     * Load admin Javascript.
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    public function admin_enqueue_scripts($hook = '') {
        wp_register_script($this->_token . '-admin',
                           esc_url($this->assets_url) . 'js/admin' . $this->script_suffix . '.js', array('jquery'),
                           $this->_version);
        wp_enqueue_script($this->_token . '-admin');
    } // End admin_enqueue_scripts ()

    /**
     * Load admin CSS.
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    public function admin_enqueue_styles($hook = '') {
        wp_register_style($this->_token . '-admin', esc_url($this->assets_url) . 'css/admin' . $this->script_suffix . '.css', array(),
                          $this->_version, false);
        wp_enqueue_style($this->_token . '-admin');
    } // End admin_enqueue_styles ()

    /**
     * Load frontend Javascript.
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    public function enqueue_scripts() {
        wp_register_script($this->_token . '-plugins',
            esc_url($this->assets_url) . 'js/plugins' . $this->script_suffix . '.js', array('jquery'),
            $this->_version, true);
        wp_enqueue_script($this->_token . '-plugins');

        wp_register_script($this->_token . '-frontend',
            esc_url($this->assets_url) . 'js/frontend' . $this->script_suffix . '.js', array('jquery'),
            $this->_version, true);
        wp_enqueue_script($this->_token . '-frontend');

    } // End enqueue_scripts ()


    /**
     * Load frontend CSS.
     * @access  public
     * @since   1.0.0
     * @return void
     */
    public function enqueue_styles() {
        wp_register_style( $this->_token . '-bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css' );
        wp_enqueue_style( $this->_token . '-bootstrap');

        wp_register_style( $this->_token . '-frontend', esc_url( $this->assets_url ) . 'css/frontend' . $this->script_suffix . '.css', array(), $this->_version, false );
        wp_enqueue_style( $this->_token . '-frontend' );


        wp_register_style($this->_token . '-dummystyle', esc_url( $this->assets_url ) . 'css/dummystyle' . $this->script_suffix . '.css', array(), $this->_version, false );
    } // End enqueue_styles ()


    /* --------------------------------------
     *
     * Class Core
     * Do not change here unless you know what you are doing
     *
     * --------------------------------------*/

    /**
     * Object Instance
     *
     * Ensures only one instance of class is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @see plugin.php
     * @return object instance
     */
    public static function instance($file = '', $token = 'token', $version = '1.0.0') {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($file, $token, $version);
        }
        return self::$_instance;
    } // End instance ()

    /**
     * Installation. Runs on activation.
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    public function install() {
        $this->_log_version_number();
    } // End install ()

    /**
     * Log the plugin version number.
     * @access  private
     * @since   1.0.0
     * @return  void
     **/
    public function _log_version_number() {
        update_option( $this->_token . '_version', $this->_version );
    } // End _log_version_number ()

} // End class