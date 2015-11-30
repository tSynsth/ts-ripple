<?php
/**
 * Shortcode Name:    TS PT Shortcode Ajax
 * Function Name:    ptshortcodeajax
 * Shortcode Tag:    [ts_ptshortcodeajax]
 * Description:    Shortcode for TS WP Plugin Template Shortcode. It uses Ajax and outputs '$content' when a button is pressed.
 * URI:            http://tuningsynesthesia.com/
 * Depricated Shortcode Tag: NA
 */


if (!class_exists("TS_PTShortcodeAjax")) {
    class TS_PTShortcodeAjax
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

            // Ajax Setup
            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 10, 999);
            add_action('wp_ajax_nopriv_ptshortcodeajax', array($this, 'ptshortcodeajax_callback'));
            add_action('wp_ajax_ptshortcodeajax', array($this, 'ptshortcodeajax_callback'));

            add_shortcode("ts_ptshortcodeajax", array($this, "ptshortcodeajax"));
        }

        public function ptshortcodeajax_init() {
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
         *    Function: ptshortcodeajax.
         * @return Shortcode main output in html
         *
         */
        public function ptshortcodeajax($atts, $content = null)
        {

            global $post;
            extract(shortcode_atts(array(
                "id" => "",
                "field" => "",
                "font_color" => "",
                "class" => ""
            ), $atts));


            $class_id = $style = $op = '';


            /*** Class ID ***/
            if (!empty($id)) {
                $class_id = 'ts-ptshortcodeajax-' . $id;
            } else {
                $rand = rand(1000, 9999);
                $class_id = 'ts-ptshortcodeajax-' . $rand;
            }

            /*** Content ***/
            if (class_exists('TS_funcs')) {
                $ts_funcs = new TS_funcs;
                $content = $ts_funcs->removeautowrap($content);
            }
            do_shortcode($content);

            /*** Custom Class ***/
            /*$style = 'color: ' . $font_color . ';';

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
            }*/

            /*** Output ***/

            $op .= '<div class="' . $class_id . ' ' . $class . '">';
            $op .= '<p>' . $content . '</p>';
            $op .= '<button class="btn btn tmpl-subtle btn-lg popover-button " data-id="' . $post->ID . '" data-field="' . $field . '"><i class="glyphicon glyphicon-repeat"></i></button>';
            $op .= '<p class="callback" style="min-height: 28px;">' . '' . '</p>';
            $op .= '</div>';

            return $op;
        }

        /**--------------------------------------------------
         *
         *    Helper Function
         *
         * -------------------------------------------------- */
        public function enqueue_scripts()
        {
            wp_localize_script($this->parent->_token . '-frontend', 'TSPTSC', array(
                'ajax_url' => admin_url('admin-ajax.php')
            ));
        }

        /**
         *
         * Function: ptshortcodeajax.
         * @return Shortcode main output in html
         *
         */

        public function ptshortcodeajax_callback()
        {
            //$op = false;
            // if (class_exists('TS_funcs')) {
            // 	$ts_funcs = new TS_funcs;
            // 	$op = $ts_funcs->ffff ($post_id, $type, $key);
            // }
            //var_dump($_POST);
            //var_dump($_REQUEST);
            $post_id = $_POST['post_id'];
            $field = $_POST['field'];
            $op = get_post_meta($post_id, $field, true);

            if (defined('DOING_AJAX') && DOING_AJAX) {
                echo $op;
                die();
            } else {
                wp_redirect(get_permalink($post_id));
                exit();
            }

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