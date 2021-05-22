<?php
/**
 * Theme Options Panel
 *
 * @since 01.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class EMdotBike_Theme_Options {
    /**
     * Start things up
     *
     * @since 0.1.1
     */
    public function __construct() {
        // We only need to register the admin panel on the back-end
        if ( is_admin() ) {
            add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
            add_action( 'admin_init', array( $this, 'register_settings' ) );
        }

    }

    /**
     * Returns all theme options
     *
     * @since 0.1.1
     */
    public static function get_theme_options() {
        return get_option( 'theme_options' );
    }

    /**
     * Returns single theme option
     *
     * @since 0.1.1
     */
    public static function get_theme_option( $id ) {
        $options = self::get_theme_options();
        if ( isset( $options[ $id ] ) ) {
            return $options[ $id ];
        }
    }

    /**
     * Add sub menu page
     *
     * @since 0.1.1
     */
    public function add_admin_menu() {
        add_menu_page(
            esc_html__( 'Theme Settings', 'emdotbike' ),
            esc_html__( 'Theme Settings', 'emdotbike' ),
            'manage_options',
            'theme-settings',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Register a setting and its sanitization callback.
     *
     * We are only registering 1 setting so we can store all options in a single option as
     * an array. You could, however, register a new setting for each option
     *
     * @since 0.1.1
     */
    public function register_settings() {
        register_setting( 'theme_options', 'theme_options', array( $this, 'sanitize' ) );
    }

    /**
     * Sanitization callback
     *
     * @since 0.1.1
     */
    public function sanitize( $options ) {

        // If we have options lets sanitize them
        if ( $options ) {

            // Checkbox
            if ( ! empty( $options['checkbox_example'] ) ) {
                $options['checkbox_example'] = 'on';
            } else {
                unset( $options['checkbox_example'] ); // Remove from options if not checked
            }

            // Input
            if ( ! empty( $options['input_example'] ) ) {
                $options['input_example'] = sanitize_text_field( $options['input_example'] );
            } else {
                unset( $options['input_example'] ); // Remove from options if empty
            }

            // Select
            if ( ! empty( $options['select_example'] ) ) {
                $options['select_example'] = sanitize_text_field( $options['select_example'] );
            }
        }

        // Return sanitized options
        return $options;
    }

    /**
     * Settings page output
     *
     * @since 0.1.1
     */
    public function create_admin_page() { ?>

        <div class="wrap">

            <h1><?php esc_html_e( 'EMdotBike Theme Options', 'emdotbike' ); ?></h1>

            <form method="post" action="options.php">

                <?php settings_fields( 'theme_options' ); ?>

                <table class="form-table emdotbike-custom-admin-login-table">

                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Footer Background Color', 'emdotbike' ); ?></th>
                        <td>
                            <?php $value = self::get_theme_option( 'input_example' ); ?>
                            <input type="text" name="theme_options[input_example]" value="<?php echo esc_attr( $value ); ?>">
                        </td>
                    </tr>

                </table>

                <?php submit_button(); ?>

            </form>

        </div><!-- .wrap -->
        <?php
    }

}

new EMdotBike_Theme_Options();

// Helper function return a theme option value
function emdotbike_get_theme_option( $id = '' ) {
    return EMdotBike_Theme_Options::get_theme_option( $id );
}
