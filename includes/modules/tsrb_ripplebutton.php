<?php
/**
 * Shortcode Name:    TS PTShortcode
 * Function Name:    ptshortcode
 * Shortcode Tag:    [ts_ripplebutton]
 * Description:    Shortcode for TS WP Plugin Template Shortcode. It simply outputs '$content'.
 * URI:            http://tuningsynesthesia.com/
 * Depricated Shortcode Tag: NA
 */


if (!class_exists("TS_RippleButton")) {
    class TS_RippleButton
    {

        /**
         * The single instance of shortcode class.
         * @var    object
         * @access  private
         * @since    1.0.0
         */
        private static $_instance = null;

        /**
         * The parent.
         * @var    object
         * @access  public
         * @since    1.0.0
         */
        public $parent = null;

        /**--------------------------------------------------
         *
         *    Constructor and Initialization
         *
         * -------------------------------------------------- */
        public function __construct($parent)
        {
            $this->parent = $parent;
            add_shortcode("ts_ripplebutton", array($this, "ripplebutton"));

        }

        public function ripplebutton_init()
        {
            if (function_exists("vc_map")) {
            }
        }
        /**--------------------------------------------------
         *
         *    Shortcode
         *
         * -------------------------------------------------- */
        /**
         *
         *    Function: ripplebutton.
         * @return Shortcode main output in html
         *
         */


        public function ripplebutton($atts, $content)
        {
            extract(shortcode_atts(array(
                "title" => "",
                "color" => "",
                "type" => ""
            ), $atts));

            //CLASS ID
            if (!empty($id)) {
                $class_id = 'ts-ptshortcode-' . $id;
            } else {
                $rand = rand(1000, 9999);
                $class_id = 'ts-ptshortcode-' . $rand;
            }

            if (!empty($color == 'red')) {
                $color = '#ff0000';
            } else if (!empty($color == 'green')) {
                $color = '#00ff00';
            } else if (!empty($color == 'blue')) {
                $color = '#rrggbb';
            } else {
                $color = 'rgba(200,200,200,0.2)';
            }


                $type = '<div id="body">'
                    .'<div class="wrap">'
                    . '<a class="box ripple-effect btn btn-default btn-lg" style="display: block;" type="button" data-ripple-limit="' . $title . '" data-ripple-color="' . $color . '">' . $content . '</a> '
                    . '</div>'
                    . '</div>';
                return $type;



//            echo "<script type='text/javascript'>alert('$type');</script>";
//            $output =
//                '<div id="body">'
//                .'<div class="wrap">'
//                . '<a href="#" class="box ripple-effect" data-ripple-limit="' . $title . '" data-ripple-color="' . $color . '">' . $content . '</a> '
//                . '</div>'
//                . '</div>';
//
//            return $output;


        }


        /**--------------------------------------------------
         *
         *    Class Core
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
        public static function instance($parent)
        {
            if (is_null(self::$_instance)) {
                self::$_instance = new self($parent);
            }
            return self::$_instance;
        } // End instance()

    } // end class

}