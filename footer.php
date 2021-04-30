        <footer>
            <div class="container footer-content">
                <div class="row footer-widgets">
                    <div class="col-4 footer-widget footer-widget-1"><?php dynamic_sidebar( 'footer-1' ); ?></div>
                    <div class="col-4 footer-widget footer-widget-2"><?php dynamic_sidebar( 'footer-2' ); ?></div>
                    <div class="col-4 footer-widget footer-widget-3 align-text-center"><?php dynamic_sidebar( 'footer-3' ); ?></div>
                <div class="copyright"><?php echo get_bloginfo( 'name' ); ?> &copy; <?php echo date( 'Y' ); ?></div>
            </div>
        </footer>

        <?php wp_footer(); ?>
    </body>
</html>
