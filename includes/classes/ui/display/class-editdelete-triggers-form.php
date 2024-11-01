<?php
/**
 * TargetPop TargetPop_EditDelete_Triggers_Form Class
 *
 * @author   Jake Evans
 * @category Display
 * @package  Includes/Classes/UI/Display
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'TargetPop_EditDelete_Triggers_Form', false ) ) :
/**
 * TargetPop_EditDelete_Triggers_Form.
 */
class TargetPop_EditDelete_Triggers_Form {

	public $initial_output;
	public $table;
	public $trigger_results;


	public function __construct() {

		global $wpdb;
		$this->table = $wpdb->prefix.'targetpop_triggers_log';
		$this->trigger_results = $wpdb->get_results("SELECT * FROM $this->table");
		$this->initial_output();

	}

	private function initial_output(){

		// If no Triggers yet...
		if(sizeof($this->trigger_results) == 0){
			$string1 = '<div id="targetpop-triggers-top-div"><p class="targetpop-max-width-p">Here you can edit and delete your existing Pop-Up Triggers. Simply click on a Trigger below, edit the details that emerge, and click the <span class="targetpop-color-blue-italic">\'Edit Trigger\'</span> button.</p>
				<div id="targetpop-popup-no-popups-div">Uh-oh! Looks like you haven\'t created any Triggers yet! <a href="'.menu_page_url( 'TargetPop-Options-triggers', false ).'&tab=triggers">Click Here to Create Triggers</a> <br><img class="targetpop-frown-icon" src="https://wpbooklist.com/wp-content/plugins/targetpop/assets/img/icons/smile.svg"></div></div>';
			$this->initial_output = $string1;
			return;
		}


		$string1 = '<div id="targetpop-triggers-top-div"><p class="targetpop-max-width-p">Here you can edit and delete your existing Pop-Up Triggers. Simply click on a Trigger below, edit the details that emerge, and click the <span class="targetpop-color-blue-italic">\'Edit Trigger\'</span> button.</p>
				<div id="targetpop-trigger-edit-delete-div">';

				$string2 = '';
				foreach ($this->trigger_results as $key => $trigger) {

					if($trigger->triggered == null){
						$trigger->triggered = 0;
					}

					$stringrow1 = '<div data-posttitle="'.$trigger->post.'" data-pagetitle="'.$trigger->page.'" data-triguid='.$trigger->uniqueid.' class="targetpop-edittriggers-trigger-row" id="targetpop-edittriggers-trigger-row-id-'.$key.'">
						<div class="targetpop-edittrig-num-div">
							<img class="targetpop-edit-delete-trigs-num-img" src="'.TARGETPOP_ROOT_IMG_URL.'hashwhite.svg"/>
							<span class="targetpop-edittrig-num-span">'.intval($key+1).'&nbsp;-</span>
						</div>
						<div class="targetpop-edittrig-name-div">
							<span class="targetpop-edittrig-name-span">'.ucfirst($trigger->name).'</span>
						</div>
						<div class="targetpop-edittrig-arrow-div">
							<img class="targetpop-edit-delete-trigs-arrow-img" src="'.TARGETPOP_ROOT_IMG_URL.'chevron-arrow-down.svg"/>
						</div>
					</div>
					<div class="targetpop-edittrig-details-div">
						<div class="targetpop-edittrig-details-inner-container">
							<div class="targetpop-edittrig-statement-div">
								<span class="targetpop-edittrig-statement-text">'.$trigger->statement.'</span>
							</div>
							<div class="targetpop-edittrig-stats-row">
								<div class="targetpop-edittrig-created">
									<img class="targetpop-edit-delete-stats-img" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'calendar.svg"/>
									<label>Created on '.gmdate("m-d-Y", $trigger->created).'</label>
								</div>
								<div class="targetpop-edittrig-triggered">
									<img class="targetpop-edit-delete-stats-img" src="'.TARGETPOP_ROOT_IMG_ICONS_URL.'verify-sign.svg"/>
									<label>Triggered '.$trigger->triggered.' times</label>
								</div>
							</div>
							';

							$stringrow2 = $this->edit_specific_fields(intval($key));

							$stringrow3 = '<div class="targetpop-edittrig-edit-delete-div">
								<div class="targetpop-spinner-white" id="targetpop-spinner-'.$trigger->ID.'"></div>
								<div class="targetpop-edit-trig-success-div"></div>
								<div class="targetpop-edittrig-delete-results-div" id="targetpop-results-div-'.$trigger->ID.'">

								</div>
								<div class="targetpop-edittrig-edit-button" id="targetpop-editbutton-id-'.$trigger->ID.'" data-triguid="'.$trigger->uniqueid.'" data-trigtype="'.$trigger->type.'">
									<img class="targetpop-edit-delete-buttons-edit-img" src="'.TARGETPOP_ROOT_IMG_URL.'pencil.svg"/>
									<span class="targetpop-edittrig-edit-text">Edit Trigger</span>
								</div>
								<div class="targetpop-edittrig-delete-button" id="targetpop-deletebutton-id-'.$trigger->ID.'" data-uniqueid="'.$trigger->ID.'">
									<img class="targetpop-edit-delete-buttons-delete-img" src="'.TARGETPOP_ROOT_IMG_URL.'garbage-bin.svg"/>
									<span class="targetpop-edittrig-delete-text">Delete Trigger</span>
								</div>
							</div>
						</div>
					</div>';

					$string2 = $string2.$stringrow1.$stringrow2.$stringrow3;
				}

					
		$string3 =	'</div>
			</div>';


		$this->initial_output = $string1.$string2.$string3;

	}

	private function edit_specific_fields($val){

		$statement = '';
		switch ($this->trigger_results[$val]->type) {
			case 'targetpop-create-triggers-1':
				$statement = '<div class="targetpop-specific-fields-trigedit-div">
					<div class="targetpop-edittrig-edit-name-div">
						<span class="targetpop-specific-fields-trigedit-span">
							Name of Trigger:
						</span>
						<input class="targetpop-trig-name-trigedit-text-input" type="text"  value="'.$this->trigger_results[$val]->name.'"/>
					</div>
					<span class="targetpop-specific-fields-trigedit-span">
						Set amount of seconds the visitor must remain on any Page before the Pop-Up appears:
					</span>
					<input class="targetpop-specific-fields-trigedit-text-input" type="text" placeholder="30 Seconds" value="'.$this->trigger_results[$val]->seconds.'"/>
				</div>';
				break;
			case 'targetpop-create-triggers-2':
				$statement = '<div class="targetpop-specific-fields-trigedit-div">
					<div class="targetpop-edittrig-edit-name-div">
						<span class="targetpop-specific-fields-trigedit-span">
							Name of Trigger:
						</span>
						<input class="targetpop-trig-name-trigedit-text-input" type="text"  value="'.$this->trigger_results[$val]->name.'"/>
					</div>
					<span class="targetpop-specific-fields-trigedit-span">
						Set amount of seconds the visitor must remain on any Post before the Pop-Up appears:
					</span>
					<input class="targetpop-specific-fields-trigedit-text-input" type="text" placeholder="30 Seconds" value="'.$this->trigger_results[$val]->seconds.'"/>
				</div>';
				break;
			case 'targetpop-create-triggers-3':
				$statement = '<div class="targetpop-specific-fields-trigedit-div">
					<div class="targetpop-edittrig-edit-name-div">
						<span class="targetpop-specific-fields-trigedit-span">
							Name of Trigger:
						</span>
						<input class="targetpop-trig-name-trigedit-text-input" type="text"  value="'.$this->trigger_results[$val]->name.'"/>
					</div>
					<span class="targetpop-specific-fields-trigedit-span">
						The Visitor to your website must click on an Internal Link (an internal link is one that links to another page or section of your website) before your Pop-Up will appear.
					</span>
				</div>';
				break;
			case 'targetpop-create-triggers-4':
				$statement2 = '';
				$statement3 = '';
				$statement = '<div class="targetpop-specific-fields-trigedit-div">
					<div class="targetpop-edittrig-edit-name-div">
						<span class="targetpop-specific-fields-trigedit-span">
							Name of Trigger:
						</span>
						<input class="targetpop-trig-name-trigedit-text-input" type="text"  value="'.$this->trigger_results[$val]->name.'"/>
					</div>
					<span class="targetpop-specific-fields-trigedit-span">
						Visitor must visit the Page below before Pop-Up appears:
					</span>
					<select id="targetpop-edit-trig-pages"><option selected default >Select a Page...</option>';

					$pages = get_pages();
					foreach ($pages as $key => $page) {
						$statement2 = $statement2.'<option value="'.$page->ID.'">'.stripslashes($page->post_title).'</option>';
					}

					$statement3 = '</select>
				</div>';
				$statement = $statement.$statement2.$statement3;
				break;
			case 'targetpop-create-triggers-5':
				//$statement = 'Visitor must view an embedded video before Pop-Up appears';
				$statement = '<div class="targetpop-specific-fields-trigedit-div">
					<div class="targetpop-edittrig-edit-name-div">
						<span class="targetpop-specific-fields-trigedit-span">
							Name of Trigger:
						</span>
						<input class="targetpop-trig-name-trigedit-text-input" type="text"  value="'.$this->trigger_results[$val]->name.'"/>
					</div>
					<span class="targetpop-specific-fields-trigedit-span">
						The Visitor to your website must view an embedded video (such as an embedded YouTube video) before your Pop-Up will appear.
					</span>
				</div>';
				break;
			case 'targetpop-create-triggers-6':
				$statement = '<div class="targetpop-specific-fields-trigedit-div">
					<div class="targetpop-edittrig-edit-name-div">
						<span class="targetpop-specific-fields-trigedit-span">
							Name of Trigger:
						</span>
						<input class="targetpop-trig-name-trigedit-text-input" type="text"  value="'.$this->trigger_results[$val]->name.'"/>
					</div>
					<span class="targetpop-specific-fields-trigedit-span">
						Input the Percentage of the Page or Post the Visitor must scroll down before your Pop-Up appears:
					</span>
					<input class="targetpop-specific-fields-trigedit-text-input" type="text" placeholder="30%" value="'.$this->trigger_results[$val]->scrollpercentage.'"/>
				</div>';
				break;
			case 'targetpop-create-triggers-7':
				$statement2 = '';
				$statement3 = '';
				$statement = '<div class="targetpop-specific-fields-trigedit-div">
					<div class="targetpop-edittrig-edit-name-div">
						<span class="targetpop-specific-fields-trigedit-span">
							Name of Trigger:
						</span>
						<input class="targetpop-trig-name-trigedit-text-input" type="text"  value="'.$this->trigger_results[$val]->name.'"/>
					</div>
					<span class="targetpop-specific-fields-trigedit-span">
						Set the amount of seconds the visitor must remain on a specific Page before the Pop-Up appears:
					</span>
					<input class="targetpop-specific-fields-trigedit-text-input" type="text" placeholder="30 Seconds" value="'.$this->trigger_results[$val]->seconds.'"/>
					<span class="targetpop-specific-fields-trigedit-span">
						Visitor must visit the Page below before Pop-Up appears:
					</span>
					<select id="targetpop-edit-trig-pages"><option selected default >Select a Page...</option>';
					$pages = get_pages();
					foreach ($pages as $key => $page) {
						$statement2 = $statement2.'<option value="'.$page->ID.'">'.stripslashes($page->post_title).'</option>';
					}
					$statement3 = '</select>
				</div>';
				$statement = $statement.$statement2.$statement3;
				break;
			case 'targetpop-create-triggers-8':
				$statement2 = '';
				$statement3 = '';
				$statement = '<div class="targetpop-specific-fields-trigedit-div">
					<div class="targetpop-edittrig-edit-name-div">
						<span class="targetpop-specific-fields-trigedit-span">
							Name of Trigger:
						</span>
						<input class="targetpop-trig-name-trigedit-text-input" type="text"  value="'.$this->trigger_results[$val]->name.'"/>
					</div>
					<span class="targetpop-specific-fields-trigedit-span">
						Set the amount of seconds the visitor must remain on a specific Post before the Pop-Up appears:
					</span>
					<input class="targetpop-specific-fields-trigedit-text-input" type="text" placeholder="30 Seconds" value="'.$this->trigger_results[$val]->seconds.'"/>
					<span class="targetpop-specific-fields-trigedit-span">
						Visitor must visit the Post below before Pop-Up appears:
					</span>
					<select id="targetpop-edit-trig-posts"><option selected default >Select a Post...</option>';
					$posts = get_posts();
					foreach ($posts as $key => $post) {
						$statement2 = $statement2.'<option value="'.$post->ID.'">'.stripslashes($post->post_title).'</option>';
					}
					$statement3 = '</select>
				</div>';
				$statement = $statement.$statement2.$statement3;
				break;
			case 'targetpop-create-triggers-9':
				$statement = '<div class="targetpop-specific-fields-trigedit-div">
					<div class="targetpop-edittrig-edit-name-div">
						<span class="targetpop-specific-fields-trigedit-span">
							Name of Trigger:
						</span>
						<input class="targetpop-trig-name-trigedit-text-input" type="text"  value="'.$this->trigger_results[$val]->name.'"/>
					</div>
					<span class="targetpop-specific-fields-trigedit-span">
						The Visitor to your website must click on an External Link (an external link is one that links to a completely different website from your own) before your Pop-Up will appear.
					</span>
				</div>';
				break;
			case 'targetpop-create-triggers-10':
				$statement2 = '';
				$statement3 = '';
				$statement = '<div class="targetpop-specific-fields-trigedit-div">
					<div class="targetpop-edittrig-edit-name-div">
						<span class="targetpop-specific-fields-trigedit-span">
							Name of Trigger:
						</span>
						<input class="targetpop-trig-name-trigedit-text-input" type="text"  value="'.$this->trigger_results[$val]->name.'"/>
					</div>
					<span class="targetpop-specific-fields-trigedit-span">
						Visitor must visit the Page below before Pop-Up appears:
					</span>
					<select id="targetpop-edit-trig-pages"><option selected default >Select a Page...</option>';

					$pages = get_pages();
					foreach ($pages as $key => $page) {
						$statement2 = $statement2.'<option value="'.$page->ID.'">'.stripslashes($page->post_title).'</option>';
					}

					$statement3 = '</select>
				</div>';
				$statement = $statement.$statement2.$statement3;
				break;
			case 'targetpop-create-triggers-11':
				$statement = '<div class="targetpop-specific-fields-trigedit-div">
					<div class="targetpop-edittrig-edit-name-div">
						<span class="targetpop-specific-fields-trigedit-span">
							Name of Trigger:
						</span>
						<input class="targetpop-trig-name-trigedit-text-input" type="text"  value="'.$this->trigger_results[$val]->name.'"/>
					</div>
					<span class="targetpop-specific-fields-trigedit-span">
						The Visitor to your website must leave a comment before your Pop-Up will appear.
					</span>
				</div>';
				break;
			default:
				# code...
				break;
		}

		return $statement;
	}
}

endif;