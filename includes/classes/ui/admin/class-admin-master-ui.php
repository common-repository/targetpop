<?php
/**
 * TargetPop Admin Menu Class
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes/UI/Admin
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'TargetPop_Admin_Master', false ) ) :
/**
 * TargetPop_Admin_Master Class.
 */
class TargetPop_Admin_Master {


    public function __construct() {

    	// Get active plugins to see if any extensions are in play
        $this->active_plugins = (array) get_option('active_plugins', array());
        if (is_multisite()) {
            $this->active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
        }

        // Get current menu/submenu 
        if(!empty($_GET['page'])){
            $this->page = filter_var($_GET['page'], FILTER_SANITIZE_STRING);
        }

        // Get current tab - if no tab, set $this->activetab to default
        if(!empty($_GET['tab'])){
            $this->activetab = filter_var($_GET['tab'], FILTER_SANITIZE_STRING);
        } else {
            $this->activetab = 'default';
        }

        // Controls UI for each Menu/Submenu page
        switch ($this->page) {
            case 'TargetPop-Options-pop-ups':
                $this->setup_default_ui();
                break;

            case 'TargetPop-Options-triggers':
                $this->setup_triggers_ui();
                break;

            case 'TargetPop-Options-extentions':
                $this->setup_extensions_ui();
                break;
            case 'TargetPop-Options-settings':
                $this->setup_settings_ui();
            break;
            default:
                // Controls UI for submenu pages added through extensions
                $this->setup_dynamic_ui();
                break;
        }
   	}

   	// Sets up tabs for the 'Books' page
    private function setup_default_ui() {
        $this->tabs = array(
            'pop'   => __("Create Pop-Ups", 'plugin-textdomain'),
            'editdeletepopups'  => __("Edit & Delete Pop-Ups", 'plugin-textdomain'),
        );

        if(has_filter('targetpop_add_tab_create_pop_ups')) {
            $this->tabs = apply_filters('targetpop_add_tab_create_pop_ups', $this->tabs);
        }

        if($this->activetab == 'default'){
            $this->activetab = null;
        }

        $this->output_tabs_ui();
        $this->output_indiv_tab();
    }

    // Sets up tabs for the 'Books' page
    private function setup_triggers_ui() {
        $this->tabs = array(
            'triggers'   => __("Create Triggers", 'plugin-textdomain'),
            'editdeletetriggers'   => __("Edit & Delete Triggers", 'plugin-textdomain'),
        );

        if(has_filter('targetpop_add_tab_triggers')) {
            $this->tabs = apply_filters('targetpop_add_tab_triggers', $this->tabs);
        }

        if($this->activetab == 'default'){
            $this->activetab = null;
        }

        $this->output_tabs_ui();
        $this->output_indiv_tab();
    }

    // Sets up tabs for the 'Books' page
    private function setup_settings_ui() {
        $this->tabs = array(
            'settings'   => __("General Settings", 'plugin-textdomain'),
        );

        if(has_filter('targetpop_add_tab_triggers')) {
            $this->tabs = apply_filters('targetpop_add_tab_triggers', $this->tabs);
        }

        if($this->activetab == 'default'){
            $this->activetab = null;
        }

        $this->output_tabs_ui();
        $this->output_indiv_tab();
    }

    // Sets up the tabs for a submenu page that has been added by an extension
    private function setup_dynamic_ui() {
        $path = $this->build_extension_path();
        $path = $path.'/includes/classes/ui/admin/';
        $dir_array = scandir($path);
        $page = explode('-',$this->page);
        $tab_array = array();
        $tab_display_array = array();
        $tab_slug_array = array();

        foreach($dir_array as $file){
            if($file == '.' || $file == '..'){
                continue;
            }

            if($file == 'targetpop-'.$page[2].'.php'){
                continue;
            }

            $filestring = explode('-', $file);
            foreach($filestring as $string){
                if($string == 'admin' || $string == 'class' || $string == 'tab' || $string == 'extension' || $string == 'ui.php'){
                    continue;
                } else{
                    array_push($tab_array, $string);
                }
            }

            array_shift($tab_array);
            $final_tab_string = '';
            $final_tab_string_for_display = '';
            foreach($tab_array as $tabpart){
                $final_tab_string_for_display = $final_tab_string_for_display.' '.ucfirst($tabpart);
                $final_tab_string = $final_tab_string.'-'.$tabpart;
            }

            array_push($tab_display_array, ltrim($final_tab_string_for_display, ' '));
            array_push($tab_slug_array, ltrim($final_tab_string, '-'));

            $final_tab_string_for_display = '';
            $final_tab_string = '';
            $tab_array = array();
        }

        $this->tabs = array();
        foreach($tab_slug_array as $key=>$slug){
            $this->tabs[$slug] = __($tab_display_array[$key], 'plugin-textdomain');
        }

        // A filter to add tabs to the submenu page. So the submenu extensions can have their own separate plugins that add tabs to it. The name of this filter will be 'targetpop_add_tab_' plus the one-word unique identifer for this extension, i.e., the word that is displayed in the TargetPop plugin main menu.  
        if(has_filter('targetpop_add_tab_'.$page[2])) {
            $this->tabs = apply_filters('targetpop_add_tab_'.$page[2], $this->tabs);
        }

        //if($this->tabs[0] == ''){
            //array_shift($this->tabs);
        //}

        if($this->activetab == 'default'){
            $this->activetab = null;
        }

        $this->output_tabs_ui();
        $this->output_indiv_tab();
    }

    // The function that actually generates the tabs on a page
    private function output_tabs_ui() {
        $current = '';
        if(!empty($_GET['tab'])){
            $this->activetab = filter_var($_GET['tab'], FILTER_SANITIZE_STRING);
        } else {
            reset($this->tabs);
            $this->activetab = strtolower(key($this->tabs));
        }

        $html =  '<h2 class="nav-tab-wrapper">';
        foreach( $this->tabs as $tab => $name ){
            $class = ($tab == $current) ? 'nav-tab-active' : '';
            $html .=  '<a class="nav-tab ' . $class . '" href="?page='.$this->page.'&tab=' . $tab . '">' . $name . '</a>';
        }
        $html .= '</h2>';
        echo $html;
    }

    // The function that controls the output for each individual tab
    private function output_indiv_tab() {
        $this->activetab;
        $this->page;
        $page = explode('-', $this->page);

        $filename = 'class-admin-'.$page[2].'-'.$this->activetab.'-tab-ui.php';
        // Support for Extensions
        if(!file_exists(TARGETPOP_CLASSES_UI_ADMIN_DIR.$filename)){
            $path = $this->build_extension_path();
            if(is_dir($path)){
                $path1 = $path.'/includes/ui/class-admin-'.$page[2].'-'.$this->activetab.'-tab-extension-ui.php';
                 if(is_dir($path1)){
                    require_once($path1);
                } else {
                    $path2 = $path.'/includes/classes/ui/admin/class-admin-'.$page[2].'-'.$this->activetab.'-tab-extension-ui.php';
                    require_once($path2);
                }
            } else {
                require_once($path);
            }
        } else {
            // Look for file in core plugin
           require_once(TARGETPOP_CLASSES_UI_ADMIN_DIR.$filename);
        }
    }

    // The function that builds paths for extensions, both for creating a new submenu page, and tabs that have been added via extensions.
    private function build_extension_path() {
        $page = explode('-', $this->page);
        foreach($this->active_plugins as $plugin){
            if(strpos($plugin, 'targetpop-') !== false){
                if(strpos($plugin, $this->activetab) !== false){
                    $temp = explode('-', $plugin);
                    if($temp[2] === $this->activetab.'.php'){
                        $filename = 'class-admin-'.$page[2].'-'.$this->activetab.'-tab-extension-ui.php';
                        $path = TARGETPOP_ROOT_WP_PLUGINS_DIR.$temp[0].'-'.$this->activetab.'/'.$filename;
                    } else {
                        echo 'something wrong';
                    }
                }
                
                if(!isset($path)){
                    $path = null;
                }

                if(file_exists($path) && !is_dir($path)){
                    return $path;
                } else {
                    $page = explode('-', $this->page);
                    if(strpos($plugin, $page[2]) !== false){
                        $path = TARGETPOP_ROOT_WP_PLUGINS_DIR.'targetpop-'.$page[2];
                        if(file_exists($path)){
                            return $path;
                        }
                    }
                }
            }
        }
    }

}
endif;


// Instantiate the class
$am = new TargetPop_Admin_Master;