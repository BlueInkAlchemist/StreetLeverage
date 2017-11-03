<?php

class SL_Trending_Options
{

    protected static $instance = null;

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    public static function get_instance() {
        if( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function add_menu_page() {
        add_menu_page(
            'StreetLeverage Options',
            'StreetLeverage Options',
            'manage_options',
            'sl-trending-options',
            array( $this, 'create_admin_page' ),
            'dashicons-chart-area'
        );
    }

    public function create_admin_page() {
        ob_start();
        load_template(WP_PLUGIN_DIR . "/streetleverage-tools/templates/admin-menus/sl-trending-options.php", false);
        echo ob_get_clean();
    }

    public function page_init() {
        register_setting( 'sl-trending-settings', 'sl_trending_days' );
        register_setting( 'sl-trending-settings', 'sl_trending_view_weight' );
        register_setting( 'sl-trending-settings', 'sl_trending_comment_weight' );
        register_setting( 'sl-trending-settings', 'sl_trending_like_weight' );
        register_setting( 'sl-trending-settings', 'sl_trending_share_weight' );
        register_setting( 'sl-trending-settings', 'sl_trending_text_prompt' );
    }

}