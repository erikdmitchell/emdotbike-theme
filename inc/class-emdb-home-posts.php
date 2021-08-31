<?php
global $emdb_home_posts;

/**
 * EMDB_Home_Posts class.
 */
class EMDB_Home_Posts {

    /**
     * has_posts
     *
     * (default value: false)
     *
     * @var bool
     * @access protected
     */
    protected $has_posts = false;

    /**
     * posts
     *
     * (default value: array())
     *
     * @var array
     * @access protected
     */
    protected $posts = array();

    /**
     * current_post
     *
     * (default value: 0)
     *
     * @var int
     * @access protected
     */
    protected $current_post = 0;

    /**
     * post_count
     *
     * (default value: 0)
     *
     * @var int
     * @access protected
     */
    protected $post_count = 0;

    /**
     * post_type
     *
     * (default value: 'post')
     *
     * @var string
     * @access protected
     */
    protected $post_type = 'post';

    /**
     * __construct function.
     *
     * @access public
     * @param string $opts (default: '')
     * @return void
     */
    public function __construct( $opts = '' ) {
        $ppp = 3;

        if ( wp_count_posts( $this->post_type )->publish > 1 ) {
            $this->has_posts = true;
            $this->total_posts = wp_count_posts( $this->post_type )->publish;
            $this->posts = get_posts( array( 'posts_per_page' => $ppp ) );
            $this->post_count = count( $this->posts );
        }
    }

    /**
     * Has posts.
     *
     * @access public
     * @return bool
     */
    public function has_posts() {
        return $this->has_posts;
    }

    /**
     * Loads post.
     *
     * @access public
     * @return bool
     */
    public function posts() {
        if ( $this->current_post < $this->post_count ) {
            return true;
        } elseif ( $this->current_post == $this->post_count && $this->post_count > 0 ) {
            // last post.
        }

        return false;

    }

    /**
     * Single post.
     *
     * @access public
     * @return array (single post)
     */
    public function post() {
        $post = $this->posts[ $this->current_post ];
        $post->post_num = $this->current_post;

        $this->current_post++;

        return $post;
    }

    /**
     * Checks for more posts than displayed on page.
     *
     * @access public
     * @return bool
     */
    public function more_posts() {
        $ppp = 3;

        if ( $this->total_posts > $ppp ) {
            return true;
        }

        return false;
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
