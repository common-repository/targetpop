<?php
/**
 * WPBookList Create Pop-Up Form Class
 *
 * @author   Jake Evans
 * @category Display
 * @package  Includes/Classes/UI/Display
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'TargetPop_Edit_Pop_Up_Form', false ) ) :
/**
 * TargetPop_Create_Pop_Up_Form.
 */
class TargetPop_Edit_Pop_Up_Form {

	public $popup_results;

	public function __construct() {

		global $wpdb;
		$this->table = $wpdb->prefix.'targetpop_saved_popups_log';
		$this->popup_results = $wpdb->get_results("SELECT * FROM $this->table");
		echo $this->output_editor();
		$this->initial_output();
	}

	private function initial_output(){

		// If no Pop-Ups yet...
		if(sizeof($this->popup_results) == 0){
			$string1 = '<div id="targetpop-triggers-top-div"><p class="targetpop-max-width-p">Here you can edit and delete your existing Pop-Ups. Simply click on a Pop-Up below, edit the details that emerge, and click the <span class="targetpop-color-blue-italic">\'Edit Pop-Up\'</span> button.</p>
				<div id="targetpop-popup-no-popups-div">Uh-oh! Looks like you haven\'t created any Pop-Ups yet! <a href="'.menu_page_url( 'TargetPop-Options-pop-ups', false ).'&tab=pop">Click Here to Create Pop-Ups</a> <br><img class="targetpop-frown-icon" src="https://wpbooklist.com/wp-content/plugins/targetpop/assets/img/icons/smile.svg"></div></div>';
			$this->initial_output = $string1;
			return;
		}
		
		$string1 = '<div id="targetpop-popup-preview-div" >
							<div>
								<span>Preview This<br/>Pop-Up</span>
								<img id="targetpop-preview-popup-icon" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'popup-white.svg" />
							</div>
						</div><div id="targetpop-triggers-top-div"><p class="targetpop-max-width-p">Here you can edit and delete your existing Pop-Ups. Simply click on a Pop-Up below, edit the details that emerge, and click the <span class="targetpop-color-blue-italic">\'Edit Pop-Up\'</span> button.</p>
				<div id="targetpop-trigger-edit-delete-div">';

				$string2 = '';
				foreach ($this->popup_results as $key => $popup) {

					if($popup->popuptriggered == null){
						$popup->popuptriggered = 0;
					}

					$stringrow1 = '<div data-popuptemplate="'.$popup->popuptemplate.'" data-popuptype="'.$popup->popuptype.'" data-popuptemplate="'.$popup->popuptemplate.'" data-popupactive="'.$popup->popupactive.'" data-popupuid="'.$popup->popupuid.'" class="targetpop-editpopupus-popup-row" id="targetpop-editpopupus-popup-row-id-'.$key.'" data-num="'.intval($key+1).'">
						<div class="targetpop-edittrig-num-div">
							<img class="targetpop-edit-delete-trigs-num-img" src="'.TARGETPOP_ROOT_IMG_URL.'hashwhite.svg"/>
							<span class="targetpop-edittrig-num-span">'.intval($key+1).'&nbsp;-</span>
						</div>
						<div class="targetpop-edittrig-name-div">
							<span class="targetpop-edittrig-name-span">'.ucfirst($popup->popupname).'</span>
						</div>
						<div class="targetpop-edittrig-arrow-div">
							<img class="targetpop-edit-delete-trigs-arrow-img" src="'.TARGETPOP_ROOT_IMG_URL.'chevron-arrow-down.svg"/>
						</div>
					</div>
					<div class="targetpop-edittrig-details-div">
						<div class="targetpop-edittrig-details-inner-container" id="targetpop-edittrig-details-inner-container-'.intval($key+1).'">
							<div class="targetpop-edittrig-statement-div">
								<span class="targetpop-edittrig-statement-text"><img class="targetpop-icon-image-question-editpopup targetpop-icon-image" data-label="'.$this->tooltip_data_label($popup->popuptype).'" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg">'.$this->popup_type($popup->popuptype).'</span><br/><span class="targetpop-edittrig-template-text">'.$this->popup_template($popup->popuptemplate).'</span>
							</div>';





							$stringrow2 = '';
							if($popup->popupactive == 'active'){
								$stringrow2 = '<div class="targetpop-edittrig-stats-row">
									<div data-popupactive="true" data-popupuid="'.$popup->popupuid.'" class="targetpop-edittrig-activate-popup">
										<label>Deactivate Pop-Up</label>
										<img style="margin-right:72px; top: 23px;" class="targetpop-edit-popup-active-toggle-img" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'switch.png"/>
										<div class="targetpop-edit-popup-active-switch">
											<span class="targetpop-edit-popup-active-switch-green"></span>
											<span class="targetpop-edit-popup-active-switch-red"></span>
										</div>
									</div>
								</div>';
							} else {
								$stringrow2 = '<div class="targetpop-edittrig-stats-row">
									<div data-popupactive="false" data-popupuid="'.$popup->popupuid.'" class="targetpop-edittrig-activate-popup">
										<label>Activate Pop-Up</label><br/>
										<img style="margin-right:54px; top: 36px;" class="targetpop-edit-popup-active-toggle-img" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'switch.png"/>
										<div class="targetpop-edit-popup-active-switch">
											<span class="targetpop-edit-popup-active-switch-green"></span>
											<span class="targetpop-edit-popup-active-switch-red"></span>
										</div>
									</div>
								</div>';
							}
							
							$stringrow3 = '<div class="targetpop-edittrig-stats-row">
								<div class="targetpop-edittrig-created">
									<img class="targetpop-edit-delete-stats-img" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'calendar.svg"/>
									<label>Created on '.gmdate("m-d-Y", $popup->popupcreated).'</label>
								</div>
								<div class="targetpop-edittrig-triggered">
									<img class="targetpop-edit-delete-stats-img" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'verify-sign.svg"/>
									<label>Triggered '.$popup->popuptriggered.' times</label>
								</div>
							</div>
							<div class="targetpop-specific-fields-trigedit-div">
								<div class="targetpop-edittrig-edit-name-div">
									<span class="targetpop-specific-fields-trigedit-span">
										Name of Pop-Up:
									</span>
									<input class="targetpop-trig-name-trigedit-text-input" type="text"  value="'.$popup->popupname.'"/>
								</div>';

							$stringrow4 = $this->edit_specific_fields(intval($key));
							$string5 = $this->output_step2_styling(intval($key));
							$string6 = $this->output_step_3(intval($key));

							$stringrow7 = '<div class="targetpop-edittrig-edit-delete-div">
								<div class="targetpop-spinner-white" id="targetpop-spinner-'.$popup->ID.'"></div>
								<div class="targetpop-edit-trig-success-div"></div>
								<div class="targetpop-edittrig-countdown-results-div" id="targetpop-results-div-countdown-'.$popup->ID.'">Reloading in 7...</div>
								<div class="targetpop-edittrig-delete-results-div" id="targetpop-results-div-'.$popup->ID.'"></div>
								<div class="targetpop-results-div" id="targetpop-edit-popup-results-id"></div>
								<div class="targetpop-editpopup-edit-button" id="targetpop-editbutton-id-'.$popup->ID.'" data-popupuid="'.$popup->popupuid.'" data-popuptemplate="'.$popup->popuptemplate.'" data-popuptype="'.$popup->popuptype.'">
									<img class="targetpop-edit-delete-buttons-edit-img" src="'.TARGETPOP_ROOT_IMG_URL.'pencil.svg"/>
									<span class="targetpop-edittrig-edit-text">Edit Pop-Up</span>
								</div>
								<div class="targetpop-editpopup-delete-button" id="targetpop-deletebutton-id-'.$popup->ID.'" data-uniqueid="'.$popup->ID.'">
									<img class="targetpop-edit-delete-buttons-delete-img" src="'.TARGETPOP_ROOT_IMG_URL.'garbage-bin.svg"/>
									<span class="targetpop-edittrig-delete-text">Delete Pop-Up</span>
								</div>
							</div>
						</div>
					</div>';

					$string2 = $string2.$stringrow1.$stringrow2.$stringrow3.$stringrow4.$string5.$string6.$stringrow7;
				}

					
		$string3 =	'</div>
			</div>';


		$this->initial_output = $string1.$string2.$string3;

	}

	private function output_editor(){
		$this->editor = '<div id="targetpop-editor-output">'.wp_editor( 'Enter your plain text and/ or HTML here.', "targetpopeditor", array('textarea_rows' => 2, 'textarea_name'=>"content_ajax",'quicktags' => array('buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,close'))).'</div><div id="targetpop-editor-output2"></div>';
	}

	private function edit_specific_fields($val){

		$statement = '<div class="targetpop-spinner-white targetpop-spinner-forpop-edit" id="targetpop-spinner-'.$val.'"></div><div class="targetpop-editpopupus-popup-row-id-populate" id="targetpop-editpopupus-popup-row-id-'.$val.'-populate" class="targetpop-edit-popup-template-container targetpop-edit-popup-preview-class"></div></div>';

		return $statement;
	}

	private function popup_type($type){
		switch ($type){
			case 'targetpop-create-type-plain-html':
				$type = 'Plain Text/HTML';
				break;
			default:
				break;
		}

		return $type;
	}

	private function popup_template($template){
		switch ($template){
			case 'default-text-1.html':
				$template = 'Default Template 1';
				break;
			default:
				break;
		}

		return $template;
	}

	private function tooltip_data_label($type){
		switch ($type){
			case 'targetpop-create-type-plain-html':
				$label = 'plaintexthtml';
				break;
			default:
				$label = '';
				break;
		}

		return $label;
	}

	private function output_step2_styling($val){
		$string = '<div class="targetpop-editpopupus-popup-row-id-step2-styling" id="targetpop-editpopupus-popup-row-id-'.$val.'-step2-styling"></div>';

		return $string;
	}

	private function output_step_3($val){

		$string3 = '<div class="targetpop-editpopupus-popup-row-id-step3-details" id="targetpop-editpopupus-popup-row-id-'.$val.'-step3-details"></div>';

		return $string3;
	}


}

endif;