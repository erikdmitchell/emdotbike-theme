<?php
ob_start();
get_template_part( 'template-parts/content', 'home-grid' );
return ob_get_clean();