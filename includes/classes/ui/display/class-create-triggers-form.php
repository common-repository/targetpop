<?php
/**
 * TargetPop TargetPop_Create_Triggers_Form Class
 *
 * @author   Jake Evans
 * @category Display
 * @package  Includes/Classes/UI/Display
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'TargetPop_Create_Triggers_Form', false ) ) :
/**
 * TargetPop_Create_Triggers_Form.
 */
class TargetPop_Create_Triggers_Form {

	public $initial_output;
	public $table;
	public $trigger_results;


	public function __construct() {

		global $wpdb;
		$this->initial_output();
		$this->table = $wpdb->prefix.'targetpop_saved_popups_log';
		$trigger_results = $wpdb->get_results("SELECT * FROM $this->table");

	}

	private function initial_output(){
		$this->initial_output = '<div id="targetpop-triggers-top-div"><p class="targetpop-max-width-p">Here you can create the Triggers that will cause a Pop-Up to appear to your visitors. Simply choose a name for your new Trigger, select an action that the Visitor must perform to trigger a Pop-Up, fill out any additional information required, and click the <span class="targetpop-color-blue-italic">\'Create New Trigger\'</span> button.</p>
				<div id="targetpop-trigger-new-div">
					<div>
						<p class="targetpop-create-popup-step-title">Step <img class="targetpop-icon-steps" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'stepone.svg"><span class="targetpop-create-popup-step-subtitle"> - Name This Trigger</span></p><br/>
						<input id="targetpop-create-trig-name" type="text" placeholder="Name This New Trigger" />
					</div>
					<div id="targetpop-create-triggers-actions-div">
						<p class="targetpop-create-popup-step-title">Step <img class="targetpop-icon-steps" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'steptwo.svg"><span class="targetpop-create-popup-step-subtitle"> - Select An Action</span></p>
						<div>
							<div>
								<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image targetpop-create-trigger-custom-img" data-label="action1" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg"><label>Spends <em>X</em> Seconds on Any Page</label><input class="targetpop-trigger-actions-checkbox targetpop-create-trigger-custom-check" id="targetpop-create-triggers-1" type="checkbox">
							</div>
							<div>
								<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image targetpop-create-trigger-custom-img" data-label="action2" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg"><label>Spends <em>X</em> Seconds on Any Post</label><input class="targetpop-trigger-actions-checkbox targetpop-create-trigger-custom-check" id="targetpop-create-triggers-2" type="checkbox">
							</div>
							<div>
								<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image targetpop-create-trigger-custom-img" data-label="action3" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg"><label>Clicks on an Internal Link</label><input class="targetpop-trigger-actions-checkbox targetpop-create-trigger-custom-check" id="targetpop-create-triggers-3" type="checkbox">
							</div>
						</div>
						<div>
							<div>
								<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image" data-label="action4" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg"><label>Visits a Specific Page</label><input class="targetpop-trigger-actions-checkbox" id="targetpop-create-triggers-4" type="checkbox">
							</div>
							<div>
								<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image targetpop-create-trigger-custom-img" data-label="action5" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg"><label>Views an Embedded Video</label><input class="targetpop-trigger-actions-checkbox targetpop-create-trigger-custom-check" id="targetpop-create-triggers-5" type="checkbox">
							</div>
						</div>
						<div>
							<div>
								<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image targetpop-create-trigger-custom-img" data-label="action7" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg"><label>Scrolls down <em>X%</em> of Page/Post</label><input class="targetpop-trigger-actions-checkbox targetpop-create-trigger-custom-check" id="targetpop-create-triggers-6" type="checkbox">
							</div>
							<div>
								<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image targetpop-create-trigger-custom-img" data-label="action8" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg"><label>Spends <em>X</em> Seconds on Specific Page</label><input class="targetpop-trigger-actions-checkbox targetpop-create-trigger-custom-check" id="targetpop-create-triggers-7" type="checkbox">
							</div>
							<div>
								<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image targetpop-create-trigger-custom-img" data-label="action9" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg"><label>Spends <em>X</em> Seconds on Specific Post</label><input class="targetpop-trigger-actions-checkbox targetpop-create-trigger-custom-check" id="targetpop-create-triggers-8" type="checkbox">
							</div>
						</div>
						<div>
							<div>
								<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image targetpop-create-trigger-custom-img" data-label="action10" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg"><label>Clicks on an External Link</label><input class="targetpop-trigger-actions-checkbox targetpop-create-trigger-custom-check" id="targetpop-create-triggers-9" type="checkbox">
							</div>
							<div>
								<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image" data-label="action11" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg"><label>Visits a Specific Post</label><input class="targetpop-trigger-actions-checkbox" id="targetpop-create-triggers-10" type="checkbox">
							</div>
							<div>
								<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image" data-label="action12" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg"><label>Leaves a Comment</label><input class="targetpop-trigger-actions-checkbox" id="targetpop-create-triggers-11" type="checkbox">
							</div>
						</div>
	                </div>
	                <div class="targetpop-spinner" id="wpbooklist-spinner-1"></div>
	                <div id="targetpop-create-triggers-details-div">
						<p class="targetpop-create-popup-step-title">Step <img class="targetpop-icon-steps" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'stepthree.svg"><span class="targetpop-create-popup-step-subtitle"> - Set Action Specifics</span></p>
						<div id="targetpop-create-triggers-specific-details-div">

						</div>
	                </div>
					<button id="targetpop-create-trigger-button">Create New Trigger</button>
					<div class="targetpop-spinner" id="wpbooklist-spinner-3"></div>
					<div id="targetpop-create-trig-results-div"></div>
				</div>
			</div>';

	}
}

endif;