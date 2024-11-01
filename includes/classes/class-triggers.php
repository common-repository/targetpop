<?php
/**
 * TargetPop Triggers Class
 *
 * @author   Jake Evans
 * @category Display
 * @package  Includes/Classes
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'TargetPop_Triggers', false ) ) :

class TargetPop_Triggers {

	public $triggersname;
	public $triggerscreated;
	public $triggerspercentage;
	public $triggersscrollpercentage;
	public $triggerspage;
	public $triggerspost;
	public $triggersseconds;
	public $triggersstatement;
	public $triggersactive;
	public $triggerspopup;
	public $triggerstriggered;
	public $triggersdatasourcename;
	public $triggersdatasourceid;
	public $triggersmlname;
	public $triggersmlid;
	public $triggersdatasourcestatus;
	public $triggersmlstatus;
	public $triggersendpoint;
	public $triggerbucketname;
	public $triggerscsvname;	
	public $triggersuniqueid;
	public $triggerstype;
	public $id;

	public $savedtriggerstable;
	public $addresult;
	public $editresult;
	public $trigdelete;

	public function __construct($action = null, $triggers_array = null, $id = null) {

		global $wpdb;
		$this->savedtriggerstable = $wpdb->prefix . 'targetpop_triggers_log';
		$this->id = $id;

		// set up values of the pop-up
		if($triggers_array != null){
			$this->triggersname = $triggers_array['triggersname'];
			$this->triggerscreated = $triggers_array['triggerscreated'];
			//$this->triggerstype = $triggers_array['triggerstype'];
			$this->triggerspercentage = $triggers_array['triggerspercentage'];
			$this->triggersscrollpercentage = $triggers_array['triggersscrollpercentage'];
			$this->triggerspage = $triggers_array['triggerspage'];
			$this->triggerspost = $triggers_array['triggerspost'];
			$this->triggersseconds = $triggers_array['triggersseconds'];
			$this->triggersstatement = $triggers_array['triggersstatement'];
			$this->triggersactive = $triggers_array['triggersactive'];
			$this->triggerstype = $triggers_array['triggerstype'];
			//$this->triggerspopup = $triggers_array['triggerspopup'];
			//$this->triggerstriggered = $triggers_array['triggerstriggered'];
			//$this->triggersdatasourcename = $triggers_array['triggersdatasourcename'];
			//$this->triggersdatasourceid = $triggers_array['triggersdatasourceid'];
			//$this->triggersmlname = $triggers_array['triggersmlname'];
			//$this->triggersmlid = $triggers_array['triggersmlid'];
			//$this->triggersdatasourcestatus = $triggers_array['triggersdatasourcestatus'];
			//$this->triggersmlstatus = $triggers_array['triggersmlstatus'];
			//$this->triggersendpoint = $triggers_array['triggersendpoint'];
			//$this->triggerbucketname = $triggers_array['triggerbucketname'];
			//$this->triggerscsvname = $triggers_array['triggerscsvname'];;
			$this->triggersuniqueid = $triggers_array['triggersuniqueid'];
		}

		if($action == 'create'){
			$this->create_triggers();
		}

		if($action == 'delete'){
			$this->delete_triggers();
		}

		if($action == 'edit'){
			$this->edit_triggers();
		}

	}

	private function create_triggers(){

		// Create a unique identifier for this trigger
		$this->triggersuniqueid = uniqid();


		global $wpdb;
		$this->addresult = $wpdb->insert( $this->savedtriggerstable, array(

		'created' => $this->triggerscreated,
		'percentage' => $this->triggerspercentage,
		'scrollpercentage' => $this->triggersscrollpercentage,
		'seconds' => $this->triggersseconds,
		'name' => $this->triggersname,
		'uniqueid' => $this->triggersuniqueid,
		'page' => $this->triggerspage,
		'post' => $this->triggerspost,
		'statement' => $this->triggersstatement,
		'active' => $this->triggersactive,
		'type' => $this->triggerstype),
        array(
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
              '%s'
          )   
  		);

	}

	private function edit_triggers(){

		global $wpdb;
		$data = array(
        	'name' => $this->triggersname,
        	'seconds'=>$this->triggersseconds,
        	'page'=>$this->triggerspage,
        	'post'=>$this->triggerspost,
        	'scrollpercentage'=>$this->triggersscrollpercentage
	    );
	    $format = array( '%s','%d','%d','%d','%d' ); 
	    $where = array( 'uniqueid' => $this->triggersuniqueid );
	    $where_format = array( '%s' );
	    $this->editresult = $wpdb->update( $wpdb->prefix.'targetpop_triggers_log', $data, $where, $format, $where_format );

	}

	private function delete_triggers(){

		global $wpdb;

		// Finding all Pop-Ups that used this trigger, removing the trigger's unique ID from the 'popuptrigger' column, and deactivating the popup
		$savedtrigger = $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->savedtriggerstable WHERE id = %s", $this->id));
		$triguniqueid = $savedtrigger->uniqueid;

		$popuptable = $wpdb->prefix.'targetpop_saved_popups_log';
		$popupresults = $wpdb->get_results("SELECT * FROM $popuptable");

		foreach ($popupresults as $key => $popup) {
			if($popup->popuptrigger == $triguniqueid){

				$data = array(
		        	'popuptrigger' => '',
		        	'popupactive' => 'inactive',
			    );
			    $format = array( '%s', '%s'); 
			    $where = array( 'id' => $popup->ID );
			    $where_format = array( '%d' );
			    $this->toggleresponse = $wpdb->update( $popuptable, $data, $where, $format, $where_format );
			}
		}

		// Deleting row
		$this->trigdelete = $wpdb->delete( $this->savedtriggerstable, array( 'ID' => $this->id ) );

		// Dropping primary key in database to alter the IDs and the AUTO_INCREMENT value
		$wpdb->query($wpdb->prepare( "ALTER TABLE $this->savedtriggerstable MODIFY ID BIGINT(190) NOT NULL", $this->savedtriggerstable));

		$wpdb->query($wpdb->prepare( "ALTER TABLE $this->savedtriggerstable DROP PRIMARY KEY", $this->savedtriggerstable));

		// Adjusting ID values of remaining entries in database
		$my_query = $wpdb->get_results($wpdb->prepare("SELECT * FROM $this->savedtriggerstable", $this->savedtriggerstable ));
		$trig_count = $wpdb->num_rows;
		for ($x = $this->id; $x <= $trig_count; $x++) {
			$data = array(
			    'ID' => $this->id
			);
			$format = array( '%s'); 
			$this->id++;  
			$where = array( 'ID' => ($this->id) );
			$where_format = array( '%d' );
			$wpdb->update( $this->savedtriggerstable, $data, $where, $format, $where_format );
		}  

		// Adding primary key back to database 
		$wpdb->query($wpdb->prepare( "ALTER TABLE $this->savedtriggerstable ADD PRIMARY KEY (`ID`)", $this->savedtriggerstable));    

		$wpdb->query($wpdb->prepare( "ALTER TABLE $this->savedtriggerstable MODIFY ID BIGINT(190) AUTO_INCREMENT", $this->savedtriggerstable));

		// Setting the AUTO_INCREMENT value based on number of remaining entries
		$trig_count++;
		$wpdb->query($wpdb->prepare( "ALTER TABLE $this->savedtriggerstable AUTO_INCREMENT = %d", $trig_count));


		
	}

	

  
}

endif;