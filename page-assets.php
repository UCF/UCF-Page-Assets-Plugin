<?php
/*
Plugin Name: UCF Page Assets
Version: 1.0.1
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
include_once 'includes/page-assets-common.php';
include_once 'admin/page-assets-metabox.php';

// Initiate the Plugin Settings
add_action( 'admin_init', array( 'UCF_Page_Assets_Config', 'settings_init' ) );
// Add the options page.
add_action( 'admin_menu', array( 'UCF_Page_Assets_Config', 'add_options_page' ) );
// Add metaboxes
add_action( 'add_meta_boxes', array( 'UCF_Page_Assets_Metabox', 'add_meta_box' ), 10, 0);
// Save metabox values
add_action( 'save_post', array( 'UCF_Page_Assets_Metabox', 'save_metabox' ), 10, 1 );
// Add javascript assets
add_action( 'admin_enqueue_scripts', array( 'UCF_Page_Assets_Metabox', 'enqueue_assets' ), 99, 1 );
// Add frontend assets
add_action( 'wp_enqueue_scripts', array( 'UCF_Page_Assets_Common', 'enqueue_assets' ), 99, 0 );
// Clear out saved attachment IDs from css/js meta field values when deleted
add_action( 'delete_metadata', array( 'UCF_Page_Assets_Common', 'delete_post_metadata' ) );
// Add media library support for css and js files
add_filter( 'upload_mimes', array( 'UCF_Page_Assets_Common', 'add_custom_mimes' ) );
