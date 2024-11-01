<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Plugin Name: TargetPop
Description: Finally -- a flexible, easy-to-use Pop-Up Maker! 
Version: 1.0.0
Author: Jake Evans
Author URI: https://www.jakerevans.com
License: GPL2
*/ 

global $wpdb;
require_once('includes/targetpop-functions.php');
require_once('includes/targetpop-ajaxfunctions.php');

// Parse the targetpopconfig file
$config_array = parse_ini_file("targetpopconfig.ini");

// Get the default admin message for inclusion into database 
define('TARGETPOP_ADMIN_MESSAGE', $config_array['initial_admin_message']);

// Root plugin folder URL of this plugin
define('TARGETPOP_ROOT_URL', plugin_dir_url( __FILE__ ));

// Grabbing dasubmenuase prefix
define('TARGETPOP_PREFIX', $wpdb->prefix);

// Root plugin folder directory for this plugin
define('TARGETPOP_ROOT_DIR', plugin_dir_path( __FILE__ ));

// Root Classes Directory for this plugin
define('TARGETPOP_CLASS_DIR', TARGETPOP_ROOT_DIR.'includes/classes/');

// Root Classes Directory for this plugin
define('TARGETPOP_INCLUDES_DIR', TARGETPOP_ROOT_DIR.'includes/');

// Root Template Directory for this plugin
define('TARGETPOP_TEMPLATES_DIR', TARGETPOP_ROOT_DIR.'includes/templates/');

// Root UI Admin directory
define('TARGETPOP_CLASSES_UI_ADMIN_DIR', TARGETPOP_CLASS_DIR.'ui/admin/');

// Root UI Display directory
define('TARGETPOP_CLASSES_UI_DISPLAY_DIR', TARGETPOP_CLASS_DIR.'ui/display/');

// Root Image Icons URL of this plugin
define('TARGETPOP_ROOT_IMG_URL', TARGETPOP_ROOT_URL.'assets/img/');

// Root Image Icons URL of this plugin
define('TARGETPOP_ROOT_IMG_ICONS_URL', TARGETPOP_ROOT_URL.'assets/img/icons/');

// Root CSS URL for this plugin
define('TARGETPOP_ROOT_CSS_URL', TARGETPOP_ROOT_URL.'assets/css/');

// Root JS URL for this plugin
define('TARGETPOP_ROOT_JS_URL', TARGETPOP_ROOT_URL.'assets/js/');

// Define the Uploads base directory
$uploads = wp_upload_dir();
$upload_path = $uploads['basedir'];
define('TARGETPOP_UPLOADS_BASE_DIR', $upload_path.'/');

$upload_url = $uploads['baseurl'];
define('TARGETPOP_UPLOADS_BASE_URL', $upload_url.'/');

// Root WordPress Plugin Directory
define('TARGETPOP_ROOT_WP_PLUGINS_DIR', WP_PLUGIN_DIR.'/');

// Adding the front-end ui css file for this plugin
add_action('wp_enqueue_scripts', 'targetpop_frontend_ui_style');

// Adding the admin css file for this plugin
add_action('admin_enqueue_scripts', 'targetpop_admin_style' );

// Adding Ajax library
add_action( 'wp_head', 'targetpop_add_ajax_library' );

// Adding admin page
add_action( 'admin_menu', 'targetpop_admin_menu' );

// Registers table names
add_action( 'init', 'targetpop_register_table_name', 1 );

// Creates tables upon activation
register_activation_hook( __FILE__, 'targetpop_create_tables' );

// Adding the jscolor script
add_action('admin_enqueue_scripts', 'targetpop_colorpicker_script' );

// For instructional admin pointers
add_action( 'admin_footer', 'targetpop_jre_admin_pointers_javascript' ); // Write our JS below here

// function to changes styling of pop-up preview at the bottom of step 2 below the text editors
add_action( 'admin_footer', 'targetpop_step2_style_changes_javascript' );

// For updating the pop-up data on the preview div for use in targetbox
add_action( 'admin_footer', 'targetpop_open_popup_preview_update_data' );

// The function that adds font names to the tinyMCE drop-down
add_filter( 'tiny_mce_before_init', 'targetpop_custom_mce_fonts' );

// Function that actually loads Custom/Google Fonts. 
add_action( 'init', 'targetpop_custom_mce_fonts_actual' );

// Adds the font drop-down and sizes to tinymce
add_filter('mce_buttons', 'targetpop_add_fonts_size_dropdown');

// Adding targetbox css file
add_action('wp_enqueue_scripts', 'targetpop_jre_plugin_targetbox_style' );
add_action('admin_enqueue_scripts', 'targetpop_jre_plugin_targetbox_style' );

// Adding targetbox JS file on both front-end and dashboard
add_action('admin_enqueue_scripts', 'targetpop_jre_plugin_targetbox_script' );
add_action('wp_enqueue_scripts', 'targetpop_jre_plugin_targetbox_script' );

// Adding script that will take care of displaying a saved pop-up
add_action('wp_enqueue_scripts', 'targetpop_jre_plugin_displaypopup_script' );
add_action('admin_enqueue_scripts', 'targetpop_jre_plugin_displaypopup_script' );

add_action('wp_enqueue_scripts', 'targetpop_jre_plugin_test' );

// For opening the media library on the Pop-Up creation page
add_action( 'admin_footer', 'targetpop_add_media_image_action_javascript' );

// For removing one of the Media Library 'Image Gallery' additions
add_action( 'admin_footer', 'targetpop_remove_media_image_action_javascript' );

// For populating the External Website preview area on the 'Create Pop-ups' page
add_action( 'admin_footer', 'targetpop_external_website_populate_action_javascript' );

// For adding the image link to the preview pop-up area
add_action( 'admin_footer', 'targetpop_image_link_type_action_javascript' );

// For resetting some of the inner html of the popup editing rows - works in conjunction with the 'targetpop_editpopups_populate_action_javascript' AJAX function in targetpop-ajaxfunctions.php
add_action( 'admin_footer', 'targetpop_editpopups_expand_cont_javascript' );

// For expanding and contracting the 'Edit Trigger' rows
add_action( 'admin_footer', 'targetpop_expand_cont_trigger_edit_rows_javascript' );


// For admin messages
//add_action( 'admin_notices', 'targetpop_admin_notice_success' );

// For the REST API update for dashboard messages 
add_action( 'rest_api_init', function () {
  register_rest_route( 'targetpop/v1', '/notice/(?P<notice>[a-z0-9\-]+)', array(
    'methods' => 'GET',
    'callback' => 'targetpop_rest_api_notice',
  ) );
} );

// For dismissing notice
add_action( 'admin_footer', 'targetpop_dismiss_notice_forever_action_javascript' ); // Write our JS below here
add_action( 'wp_ajax_targetpop_dismiss_notice_forever_action', 'targetpop_dismiss_notice_forever_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_dismiss_notice_forever_action', 'targetpop_dismiss_notice_forever_action_callback' );

// For populating the Template drop-down on step one of Pop-Up creation
add_action( 'admin_footer', 'targetpop_stepone_template_action_javascript' );
add_action( 'wp_ajax_targetpop_stepone_template_action', 'targetpop_stepone_template_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_stepone_template_action', 'targetpop_stepone_template_action_callback' );

// For creating a new Pop-Up
add_action( 'admin_footer', 'targetpop_create_popup_action_javascript' );
add_action( 'wp_ajax_targetpop_create_popup_action', 'targetpop_create_popup_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_create_popup_action', 'targetpop_create_popup_action_callback' );

// For populating Step 2 of the Pop-Up Creation process
add_action( 'admin_footer', 'targetpop_popup_steptwo_action_javascript' );
add_action( 'wp_ajax_targetpop_popup_steptwo_action', 'targetpop_popup_steptwo_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_popup_steptwo_action', 'targetpop_popup_steptwo_action_callback' );

// For opening and previewing a Pop-Up during creation
add_action( 'admin_footer', 'targetpop_open_popup_preview_action_javascript' );
add_action( 'wp_ajax_targetpop_open_popup_preview_action', 'targetpop_open_popup_preview_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_open_popup_preview_action', 'targetpop_open_popup_preview_action_callback' );

// For populating Step 3 of the new trigger creation process
add_action( 'admin_footer', 'targetpop_create_trig_step3_action_javascript' );
add_action( 'wp_ajax_targetpop_create_trig_step3_action', 'targetpop_create_trig_step3_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_create_trig_step3_action', 'targetpop_create_trig_step3_action_callback' );

// For creating a trigger
add_action( 'admin_footer', 'targetpop_create_trigger_action_javascript' );
add_action( 'wp_ajax_targetpop_create_trigger_action', 'targetpop_create_trigger_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_create_trigger_action', 'targetpop_create_trigger_action_callback' );

// For deleting an existing trigger
add_action( 'admin_footer', 'targetpop_delete_trigger_action_javascript' );
add_action( 'wp_ajax_targetpop_delete_trigger_action', 'targetpop_delete_trigger_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_delete_trigger_action', 'targetpop_delete_trigger_action_callback' );

// For deleting an existing popup
add_action( 'admin_footer', 'targetpop_delete_popup_action_javascript' );
add_action( 'wp_ajax_targetpop_delete_popup_action', 'targetpop_delete_popup_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_delete_popup_action', 'targetpop_delete_popup_action_callback' );

// For editing a triggers
add_action( 'admin_footer', 'targetpop_edit_trig_action_javascript' );
add_action( 'wp_ajax_targetpop_edit_trig_action', 'targetpop_edit_trig_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_edit_trig_action', 'targetpop_edit_trig_action_callback' );

// For enabling/disabling a Pop-Up
add_action( 'admin_footer', 'targetpop_active_toggle_action_javascript' );
add_action( 'wp_ajax_targetpop_active_toggle_action', 'targetpop_active_toggle_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_active_toggle_action', 'targetpop_active_toggle_action_callback' );

// For populating the Pop-Up editor fields
add_action( 'admin_footer', 'targetpop_editpopups_populate_action_javascript' );
add_action( 'wp_ajax_targetpop_editpopups_populate_action', 'targetpop_editpopups_populate_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_editpopups_populate_action', 'targetpop_editpopups_populate_action_callback' );

// For displaying a saved Pop-Up to the visitor
add_action( 'wp_footer', 'targetpop_display_popup_action_javascript' );
add_action( 'wp_ajax_targetpop_display_popup_action', 'targetpop_display_popup_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_display_popup_action', 'targetpop_display_popup_action_callback' );

// For activaing/deactivating a pop-up
add_action( 'admin_footer', 'targetpop_toggle_popup_action_javascript' );
add_action( 'wp_ajax_targetpop_toggle_popup_action', 'targetpop_toggle_popup_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_toggle_popup_action', 'targetpop_toggle_popup_action_callback' );

// For listening for a TargetBox open/closing and recording data
add_action( 'wp_footer', 'targetpop_targetbox_listen_action_javascript' );
add_action( 'wp_ajax_targetpop_targetbox_listen_action', 'targetpop_targetbox_listen_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_targetbox_listen_action', 'targetpop_targetbox_listen_action_callback' );

// For handling the tracking of video events, modification of embedded youtube videos, etc.
add_action( 'wp_footer', 'targetpop_video_tracking_action_javascript' );
add_action( 'wp_ajax_targetpop_video_tracking_action', 'targetpop_video_tracking_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_video_tracking_action', 'targetpop_video_tracking_action_callback' );

// For activating a newly-created popup fro the activation link
add_action( 'admin_footer', 'targetpop_activate_link_action_javascript' );
add_action( 'wp_ajax_targetpop_activate_link_action', 'targetpop_activate_link_action_callback' );
add_action( 'wp_ajax_nopriv_targetpop_activate_link_action', 'targetpop_activate_link_action_callback' );

// Filter that forces tinyMCE 'Text' tab to be the default //TO-DO need to figure out how to apply only to TARGETPOP'S editors
add_filter( 'wp_default_editor', create_function('', 'return "html";') );



?>