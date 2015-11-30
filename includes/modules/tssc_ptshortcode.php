<?php
	/**
	 * Shortcode Name: 	TS PTShortcode
	 * Function Name: 	ptshortcode
	 * Shortcode Tag: 	[ts_ptshortcode]
	 * Description: 	Shortcode for TS WP Plugin Template Shortcode. It simply outputs '$content'.
	 * URI: 			http://tuningsynesthesia.com/
	 * Depricated Shortcode Tag: NA
	 */

//d
	
if(!class_exists("TS_PTShortcode")){
	class TS_PTShortcode{

		/**
		 * The single instance of shortcode class.
		 * @var 	object
		 * @access  private
		 * @since 	1.0.0
		 */
		private static $_instance = null;

		/**
		 * The parent.
		 * @var 	object
		 * @access  public
		 * @since 	1.0.0
		 */
		public $parent = null;

		/**--------------------------------------------------
		 *
		 *	Constructor and Initialization 
		 *
		 * -------------------------------------------------- */
		public function __construct( $parent ) {
			$this->parent = $parent;
			add_shortcode("ts_ptshortcode", array($this,"ptshortcode"));
		}
		public function ptshortcode_init(){
			if(function_exists("vc_map")){	
			}
		}
		/**--------------------------------------------------
		 *
		 *	Shortcode 
		 *
		 * -------------------------------------------------- */
		/**
		 *
		 *	Function: ptshortcode.
		 *  @return Shortcode main output in html
		 *
		 */
		public function ptshortcode ($atts, $content = null){
			
			extract(shortcode_atts(array(
				"id" => "",
				"font_color" => "",
				"class" => ""
			),$atts));


			$class_id = $style = $op = '';

			/*** Class ID ***/
			if(!empty($id)){
				$class_id = 'ts-ptshortcode-' . $id;
			} else {
				$rand = rand ( 1000 , 9999 );
				$class_id = 'ts-ptshortcode-' . $rand;
			}

			/*** Content ***/
			if (class_exists('TS_funcs')) {
				$ts_funcs = new TS_funcs;
				$content = $ts_funcs->removeautowrap ($content);
			}
			do_shortcode($content);

			/*** Custom Class ***/
			$style = 'color: ' . $font_color . ';';

			if (!empty($style)){

				$styleblock = '.' . $class_id . '{' . $style . '}';

				if (class_exists('TS_funcs') && $ts_funcs->tste_settings['gn_theme_ajax'] === 'true') {
						echo '<style id="style-' . $class_id . '" type="text/css">'
								. $styleblock
							. '</style>';
				}else{
					wp_enqueue_style($this->parent->_token . '-dummystyle');
					wp_add_inline_style($this->parent->_token . '-dummystyle', $styleblock);
				}
			}
			
			/*** Output ***/
			$op = '<div class="' . $class_id . ' ' . $class . '">'
					. $content
					. '</div>';

			return $op;
		}


		/**--------------------------------------------------
		 *
		 *	Class Core
	     *  Do not change here unless you know what you are doing
		 *
		 * -------------------------------------------------- */
	    	/**
			 * Object Instance and Inheritance
			 *
			 * Ensures only one instance of class is loaded or can be loaded.
			 *
			 * @since 1.0.0
			 * @static
			 * @see __construct()
			 * @return Object Instance and Inheritance
			 */
			public static function instance ( $parent ) {
				if ( is_null( self::$_instance ) ) {
					self::$_instance = new self( $parent );
				}
				return self::$_instance;
			} // End instance()

	} // end class

}