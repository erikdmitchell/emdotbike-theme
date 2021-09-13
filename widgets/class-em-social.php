<?php
/**
 * Social media widget
 *
 * @package WordPress
 * @subpackage emdotbike
 * @since emdotbike 0.1.0
 */

/**
 * EM_Social class.
 *
 * @extends WP_Widget
 */
class EM_Social extends WP_Widget {

    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct(
            'em-social',  // Base ID.
            'Social Media'   // Name.
        );

        add_action(
            'widgets_init',
            function() {
                register_widget( 'EM_Social' );
            }
        );

    }

    /**
     * Args
     *
     * @var mixed
     * @access public
     */
    public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>',
    );

    /**
     * Widget.
     *
     * @access public
     * @param mixed $args array.
     * @param mixed $instance array.
     * @return void
     */
    public function widget( $args, $instance ) {
        $widget = '';
        $html = '';

        $html .= '<h3>Connect with Me</h3>';
        $html .= '<div class="em-social-media-wrap">';
            $html .= '<ul class="social-media">';
                $html .= '<li id="social-media-facebook"><a href="https://www.facebook.com/erikdmitchell"><i class="fab fa-facebook"></i></a></li>';
                $html .= '<li id="social-media-twitter"><a href="https://twitter.com/erikdmitchell"><i class="fab fa-twitter"></i></a></li>';
                $html .= '<li id="social-media-instagram"><a href="https://instagram.com/erikdmitchell"><i class="fab fa-instagram"></i></a></li>';
            $html .= '</ul>';
        $html .= '</div>';

        $widget .= $args['before_widget'];

        $widget .= '<div class="em-social-widget">';

            $widget .= $html;

        $widget .= '</div>';

        $widget .= $args['after_widget'];

        echo wp_kses_post( $widget );
    }

    /**
     * Update.
     *
     * @access public
     * @param mixed $new_instance array.
     * @param mixed $old_instance array.
     * @return array.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();

        return $instance;
    }

}
$em_social = new EM_Social();
