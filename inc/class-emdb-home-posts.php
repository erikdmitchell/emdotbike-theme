<?php
global $emdb_home_posts;

class EMDB_Home_Posts {
   protected $opts;

   public function __construct($opts = '') {      
       $this->opts = $opts;
   }

   public function foo() {
       return 'foo';
   }
}

function emdb_front_page_check() {
    global $emdb_home_posts;
    
    if (is_front_page()) {
        $emdb_home_posts = new EMDB_Home_Posts();
    }
}

add_action('wp', 'emdb_front_page_check');