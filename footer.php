        <footer>
            <div class="footer-content">
                <div class="footer-widgets">
                    <div class="footer-widget footer-widget-1"><?php dynamic_sidebar( 'footer-1' ); ?></div>
                    <div class="footer-widget footer-widget-2"><?php dynamic_sidebar( 'footer-2' ); ?></div>
                </div>
                <div class="copyright"><?php echo get_bloginfo( 'name' ); ?> &copy; <?php echo date( 'Y' ); ?></div>
            </div>
        </footer>

        <?php wp_footer(); ?>
    </body>
</html>
