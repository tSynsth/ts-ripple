<?php 
	/*
	 * Plugin Name:       TS Ripple
	 * Version:           1.1.0
	 * Plugin URI:        http://tuningsynesthesia.com/
	 * Description:       NA
	 * Author:            Reza Putra Santoso
	 * Author URI:        http://tuningsynesthesia.com/
	 * Requires at least: 3.2.0
	 * Tested up to:      3.4.0
	 * Text Domain:       tsrb
	 * Domain Path:       /lang
	 * License:	  		  ISC
	 * @package WordPress
	 * @author Author Name
	 * @since 1.0.0
	 */

	/**
     * Get the current plugin data.
     * @since   1.0.0
     * @return  An array contains plugin data 
     **/

if (!function_exists('tsrb')) {
	function tsrb() {

		$plugin = _get_the_plugin(__FILE__);
		$_token = $plugin['TextDomain'];
		$_version = $plugin['Version'];

		/**
		 * Constants
		 * Uncomment if necessary
		 * @since   1.0.0
		 **/

		/*if ( ! defined( 'CONST' ) )
		define( 'CONST', 'a constant value' );*/

		/**
		 * File inclusion
		 * @since   1.0.0
		 **/

		require_once( 'includes/class-' . $_token . '.php' );
		// activate addons one by one from modules directory
        foreach(glob(dirname(__FILE__)  . '/includes/modules/*.php') as $module){
            require_once($module);
        }
		/**
		 * Returns the main instance of pn to prevent the need to use globals.
		 *
		 * @since  1.0.0
		 * @return object pn
		 */
		$instance = tsrb::instance( __FILE__, $_token, $_version );
		$instance->ptshortcode = TS_PTShortcode::instance( $instance );
		$instance->ptshortcodeajax = TS_PTShortcodeajax::instance( $instance );
		$instance->rcshortcode = TS_RippleButton:: instance( $instance );
		return $instance;
	}
}

	/**
     * Get the current plugin data.
     * @since   1.0.0
     * @return  An array contains plugin data 
     **/

if (!function_exists('_get_the_plugin')) {
    function _get_the_plugin($file) {

        if ( ! function_exists( 'get_plugins' ) )
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        $plugin_folder = get_plugins( '/' . plugin_basename( dirname( $file ) ) );
        $plugin_file = basename( ( $file ) );

        return $plugin_folder[$plugin_file];

    } // End _get_the_plugin ()
}

tsrb();

?>