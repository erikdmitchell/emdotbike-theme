<?php

class EM_Social extends WP_Widget {
 
    function __construct() {
 
        parent::__construct(
            'em-social',  // Base ID
            'Social Media'   // Name
        );
 
        add_action( 'widgets_init', function() {
            register_widget( 'EM_Social' );
        });
 
    }
 
    public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    );
 
    public function widget( $args, $instance ) {
        $html = '';
        
        $html .= '<h3>Connect with Me</h3>';
        $html .= '<ul class="social-media">';
            $html .= '<li id="social-media-facebook"><a href="https://www.facebook.com/erikdmitchell"><i class="fab fa-facebook"></i></a></li>';
            $html .= '<li id="social-media-twitter"><a href="https://twitter.com/erikdmitchell"><i class="fab fa-twitter"></i></a></li>';
            $html .= '<li id="social-media-instagram"><a href="https://instagram.com/erikdmitchell"><i class="fab fa-instagram"></i></a></li>';
        $html .= '</ul>';
        
        echo $args['before_widget'];
 
        //echo '<div class="textwidget">'; 
                    
            echo $html;                    
 
        //echo '</div>';
 
        echo $args['after_widget'];
 
    }
 
/*
    public function form( $instance ) {
 
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
        $text = ! empty( $instance['text'] ) ? $instance['text'] : esc_html__( '', 'text_domain' );
        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'Text' ) ); ?>"><?php echo esc_html__( 'Text:', 'text_domain' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" cols="30" rows="10"><?php echo esc_attr( $text ); ?></textarea>
        </p>
        <?php
 
    }
*/
 
    public function update( $new_instance, $old_instance ) {
 
        $instance = array();
 
        //$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        //$instance['text'] = ( !empty( $new_instance['text'] ) ) ? $new_instance['text'] : '';
 
        return $instance;
    }
 
}
$em_social = new EM_Social();