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

/**
 * INCLUDES
 **/
include_once 'includes/page-assets-config.php';

// Initiate the Plugin Settings
add_action( 'admin_init', array( 'UCF_Page_Assets_Config', 'settings_init' ) );
// Add the options page.
add_action( 'admin_menu', array( 'UCF_Page_Assets_Config', 'add_options_page' ) );
