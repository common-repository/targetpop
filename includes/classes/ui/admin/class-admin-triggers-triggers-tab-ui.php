<?php
/**
 * TargetPop 'Triggers' Tab Class
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes/UI/Admin
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'TargetPop_Triggers_Tab', false ) ) :
/**
 * TargetPop_Triggers_Tab.
 */
class TargetPop_Triggers_Tab {

    public function __construct() {
    	require_once(TARGETPOP_CLASSES_UI_DISPLAY_DIR.'class-ui-display-template.php');
    	require_once(TARGETPOP_CLASSES_UI_DISPLAY_DIR.'class-create-triggers-form.php');
    	// Instantiate the class
		$this->template = new TargetPop_UI_Display_Template;
		$this->form = new TargetPop_Create_Triggers_Form();
		$this->output_open_display_container();
		$this->output_tab_content();
		$this->output_close_display_container();
		$this->output_display_template_advert();
    }

    private function output_open_display_container(){
        $icon_url = TARGETPOP_ROOT_IMG_ICONS_URL.'switch.svg';
        $title = 'Create Triggers';
    	echo $this->template->output_open_display_container($title, $icon_url).'<div style="display:none;" id="targetpop-special-for-editor"></div>';
    }

    private function output_tab_content(){
    	echo $this->form->initial_output;
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
$am = new TargetPop_Triggers_Tab;