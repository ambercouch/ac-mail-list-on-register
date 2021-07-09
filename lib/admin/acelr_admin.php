<?php



function acelr_options_assets() {
    wp_enqueue_script( 'acelr-admin-script', plugins_url( '/', __FILE__ ) . '../../dist/admin/js/admin-script-acelr.js', array( 'wp-api', 'wp-i18n', 'wp-components', 'wp-element' ), AC_EMAIL_LIST_ON_REGISTRATION_PLUGIN_VERSION, true );
    wp_enqueue_style( 'acelr-admin-style', plugins_url( '/', __FILE__ ) . '../../dist/admin/css/admin-styles-acelr.css', array( 'wp-components' ) );
}

function acelr_menu_callback() {
    echo '<div id="codeinwp-awesome-plugin"></div>';
}

function acelr_add_option_menu() {
    $page_hook_suffix = add_options_page(
        __( 'AC Email List Settings', 'acelr' ),
        __( 'AC Email List', 'acelr' ),
        'manage_options',
        'acelr',
        'acelr_menu_callback'
    );

    add_action( "admin_print_scripts-{$page_hook_suffix}", 'acelr_options_assets' );
}

add_action( 'admin_menu', 'acelr_add_option_menu' );


function codeinwp_register_settings() {
    register_setting(
        'acelr_settings',
        'acelr_sib_key',
        array(
            'type'         => 'string',
            'show_in_rest' => true,
            'description' => 'API key for Sendinblue'

        )
    );
}

add_action( 'init', 'codeinwp_register_settings' );
