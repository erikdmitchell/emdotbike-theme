<?php
global $emdb_home_posts;

class EMDB_Home_Posts {

    protected $has_posts = false;

    protected $posts = array();

    protected $current_post = 0;

    protected $post_count = 0;

    protected $post_type = 'post';

    public function __construct( $opts = '' ) {
        $ppp = 3;

        if ( wp_count_posts( $this->post_type )->publish > 1 ) {
            $this->has_posts = true;
            $this->posts = get_posts( array( 'posts_per_page' => $ppp ) );
            $this->post_count = count( $this->posts );
        }
    }

    public function has_posts() {
        return $this->has_posts;
    }

    public function posts() {
        if ( $this->current_post < $this->post_count ) {
            return true;
        } elseif ( $this->current_post == $this->post_count && $this->post_count > 0 ) {
            // last post.
        }

        return false;

    }

    public function post() {
        $post = $this->posts[ $this->current_post ];
        $post->post_num = $this->current_post;

        $this->current_post++;

        return $post;
    }

}

/**
 * Checks if on front page and loads class into global var.
 *
 * @access public
 * @return void
 */
function emdb_front_page_check() {
    global $emdb_home_posts;

    if ( is_front_page() ) {
        $emdb_home_posts = new EMDB_Home_Posts();
    }
}
add_action( 'wp', 'emdb_front_page_check' );
