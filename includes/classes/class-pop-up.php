<?php
/**
 * WPBookList Pop-Up Class
 *
 * @author   Jake Evans
 * @category Display
 * @package  Includes/Classes
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'TargetPop_Pop_Up', false ) ) :
/**
 * TargetPop_Create_Pop_Up_Form.
 */
class TargetPop_Pop_Up {

	public $popuptype;
	public $popupname;
	public $popuptemplate;
	public $popupheight;	
	public $popupwidth;
	public $popupautoheight;
	public $popupautowidth;
	public $popuptransition;
	public $popupopenspeed;
	public $popupclosingspeed;
	public $popupslidespeed;
	public $popupclosetrigger;
	public $popuptrigger;
	public $popupbackdropcolor;
	public $popupbackdropopacity;
	public $popupappeardelay;
	public $popuptrackstats;
	public $popupmobile;	
	public $popupremoveclose;
	public $popupslideauto;
	public $popupstylestring;
	public $contenttext;

	public $popupuid;
	public $savedpopupstable;
	public $id;
	public $popupdelete;
	public $popupresults;
	public $edit_populate_html;
	public $edit_result;
	public $edit_data;
	public $create_result;
	public $create_data;
	public $toggle;
	public $toggleresponse;
	public $tripped;
	public $triggers;

	public function __construct($action = null, $popup_array = null, $id = null, $toggle = null) {

		global $wpdb;
		$this->savedpopupstable = $wpdb->prefix . 'targetpop_saved_popups_log';
		$this->id = $id;
		$this->toggle = $toggle;

		// set up values of the pop-up
		if($popup_array != null){
			$this->popupuid = $popup_array['popupuid'];
			$this->popuptype = $popup_array['popuptype'];
			$this->popupname = $popup_array['popupname'];
			$this->popuptemplate = $popup_array['popuptemplate'];
			$this->popupheight = $popup_array['popupheight'];
			$this->popupwidth = $popup_array['popupwidth'];
			$this->popupautoheight = $popup_array['popupautoheight'];
			$this->popupautowidth = $popup_array['popupautowidth'];
			$this->popuptransition = $popup_array['popuptransition'];
			$this->popupopenspeed = $popup_array['popupopenspeed'];
			$this->popupclosingspeed = $popup_array['popupclosingspeed'];
			$this->popupslidespeed = $popup_array['popupslidespeed'];
			$this->popupclosetrigger = $popup_array['popupclosetrigger'];
			$this->popuptrigger = $popup_array['popuptrigger'];
			$this->popupbackdropopacity = $popup_array['popupbackdropopacity'];
			$this->popupbackdropcolor = $popup_array['popupbackdropcolor'];
			$this->popupappeardelay = $popup_array['popupappeardelay'];
			$this->popuptrackstats = $popup_array['popuptrackstats'];
			$this->popupmobile = $popup_array['popupmobile'];
			$this->popupremoveclose = $popup_array['popupremoveclose'];
			$this->popupslideauto = $popup_array['popupslideauto'];
			$this->popupstylestring = $popup_array['popupstylestring'];
			$this->contenttext = $popup_array['contenttext'];
		}
		if($action == 'create'){
			$this->create_popup();
		}

		if($action == 'edit'){
			$this->edit_popup();
		}

		if($action == 'delete'){
			$this->delete_popup();
		}

		if($action == 'edit_populate'){
			$this->edit_populate_popup($id);
		}

		if($action == 'trip'){
			$this->determine_trip();
		}

		if($action == 'toggle'){
			$this->toggle_popup();
		}

		if($action == 'recordopen'){
			$this->record_open();
		}

	}

	private function create_popup(){

		// Create a unique identifier for this popup
		$this->popupuid = uniqid();


		$data = array(
			'popupbackdropopacity' => $this->popupbackdropopacity,
			'popupopenspeed' => $this->popupopenspeed,
			'popupclosingspeed' => $this->popupclosingspeed,
			'popupcreated' => time(),
			'popupslidespeed' => $this->popupslidespeed,
			'popupheight' => $this->popupheight,	
			'popupwidth' => $this->popupwidth,
			'popupappeardelay' => $this->popupappeardelay,
			'popuptype' => $this->popuptype,
			'popupname' => $this->popupname,
			'popuptemplate' => $this->popuptemplate,
			'popupautoheight' => $this->popupautoheight,
			'popupautowidth' => $this->popupautowidth,
			'popupclosetrigger' => $this->popupclosetrigger,
			'popuptrigger' => $this->popuptrigger,
			'popupbackdropcolor' => $this->popupbackdropcolor,
			'popuptrackstats' => $this->popuptrackstats,
			'popupmobile' => $this->popupmobile,	
			'contenttext' => $this->contenttext,
			'popupuid' => $this->popupuid,
			'popuptransition' => $this->popuptransition,
			'popupremoveclose' => $this->popupremoveclose,
			'popupslideauto' => $this->popupslideauto,
			'popupstylestring' => $this->popupstylestring,
			'popupactive' => 'inactive'
		);


		global $wpdb;
		$this->create_result = $wpdb->insert( $this->savedpopupstable, $data,
        array(
              '%d',
              '%d',
              '%d',
              '%d',
              '%d',
              '%d',
              '%d',
              '%d',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s'
          )   
  		);

  		$this->create_data = $data;

	}

	private function edit_popup(){
		global $wpdb;
		$data = array(
			'popupbackdropopacity' => $this->popupbackdropopacity,
			'popupopenspeed' => $this->popupopenspeed,
			'popupclosingspeed' => $this->popupclosingspeed,
			'popupslidespeed' => $this->popupslidespeed,
			'popupheight' => $this->popupheight,	
			'popupwidth' => $this->popupwidth,
			'popupappeardelay' => $this->popupappeardelay,
			'popuptype' => $this->popuptype,
			'popupname' => $this->popupname,
			'popuptemplate' => $this->popuptemplate,
			'popupautoheight' => $this->popupautoheight,
			'popupautowidth' => $this->popupautowidth,
			'popupclosetrigger' => $this->popupclosetrigger,
			'popuptrigger' => $this->popuptrigger,
			'popupbackdropcolor' => $this->popupbackdropcolor,
			'popuptrackstats' => $this->popuptrackstats,
			'popupmobile' => $this->popupmobile,	
			'contenttext' => $this->contenttext,
			'popuptransition' => $this->popuptransition,
			'popupremoveclose' => $this->popupremoveclose,
			'popupslideauto' => $this->popupslideauto,
			'popupstylestring' => $this->popupstylestring,
		);

		$format = array(
			'%d',
			'%d',
			'%d',
			'%d',
			'%d',
			'%d',
			'%d',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s'
		);

	    $where = array( 'popupuid' => $this->popupuid );
	    $where_format = array( '%s' );
	    $this->edit_result = $wpdb->update( $wpdb->prefix.'targetpop_saved_popups_log', $data, $where, $format, $where_format );
	    $this->edit_data = $data;
	}

	
	private function delete_popup(){

		global $wpdb;

		// Deleting row
		$this->popupdelete = $wpdb->delete( $this->savedpopupstable, array( 'ID' => $this->id ) );

		// Dropping primary key in database to alter the IDs and the AUTO_INCREMENT value
		$wpdb->query($wpdb->prepare( "ALTER TABLE $this->savedpopupstable MODIFY ID BIGINT(190) NOT NULL", $this->savedpopupstable));

		$wpdb->query($wpdb->prepare( "ALTER TABLE $this->savedpopupstable DROP PRIMARY KEY", $this->savedpopupstable));

		// Adjusting ID values of remaining entries in database
		$my_query = $wpdb->get_results($wpdb->prepare("SELECT * FROM $this->savedpopupstable", $this->savedpopupstable ));
		$trig_count = $wpdb->num_rows;
		for ($x = $this->id; $x <= $trig_count; $x++) {
			$data = array(
			    'ID' => $this->id
			);
			$format = array( '%s'); 
			$this->id++;  
			$where = array( 'ID' => ($this->id) );
			$where_format = array( '%d' );
			$wpdb->update( $this->savedpopupstable, $data, $where, $format, $where_format );
		}  

		// Adding primary key back to database 
		$wpdb->query($wpdb->prepare( "ALTER TABLE $this->savedpopupstable ADD PRIMARY KEY (`ID`)", $this->savedpopupstable));    

		$wpdb->query($wpdb->prepare( "ALTER TABLE $this->savedpopupstable MODIFY ID BIGINT(190) AUTO_INCREMENT", $this->savedpopupstable));

		// Setting the AUTO_INCREMENT value based on number of remaining entries
		$trig_count++;
		$wpdb->query($wpdb->prepare( "ALTER TABLE $this->savedpopupstable AUTO_INCREMENT = %d", $trig_count));
	}

	function edit_populate_popup(){

		global $wpdb;
		$statement1 = '';
		$statement2 = '';
		$triggers = '';

		$savedtriggerstable = $wpdb->prefix . 'targetpop_triggers_log';
		$result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $savedtriggerstable", $savedtriggerstable));

		$triggers = '';
		foreach ($result as $key => $value) {
			$triggers = $triggers.'<option value="'.$value->uniqueid.'">'.$value->name.'</option>';
		}


		$this->table = $wpdb->prefix.'targetpop_saved_popups_log';
		$this->popupresults = $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table WHERE popupuid = %s", $this->id));

		$statement1 = '<div class="targetpop-spinner-white targetpop-spinner-forpop-edit" id="targetpop-spinner-'.$val.'"></div><div class="targetpop-edit-popup-template-container">'.$this->popupresults->contenttext;
		
		$statement1 = $statement1.'</div></div>';


		$statement2 = '<div id="targetpop-step2-edit-styling-div">
					<div class="targetpop-step2-column-div">
						<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image" data-label="border" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Border</label>
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
						<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image" data-label="borderradius" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Border-Radius</label>
						<div>
							<input id="targetpop-step2-styling-border-radius-px" placeholder="5px"   type="number" />
						</div>
					</div>
					<div class="targetpop-step2-column-div">
						<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image" data-label="color2" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Background Color</label>
						<div id="targetpop-row-for-colorpicker2-step2">
						</div>
					</div>
					<div class="targetpop-step2-column-div targetpop-step2-style-block">
						<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image" data-label="boxshadow" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Box-Shadow</label>
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
					<div class="targetpop-step2-column-div targetpop-step2-style-block">
						<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image" data-label="bodytextshadow" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Text-Shadow</label>
						<div id="targetpop-row-for-colorpicker5-step2">
							<input id="targetpop-step2-styling-text-shadow-body-x"  placeholder="5"   type="number" />
							<input id="targetpop-step2-styling-text-shadow-body-y"  placeholder="5"   type="number" />
							<input id="targetpop-step2-styling-text-shadow-body-blur"  placeholder="5"   type="number" />
						</div>
					</div>
					<div class="targetpop-step2-column-div targetpop-step2-style-block">
						<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image" data-label="bodypadding" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Padding</label>
						<div id="targetpop-row-for-colorpicker44-step2">
							<input id="targetpop-step2-styling-padding-body-top" placeholder="5"   type="number" />
							<input id="targetpop-step2-styling-padding-body-bottom" placeholder="5"   type="number" />
							<input id="targetpop-step2-styling-padding-body-left" placeholder="5"   type="number" />
							<input id="targetpop-step2-styling-padding-body-right" placeholder="5"   type="number" />
						</div>
					</div>
				</div>';

		$statement3 = '<div id="targetpop-create-popup-step3-div">
						<div id="targetpop-edit-popup-details-div">
							<div class="targetpop-step3-row" id="targetpop-step3-row1">
								<div id="targetpop-height-div">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="popupheight"  src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Pop-Up Height:</label>
									<input type="number" max="100" min="20" id="targetpop-height-text-input" placeholder="10%" /><label class="targetpop-create-step-3-check-labels" id="targetpop-height-text-label"><span id="targetpop-height-text-span">Or</span> Auto Height </label>
									<input id="targetpop-auto-height-checkbox" type="checkbox"  />
								</div>
								<div id="targetpop-width-div">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="popupwidth"  src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Pop-Up Width:</label>
									<input type="number" max="100" min="20" id="targetpop-width-text-input" placeholder="10%" /><label class="targetpop-create-step-3-check-labels" id="targetpop-width-text-label"><span id="targetpop-width-text-span">Or</span> Auto Width </label>
									<input id="targetpop-auto-width-checkbox" type="checkbox"  />
								</div>
							</div>
							<div class="targetpop-step3-row" id="targetpop-step3-row3">
								<div id="targetpop-transition-row">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="transition" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Pop-Up Transition:</label>
									<select id="targetpop-create-popup-transition">
										<option selected disabled>Select an Animation...</option>
										<option>Elastic</option>
										<option>Fade</option>
									</select>
								</div>
								<div id="targetpop-trans-speed-div">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="transspeed"  src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Opening Speed:</label>
									<input type="number" min="350" value="350" id="targetpop-open-speed-input" placeholder="350" />
								</div>
								<div id="targetpop-closing-speed-div">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="closingspeed"  src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Closing Speed:</label>
									<input type="number" min="300" value="300" id="targetpop-closing-speed-input" placeholder="300" />
								</div>
								<div id="targetpop-track-stats-row">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="popupcloseswhen" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Pop-Up Closes When:</label>
									<select id="targetpop-create-popup-close-trigger">
										<option selected disabled>Select an Action...</option>
										<option>Visitor presses ESC key</option>
										<option>Bottom X button is clicked</option>
										<option>Visitor clicks outside of Pop-Up</option>
										<option>All of the above</option>
									</select>
								</div>
								<div>
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="assignatrigger" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Assign a Trigger:</label>
									<select id="targetpop-create-popup-trigger">
										<option selected disabled>Select a Trigger...</option>
										<option>Default Trigger</option>
										'.$triggers.'
									</select>
								</div>
								<div id="targetpop-row-for-colorpicker">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="setbackdropcolor" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Set Backdrop Color:</label><div style="display:none;" id="targetpop-backdropcolor-div"></div>
								</div>
								<div id="targetpop-overlay-opacity-div">
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="overlayopacity"  src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Backdrop Opacity:</label>
									<input type="number" value="85" min="0" max="100" id="targetpop-backdrop-opacity-input" placeholder="85%" />
								</div>

							</div>
							<div class="targetpop-step3-row" id="targetpop-step3-row3">
								<!--
								<div>
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="openinganimation" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Opening Animation:</label>
									<select id="targetpop-create-popup-open-anim">
										<option selected disabled>Select an Animation...</option>
										<option>Fades in</option>
										<option>Slides in from left</option>
										<option>Slides in from right</option>
									</select>
								</div>
								-->
								<div>
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="apperancedelay" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Appearance Delay:</label>
									<input min="0" max="180" type="number" id="targetpop-create-popup-open-delay" placeholder="0 Seconds"/>
								</div>
							</div>
							<div class="targetpop-step3-row" id="targetpop-step3-row4">
								<!--
								<div>
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="closing animation" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Closing Animation:</label>
									<select id="targetpop-create-popup-close-anim">
										<option selected disabled>Select an Animation...</option>
										<option>Fades out</option>
										<option>Slides to the left</option>
										<option>Slides to the right</option>
									</select>
								</div>
								-->
								<div>
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="disableonmobile" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Disable on Mobile?</label>
									<div id="targetpop-create-step3-checkboxes-div">
										<input type="checkbox" id="targetpop-create-popup-disablemobileyes"/>
										<label class="targetpop-create-step-3-check-labels">Yes</label>
										<input type="checkbox" id="targetpop-create-popup-disablemobileno"/>
										<label class="targetpop-create-step-3-check-labels">No</label>
									</div>
								</div>
								<div>
									<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="removeclosebutton" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Remove Close Button?</label>
									<div id="targetpop-create-step3-checkboxes-div">
										<input type="checkbox" id="targetpop-create-popup-removecloseyes"/>
										<label class="targetpop-create-step-3-check-labels">Yes</label>
										<input type="checkbox" id="targetpop-create-popup-removecloseno"/>
										<label class="targetpop-create-step-3-check-labels">No</label>
									</div>
								</div>
							</div>
						</div>
					</div>';

	/*
	<div id="targetpop-slideshow-speed-div">
		<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="slideshowspeed"  src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Slideshow Speed:</label>
		<input type="number" min="2" value="2" id="targetpop-slideshow-speed-input" placeholder="2" />
	</div>
	<div id="targetpop-autostart-slideshow-row">
		<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="slideshowauto" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Auto-Start Slideshow?</label>
		<div id="targetpop-create-step3-checkboxes-div">
			<input type="checkbox" id="targetpop-create-popup-startslideyes"/>
			<label class="targetpop-create-step-3-check-labels">Yes</label>
			<input type="checkbox" id="targetpop-create-popup-startslideno"/>
			<label class="targetpop-create-step-3-check-labels">No</label>
		</div>
	</div>
	<div>
		<img class="targetpop-icon-image-question-create-step-2 targetpop-icon-image" data-label="trackstatistics" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'question-white.svg" /><label>Track Statistics?</label>
		<div id="targetpop-create-step3-checkboxes-div">
			<input type="checkbox" id="targetpop-create-popup-trackyes"/>
			<label class="targetpop-create-step-3-check-labels">Yes</label>
			<input type="checkbox" id="targetpop-create-popup-trackno"/>
			<label class="targetpop-create-step-3-check-labels">No</label>
		</div>
	</div>
	*/

		$this->edit_populate_html = $statement1.'--sep--seperator--sep--'.$statement2.'--sep--seperator--sep--'.$statement3;

		$html = $this->edit_populate_html;
			$contents = array();
			$startDelimiterLength = strlen('[');
			$endDelimiterLength = strlen(']');
			$startFrom = $contentStart = $contentEnd = 0;
			while (false !== ($contentStart = strpos($html, '[', $startFrom))) {
				$contentStart += $startDelimiterLength;
				$contentEnd = strpos($html, ']', $contentStart);
				if (false === $contentEnd) {
			  	break;
				}
				//array_push($contents, substr($html, $contentStart, $contentEnd - $contentStart));
				$contents[] = substr($html, $contentStart, $contentEnd - $contentStart);
				$startFrom = $contentEnd + $endDelimiterLength;
			}

			$array_length = sizeof($contents);
			foreach ($contents as $key => $shortcode) {
				
				$shortcode_type = 'single';
				$shortcode_output = '';
				$between_text = '';

				// Make sure we don't overshoot the array
				if($key+1 <= $array_length){
					if(mb_substr($contents[$key+1], 0, 1) == '/' ){
						$shortcode_type = 'double';
					}
				

				  	if($shortcode_type == 'single'){
				  		$shortcode_output = do_shortcode('['.$shortcode.']');
				  		$html = str_replace('['.$shortcode.']', $shortcode_output, $html);
				  	}

				  	if($shortcode_type == 'double'){
				    	$html = ' ' . $html;
				    	$ini = strpos($html, $shortcode);
				    	if ($ini != 0){
				    		$ini += strlen($shortcode);
				    		strpos($html, $contents[$key], $ini);
				    		$len = strpos($html, $contents[$key+1], $ini) - $ini;
				    		$between_text = substr($html, ($ini+1), ($len-2));
				    		$shortcode_output = do_shortcode('['.$shortcode.']'.$between_text.'['.$contents[$key+1].']');
				    		$html = str_replace('['.$shortcode.']'.$between_text.'['.$contents[$key+1].']', $shortcode_output, $html);
				    	}
				  	}
				}
			}

		$this->edit_populate_html = $html;

	}

	// Determines whether or not a trigger has been tripped
	private function toggle_popup(){
		global $wpdb;
		$table = $wpdb->prefix.'targetpop_saved_popups_log';

		$data = array(
        	'popupactive' => $this->toggle
	    );
	    $format = array( '%s'); 
	    $where = array( 'popupuid' => $this->id );
	    $where_format = array( '%s' );
	    $this->toggleresponse = $wpdb->update( $table, $data, $where, $format, $where_format );
	}

	// Determines whether or not a trigger has been tripped
	private function record_open(){
		global $wpdb;
		$table = $wpdb->prefix.'targetpop_saved_popups_log';
		$popup = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE popupuid = %s", $this->id));

		if($popup->popuptriggered == null){
			$popup->popuptriggered = 0;
		}

		$opens = $popup->popuptriggered+1;

		$data = array(
        	'popuptriggered' => $opens
	    );
	    $format = array( '%s'); 
	    $where = array( 'popupuid' => $this->id );
	    $where_format = array( '%s' );
	    $this->popuprecordopen = $wpdb->update( $table, $data, $where, $format, $where_format );
	}
  
  	// Determines whether or not a trigger has been tripped, and which trigger(s) that is
	private function determine_trip(){
		global $wpdb;
		$table = $wpdb->prefix.'targetpop_saved_popups_log';
		$trigtable = $wpdb->prefix.'targetpop_triggers_log';
		$popups = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE popupactive = %s", 'active'));

		// Build array of triggers to check
		$triggers_array = array();
		foreach ($popups as $key => $popup) {
			array_push($triggers_array, $popup->popuptrigger);
		}

		$trigger_data_array = array();
		foreach ($triggers_array as $key => $trigger) {
			$trig = $wpdb->get_row($wpdb->prepare("SELECT * FROM $trigtable WHERE uniqueid = %s", $trigger));
			array_push($trigger_data_array, $trig);
		}

		foreach ($popups as $key => $popup) {

			$html = $popup->contenttext;
			$contents = array();
			$startDelimiterLength = strlen('[');
			$endDelimiterLength = strlen(']');
			$startFrom = $contentStart = $contentEnd = 0;
			while (false !== ($contentStart = strpos($html, '[', $startFrom))) {
				$contentStart += $startDelimiterLength;
				$contentEnd = strpos($html, ']', $contentStart);
				if (false === $contentEnd) {
			  	break;
				}
				//array_push($contents, substr($html, $contentStart, $contentEnd - $contentStart));
				$contents[] = substr($html, $contentStart, $contentEnd - $contentStart);
				$startFrom = $contentEnd + $endDelimiterLength;
			}

			$array_length = sizeof($contents);
			foreach ($contents as $key => $shortcode) {
				
				$shortcode_type = 'single';
				$shortcode_output = '';
				$between_text = '';

				// Make sure we don't overshoot the array
				if($key+1 <= $array_length){
					if(mb_substr($contents[$key+1], 0, 1) == '/' ){
						$shortcode_type = 'double';
					}
				

				  	if($shortcode_type == 'single'){
				  		$shortcode_output = do_shortcode('['.$shortcode.']');
				  		$html = str_replace('['.$shortcode.']', $shortcode_output, $html);
				  	}

				  	if($shortcode_type == 'double'){
				    	$html = ' ' . $html;
				    	$ini = strpos($html, $shortcode);
				    	if ($ini != 0){
				    		$ini += strlen($shortcode);
				    		strpos($html, $contents[$key], $ini);
				    		$len = strpos($html, $contents[$key+1], $ini) - $ini;
				    		$between_text = substr($html, ($ini+1), ($len-2));
				    		$shortcode_output = do_shortcode('['.$shortcode.']'.$between_text.'['.$contents[$key+1].']');
				    		$html = str_replace('['.$shortcode.']'.$between_text.'['.$contents[$key+1].']', $shortcode_output, $html);
				    	}
				  	}
				}
			}
		}

		$popup->contenttext = $html;
		$this->tripped = $popups;
		$this->triggers = $trigger_data_array;
	}



}

endif;