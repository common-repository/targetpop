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

if ( ! class_exists( 'TargetPop_Create_Pop_Up_Form', false ) ) :
/**
 * TargetPop_Create_Pop_Up_Form.
 */
class TargetPop_Create_Pop_Up_Form {

	public $template;
	public $form;

	public function __construct($form = null, $template = null) {

		$this->template = $template;
		$this->form = $form;

		if($form == 'initial'){
			$this->output_create_popup_form_step_one();
			$this->output_editor();
		}

		if($form == 'E-Mail/Subscriptions'){

			$this->output_step2_header();

			switch ($this->template) {
				case 'default-email-1.html':
					$this->output_default_template();
					$this->output_step2_close();
					$this->output_step2_styling();
					$this->output_step_3();
					break;
				case 'default-email-2.html':
					$this->output_default_template();
					$this->output_step2_close();
					$this->output_step2_styling();
					$this->output_step_3();
					break;
				default:
					# code...
					break;
			}
		}

		if($form == 'Plain Text/HTML'){

			$this->output_step2_header();

			switch ($this->template) {
				case 'default-text-1.html':
					$this->output_default_template();
					$this->output_step2_close();
					$this->output_step2_styling();
					$this->output_step_3();
					break;
				case 'default-text-2.html':
					$this->output_default_template();
					$this->output_step2_close();
					$this->output_step2_styling();
					$this->output_step_3();
					break;
				
				default:
					# code...
					break;
			}
		}

		if($form == 'Recent Posts'){
			$this->output_step2_header();

			switch ($this->template) {
				case 'default-post-1.html':
					$this->output_default_template();
					$this->output_step2_close();
					$this->output_step2_styling();
					$this->output_step_3();
					break;
				default:
					# code...
					break;
			}
		}

		if($form == 'Image Gallery'){
			$this->output_step2_header();

			switch ($this->template) {
				case 'default-gallery-1.html':
					$this->output_default_template();
					$this->output_step2_close();
					$this->output_image_gallery_specials();
					$this->output_step2_styling();
					$this->output_step_3();
					break;
				default:
					# code...
					break;
			}
		}

		if($form == 'External Website'){
			$this->output_step2_header();

			switch ($this->template) {
				case 'default-external-1.html':
					$this->output_default_template();
					$this->output_step2_close();
					$this->output_external_website_specials();
					$this->output_step2_styling();
					$this->output_step_3();
					break;
				default:
					# code...
					break;
			}
		}

		if($form == 'Internal URL'){
			$this->output_step2_header();

			switch ($this->template) {
				case 'default-internal-1.html':
					$this->output_default_template();
					$this->output_step2_close();
					$this->output_internal_website_specials();
					$this->output_step2_styling();
					$this->output_step_3();
					break;
				default:
					# code...
					break;
			}
		}

		if($form == 'Single Image w/ Link'){
			$this->output_step2_header();

			switch ($this->template) {
				case 'default-imagelink-1.html':
					$this->output_default_template();
					$this->output_step2_close();
					$this->output_image_link_specials();
					$this->output_step2_styling();
					$this->output_step_3();
					break;
				default:
					# code...
					break;
			}
		}

		if($form == 'Video'){
			$this->output_step2_header();

			switch ($this->template) {
				case 'default-video-1.html':
					$this->output_default_template();
					$this->output_step2_close();
					$this->output_video_specials();
					$this->output_step2_styling();
					$this->output_step_3();
					break;
				default:
					# code...
					break;
			}
		}

		if($form == 'Embedded Page'){
			$this->output_default_template();
		}



		if($form == 'Single Image'){
			$this->output_default_template();
		}

		if($form == 'Image with Link'){
			$this->output_default_template();
		}

		if($form == 'Multiple Images'){
			$this->output_default_template();
		}

		if($form == 'E-Mail Capture'){
			$this->output_default_template();
		}

		//$this->output_step_3();


	}

	private function output_step2_header(){
		echo '<div id="targetpop-create-popup-step2-div" style="opacity:0;">
						<p class="targetpop-create-popup-step-title">Step <img class="targetpop-icon-steps" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'steptwo.svg" /><span class="targetpop-create-popup-step-subtitle"> - Create Pop-Up Contents & Styling</span></p>
						<div class="targetpop-create-step-line"></div>
						<!--
						<div id="targetpop-create-popup-plain-text-container">
						<p>Enter your Plain text and/or HTML in the text editor below</p>
						</div>
						-->
						<div id="targetpop-step2-template-bones-div">';
	}

	private function output_default_template(){
		require_once(TARGETPOP_TEMPLATES_DIR.$this->template);
	}

	private function output_external_website_specials(){

		echo '<div id="targetpop-step2-ext-web-container">
				<div>
				<label>Input the URL of the External Website Below:</label><br/>
				<input id="targetpop-iframe-website-url" type="text" placeholder="https://www.example.com"/>
				<button id="targetpop-step2-ext-web-button-external">Test URL</button>
				<div id="targetpop-step2-ext-web-iframe-message">Note: If the website does not appear in the preview area above, there\'s either something wrong with the address you provided, or the website doesn\'t allow itself to be used this way - if that\'s the case, you\'ll have to choose a different website. Also, if your site is secure (see an "https" in your address bar?), then the only external websites you can display are other secure websites.</div>
				</div>
				<div class="targetpop-spinner" id="wpbooklist-spinner-external"></div>
				<div id="targetpop-step2-ext-web-message"></div>
		</div>';
	}

	private function output_internal_website_specials(){

		echo '<div id="targetpop-step2-ext-web-container">
				<div>
				<label>Input the URL of the Internal Website Below:</label><br/>
				<input id="targetpop-iframe-website-url" type="text" placeholder="https://www.example.com"/>
				<button id="targetpop-step2-ext-web-button-internal">Test URL</button>
				<div class="targetpop-spinner" id="wpbooklist-spinner-external"></div>
				<div id="targetpop-step2-ext-web-message"></div>
			</div>
		</div>';
	}

	private function output_image_link_specials(){

		echo '<div id="targetpop-step2-img-gal-container">
				<div id="targetpop-add-img-div-1" class="targetpop-add-img-div" data-imgnum="1">
					<button class="targetpop-add-img-button" data-imgnum="1">Add an Image...</button>
					<input class="targetpop-add-img-input" id="targetpop-add-img-input-1" type="text" />
				</div>
				<div class="targetpop-image-link-opts-row">
					<label>Image Width:</label><input id="targetpop-img-type-width" type="number" placeholder="50" /><label>%</label>
				</div>
				<div class="targetpop-image-link-opts-row" id="targetpop-image-link-opts-row">
					<label>Transparent Body Background:</label><input id="targetpop-transparent-body-img-type" type="checkbox" />
				</div>
				<div class="targetpop-image-link-opts-row" id="targetpop-image-link-opts-row">
					<label>Transparent Header Background:</label><input id="targetpop-transparent-header-img-type" type="checkbox" />
				</div>
				<div>
					<label id="targetpop-add-img-input-2">Input the Link URL:</label><input placeholder="https://www.example.com" id="targetpop-image-link-link" type="text" />
				</div>
		</div>';
	}

	private function output_image_gallery_specials(){

		echo '<div id="targetpop-step2-img-gal-container">
				<div id="targetpop-add-img-div-1" class="targetpop-add-img-div" data-imgnum="1">
					<button class="targetpop-add-img-button" data-imgnum="1">Add an Image...</button>
					<input class="targetpop-add-img-input" id="targetpop-add-img-input-1" type="text" />
					<img class="targetpop-remove-add-img-x" id="targetpop-remove-add-img-x-1" data-removeimgnum="1" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'round-delete-button.svg"/>
				</div>
				<div id="targetpop-add-additional-img-gal">
					<div data-addoredit="add" id="targetpop-add-more-imgs-blue"><img id="targetpop-settings-addmore-img" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'add.svg">Add More Images</div>
				</div>
		</div>';
	}

	private function output_video_specials(){

		echo '<div id="targetpop-step2-img-gal-container">
				<div id="targetpop-add-img-div-1" class="targetpop-add-img-div" data-imgnum="1">
					<button class="targetpop-add-img-button" data-imgnum="1">Add a Video...</button>
					<input class="targetpop-add-img-input" id="targetpop-add-img-input-1" type="text" />
				</div>
		</div>';
	}

	private function output_step2_close(){
		echo '</div></div>';
	}

	private function output_step2_styling(){
		$string = '<div id="targetpop-step2-styling-div" style="opacity:0;">
					<div class="targetpop-step2-column-div">
						<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image" data-label="border" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Border</label>
						<div>
							<select id="targetpop-step2-styling-border">
								<option>Solid</option>
								<option>Dotted</option>
								<option>Dashed</option>
								<option>Double</option>
								<option>Groove</option>
								<option>Ridge</option>
								<option>Outset</option>
								<option>Inset</option>
								<option>No Border</option>
							</select>
							<input id="targetpop-step2-styling-border-px" placeholder="5"   type="number" />
							<div id="targetpop-row-for-colorpicker6-step2">
							</div>
						</div>
					</div>
					<div class="targetpop-step2-column-div">
						<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image" data-label="borderradius" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Border-Radius</label>
						<div>
							<input id="targetpop-step2-styling-border-radius-px" placeholder="5px"   type="number" />
						</div>
					</div>
					<div id="targetpop-step2-color-2-total-row" class="targetpop-step2-column-div">
						<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image" data-label="color2" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Background Color</label>
						<div id="targetpop-row-for-colorpicker2-step2">
						</div>
					</div>
					<div id="targetpop-step2-box-shadow-total-row" class="targetpop-step2-column-div targetpop-step2-style-block">
						<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image" data-label="boxshadow" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Box-Shadow</label>
						<div id="targetpop-row-for-colorpicker3-step2">
							<select id="targetpop-step2-styling-box-shadow-type">
								<option selected default>Inset</option>
								<option>Outset</option>
							</select>
							<input id="targetpop-step2-styling-box-shadow-x" placeholder="5"  type="number" />
							<input id="targetpop-step2-styling-box-shadow-y" placeholder="5"  type="number" />
							<input id="targetpop-step2-styling-box-shadow-blur" placeholder="5"  type="number" />
							<input id="targetpop-step2-styling-box-shadow-spread" placeholder="5"  type="number" />
						</div>
					</div>
					<div id="targetpop-step2-body-text-shadow-total-row" class="targetpop-step2-column-div targetpop-step2-style-block">
						<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image" data-label="bodytextshadow" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Text-Shadow</label>
						<div id="targetpop-row-for-colorpicker5-step2">
							<input id="targetpop-step2-styling-text-shadow-body-x"  placeholder="5"   type="number" />
							<input id="targetpop-step2-styling-text-shadow-body-y"  placeholder="5"   type="number" />
							<input id="targetpop-step2-styling-text-shadow-body-blur"  placeholder="5"   type="number" />
						</div>
					</div>
					<div id="targetpop-step2-body-padding-total-row" class="targetpop-step2-column-div targetpop-step2-style-block">
						<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image" data-label="bodypadding" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Padding</label>
						<div id="targetpop-row-for-colorpicker44-step2">
							<input id="targetpop-step2-styling-padding-body-top" placeholder="5"   type="number" />
							<input id="targetpop-step2-styling-padding-body-bottom" placeholder="5"   type="number" />
							<input id="targetpop-step2-styling-padding-body-left" placeholder="5"   type="number" />
							<input id="targetpop-step2-styling-padding-body-right" placeholder="5"   type="number" />
						</div>
					</div>
				</div>';

		echo $string;
	}

	private function output_editor(){
		$this->editor = '<div id="targetpop-editor-output">'.wp_editor( 'Enter your plain text and/ or HTML here.', "targetpopeditor", array('textarea_rows' => 2, 'textarea_name'=>"content_ajax",'quicktags' => array('buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,close'))).'</div><div id="targetpop-editor-output2">'.'</div>';
	}

	private function output_create_popup_form_step_one(){

		$string1 = '<div id="targetpop-create-popup-container">
						<div id="targetpop-popup-preview-div" data-height="300" data-width="300" style="pointer-events:none;" >
							<div>
								<span>Preview This<br/>Pop-Up</span>
								<img id="targetpop-preview-popup-icon" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'popup-white.svg" />
							</div>
						</div>
						<p class="targetpop-max-width-p">To create a Pop-Up, simply fill out the options below and click the<span class="targetpop-color-blue-italic"> \'Create Pop-Up\'</span> button. Then head over to the <a href="'.menu_page_url( 'TargetPop-Options-triggers', false ).'&tab=triggers">Triggers Page</a> to assign your new Pop-Up to a Trigger.</p>
						<div id="targetpop-create-popup-step1-div">
							<p class="targetpop-create-popup-step-title">Step <img class="targetpop-icon-steps" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'stepone.svg" /><span class="targetpop-create-popup-step-subtitle"> - Choose a Pop-Up Type & Template</span></p>
							<div class="targetpop-create-step-line"></div>
							<div id="targetpop-create-popup-checkbox-div">
								<div class="targetpop-step1-row" id="targetpop-step1-row1">
										<div>
											<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image" data-label="emailsubscribe" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>E-Mail/Subscriptions</label><input class="targetpop-create-checkbox" id="targetpop-create-type-email-subscribe" type="checkbox" />
										</div>
										<div>
											<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image" data-label="plaintexthtml" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Plain Text/HTML</label><input class="targetpop-create-checkbox" id="targetpop-create-type-plain-html" type="checkbox" />
										</div>
										<div>
											<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image" data-label="pageorpost" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Recent Posts</label><input class="targetpop-create-checkbox" id="targetpop-create-type-page-or-post" type="checkbox" />

										</div>
										<div>
											<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image" data-label="imagegallery" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Image Gallery</label><input class="targetpop-create-checkbox" id="targetpop-create-type-gallery" type="checkbox" />
										</div>
										<div>
											<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image" data-label="externalwebsite" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>External Website</label><input class="targetpop-create-checkbox" id="targetpop-create-type-iframe" type="checkbox" />

										</div>
										<div>
											<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image" data-label="internalurl" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Internal URL</label><input class="targetpop-create-checkbox" id="targetpop-create-type-internal-url" type="checkbox" />
										</div>
										<div>
											<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image" data-label="singleimagewithlink" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Single Image w/ Link</label><input class="targetpop-create-checkbox" id="targetpop-create-type-image" type="checkbox" />
										</div>
										<div>
											<img class="targetpop-icon-image-question-create-step-1 targetpop-icon-image" data-label="video" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Video</label><input class="targetpop-create-checkbox" id="targetpop-create-type-video" type="checkbox" />
										</div>
								</div>
							</div>
							<div id="targetpop-step-1-template-div">
							</div>
							<div class="targetpop-spinner" id="wpbooklist-spinner-1"></div>
						</div>
					</div>';
		
		$this->initial_output = $string1;

	}

	private function output_step_3(){

		global $wpdb;
		$savedtriggerstable = $wpdb->prefix . 'targetpop_triggers_log';
		$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $savedtriggerstable", $savedtriggerstable));

		$triggers = '';
		foreach ($result as $key => $value) {
			$triggers = $triggers.'<option value="'.$value->uniqueid.'">'.$value->name.'</option>';
		}

		$string3 = '<div id="targetpop-create-popup-step3-div">
						<p class="targetpop-create-popup-step-title">Step <img class="targetpop-icon-steps" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'stepthree.svg" /> - <span class="targetpop-create-popup-step-subtitle">Set Pop-Up Details</span></p>
						<div class="targetpop-create-step-line"></div>
						<div id="targetpop-create-popup-details-div">
							<div class="targetpop-step3-row" id="targetpop-step3-row1">
								<div>
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="namethispopup" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Name This Pop-Up:</label>
									<input type="text" id="targetpop-create-popup-name" placeholder="Name of Pop-Up"/>
								</div>
								<div id="targetpop-height-div">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="popupheight"  src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Pop-Up Height:</label>
									<input type="number" max="100" min="20" id="targetpop-height-text-input" placeholder="10%" value="300"/><label class="targetpop-create-step-3-check-labels" id="targetpop-height-text-label"><span id="targetpop-height-text-span">Or</span> Auto Height </label>
									<input id="targetpop-auto-height-checkbox" type="checkbox"  />
								</div>
								<div id="targetpop-width-div">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="popupwidth"  src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Pop-Up Width:</label>
									<input type="number" max="100" min="20" id="targetpop-width-text-input" placeholder="10%" value="300"/><label class="targetpop-create-step-3-check-labels" id="targetpop-width-text-label"><span id="targetpop-width-text-span">Or</span> Auto Width </label>
									<input id="targetpop-auto-width-checkbox" type="checkbox"  />
								</div>
							</div>
							<div class="targetpop-step3-row" id="targetpop-step3-row3">
								<div id="targetpop-transition-row">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="transition" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Pop-Up Transition:</label>
									<select id="targetpop-create-popup-transition">
										<option selected disabled>Select an Animation...</option>
										<option>Elastic</option>
										<option>Fade</option>
									</select>
								</div>
								<div id="targetpop-trans-speed-div">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="transspeed"  src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Opening Speed:</label>
									<input type="number" min="350" value="350" id="targetpop-open-speed-input" placeholder="350" />
								</div>
								<div id="targetpop-closing-speed-div">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="closingspeed"  src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Closing Speed:</label>
									<input type="number" min="300" value="300" id="targetpop-closing-speed-input" placeholder="300" />
								</div>
								<div id="targetpop-track-stats-row">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="popupcloseswhen" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Pop-Up Closes When:</label>
									<select id="targetpop-create-popup-close-trigger">
										<option selected disabled>Select an Action...</option>
										<option>Visitor presses ESC key</option>
										<option>Bottom X button is clicked</option>
										<option>Visitor clicks outside of Pop-Up</option>
										<option>All of the above</option>
									</select>
								</div>
								<div>
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="assignatrigger" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Assign a Trigger:</label>
									<select id="targetpop-create-popup-trigger">
										<option selected disabled>Select a Trigger...</option>
										<option>Default Trigger</option>
										'.$triggers.'
									</select>
								</div>
								<div id="targetpop-row-for-colorpicker">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="setbackdropcolor" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Set Backdrop Color:</label><div style="display:none;" id="targetpop-backdropcolor-div"></div>
								</div>
								<div id="targetpop-overlay-opacity-div">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="overlayopacity"  src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Backdrop Opacity:</label>
									<input type="number" value="85" min="0" max="100" id="targetpop-backdrop-opacity-input" placeholder="85%" />
								</div>

							</div>
							<div class="targetpop-step3-row" id="targetpop-step3-row3">
								<!--
								<div>
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="openinganimation" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Opening Animation:</label>
									<select id="targetpop-create-popup-open-anim">
										<option selected disabled>Select an Animation...</option>
										<option>Fades in</option>
										<option>Slides in from left</option>
										<option>Slides in from right</option>
									</select>
								</div>
								-->
								<div>
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="apperancedelay" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Appearance Delay:</label>
									<input min="0" max="180" type="number" id="targetpop-create-popup-open-delay" placeholder="0 Seconds"/>
								</div>
							</div>
							<div class="targetpop-step3-row" id="targetpop-step3-row4">
								<!--
								<div>
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="closing animation" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Closing Animation:</label>
									<select id="targetpop-create-popup-close-anim">
										<option selected disabled>Select an Animation...</option>
										<option>Fades out</option>
										<option>Slides to the left</option>
										<option>Slides to the right</option>
									</select>
								</div>
								-->
								<div>
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="disableonmobile" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Disable on Mobile?</label>
									<div id="targetpop-create-step3-checkboxes-div">
										<input type="checkbox" id="targetpop-create-popup-disablemobileyes"/>
										<label class="targetpop-create-step-3-check-labels">Yes</label>
										<input type="checkbox" id="targetpop-create-popup-disablemobileno"/>
										<label class="targetpop-create-step-3-check-labels">No</label>
									</div>
								</div>
								<div>
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="removeclosebutton" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Remove Close Button?</label>
									<div id="targetpop-create-step3-checkboxes-div">
										<input type="checkbox" id="targetpop-create-popup-removecloseyes"/>
										<label class="targetpop-create-step-3-check-labels">Yes</label>
										<input type="checkbox" id="targetpop-create-popup-removecloseno"/>
										<label class="targetpop-create-step-3-check-labels">No</label>
									</div>
								</div>
								<div id="targetpop-create-popup-final-div">
									<button id="targetpop-create-popup-button">Create Pop-Up!</button>
									<div class="targetpop-spinner" id="wpbooklist-spinner-2"></div>
									<div id="targetpop-results-div"></div>
								</div>
							</div>
						</div>';

		// Elements to add back in once other Pop-Up types are created
		/*
		<div id="targetpop-slideshow-speed-div">
				<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="slideshowspeed"  src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Slideshow Speed:</label>
				<input type="number" min="2" value="2" id="targetpop-slideshow-speed-input" placeholder="2" />
			</div>
		<div>
			<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="trackstatistics" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Track Statistics?</label>
			<div id="targetpop-create-step3-checkboxes-div">
				<input type="checkbox" id="targetpop-create-popup-trackyes"/>
				<label class="targetpop-create-step-3-check-labels">Yes</label>
				<input type="checkbox" id="targetpop-create-popup-trackno"/>
				<label class="targetpop-create-step-3-check-labels">No</label>
			</div>
		</div>
		<div id="targetpop-autostart-slideshow-row">
			<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="slideshowauto" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question.svg" /><label>Auto-Start Slideshow?</label>
			<div id="targetpop-create-step3-checkboxes-div">
				<input type="checkbox" id="targetpop-create-popup-startslideyes"/>
				<label class="targetpop-create-step-3-check-labels">Yes</label>
				<input type="checkbox" id="targetpop-create-popup-startslideno"/>
				<label class="targetpop-create-step-3-check-labels">No</label>
			</div>
		</div>
		*/

		echo $string3;
	}

  
}

endif;