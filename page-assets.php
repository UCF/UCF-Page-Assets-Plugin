<?php
/*
Plugin Name: UCF Page Assets
Version: 1.0.0
Author: UCF Web Communications
License: GPL3
Description: Enqueue a page specific stylesheet and javascript file.
*/

if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'UCF_PAGE_ASSETS__FILE', __FILE__ );
define( 'UCF_PAGE_ASSETS__STATIC_URL', plugins_url( 'static', __FILE__ ) );
define( 'UCF_PAGE_ASSETS__JS_URL', UCF_PAGE_ASSETS__STATIC_URL . '/js' );

/**
 * INCLUDES
 **/
include_once 'includes/page-assets-config.php';
include_once 'admin/page-assets-metabox.php';

// Initiate the Plugin Settings
add_action( 'admin_init', array( 'UCF_Page_Assets_Config', 'settings_init' ) );
// Add the options page.
add_action( 'admin_menu', array( 'UCF_Page_Assets_Config', 'add_options_page' ) );
// Add metaboxes
add_action( 'add_meta_boxes', array( 'UCF_Page_Assets_Metabox', 'add_meta_box' ), 10, 2 );
// Add javascript assets
add_action( 'admin_enqueue_scripts', array( 'UCF_Page_Assets_Metabox', 'enqueue_assets' ), 10, 1 );
