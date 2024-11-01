<?php
/**
 * TargetPop 'Edit Pop-Ups' Tab Class
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes/UI/Admin
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'TargetPop_Edit_Pop_Ups_Tab', false ) ) :
/**
 * TargetPop_Edit_Pop_Ups_Tab.
 */
class TargetPop_Edit_Pop_Ups_Tab {

    public function __construct() {
    	require_once(TARGETPOP_CLASSES_UI_DISPLAY_DIR.'class-ui-display-template.php');
    	require_once(TARGETPOP_CLASSES_UI_DISPLAY_DIR.'class-edit-pop-up-form.php');
    	// Instantiate the class
		$this->template = new TargetPop_UI_Display_Template;
		$this->form = new TargetPop_Edit_Pop_Up_Form();
		$this->output_open_display_container();
		$this->output_tab_content();
		$this->output_close_display_container();
		$this->output_display_template_advert();
    }

    private function output_open_display_container(){
        $icon_url = TARGETPOP_ROOT_IMG_ICONS_URL.'popup.svg';
        $title = 'Edit & Delete Pop-Ups';
    	echo $this->template->output_open_display_container($title, $icon_url).'<div style="display:none;" id="targetpop-special-for-editor"></div>';
    }

    private function output_tab_content(){
    	echo $this->form->initial_output.$this->form->editor;
    }

    private function output_close_display_container(){
    	echo $this->template->output_close_display_container();
    }

    private function output_display_template_advert(){
    	echo $this->template->output_template_advert();
    }

}

endif;


// Instantiate the class
$am = new TargetPop_Edit_Pop_Ups_Tab;