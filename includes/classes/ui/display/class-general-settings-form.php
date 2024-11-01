<?php
/**
 * TargetPop Create Pop-Up Form Class
 *
 * @author   Jake Evans
 * @category Display
 * @package  Includes/Classes/UI/Display
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'TargetPop_Create_General_Settings_Form', false ) ) :
/**
 * TargetPop_Create_General_Settings_Form.
 */
class TargetPop_Create_General_Settings_Form {

	public $purchaseurls;

	public function __construct($form) {

		$this->set_db_stuff();
		$this->output_create_general_settings_form();


	}

	private function set_db_stuff(){
		global $wpdb;
		$settings_table = $wpdb->prefix.'targetpop_general_settings_log';
		$general_settings = $wpdb->get_row("SELECT * FROM $settings_table");

		// Set up purchase URL string
		$this->purchaseurl = explode(',',$general_settings->purchaseurl);

	}


	private function output_create_general_settings_form(){

		$string1 = '<div id="targetpop-create-popup-container">
						<p>Here you can specify everything possible to ensure you\'re enjoying the best <span class="targetpop-color-blue-italic"> TargetPop</span> experience. Simply fill out the parts of the form below that apply to you and your website and click the <span class="targetpop-color-blue-italic"> \'Save Settings\'</span> button - that\' it!</p>
						<div id="targetpop-general-settings-actual-div">
							<div class="targetpop-general-settings-line"></div>

							<div id="targetpop-create-popup-details-div">
							<div class="targetpop-step3-row" id="targetpop-step3-row1">
								<div id="targetpop-general-settings-first-row">
									<img class="targetpop-icon-image-question-create-step-2" src="https://targetpop.io/wp-content/plugins/targetpop/assets/img/icons/question.svg"><label>Purchase Identifers/URLs</label>';
									
								$string2 = '';
								foreach ($this->purchaseurl as $key=>$url) {
									$string2 = $string2.'<input class="targetpop-settings-purchase-entry" id="targetpop-settings-purchase-entry-'.$key.'" value="'.$url.'"></input>';
								}

								$string3 = '';
								if($string2 == ''){
									$string3 = '<div id="targetpop-settings-add-another-purchase"><img id="targetpop-settings-addmore-img" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'.add.svg"/> Add</div>';
								} else {
									$string3 = '<div id="targetpop-settings-add-another-purchase"><img id="targetpop-settings-addmore-img" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'add.svg"/> Add More</div>';
								}



								$string4 = '</div>
								<div>
									<img class="targetpop-icon-image-question-create-step-2" src="https://targetpop.io/wp-content/plugins/targetpop/assets/img/icons/question.svg"><label>Pop-Up Template:</label>
									<select id="targetpop-create-popup-template">
										<option selected="" disabled="">Select a Pop-Up Template...</option>
										<option>Template 1</option>
										<option>Template 3</option>
									</select>
								</div>
							</div>
							<div class="targetpop-step3-row" id="targetpop-step3-row3">
								<div id="targetpop-track-stats-row">
									<img class="targetpop-icon-image-question-create-step-2" src="https://targetpop.io/wp-content/plugins/targetpop/assets/img/icons/question.svg"><label>Pop-Up closes when:</label>
									<select id="targetpop-create-popup-close-trigger">
										<option selected="" disabled="">Select an Animation...</option>
										<option>User clicks outside of Pop-Up</option>
										<option>All of the above</option>
									</select>
								</div>
								<div>
									<img class="targetpop-icon-image-question-create-step-2" src="https://targetpop.io/wp-content/plugins/targetpop/assets/img/icons/question.svg"><label>Set Backdrop Color:</label><div style="display:none;" id="targetpop-backdropcolor-div"></div>
									<input type="text" placeholder="#181818" onchange="update(this.jscolor)" id="targetpop-backdropcolor-input" class="targetpop-colorpicker-class jscolor">
								</div>
							</div>
							<div class="targetpop-step3-row" id="targetpop-step3-row3">
								<div>
									<img class="targetpop-icon-image-question-create-step-2" src="https://targetpop.io/wp-content/plugins/targetpop/assets/img/icons/question.svg"><label>Opening Animation:</label>
									<select id="targetpop-create-popup-open-anim">
										<option selected="" disabled="">Select an Animation...</option>
										<option>Fades in</option>
										<option>Slides in from left</option>
										<option>Slides in from right</option>
									</select>
								</div>
								<div>
									<img class="targetpop-icon-image-question-create-step-2" src="https://targetpop.io/wp-content/plugins/targetpop/assets/img/icons/question.svg"><label>Appearance Delay:</label>
									<input type="text" id="targetpop-create-popup-open-delay" placeholder="0">
								</div>
							</div>
							<div class="targetpop-step3-row" id="targetpop-step3-row4">
								<div>
									<img class="targetpop-icon-image-question-create-step-2" src="https://targetpop.io/wp-content/plugins/targetpop/assets/img/icons/question.svg"><label>Closing Animation:</label>
									<select id="targetpop-create-popup-close-anim">
										<option selected="" disabled="">Select an Animation...</option>
										<option>Fades out</option>
										<option>Slides to the left</option>
										<option>Slides to the right</option>
									</select>
								</div>
								<div>
									<img class="targetpop-icon-image-question-create-step-2" src="https://targetpop.io/wp-content/plugins/targetpop/assets/img/icons/question.svg"><label>Track Statistics?</label>
									<div id="targetpop-create-step3-checkboxes-div">
										<input type="checkbox" id="targetpop-create-popup-trackyes">
										<label>Yes</label>
										<input type="checkbox" id="targetpop-create-popup-trackno">
										<label>No</label>
									</div>
								</div>
							</div>
						</div>


							<div class="targetpop-spinner" id="targetpop-spinner-1"></div>
						</div>
					</div>';


		$this->initial_output = $string1.$string2.$string3.$string4;

	}



  
}

endif;