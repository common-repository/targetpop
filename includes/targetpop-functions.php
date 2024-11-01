<?php

function targetpop_rest_api_notice( $data ){
    global $wpdb;
    $table_name = $wpdb->prefix . 'targetpop_general_settings_log';
    $options_row = $wpdb->get_results("SELECT * FROM $table_name");
    $newmessage = $data['notice'];
    $dismiss = $options_row[0]->admindismiss;
    if($dismiss == 0){
      $data = array(
          'admindismiss' => 1,
          'adminmessage' => $newmessage
      );
      $format = array( '%d', '%s'); 
      $where = array( 'ID' => 1 );
      $where_format = array( '%d' );
      $wpdb->update( $table_name, $data, $where, $format, $where_format );
    } else {
      $data = array(
          'adminmessage' => $newmessage
      );
      $format = array('%s'); 
      $where = array( 'ID' => 1 );
      $where_format = array( '%d' );
      $wpdb->update( $table_name, $data, $where, $format, $where_format );
    }
}

function targetpop_admin_notice_success() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'targetpop_general_settings_log';
  $options_row = $wpdb->get_results("SELECT * FROM $table_name");
  $dismiss = $options_row[0]->admindismiss;

  if($dismiss == 1){
    $message = $options_row[0]->adminmessage;
    $url = home_url();
    $newmessage = str_replace('alaainqphpaholeechoaholehomeanusurlalparpascaholeainqara',$url,$message);
    $newmessage = str_replace('asq',"'",$newmessage);
    $newmessage = str_replace("hshmrk","#",$newmessage);
    $newmessage = str_replace("ampersand","&",$newmessage);
    $newmessage = str_replace('adq','"',$newmessage);
    $newmessage = str_replace('aco',':',$newmessage);
    $newmessage = str_replace('asc',';',$newmessage);
    $newmessage = str_replace('aslash','/',$newmessage);
    $newmessage = str_replace('ahole',' ',$newmessage);
    $newmessage = str_replace('ara','>',$newmessage);
    $newmessage = str_replace('ala','<',$newmessage);
    $newmessage = str_replace('anem','!',$newmessage);
    $newmessage = str_replace('dash','-',$newmessage);
    $newmessage = str_replace('akomma',',',$newmessage);
    $newmessage = str_replace('anequal','=',$newmessage);
    $newmessage = str_replace('dot','.',$newmessage);
    $newmessage = str_replace('anus','_',$newmessage);
    $newmessage = str_replace('adollar','$',$newmessage);
    $newmessage = str_replace('ainq','?',$newmessage);
    $newmessage = str_replace('alp','(',$newmessage);
    $newmessage = str_replace('arp',')',$newmessage);
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php echo $newmessage; ?></p>
    </div>
    <?php
  }
}



function targetpop_jre_plugin_test() {
  wp_enqueue_script( 'tinymce_js', includes_url( 'js/tinymce/' ) . 'wp-tinymce.php', array( 'jquery' ), false, true );
}

// Adding the Ajax library
function targetpop_add_ajax_library() {
 
    $html = '<script type="text/javascript">';

    // checking $protocol in HTTP or HTTPS
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
        // this is HTTPS
        $protocol  = "https";
    } else {
        // this is HTTP
        $protocol  = "http";
    }
    $tempAjaxPath = admin_url( 'admin-ajax.php' );
    $goodAjaxUrl = $protocol.strchr($tempAjaxPath,':');

    $html .= 'var ajaxurl = "' . $goodAjaxUrl . '"';
    $html .= '</script>';
    echo $html;
    
} // End add_ajax_library

// Adding the front-end ui css file for this extension
function targetpop_frontend_ui_style() {
    wp_register_style('targetpop-frontend-ui', TARGETPOP_ROOT_CSS_URL.'targetpop-frontend-ui.css' );
    wp_enqueue_style('targetpop-frontend-ui');
}

// Code for adding the general admin CSS file
function targetpop_admin_style() {
  if(current_user_can('administrator' )){
      wp_register_style('targetpop-admin-ui', TARGETPOP_ROOT_CSS_URL.'targetpop-admin-ui.css');
      wp_enqueue_style('targetpop-admin-ui');
  }
}

// Code for adding the colorpicker js file
function targetpop_colorpicker_script() {
    wp_register_script( 'targetpop-colorpicker-script', TARGETPOP_ROOT_JS_URL.'jscolor.js', array('jquery') );
    wp_enqueue_script('targetpop-colorpicker-script');
}

// Code for adding the targetbox js file
function targetpop_jre_plugin_targetbox_script() {
    wp_register_script( 'targetboxjsfortargetpop', TARGETPOP_ROOT_JS_URL.'targetbox/jquery.targetbox-min.js', array('jquery') );
    wp_enqueue_script('targetboxjsfortargetpop');
}

// Code for adding the displaypopup js file
function targetpop_jre_plugin_displaypopup_script() {
    wp_register_script( 'displaypopupjsfortargetpop', TARGETPOP_ROOT_JS_URL.'displaypopup.js', array('jquery') );
    wp_enqueue_script('displaypopupjsfortargetpop');
}

// Code for adding the targetbox CSS file
function targetpop_jre_plugin_targetbox_style() {
    wp_register_style( 'targetboxcssfortargetpop', TARGETPOP_ROOT_CSS_URL.'targetbox.css' );
    wp_enqueue_style('targetboxcssfortargetpop');
}

//Function to add the admin menu
function targetpop_admin_menu() {
  add_menu_page( 'TargetPop Options', 'TargetPop', 'manage_options', 'TargetPop-Options', 'targetpop_admin_page_function', TARGETPOP_ROOT_IMG_URL.'targetpopdashboardicon.png', 6  );

  $submenu_array = array(
    "Pop-Ups",
    "Triggers",
    //"Settings"
  );

  // Filter to allow the addition of a new subpage
  if(has_filter('targetpop_add_sub_menu')) {
    $submenu_array = apply_filters('targetpop_add_sub_menu', $submenu_array);
  }

  foreach($submenu_array as $key=>$submenu){
    $menu_slug = strtolower(str_replace(' ', '-', $submenu));
    add_submenu_page('TargetPop-Options', 'WPBookList', $submenu, 'manage_options', 'TargetPop-Options-'.$menu_slug, 'targetpop_admin_page_function');
  }

  remove_submenu_page('TargetPop-Options', 'TargetPop-Options');

}

function targetpop_admin_page_function(){
  global $wpdb;
  require_once(TARGETPOP_CLASSES_UI_ADMIN_DIR.'class-admin-master-ui.php');
}

// Function to add table names to the global $wpdb
function targetpop_register_table_name() {
    global $wpdb;
    $wpdb->targetpop_saved_popups_log = "{$wpdb->prefix}targetpop_saved_popups_log";
    $wpdb->targetpop_triggers_log = "{$wpdb->prefix}targetpop_triggers_log";
    $wpdb->targetpop_general_settings_log = "{$wpdb->prefix}targetpop_general_settings_log";
    $wpdb->targetpop_saved_triggers_log = "{$wpdb->prefix}targetpop_saved_triggers_log";
    $wpdb->targetpop_master_data_log = "{$wpdb->prefix}targetpop_master_data_log";
}

// Runs once upon plugin activation and creates tables
function targetpop_create_tables() {
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  global $wpdb;
  global $charset_collate; 

  $url = home_url(); 
  $plugin  ='TargetPop';
  $date = time();

  $postdata = http_build_query(
      array(
          'url' => $url,
          'plugin' => $plugin,
          'date' => $date
      )
  );

  $opts = array('http' =>
      array(
          'method'  => 'POST',
          'header'  => 'Content-type: application/x-www-form-urlencoded',
          'content' => $postdata
      )
  );

  $context = stream_context_create($opts);
  $result = '';
  $responsecode = '';
  if(function_exists('file_get_contents')){
      error_log('log1');
      file_get_contents('https://jakerevans.com/pmfileforrecord.php', false, $context);
  } else {
    if (function_exists('curl_init')){ 
      error_log('log4');
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
      curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
      $url = 'https://jakerevans.com/pmfileforrecord.php';
      curl_setopt($ch, CURLOPT_URL, $url);

      $data = array('url'=>$url, 'plugin'=>$plugin, 'date' => $date);

      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

      $result = curl_exec($ch);
      $responsecode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
    }
  }

  // Call this manually as we may have missed the init hook
  targetpop_register_table_name();
  
  $sql_create_table1 = "CREATE TABLE {$wpdb->targetpop_saved_popups_log} 
  (
        ID bigint(190) auto_increment,
        popupname varchar(190),
        popuptype varchar(255),
        popuptemplate varchar(255),
        popupheight bigint(255),
        popupwidth bigint(255),
        popupautoheight varchar(255),
        popupautowidth varchar(255),
        popuptransition varchar(255),
        popupopenspeed bigint(255),
        popupclosingspeed bigint(255),
        popupslidespeed bigint(255),
        popupclosetrigger varchar(255),
        popuptriggered varchar(255),
        popupcreated varchar(255),
        popuptrigger varchar(255),
        popupbackdropcolor varchar(255),
        popupbackdropopacity bigint(255),
        popupappeardelay bigint(255),
        popuptrackstats varchar(255),
        popupmobile varchar(255),
        popupremoveclose varchar(255),
        popupslideauto varchar(255),
        contenttext LONGTEXT,
        popupstylestring LONGTEXT,
        popupuid varchar(255),
        popupactive varchar(255),
        PRIMARY KEY  (ID),
          KEY popupname (popupname)
  ) $charset_collate; ";
  dbDelta( $sql_create_table1 );

  $sql_create_table2 = "CREATE TABLE {$wpdb->targetpop_general_settings_log} 
  (
        ID bigint(190) auto_increment,
        datacapture varchar(190) NOT NULL DEFAULT 'inactive',
        capturebegan bigint(255),
        captureend bigint(255),
        admindismiss bigint(255) NOT NULL DEFAULT 1,
        adminmessage varchar(10000) NOT NULL DEFAULT '".TARGETPOP_ADMIN_MESSAGE."',
        purchaseurl MEDIUMTEXT,
        PRIMARY KEY  (ID),
          KEY datacapture (datacapture)
  ) $charset_collate; ";
  dbDelta( $sql_create_table2 );
  $table_name = $wpdb->prefix . 'targetpop_general_settings_log';
  $wpdb->insert( $table_name, array('ID' => 1));



  $sql_create_table3 = "CREATE TABLE {$wpdb->targetpop_triggers_log} 
  (
        ID bigint(190) auto_increment,
        name varchar(190),
        created bigint(255),
        type varchar(255),
        percentage bigint(255),
        scrollpercentage bigint(255),
        page bigint(255),
        post bigint(255),
        seconds bigint(255),
        statement MEDIUMTEXT,
        active varchar(255),
        popup varchar(255),
        triggered bigint(255),
        datasourcename varchar(255),
        datasourceid varchar(255),
        mlname varchar(255),
        mlid varchar(255),
        datasourcestatus varchar(255),
        mlstatus varchar(255),
        endpoint varchar(255),
        bucketname varchar(255),
        csvname varchar(255),
        uniqueid varchar(255),
        PRIMARY KEY  (ID),
          KEY name (name)
  ) $charset_collate; ";
  dbDelta( $sql_create_table3 );



}


// function to changes styling of pop-up preview at the bottom of step 2 below the text editors
function targetpop_step2_style_changes_javascript(){
  ?>
  <script type="text/javascript" >
  "use strict";
  jQuery(document).ready(function($) {

    
    // Listener for the Border-Style drop-down
    $(document).on("change","#targetpop-step2-styling-border", function(event){

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#targetpop-template-inner-bones').attr('style');
      var borderwidth = $('#targetpop-step2-styling-border-px').val();
      var bordercolor = '#'+$('#targetpop-colorpicker6-step2').val();
      var newborder = $(this).val();

      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('border:')){ // If existing style has a border property already set by the UI (Not by the initial stylesheet)
          existbefore = existingstyle.substr(0, existingstyle.indexOf('border:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('border:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 

          if(newborder == 'No Border'){ // If switching to 'No Border'
            $('#targetpop-template-inner-bones').attr('style', existbefore+existafter+'border: none !important;');
          } else {
            $('#targetpop-template-inner-bones').attr('style', existbefore+existafter+' border: '+newborder+' '+borderwidth+'px '+bordercolor+'!important;');
          }

        } else { // If there hasn't bee a border set by the UI but there is other existing styling
          if(newborder == 'No Border'){ // If switching to 'No Border'
            $('#targetpop-template-inner-bones').attr('style', existingstyle+'border: none !important;');
          } else {
            $('#targetpop-template-inner-bones').attr('style', existingstyle+'; border: '+newborder+' '+borderwidth+'px '+bordercolor+'!important;');
          }
        }
      } else { // No Existing Style at all
        if(newborder == 'No Border'){// If switching to 'No Border'
          $('#targetpop-template-inner-bones').attr('style', 'border: none !important;');
        } else {
          $('#targetpop-template-inner-bones').attr('style', ' border: '+newborder+' '+borderwidth+'px '+bordercolor+'!important;');
        }
      }

    });

    // Listener for the border-width input
    $(document).on("change","#targetpop-step2-styling-border-px", function(event){


      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#targetpop-template-inner-bones').attr('style');
      var borderwidth = $(this).val()
      var bordercolor = '#'+$('#targetpop-colorpicker6-step2').val();
      var newborder = $('#targetpop-step2-styling-border').val();

      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('border:')){ // If existing style has a border property already set by the UI (Not by the initial stylesheet)
          existbefore = existingstyle.substr(0, existingstyle.indexOf('border:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('border:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 

          if(newborder == 'No Border'){ // If switching to 'No Border'
            $('#targetpop-template-inner-bones').attr('style', existbefore+existafter+'border: none !important;');
          } else {
            $('#targetpop-template-inner-bones').attr('style', existbefore+existafter+' border: '+newborder+' '+borderwidth+'px '+bordercolor+'!important;');
          }

        } else { // If there hasn't bee a border set by the UI but there is other existing styling
          if(newborder == 'No Border'){ // If switching to 'No Border'
            $('#targetpop-template-inner-bones').attr('style', existingstyle+'border: none !important;');
          } else {
            $('#targetpop-template-inner-bones').attr('style', existingstyle+'; border: '+newborder+' '+borderwidth+'px '+bordercolor+'!important;');
          }
        }
      } else { // No Existing Style at all
        if(newborder == 'No Border'){// If switching to 'No Border'
          $('#targetpop-template-inner-bones').attr('style', 'border: none !important;');
        } else {
          $('#targetpop-template-inner-bones').attr('style', ' border: '+newborder+' '+borderwidth+'px '+bordercolor+'!important;');
        }
      }
    });

    // Listener for the border-color input
    $(document).on("change","#targetpop-colorpicker6-step2", function(event){


      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#targetpop-template-inner-bones').attr('style');
      var borderwidth = $('#targetpop-step2-styling-border-px').val()
      var bordercolor = '#'+$('#targetpop-colorpicker6-step2').val();
      var newborder = $('#targetpop-step2-styling-border').val();

      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('border:')){ // If existing style has a border property already set by the UI (Not by the initial stylesheet)
          existbefore = existingstyle.substr(0, existingstyle.indexOf('border:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('border:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 

          if(newborder == 'No Border'){ // If switching to 'No Border'
            $('#targetpop-template-inner-bones').attr('style', existbefore+existafter+'border: none !important;');
          } else {
            $('#targetpop-template-inner-bones').attr('style', existbefore+existafter+' border: '+newborder+' '+borderwidth+'px '+bordercolor+'!important;');
          }

        } else { // If there hasn't bee a border set by the UI but there is other existing styling
          if(newborder == 'No Border'){ // If switching to 'No Border'
            $('#targetpop-template-inner-bones').attr('style', existingstyle+'border: none !important;');
          } else {
            $('#targetpop-template-inner-bones').attr('style', existingstyle+'; border: '+newborder+' '+borderwidth+'px '+bordercolor+'!important;');
          }
        }
      } else { // No Existing Style at all
        if(newborder == 'No Border'){// If switching to 'No Border'
          $('#targetpop-template-inner-bones').attr('style', 'border: none !important;');
        } else {
          $('#targetpop-template-inner-bones').attr('style', ' border: '+newborder+' '+borderwidth+'px '+bordercolor+'!important;');
        }
      }
    });

    // Listener for the Border-Radius input
    $(document).on("change","#targetpop-step2-styling-border-radius-px", function(event){

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#targetpop-template-inner-bones').attr('style');
      var newborderradiuspx = $('#targetpop-step2-styling-border-radius-px').val();


      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('border-radius:')){ 
          existbefore = existingstyle.substr(0, existingstyle.indexOf('border-radius:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('border-radius:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 
          $('#targetpop-template-inner-bones, #targetpop-step2-template-bones-div').attr('style', existbefore+existafter+' border-radius: '+newborderradiuspx+'px!important;');

        } else { // If there hasn't been a border-radius set by the UI...
            $('#targetpop-template-inner-bones, #targetpop-step2-template-bones-div').attr('style', existingstyle+'; border-radius: '+newborderradiuspx+'px!important;');
        } 
      } else {
          $('#targetpop-template-inner-bones, #targetpop-step2-template-bones-div').attr('style', 'border-radius: '+newborderradiuspx+'px!important;');
      }
    });
    

    // Listener for Color 1
    $(document).on("change","#targetpop-colorpicker1-step2", function(event){
      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#targetpop-template-top-banner').attr('style');
      var newbackgroundcolor = '#'+$(this).val();


      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('background-color:')){ 
          existbefore = existingstyle.substr(0, existingstyle.indexOf('background-color:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('background-color:')); 
          if(existingstyle.includes('important')){ 
            //existafter = existafter.substr(existafter.indexOf('important')+10); 
          }
          $('#targetpop-template-top-banner').attr('style', existbefore+existafter+' background-color: '+newbackgroundcolor+'!important;');
        } else { // If there hasn't been a border-radius set by the UI...
            $('#targetpop-template-top-banner').attr('style', existingstyle+'; background-color: '+newbackgroundcolor+'!important;');
        } 
      } else {
          $('#targetpop-template-top-banner').attr('style', 'background-color: '+newbackgroundcolor+'!important;');
      }
     
    });

    // Listener for Color2
    $(document).on("change","#targetpop-colorpicker2-step2", function(event){
      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#targetpop-template-body').attr('style');
      var newbackgroundcolor = '#'+$(this).val();


      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('background-color:')){ 
          existbefore = existingstyle.substr(0, existingstyle.indexOf('background-color:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('background-color:')); 
          if(existingstyle.includes('important')){ 
            //existafter = existafter.substr(existafter.indexOf('important')+10); 
          }
          $('#targetpop-template-body, #targetpop-template-top-banner').attr('style', existbefore+existafter+' background-color: '+newbackgroundcolor+'!important;');
        } else { // If there hasn't been a border-radius set by the UI...
            $('#targetpop-template-body, #targetpop-template-top-banner').attr('style', existingstyle+'; background-color: '+newbackgroundcolor+'!important;');
        } 
      } else {
          $('#targetpop-template-body, #targetpop-template-top-banner').attr('style', 'background-color: '+newbackgroundcolor+'!important;');
      }
    });
  
    // Listener for body padding top
    $(document).on("change","#targetpop-step2-styling-padding-body-top", function(event){

      var popuptype = '';
      var idtomod = '';
      // Getting popup type and template
      $('.targetpop-create-checkbox').each(function(){
        if($(this).prop('checked') == true){
          popuptype = $(this).attr('id');
        }
      })
      switch(popuptype) {
        case 'targetpop-create-type-plain-html':
          idtomod = 'targetpop-template-body';
            break;
        case 'targetpop-create-type-page-or-post':
          idtomod = 'targetpop-template-top-banner';
            break;
        default:
      }

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#'+idtomod).attr('style');
      var padtop = $('#targetpop-step2-styling-padding-body-top').val();
      var padbottom = $('#targetpop-step2-styling-padding-body-bottom').val();
      var padleft = $('#targetpop-step2-styling-padding-body-left').val();
      var padright = $('#targetpop-step2-styling-padding-body-right').val();

      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('padding:')){ // If existing style has a padding property already set by the UI (Not by the initial stylesheet)
          existbefore = existingstyle.substr(0, existingstyle.indexOf('padding:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('padding:')); 
          if(existafter.includes('important')){
            //existafter = existafter.substr(existafter.indexOf('important')+10); 
          }
          $('#'+idtomod).attr('style', existbefore+existafter+' padding: '+padtop+'px '+padright+'px '+padbottom+'px '+padleft+'px!important;');

        } else { // If there hasn't been a text-shadow set by the UI but there is other existing styling
          $('#'+idtomod).attr('style', existingstyle+' padding: '+padtop+'px '+padright+'px '+padbottom+'px '+padleft+'px!important;');
          
        }
      } else { // No Existing Style at all
        $('#'+idtomod).attr('style', ' padding: '+padtop+'px '+padright+'px '+padbottom+'px '+padleft+'px!important;');
        
      }
    });

    // Listener for body padding bottom
    $(document).on("change","#targetpop-step2-styling-padding-body-bottom", function(event){

      var popuptype = '';
      var idtomod = '';
      // Getting popup type and template
      $('.targetpop-create-checkbox').each(function(){
        if($(this).prop('checked') == true){
          popuptype = $(this).attr('id');
        }
      })
      switch(popuptype) {
        case 'targetpop-create-type-plain-html':
          idtomod = 'targetpop-template-body';
            break;
        case 'targetpop-create-type-page-or-post':
          idtomod = 'targetpop-template-top-banner';
            break;
        default:
      }

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#'+idtomod).attr('style');
      var padtop = $('#targetpop-step2-styling-padding-body-top').val();
      var padbottom = $('#targetpop-step2-styling-padding-body-bottom').val();
      var padleft = $('#targetpop-step2-styling-padding-body-left').val();
      var padright = $('#targetpop-step2-styling-padding-body-right').val();

      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('padding:')){ // If existing style has a padding property already set by the UI (Not by the initial stylesheet)
          existbefore = existingstyle.substr(0, existingstyle.indexOf('padding:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('padding:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 
          $('#'+idtomod).attr('style', existbefore+existafter+' padding: '+padtop+'px '+padright+'px '+padbottom+'px '+padleft+'px!important;');

        } else { // If there hasn't been a text-shadow set by the UI but there is other existing styling
          $('#'+idtomod).attr('style', existingstyle+' padding: '+padtop+'px '+padright+'px '+padbottom+'px '+padleft+'px!important;');
          
        }
      } else { // No Existing Style at all
        $('#'+idtomod).attr('style', ' padding: '+padtop+'px '+padright+'px '+padbottom+'px '+padleft+'px!important;');
        
      }
    });

    // Listener for body padding left
    $(document).on("change","#targetpop-step2-styling-padding-body-left", function(event){

      var popuptype = '';
      var idtomod = '';
      // Getting popup type and template
      $('.targetpop-create-checkbox').each(function(){
        if($(this).prop('checked') == true){
          popuptype = $(this).attr('id');
        }
      })
      switch(popuptype) {
        case 'targetpop-create-type-plain-html':
          idtomod = 'targetpop-template-body';
            break;
        case 'targetpop-create-type-page-or-post':
          idtomod = 'targetpop-template-top-banner';
            break;
        default:
      }

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#'+idtomod).attr('style');
      var padtop = $('#targetpop-step2-styling-padding-body-top').val();
      var padbottom = $('#targetpop-step2-styling-padding-body-bottom').val();
      var padleft = $('#targetpop-step2-styling-padding-body-left').val();
      var padright = $('#targetpop-step2-styling-padding-body-right').val();

      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('padding:')){ // If existing style has a padding property already set by the UI (Not by the initial stylesheet)
          existbefore = existingstyle.substr(0, existingstyle.indexOf('padding:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('padding:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 
          $('#'+idtomod).attr('style', existbefore+existafter+' padding: '+padtop+'px '+padright+'px '+padbottom+'px '+padleft+'px!important;');

        } else { // If there hasn't been a text-shadow set by the UI but there is other existing styling
          $('#'+idtomod).attr('style', existingstyle+' padding: '+padtop+'px '+padright+'px '+padbottom+'px '+padleft+'px!important;');
          
        }
      } else { // No Existing Style at all
        $('#'+idtomod).attr('style', ' padding: '+padtop+'px '+padright+'px '+padbottom+'px '+padleft+'px!important;');
        
      }
    });

    // Listener for body padding right
    $(document).on("change","#targetpop-step2-styling-padding-body-right", function(event){

      var popuptype = '';
      var idtomod = '';
      // Getting popup type and template
      $('.targetpop-create-checkbox').each(function(){
        if($(this).prop('checked') == true){
          popuptype = $(this).attr('id');
        }
      })
      switch(popuptype) {
        case 'targetpop-create-type-plain-html':
          idtomod = 'targetpop-template-body';
            break;
        case 'targetpop-create-type-page-or-post':
          idtomod = 'targetpop-template-top-banner';
            break;
        default:
      }

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#'+idtomod).attr('style');
      var padtop = $('#targetpop-step2-styling-padding-body-top').val();
      var padbottom = $('#targetpop-step2-styling-padding-body-bottom').val();
      var padleft = $('#targetpop-step2-styling-padding-body-left').val();
      var padright = $('#targetpop-step2-styling-padding-body-right').val();

      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('padding:')){ // If existing style has a padding property already set by the UI (Not by the initial stylesheet)
          existbefore = existingstyle.substr(0, existingstyle.indexOf('padding:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('padding:')); 
          if(existafter.includes('important')){
           // //existafter = existafter.substr(existafter.indexOf('important')+10); 
          }
          $('#'+idtomod).attr('style', existbefore+existafter+' padding: '+padtop+'px '+padright+'px '+padbottom+'px '+padleft+'px!important;');

        } else { // If there hasn't been a text-shadow set by the UI but there is other existing styling
          $('#'+idtomod).attr('style', existingstyle+' padding: '+padtop+'px '+padright+'px '+padbottom+'px '+padleft+'px!important;');
          
        }
      } else { // No Existing Style at all
        $('#'+idtomod).attr('style', ' padding: '+padtop+'px '+padright+'px '+padbottom+'px '+padleft+'px!important;');
        
      }
    });

    // Listener for Box-Shadow Type
    $(document).on("change","#targetpop-step2-styling-box-shadow-type", function(event){

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#targetpop-template-body').attr('style');
      var type = $('#targetpop-step2-styling-box-shadow-type').val();
      var boxx = $('#targetpop-step2-styling-box-shadow-x').val();
      var boxy = $('#targetpop-step2-styling-box-shadow-y').val();
      var blur = $('#targetpop-step2-styling-box-shadow-blur').val();
      var spread = $('#targetpop-step2-styling-box-shadow-spread').val();
      var color = '#'+$('#targetpop-colorpicker3-step2').val();

      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('box-shadow:')){ // If existing style has a box-shadow property already set by the UI (Not by the initial stylesheet)
          existbefore = existingstyle.substr(0, existingstyle.indexOf('box-shadow:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('box-shadow:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 

          if(type == 'Outset'){ // If switching to 'Outset'
            $('#targetpop-template-body').attr('style', existbefore+existafter+' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          } else {
            $('#targetpop-template-body').attr('style', existbefore+existafter+' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          }

        } else { // If there hasn't been a box-shadow set by the UI but there is other existing styling
          if(type == 'Outset'){ // If switching to 'Outset'
            $('#targetpop-template-body').attr('style', existingstyle+' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          } else {
            $('#targetpop-template-body').attr('style', existingstyle+' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          }
        }
      } else { // No Existing Style at all
        if(type == 'Outset'){ // If switching to 'Outset'
          $('#targetpop-template-body').attr('style', ' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
        } else {
          $('#targetpop-template-body').attr('style', ' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
        }
      }

    });

    // Listener for Box-Shadow X
    $(document).on("change","#targetpop-step2-styling-box-shadow-x", function(event){

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#targetpop-template-body').attr('style');
      var type = $('#targetpop-step2-styling-box-shadow-type').val();
      var boxx = $('#targetpop-step2-styling-box-shadow-x').val();
      var boxy = $('#targetpop-step2-styling-box-shadow-y').val();
      var blur = $('#targetpop-step2-styling-box-shadow-blur').val();
      var spread = $('#targetpop-step2-styling-box-shadow-spread').val();
      var color = '#'+$('#targetpop-colorpicker3-step2').val();

      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('box-shadow:')){ // If existing style has a box-shadow property already set by the UI (Not by the initial stylesheet)
          existbefore = existingstyle.substr(0, existingstyle.indexOf('box-shadow:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('box-shadow:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 

          if(type == 'Outset'){ // If switching to 'Outset'
            $('#targetpop-template-body').attr('style', existbefore+existafter+' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          } else {
            $('#targetpop-template-body').attr('style', existbefore+existafter+' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          }

        } else { // If there hasn't been a box-shadow set by the UI but there is other existing styling
          if(type == 'Outset'){ // If switching to 'Outset'
            $('#targetpop-template-body').attr('style', existingstyle+' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          } else {
            $('#targetpop-template-body').attr('style', existingstyle+' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          }
        }
      } else { // No Existing Style at all
        if(type == 'Outset'){ // If switching to 'Outset'
          $('#targetpop-template-body').attr('style', ' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
        } else {
          $('#targetpop-template-body').attr('style', ' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
        }
      }

    });

    // Listener for Box-Shadow Y
    $(document).on("change","#targetpop-step2-styling-box-shadow-y", function(event){

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#targetpop-template-body').attr('style');
      var type = $('#targetpop-step2-styling-box-shadow-type').val();
      var boxx = $('#targetpop-step2-styling-box-shadow-x').val();
      var boxy = $('#targetpop-step2-styling-box-shadow-y').val();
      var blur = $('#targetpop-step2-styling-box-shadow-blur').val();
      var spread = $('#targetpop-step2-styling-box-shadow-spread').val();
      var color = '#'+$('#targetpop-colorpicker3-step2').val();

      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('box-shadow:')){ // If existing style has a box-shadow property already set by the UI (Not by the initial stylesheet)
          existbefore = existingstyle.substr(0, existingstyle.indexOf('box-shadow:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('box-shadow:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 

          if(type == 'Outset'){ // If switching to 'Outset'
            $('#targetpop-template-body').attr('style', existbefore+existafter+' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          } else {
            $('#targetpop-template-body').attr('style', existbefore+existafter+' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          }

        } else { // If there hasn't been a box-shadow set by the UI but there is other existing styling
          if(type == 'Outset'){ // If switching to 'Outset'
            $('#targetpop-template-body').attr('style', existingstyle+' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          } else {
            $('#targetpop-template-body').attr('style', existingstyle+' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          }
        }
      } else { // No Existing Style at all
        if(type == 'Outset'){ // If switching to 'Outset'
          $('#targetpop-template-body').attr('style', ' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
        } else {
          $('#targetpop-template-body').attr('style', ' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
        }
      }

    });

    // Listener for Box-Shadow Blur
    $(document).on("change","#targetpop-step2-styling-box-shadow-blur", function(event){

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#targetpop-template-body').attr('style');
      var type = $('#targetpop-step2-styling-box-shadow-type').val();
      var boxx = $('#targetpop-step2-styling-box-shadow-x').val();
      var boxy = $('#targetpop-step2-styling-box-shadow-y').val();
      var blur = $('#targetpop-step2-styling-box-shadow-blur').val();
      var spread = $('#targetpop-step2-styling-box-shadow-spread').val();
      var color = '#'+$('#targetpop-colorpicker3-step2').val();

      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('box-shadow:')){ // If existing style has a box-shadow property already set by the UI (Not by the initial stylesheet)
          existbefore = existingstyle.substr(0, existingstyle.indexOf('box-shadow:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('box-shadow:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 

          if(type == 'Outset'){ // If switching to 'Outset'
            $('#targetpop-template-body').attr('style', existbefore+existafter+' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          } else {
            $('#targetpop-template-body').attr('style', existbefore+existafter+' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          }

        } else { // If there hasn't been a box-shadow set by the UI but there is other existing styling
          if(type == 'Outset'){ // If switching to 'Outset'
            $('#targetpop-template-body').attr('style', existingstyle+' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          } else {
            $('#targetpop-template-body').attr('style', existingstyle+' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          }
        }
      } else { // No Existing Style at all
        if(type == 'Outset'){ // If switching to 'Outset'
          $('#targetpop-template-body').attr('style', ' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
        } else {
          $('#targetpop-template-body').attr('style', ' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
        }
      }
    });

    // Listener for Box-Shadow spread
    $(document).on("change","#targetpop-step2-styling-box-shadow-spread", function(event){

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#targetpop-template-body').attr('style');
      var type = $('#targetpop-step2-styling-box-shadow-type').val();
      var boxx = $('#targetpop-step2-styling-box-shadow-x').val();
      var boxy = $('#targetpop-step2-styling-box-shadow-y').val();
      var blur = $('#targetpop-step2-styling-box-shadow-blur').val();
      var spread = $('#targetpop-step2-styling-box-shadow-spread').val();
      var color = '#'+$('#targetpop-colorpicker3-step2').val();

      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('box-shadow:')){ // If existing style has a box-shadow property already set by the UI (Not by the initial stylesheet)
          existbefore = existingstyle.substr(0, existingstyle.indexOf('box-shadow:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('box-shadow:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 

          if(type == 'Outset'){ // If switching to 'Outset'
            $('#targetpop-template-body').attr('style', existbefore+existafter+' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          } else {
            $('#targetpop-template-body').attr('style', existbefore+existafter+' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          }

        } else { // If there hasn't been a box-shadow set by the UI but there is other existing styling
          if(type == 'Outset'){ // If switching to 'Outset'
            $('#targetpop-template-body').attr('style', existingstyle+' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          } else {
            $('#targetpop-template-body').attr('style', existingstyle+' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          }
        }
      } else { // No Existing Style at all
        if(type == 'Outset'){ // If switching to 'Outset'
          $('#targetpop-template-body').attr('style', ' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
        } else {
          $('#targetpop-template-body').attr('style', ' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
        }
      }

    });

    // Listener for Box-Shadow color
    $(document).on("change","#targetpop-colorpicker3-step2", function(event){

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#targetpop-template-body').attr('style');
      var type = $('#targetpop-step2-styling-box-shadow-type').val();
      var boxx = $('#targetpop-step2-styling-box-shadow-x').val();
      var boxy = $('#targetpop-step2-styling-box-shadow-y').val();
      var blur = $('#targetpop-step2-styling-box-shadow-blur').val();
      var spread = $('#targetpop-step2-styling-box-shadow-spread').val();
      var color = '#'+$('#targetpop-colorpicker3-step2').val();

      // If there is an existing style
      if(existingstyle != undefined){
        if(existingstyle.includes('box-shadow:')){ // If existing style has a box-shadow property already set by the UI (Not by the initial stylesheet)
          existbefore = existingstyle.substr(0, existingstyle.indexOf('box-shadow:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('box-shadow:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 

          if(type == 'Outset'){ // If switching to 'Outset'
            $('#targetpop-template-body').attr('style', existbefore+existafter+' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          } else {
            $('#targetpop-template-body').attr('style', existbefore+existafter+' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          }

        } else { // If there hasn't been a box-shadow set by the UI but there is other existing styling
          if(type == 'Outset'){ // If switching to 'Outset'
            $('#targetpop-template-body').attr('style', existingstyle+' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          } else {
            $('#targetpop-template-body').attr('style', existingstyle+' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
          }
        }
      } else { // No Existing Style at all
        if(type == 'Outset'){ // If switching to 'Outset'
          $('#targetpop-template-body').attr('style', ' box-shadow: '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
        } else {
          $('#targetpop-template-body').attr('style', ' box-shadow: '+type+' '+boxx+'px '+boxy+'px '+blur+'px '+spread+'px '+color+'!important;');
        }
      }

    });

  
    // Listener for Body Text-Shadow X
    $(document).on("change","#targetpop-step2-styling-text-shadow-body-x", function(event){

      var popuptype = '';
      var idtomod = '';
      // Getting popup type and template
      $('.targetpop-create-checkbox').each(function(){
        if($(this).prop('checked') == true){
          popuptype = $(this).attr('id');
        }
      })
      switch(popuptype) {
        case 'targetpop-create-type-plain-html':
          idtomod = 'targetpop-template-body';
            break;
        case 'targetpop-create-type-page-or-post':
          idtomod = 'targetpop-template-top-banner';
            break;
        default:
      }

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#'+idtomod).attr('style');
      var textx = $('#targetpop-step2-styling-text-shadow-body-x').val();
      var texty = $('#targetpop-step2-styling-text-shadow-body-y').val();
      var blur = $('#targetpop-step2-styling-text-shadow-body-blur').val();
      var color = '#'+$('#targetpop-colorpicker5-step2').val();

      // If there is an existing style
      if(existingstyle != undefined){
        
        if(existingstyle.includes('text-shadow:')){ // If existing style has a text-shadow property already set by the UI (Not by the initial stylesheet)
          
          existbefore = existingstyle.substr(0, existingstyle.indexOf('text-shadow:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('text-shadow:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 
          
          $('#'+idtomod).attr('style', existbefore+existafter+' text-shadow: '+textx+'px '+texty+'px '+blur+'px '+color+'!important;');

        } else { // If there hasn't been a text-shadow set by the UI but there is other existing styling
          $('#'+idtomod).attr('style', existingstyle+' text-shadow: '+textx+'px '+texty+'px '+blur+'px '+color+'!important;');
          
        }
      } else { // No Existing Style at all
        $('#'+idtomod).attr('style', ' text-shadow: '+textx+'px '+texty+'px '+blur+'px '+color+'!important;');
        
      }
    });

    // Listener for Body Text-Shadow Y
    $(document).on("change","#targetpop-step2-styling-text-shadow-body-y", function(event){

      var popuptype = '';
      var idtomod = '';
      // Getting popup type and template
      $('.targetpop-create-checkbox').each(function(){
        if($(this).prop('checked') == true){
          popuptype = $(this).attr('id');
        }
      })
      switch(popuptype) {
        case 'targetpop-create-type-plain-html':
          idtomod = 'targetpop-template-body';
            break;
        case 'targetpop-create-type-page-or-post':
          idtomod = 'targetpop-template-top-banner';
            break;
        default:
      }

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#'+idtomod).attr('style');
      var textx = $('#targetpop-step2-styling-text-shadow-body-x').val();
      var texty = $('#targetpop-step2-styling-text-shadow-body-y').val();
      var blur = $('#targetpop-step2-styling-text-shadow-body-blur').val();
      var color = '#'+$('#targetpop-colorpicker5-step2').val();

      // If there is an existing style
      if(existingstyle != undefined){
        
        if(existingstyle.includes('text-shadow:')){ // If existing style has a text-shadow property already set by the UI (Not by the initial stylesheet)
          
          existbefore = existingstyle.substr(0, existingstyle.indexOf('text-shadow:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('text-shadow:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 
          
          $('#'+idtomod).attr('style', existbefore+existafter+' text-shadow: '+textx+'px '+texty+'px '+blur+'px '+color+'!important;');

        } else { // If there hasn't been a text-shadow set by the UI but there is other existing styling
          $('#'+idtomod).attr('style', existingstyle+' text-shadow: '+textx+'px '+texty+'px '+blur+'px '+color+'!important;');
          
        }
      } else { // No Existing Style at all
        $('#'+idtomod).attr('style', ' text-shadow: '+textx+'px '+texty+'px '+blur+'px '+color+'!important;');
        
      }
    });

    // Listener for Body Text-Shadow blur
    $(document).on("change","#targetpop-step2-styling-text-shadow-body-blur", function(event){

      var popuptype = '';
      var idtomod = '';
      // Getting popup type and template
      $('.targetpop-create-checkbox').each(function(){
        if($(this).prop('checked') == true){
          popuptype = $(this).attr('id');
        }
      })
      switch(popuptype) {
        case 'targetpop-create-type-plain-html':
          idtomod = 'targetpop-template-body';
            break;
        case 'targetpop-create-type-page-or-post':
          idtomod = 'targetpop-template-top-banner';
            break;
        default:
      }

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#'+idtomod).attr('style');
      var textx = $('#targetpop-step2-styling-text-shadow-body-x').val();
      var texty = $('#targetpop-step2-styling-text-shadow-body-y').val();
      var blur = $('#targetpop-step2-styling-text-shadow-body-blur').val();
      var color = '#'+$('#targetpop-colorpicker5-step2').val();

      // If there is an existing style
      if(existingstyle != undefined){
        
        if(existingstyle.includes('text-shadow:')){ // If existing style has a text-shadow property already set by the UI (Not by the initial stylesheet)
          
          existbefore = existingstyle.substr(0, existingstyle.indexOf('text-shadow:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('text-shadow:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 
          
          $('#'+idtomod).attr('style', existbefore+existafter+' text-shadow: '+textx+'px '+texty+'px '+blur+'px '+color+'!important;');

        } else { // If there hasn't been a text-shadow set by the UI but there is other existing styling
          $('#'+idtomod).attr('style', existingstyle+' text-shadow: '+textx+'px '+texty+'px '+blur+'px '+color+'!important;');
          
        }
      } else { // No Existing Style at all
        $('#'+idtomod).attr('style', ' text-shadow: '+textx+'px '+texty+'px '+blur+'px '+color+'!important;');
        
      }
    });

    // Listener for Body Text-Shadow color
    $(document).on("change","#targetpop-colorpicker5-step2", function(event){

      var popuptype = '';
      var idtomod = '';
      // Getting popup type and template
      $('.targetpop-create-checkbox').each(function(){
        if($(this).prop('checked') == true){
          popuptype = $(this).attr('id');
        }
      })
      switch(popuptype) {
        case 'targetpop-create-type-plain-html':
          idtomod = 'targetpop-template-body';
            break;
        case 'targetpop-create-type-page-or-post':
          idtomod = 'targetpop-template-top-banner';
            break;
        default:
      }

      var existbefore = '';
      var existafter = '';
      var existingstyle = $('#'+idtomod).attr('style');
      var textx = $('#targetpop-step2-styling-text-shadow-body-x').val();
      var texty = $('#targetpop-step2-styling-text-shadow-body-y').val();
      var blur = $('#targetpop-step2-styling-text-shadow-body-blur').val();
      var color = '#'+$('#targetpop-colorpicker5-step2').val();

      // If there is an existing style
      if(existingstyle != undefined){
        
        if(existingstyle.includes('text-shadow:')){ // If existing style has a text-shadow property already set by the UI (Not by the initial stylesheet)
          
          existbefore = existingstyle.substr(0, existingstyle.indexOf('text-shadow:')); 
          existafter = existingstyle.substr(existingstyle.indexOf('text-shadow:')); 
          //existafter = existafter.substr(existafter.indexOf('important')+10); 
          
          $('#'+idtomod).attr('style', existbefore+existafter+' text-shadow: '+textx+'px '+texty+'px '+blur+'px '+color+'!important;');

        } else { // If there hasn't been a text-shadow set by the UI but there is other existing styling
          $('#'+idtomod).attr('style', existingstyle+' text-shadow: '+textx+'px '+texty+'px '+blur+'px '+color+'!important;');
          
        }
      } else { // No Existing Style at all
        $('#'+idtomod).attr('style', ' text-shadow: '+textx+'px '+texty+'px '+blur+'px '+color+'!important;');
        
      }
    });

  });

  </script>
  <?php
}





function targetpop_jre_admin_pointers_javascript(){
    wp_enqueue_style( 'wp-pointer' );
    wp_enqueue_script( 'wp-pointer' );
    wp_enqueue_script( 'utils' ); // for user settings
  ?>
  <script type="text/javascript" >
  "use strict";
  jQuery(document).ready(function($) {

    

    // Clicking on 'Approve Checked Comments' button
    $('body').on('mouseenter', ".targetpop-icon-image", function () {
      var label = $(this).attr('data-label');
      var pointer;

      switch(label) {
        case 'emailsubscribe':
            pointer = $(this).pointer({
              content: '<h3>E-Mail/Subscriptions</h3><p class="targetpop-admin-pointer">Choose this Pop-Up type if you need a way to gain subscribers and capture the E-Mail addresses of your visitors.',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'plaintexthtml':
            pointer = $(this).pointer({
              content: '<h3>Plain Text/HTML</h3><p class="targetpop-admin-pointer">Choose this Pop-Up type if you need a way to display some text or HTML to your visitors - from something as simple as "Thanks for visiting!", to something as lengthy as the entire contents of the novel <span style="font-style:italic;">War and Peace</span>. This Pop-Up type also supports the use of Shortcodes.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'pageorpost':
            pointer = $(this).pointer({
              content: '<h3>Page or Post</h3><p class="targetpop-admin-pointer">Choose this Pop-Up type to show your visitors some of your most recent Posts - displays the Post Title, Featured Image, and the Excerpt.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'imagegallery':
            pointer = $(this).pointer({
              content: '<h3>Image Gallery</h3><p class="targetpop-admin-pointer">Choose this Pop-Up type if you have a series of images to show your visitors. This differs from the \'Slideshow\' Pop-Up type in that the visitors can navigate through the photos manually. Use this to feature a new product for sale, photos of your brick-and-mortar storefront, or maybe just some pictures from the family summer vacation!</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'externalwebsite':
            pointer = $(this).pointer({
              content: '<h3>External Website</h3><p class="targetpop-admin-pointer">Choose this Pop-Up type if there\'s a different website you\'d like to show your visitors - could be utilized to advertise a businesss partner\'s website, a company that sells accessories for your product, or to provide additional information on a subject, like a particular Wikipedia page. </p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'internalurl':
            pointer = $(this).pointer({
              content: '<h3>Optimize Database Tables</h3><p class="targetpop-admin-pointer">Use this Pop-Up type if you\'d like to display a specific page on your website to your visitors. This differs from the \'Page or Post\' Pop-Up type in that this will embed the actual Page inside the Pop-Up, as opposed to simply displaying the content of that Page.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'singleimagewithlink':
            pointer = $(this).pointer({
              content: '<h3>Single Image With Link</h3><p class="targetpop-admin-pointer">Choose this Pop-Up if you\'d like to display one simple Image as a link to your visitors. The visitor will be directed to the link when clicking on the image. Utilize this to advertise a Sale, a specifc product, or a coupon.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'video':
            pointer = $(this).pointer({
              content: '<h3>Video</h3><p class="targetpop-admin-pointer">Use this Pop-Up Type if you\'d like to embed a video in a Pop-Up to show to your visitors. Perfect for a short video review or demonstration of a product, or simply as a way to say thanks after a visitor makes a purchase or reads a particular Post.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'slideshow':
            pointer = $(this).pointer({
              content: '<h3>Slideshow</h3><p class="targetpop-admin-pointer">Choose this Pop-Up type if you have multiple images to show your visitors. This differs from the \'Image Gallery\' Pop-Up type in that this will automatically begin cycling through the images you\'ve selected.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'emailcapture':
            pointer = $(this).pointer({
              content: '<h3>E-Mail Capture</h3><p class="targetpop-admin-pointer">Choose this Pop-Up type if you need a way to capture a visitor\'s E-Mail Address. Could be used as a way to generate newsletter subscribers, let visitors know when a certain product or Post is available, or as a way to inform your visitors of breaking news.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'namethispopup':
            pointer = $(this).pointer({
              content: '<h3>Name This Pop-Up</h3><p class="targetpop-admin-pointer">This one is pretty straight-forward: simply choose a name for this Pop-Up. This is for administrative purposes only - the name won\'t be displayed anywhere your website visitors can see it.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'popuptemplate':
            pointer = $(this).pointer({
              content: '<h3>Choose a Template</h3><p class="targetpop-admin-pointer">Here you can choose which template you\'d like to use for this Pop-Up. Templates change the look-and-feel of your Pop-Ups and how the content is displayed within. Get more Templates from http://targetpop.io</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'popupheight':
            pointer = $(this).pointer({
              content: '<h3>E-Mail Capture</h3><p class="targetpop-admin-pointer">Set the height of the Pop-Up here. Either input a percentage (this is a percentage of the screen width - so a Pop-Up with a height of 50% would be roughly half as tall as your display), or check the \'Auto Height\' checkbox to set the Height and Width to adjust automatically depending on the content of the Pop-Up.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'popupwidth':
            pointer = $(this).pointer({
              content: '<h3>E-Mail Capture</h3><p class="targetpop-admin-pointer">Set the width of the Pop-Up here. Either input a percentage (this is a percentage of the screen width - so a Pop-Up with a width of 50% would be roughly half as wide as your display), or check the \'Auto Width\' checkbox to set the Height and Width to adjust automatically depending on the content of the Pop-Up.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'popupcloseswhen':
            pointer = $(this).pointer({
              content: '<h3>E-Mail Capture</h3><p class="targetpop-admin-pointer">Choose which action the visitor must take to close the Pop-Up. Choosing \'All of the Above\' will give the visitor more options to easily dismiss your Pop-Up, but that also means they might pay less attention to it by dismissing it before viewing the contents.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'setbackdropcolor':
            pointer = $(this).pointer({
              content: '<h3>E-Mail Capture</h3><p class="targetpop-admin-pointer">Here is where you can set what color the background will transition to when the Pop-Up opens. Typically this is a dark-gray to a lighter-black color, but TargetPop supports whatever color you prefer.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'apperancedelay':
            pointer = $(this).pointer({
              content: '<h3>E-Mail Capture</h3><p class="targetpop-admin-pointer">Set the amount of seconds to wait before displaying the Pop-Up after it has been triggered. For example, say you want a pop-up to appear 30 seconds after a user visits a certain page - you\'d input the number 30 here. </p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'trackstatistics':
            pointer = $(this).pointer({
              content: '<h3>E-Mail Capture</h3><p class="targetpop-admin-pointer">Choose whether or not you want to track this Pop-Up\'s stats - this includes things such as amount of times triggered, average time of day it\'s triggered, which day of the week this is triggered the most, etc. Check out the stats for your Pop-Ups on the \'Statistics\' page.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'disableonmobile':
            pointer = $(this).pointer({
              content: '<h3>Disable on Mobile</h3><p class="targetpop-admin-pointer">By default, TargetPop will display your Pop-Ups on mobile devices, but here you can choose to disable this behavior. Disabling mobile Pop-Ups might result in a better user experience for those visitors to your site with smaller mobile devices.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'assignatrigger':
            pointer = $(this).pointer({
              content: '<h3>Assign a Trigger</h3><p class="targetpop-admin-pointer">You\'ll need to decide under what conditions you want this Pop-Up to appear to your visitors. By default, TargetPop will display a Pop-Up after a visitor has viewed a page for at least 20 seconds, but you can create tons of different and creative triggers for any occasion and circumstance over on the "Triggers" menu page of TargetPop. </p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'border':
            pointer = $(this).pointer({
              content: '<h3>Border</h3><p class="targetpop-admin-pointer">Here you can set the Border Style, Border Color, and Border Width in Pixels. Be sure to see your changes live in the preview above and by hovering over the blue \'Preview This Pop-Up\' button to your right.</p>',
              position: {
                  edge: 'left',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'borderradius':
            pointer = $(this).pointer({
              content: '<h3>Border Radius</h3><p class="targetpop-admin-pointer">Here you can set the Border Radius of your Pop-Up. Basically this controls how rounded the corners of your Pop-Up are. The higher the number, the more rounded. Be sure to see your changes live in the preview above and by hovering over the blue \'Preview This Pop-Up\' button to your right.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'color1':
            pointer = $(this).pointer({
              content: '<h3>Color 1</h3><p class="targetpop-admin-pointer">Here you can set the Color of the Header area. Pretty self-explainatory.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'color2':
            pointer = $(this).pointer({
              content: '<h3>Color 2</h3><p class="targetpop-admin-pointer">Here you can set the Background Color of the Pop-up. Pretty self-explainatory.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'boxshadow':
            pointer = $(this).pointer({
              content: '<h3>Box-Shadow</h3><p class="targetpop-admin-pointer">See the faint dark blur along the edges of the Pop-Up preview above? That\'s what we call a "Box-Shadow". Use the 6 Inputs here to modify that Box-Shadow. The first drop-down box controls whether the Box-Shadow exists inside or outside of the Pop-Up area. The next 2 boxes control the Vertical and Horizontal positioning. The next two after those control how "Blurry" the Box-Shadow is and how far it "Spreads." The one after that is the Color of the Box-Shadow.<br/></br>Clear as mud right??? <img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smile.svg"></p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'headertextshadow':
            pointer = $(this).pointer({
              content: '<h3>Header Text-Shadow</h3><p class="targetpop-admin-pointer">See the faint dark blur outlining the <em>"Place Header Content Here!"</em> text in the Pop-Up preview above? That\'s what we call a "Text-Shadow". Use the 4 Inputs here to modify that Text-Shadow. The first 2 boxes control the Vertical and Horizontal positioning. The next one controls how "Blurry" the Text-Shadow is, and the one after that is the color of the Text-Shadow. <br/></br>Got all that??? <img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smile.svg"></p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'bodytextshadow':
            pointer = $(this).pointer({
              content: '<h3>Text-Shadow</h3><p class="targetpop-admin-pointer">See the faint dark blur outlining the <em>"Place Header Content Here!"</em> text in the Pop-Up preview above? That\'s what we call a "Text-Shadow". Use the 4 Inputs here to add a Text-Shadow to the Body Area. The first 2 boxes control the Vertical and Horizontal positioning. The next one controls how "Blurry" the Text-Shadow is, and the one after that is the color of the Text-Shadow. <br/></br>Easy enough, right??? <img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smile.svg"></p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'headerpadding':
            pointer = $(this).pointer({
              content: '<h3>Header Padding</h3><p class="targetpop-admin-pointer">Here you can set the Padding of the Header area. Padding is essentially a space between the inside edge of a container and where it\'s content begins. This is used to prevent the contents from running up against the edge of it\'s container. The first two inputs set the Vertical and Horizontal Padding, and the next two set the Left and Right padding. <br/></br>Easy enough, right??? <img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smile.svg"></p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'bodypadding':
            pointer = $(this).pointer({
              content: '<h3>Padding</h3><p class="targetpop-admin-pointer">Here you can set the Padding for your Pop-Up. Padding is essentially a space between the inside edge of a container and where it\'s content begins. This is used to prevent the contents from running up against the edge of it\'s container. The first two inputs set the Vertical and Horizontal Padding, and the next two set the Left and Right padding. <br/></br>Easy enough, right??? <img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smile.svg"></p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'transition':
            pointer = $(this).pointer({
              content: '<h3>Transition</h3><p class="targetpop-admin-pointer">Set the animation used when the Pop-Up opens and closes.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'transspeed':
            pointer = $(this).pointer({
              content: '<h3>Opening Speed</h3><p class="targetpop-admin-pointer">Here you can set how quickly the Pop-Up opens. By default, TargetPop will take 350 milliseconds to open a Pop-Up, but you can set it to take longer to open if you\'d like. This could be useful for ensuring that all content within the Pop-Up is fully loaded before displaying the Pop-Up to the Visitor, or to give your visitors a little heads-up that something is loading and that they should pay attention. Enter the speed in milliseconds (1 second is equal to 1000 milliseconds, 2.5 seconds would be 2500 milliseconds, etc.)</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'closingspeed':
            pointer = $(this).pointer({
              content: '<h3>Closing Speed</h3><p class="targetpop-admin-pointer">Similar to the Opening Speed above, here you can set how long TargetPop takes to close a Pop-Up. Enter the speed in milliseconds (1 second is equal to 1000 milliseconds, 2.5 seconds would be 2500 milliseconds, etc.)</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'slideshowspeed':
            pointer = $(this).pointer({
              content: '<h3>Slideshow Speed</h3><p class="targetpop-admin-pointer">Similar to the Opening and Closing Speed above, here you can set how long TargetPop stays on one image of an Automatic Slideshow. Enter the speed in full seconds, not in milliseconds (so for a slideshow that spends 3 seconds on each image, simply input the number 3).</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'overlayopacity':
            pointer = $(this).pointer({
              content: '<h3>Backdrop Opacity</h3><p class="targetpop-admin-pointer">Here you can set how opaque the Backdrop is. Basically, the closer to 0 it is, the more transparent it is. Likewise, if you enter a value of 100, the backdrop will be a solid color and the visitor will be unable to see any parts of your website, aside from the backdrop itself and the Pop-Up. For a completely transparent backdrop, enter 0. For a solid backdrop, enter 100. For a backdrop that is, say, 50% transparent, enter 50.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'removeclosebutton':
            pointer = $(this).pointer({
              content: '<h3>Remove Close Button</h3><p class="targetpop-admin-pointer">Here you can choose to remove the close button from the Pop-Up. Removing the close button could improve the aestetics of your Pop-Up, but will remove an obvious method for closing the Pop-Up, leaving the visitor with the option of clicking anywhere outside of the Pop-Up to close it. </p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'slideshowauto':
            pointer = $(this).pointer({
              content: '<h3>Auto-Start Slideshow</h3><p class="targetpop-admin-pointer">Here you can choose to automatically begin a slideshow once the Pop-Up finishes opening.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'action1':
            pointer = $(this).pointer({
              content: '<h3>Spends <em>X</em> Seconds on Any Page</h3><p class="targetpop-admin-pointer">The Visitor to your website must remain on any Page for a specified number of seconds before your Pop-Up will appear.</p>',
              position: {
                  edge: 'left',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'action2':
            pointer = $(this).pointer({
              content: '<h3>Spends <em>X</em> Seconds on Any Post</h3><p class="targetpop-admin-pointer">The Visitor to your website must remain on any Post for a specified number of seconds before your Pop-Up will appear.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'action3':
            pointer = $(this).pointer({
              content: '<h3>Clicks on an Internal Link</h3><p class="targetpop-admin-pointer">The Visitor to your website must click on an Internal Link (an internal link is one that links to another page or section of your website) before your Pop-Up will appear.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'action4':
            pointer = $(this).pointer({
              content: '<h3>Visits a Specific Page</h3><p class="targetpop-admin-pointer">The Visitor to your website must visit a specific Page before your Pop-Up will appear.</p>',
              position: {
                  edge: 'left',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'action5':
            pointer = $(this).pointer({
              content: '<h3>Views an Embedded Video</h3><p class="targetpop-admin-pointer">The Visitor to your website must view an embedded video (such as an embedded YouTube video) before your Pop-Up will appear.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'action6':
            pointer = $(this).pointer({
              content: '<h3>Clicks the \'Back\' Button</h3><p class="targetpop-admin-pointer">The Visitor to your website must click the \'Back\' button before your Pop-Up will appear.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'action7':
            pointer = $(this).pointer({
              content: '<h3>Scrolls down <em>X%</em> of Page/Post</h3><p class="targetpop-admin-pointer">The Visitor to your website must scroll down a certain percentage of a Page or Post before your Pop-Up will appear.</p>',
              position: {
                  edge: 'left',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'action8':
            pointer = $(this).pointer({
              content: '<h3>Spends <em>X</em> Seconds on Specific Page</h3><p class="targetpop-admin-pointer">The Visitor to your website must spend a specified number of seconds on a particular Page before your Pop-Up will appear.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'action9':
            pointer = $(this).pointer({
              content: '<h3>Spends <em>X</em> Seconds on Specific Post</h3><p class="targetpop-admin-pointer">The Visitor to your website must spend a specified number of seconds on a particular Post before your Pop-Up will appear.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'action10':
            pointer = $(this).pointer({
              content: '<h3>Clicks on an External Link</h3><p class="targetpop-admin-pointer">The Visitor to your website must click on an External Link (an external link is one that links to a completely different website from your own) before your Pop-Up will appear.</p>',
              position: {
                  edge: 'left',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'action11':
            pointer = $(this).pointer({
              content: '<h3>Visits a Specific Post</h3><p class="targetpop-admin-pointer">The Visitor to your website must visit a specific Post before your Pop-Up will appear.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'action12':
            pointer = $(this).pointer({
              content: '<h3>Leaves a Comment</h3><p class="targetpop-admin-pointer">The Visitor to your website must leave a comment before your Pop-Up will appear.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;
        case 'action13':
            pointer = $(this).pointer({
              content: '<h3>Leaves the Website</h3><p class="targetpop-admin-pointer">The Visitor to your website must intend to leave your website before your Pop-Up will appear.</p>',
              position: {
                  edge: 'right',
                  align: 'right',
              },
              close: function() {
                  //
              }
            })
            break;

        default:
            //code block
      }
      
      // open the pointer on mouseenter
      pointer.pointer('open');

      // close the pointer on mouseleave
      $('body').on('mouseleave', ".targetpop-icon-image", function () {
        pointer.pointer('close');
      });

    });
  });
  </script>
  <?php
}

function targetpop_open_popup_preview_update_data() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {

      // Append pop-up type to DOM
      $(document).on("change",".targetpop-create-checkbox", function(event){
        $(".targetpop-create-checkbox").each(function(){
          if($(this).prop('checked') == true){
            $('#targetpop-popup-preview-div').attr('data-type', $(this).attr('id'))
          }
        });
      });

      // Append pop-up plain text/HTML to DOM
      $(document).on("keyup","#targetpopeditor", function(event){
        $('#targetpop-popup-preview-div').attr('data-content', $(this).val());
      });

      // Append pop-up name to DOM
      $(document).on("keyup","#targetpop-create-popup-name", function(event){
        $('#targetpop-popup-preview-div').attr('data-name', $(this).val());
      });

      // Append pop-up template to DOM
      $(document).on("change","#targetpop-create-popup-template", function(event){
        $('#targetpop-popup-preview-div').attr('data-template', $(this).val());
      });

      // Append pop-up height to DOM
      $(document).on("change","#targetpop-height-text-input", function(event){
        $('#targetpop-popup-preview-div').attr('data-height', $(this).val());
      });

      // Append pop-up height to DOM
      $(document).on("keyup","#targetpop-height-text-input", function(event){
        $('#targetpop-popup-preview-div').attr('data-height', $(this).val());
        $('#targetpop-popup-preview-div').attr('data-autowidth', 'false');
        $('#targetpop-popup-preview-div').attr('data-autoheight', 'false');
      });

      // Append pop-up width to DOM
      $(document).on("change","#targetpop-width-text-input", function(event){
        $('#targetpop-popup-preview-div').attr('data-width', $(this).val());
        $('#targetpop-popup-preview-div').attr('data-autowidth', 'false');
        $('#targetpop-popup-preview-div').attr('data-autoheight', 'false');
      });

      // Append pop-up width to DOM
      $(document).on("keyup","#targetpop-width-text-input", function(event){
        $('#targetpop-popup-preview-div').attr('data-width', $(this).val());
      });

      // Append pop-up transition to DOM
      $(document).on("change","#targetpop-create-popup-transition", function(event){
        $('#targetpop-popup-preview-div').attr('data-transition', $(this).val().toLowerCase());
      });

      // Append pop-up transition speed to DOM
      $(document).on("change","#targetpop-trans-speed-input", function(event){
        $('#targetpop-popup-preview-div').attr('data-transspeed', $(this).val());
      });

      // Append pop-up closing speed to DOM
      $(document).on("change","#targetpop-closing-speed-input", function(event){
        $('#targetpop-popup-preview-div').attr('data-closespeed', $(this).val());
      });

      // Append pop-up slideshow speed to DOM
      $(document).on("change","#targetpop-slideshow-speed-input", function(event){
        $('#targetpop-popup-preview-div').attr('data-slidespeed', $(this).val()*1000);
      });

      // Append pop-up backdrop opacity to DOM
      $(document).on("change","#targetpop-backdrop-opacity-input", function(event){
        $('#targetpop-popup-preview-div').attr('data-backopacity', $(this).val()*0.01);
      });

      // Append pop-up auto width to DOM
      $(document).on("change","#targetpop-auto-width-checkbox", function(event){
        if($(this).prop('checked') == true){
          $('#targetpop-popup-preview-div').attr('data-autowidth', 'true');
          $('#targetpop-popup-preview-div').attr('data-autoheight', 'true');
        } else {

          if($('#targetpop-popup-preview-div').attr('data-width') != undefined){
            $('#targetpop-width-text-input').val($('#targetpop-popup-preview-div').attr('data-width'))
          }
          if($('#targetpop-popup-preview-div').attr('data-height') != undefined){
            $('#targetpop-height-text-input').val($('#targetpop-popup-preview-div').attr('data-height'))
          }

          $('#targetpop-popup-preview-div').attr('data-autowidth', 'false');
          $('#targetpop-popup-preview-div').attr('data-autoheight', 'false');
        }
      });

      // Append pop-up auto height to DOM
      $(document).on("change","#targetpop-auto-height-checkbox", function(event){
        if($(this).prop('checked') == true){
          $('#targetpop-popup-preview-div').attr('data-autoheight', 'true');
          $('#targetpop-popup-preview-div').attr('data-autowidth', 'true');
        } else {
          
          if($('#targetpop-popup-preview-div').attr('data-height') != undefined){
            $('#targetpop-height-text-input').val($('#targetpop-popup-preview-div').attr('data-height'))
          }
          if($('#targetpop-popup-preview-div').attr('data-width') != undefined){
            $('#targetpop-width-text-input').val($('#targetpop-popup-preview-div').attr('data-width'))
          }

          $('#targetpop-popup-preview-div').attr('data-autoheight', 'false');
          $('#targetpop-popup-preview-div').attr('data-autowidth', 'false');
        }
      });

      // Append pop-up close action to DOM
      $(document).on("change","#targetpop-create-popup-close-trigger", function(event){
        // Disable/Enable the 'Remove Close Button' Checkboxes
        if($(this).val() == 'Bottom X button is clicked'){
          $('#targetpop-create-popup-removecloseyes').prop('checked', false);
          $('#targetpop-create-popup-removecloseno').prop('checked', true);
          $('#targetpop-create-popup-removecloseyes').attr('disabled', true)
          $('#targetpop-create-popup-removecloseno').attr('disabled', true)
          $('#targetpop-create-popup-removecloseyes').next().css({'pointer-events':'none'})
          $('#targetpop-create-popup-removecloseno').next().css({'pointer-events':'none'})
          $('#targetpop-create-popup-removecloseyes').next().css({'opacity':'0.5'})
          $('#targetpop-create-popup-removecloseno').next().css({'opacity':'0.5'})
        }

        if($(this).val() == 'Visitor presses ESC key'){
          $('#targetpop-create-popup-removecloseyes').prop('checked', true);
          $('#targetpop-create-popup-removecloseno').prop('checked', false);
          $('#targetpop-create-popup-removecloseyes').attr('disabled', true)
          $('#targetpop-create-popup-removecloseno').attr('disabled', true)
          $('#targetpop-create-popup-removecloseyes').next().css({'pointer-events':'none'})
          $('#targetpop-create-popup-removecloseno').next().css({'pointer-events':'none'})
          $('#targetpop-create-popup-removecloseyes').next().css({'opacity':'0.5'})
          $('#targetpop-create-popup-removecloseno').next().css({'opacity':'0.5'})
        }

        if($(this).val() == 'All of the above'){
          $('#targetpop-create-popup-removecloseyes').prop('checked', false);
          $('#targetpop-create-popup-removecloseno').prop('checked', true);
          $('#targetpop-create-popup-removecloseyes').removeAttr('disabled')
          $('#targetpop-create-popup-removecloseno').removeAttr('disabled')
          $('#targetpop-create-popup-removecloseyes').next().css({'pointer-events':'all'})
          $('#targetpop-create-popup-removecloseno').next().css({'pointer-events':'all'})
          $('#targetpop-create-popup-removecloseyes').next().css({'opacity':'1'})
          $('#targetpop-create-popup-removecloseno').next().css({'opacity':'1'})
        }

        if($(this).val() == 'Visitor clicks outside of Pop-Up'){
          $('#targetpop-create-popup-removecloseyes').prop('checked', true);
          $('#targetpop-create-popup-removecloseno').prop('checked', false);
          $('#targetpop-create-popup-removecloseyes').attr('disabled', true)
          $('#targetpop-create-popup-removecloseno').attr('disabled', true)
          $('#targetpop-create-popup-removecloseyes').next().css({'pointer-events':'none'})
          $('#targetpop-create-popup-removecloseno').next().css({'pointer-events':'none'})
          $('#targetpop-create-popup-removecloseyes').next().css({'opacity':'0.5'})
          $('#targetpop-create-popup-removecloseno').next().css({'opacity':'0.5'})
        }

        $('#targetpop-popup-preview-div').attr('data-close', $(this).val());
      });

      // Append pop-up backdrop color to DOM
      $(document).on("change","#targetpop-backdropcolor-input", function(event){
        $('#targetpop-popup-preview-div').attr('data-backdrop', $(this).val());
      });

      // Append pop-up remove close button to DOM
      $(document).on("click","#targetpop-create-popup-removecloseyes", function(event){
        if($(this).prop('checked') == true){
          $('#targetpop-popup-preview-div').attr('data-removeclose', 'false');
        } else {
          $('#targetpop-popup-preview-div').removeAttr('data-removeclose');
        }
      });

      // Append pop-up remove close button to DOM
      $(document).on("click","#targetpop-create-popup-removecloseno", function(event){
        if($(this).prop('checked') == true){
          $('#targetpop-popup-preview-div').removeAttr('data-removeclose');
        }
      });
    });
    </script>
  <?php
}


// The function that adds font names to the tinyMCE drop-down
function targetpop_custom_mce_fonts( $settings ) {

    $font_formats = 'Abril Fatface=Abril Fatface;'
                  . 'Amatic SC=Amatic SC;'
                  . 'Andale Mono=andale mono,times;'
                  . 'Arial=arial,helvetica,sans-serif;'
                  . 'Arial Black=arial black,avant garde;'
                  . 'Book Antiqua=book antiqua,palatino;'
                  . 'Cinzel=Cinzel;'
                  . 'Comic Sans MS=comic sans ms,sans-serif;'
                  . 'Courier New=courier new,courier;'
                  . 'Georgia=georgia,palatino;'
                  . 'Helvetica=helvetica;'
                  . 'Impact=impact,chicago;'
                  . 'Indie Flower=Indie Flower;'
                  . 'Josefin Sans=Josefin Sans;'
                  . 'Lobster=Lobster;'
                  . 'Roboto=Roboto;'
                  . 'Sevillana=Sevillana;'
                  . 'Symbol=symbol;'
                  . 'Tahoma=tahoma,arial,helvetica,sans-serif;'
                  . 'Terminal=terminal,monaco;'
                  . 'Times New Roman=times new roman,times;'
                  . 'Trebuchet MS=trebuchet ms,geneva;'
                  . 'Ubuntu=Ubuntu;'
                  . 'Verdana=verdana,geneva;'
                  . 'Webdings=webdings;'
                  . 'Wingdings=wingdings,zapf dingbats;';

    $settings[ 'font_formats' ] = $font_formats;

    return $settings;

}

// Function that actually loads Custom/Google Fonts. 
function targetpop_custom_mce_fonts_actual() {
    $font_url = 'https://fonts.googleapis.com/css?family=Lobster|Sevillana|Ubuntu:400,700,400italic,700italic|Roboto:400,700,400italic,700italic|Indie+Flower|Josefin+Sans|Abril+Fatface|Amatic+SC|Cinzel';
    add_editor_style( str_replace( ',', '%2C', $font_url ) );
}

 // Adds the font drop-down and sizes to tinymce
function targetpop_add_fonts_size_dropdown($buttons) {
     array_unshift($buttons, 'fontselect');
     array_unshift($buttons, 'fontsizeselect');
     return $buttons;
}

function targetpop_open_popup_preview_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on("mouseenter","#targetpop-popup-preview-div", function(event){

        var previewdiv = $('#targetpop-popup-preview-div');
        var type = previewdiv.attr('data-type');
        var content = $('#targetpop-step2-template-bones-div').html();
        var name = previewdiv.attr('data-name');
        var template = previewdiv.attr('data-template');
        var height = previewdiv.attr('data-height');
        var width = previewdiv.attr('data-width');
        var autowidth = previewdiv.attr('data-autowidth');
        var autoheight = previewdiv.attr('data-autoheight');
        var close = previewdiv.attr('data-close');
        var backdrop = previewdiv.attr('data-backdrop');
        var transitionspeed = parseInt(previewdiv.attr('data-transspeed'));
        var closespeed = parseInt(previewdiv.attr('data-closespeed'));
        var slidespeed = parseInt(previewdiv.attr('data-slidespeed'));
        var transition = previewdiv.attr('data-transition');
        var backopacity = parseFloat(previewdiv.attr('data-backopacity'));
        var removeclose = previewdiv.attr('data-close');

        // If on the 'Edit & Delete Pop-Ups' page...
        if(content == undefined){
          content = $('.targetpop-edit-popup-template-container div').html();

          $('.targetpop-editpopupus-popup-row').each(function(){
            if($(this).next().css('height') != '0px'){
              var jHtmlObject = $(this).next().find('.targetpop-edit-popup-template-container').html();
              var editor = jQuery("<p>").append(jHtmlObject);

              
              editor.find(".targetpop-spinner-white").remove();
              editor.find("#wp-targetpopeditor-wrap").remove();
              editor.find("#wp-targetpopeditor2-wrap").remove();
              content = editor.html();
              return false;
            }
          })
        }

        // Setting up logic for how the pop-up will close
        var removebutton = true;
        var overlayclose = true;
        var esckey = true;
        if(removeclose != undefined && removeclose != null){
          if(removeclose == 'Visitor presses ESC key'){
            overlayclose = false;
            removebutton = false;
          }

          if(removeclose == 'Visitor clicks outside of Pop-Up'){
            removebutton = false;
            esckey = false;
          }

          if(removeclose == 'Bottom X button is clicked'){
            overlayclose = false;
            esckey = false;
          }

          if(removeclose == 'All of the above' && $('#targetpop-create-popup-removecloseyes').prop('checked') == true){
            removebutton = false;
          }
        }


        if(transition == undefined){
          transition = 'fade';
        }

        // Set color of overlay
        $('#tboxOverlay').css({'background':'#'+backdrop})

        if(autoheight == 'true' || autowidth == 'true'){
          height = 'auto';
          width = 'auto';
        } else {
          height = height+'px';
          width = width+'px';
        }


        // If the Pop-Up is an image gallery pop-up...
        if($('a.targetpop-popup-gallery-link').length > 0){
          $('a.targetpop-popup-gallery-link').targetbox({
            rel:'gal',
            transition:transition, // or Fade
            speed: transitionspeed, // Speed of transition in miliseconds,
            inline: false, // If true, content from the current document can be displayed by passing the href property (above) a jQuery selector, or jQuery object.
            open: false, // If true, targetbox opens immediately
            scalePhotos:true,
            returnFocus:true, // when closed, focus is returned to previous element
            opacity:backopacity, // Overlay/backdrop opacity level
            trapFocus:true, // keyboard input limited to targetbox when open
            scrolling:false,
            fastIframe:false, // controls when loading animation and onComplete event finish and fire
            title:false,
            preloading:true, // pre-loads the next and previous elements, say in a slideshow or gallery
            overlayClose:overlayclose, // if false, user can't close targetbox by clicking off of it
            escKey: esckey, // if false, user can't close with esc button
            arrowKey:true, // if false, will disable arrow keys for nav in targetbox
            loop:true, //If false, will disable the ability to loop back to the beginning of the group when on the last element
            data:false, // Something about GET and POST values and ajax calls, acts like jQuery load()
            className:false, // Appends a classname to overlay and targetbox
            fadeOut:closespeed, // speed of closing
            closeButton:removebutton, // set to false to remove close button
            iframe:false, //If true, specifies that content should be displayed in an iFrame.
            html:false, //for displaying string of html or text
            photo:false, //If true, this setting forces targetbox to display a link as a photo
            slideshow:false, //If true, adds automatic slideshow to content group/gallery
            slideshowSpeed:slidespeed, // speed of slideshot in milliseconds
            slideshowAuto:true, //to automatically start slideshow
            slideshowStart:"start slideshow", // text for slideshow start button 
            slideshowStop:"stop slideshow", // text for slideshow start button 
            fixed:false, //if true, targetbox will be displayed in a fixed position within the visitor's viewport
            width:width+'%',
            initialWidth:width+'%',
            top:false,
            bottom:false,
            left:false,
            right:false,
            height:height+'%',
            initialHeight:height+'%',
            onOpen:function(){

            },
            onLoad:function(){

            },
            onComplete:function(){

              // Adjust the height to fill the container just for the preview
              $('#targetbox #targetpop-template-body').css({'height':'100%'})

            },
            onCleanup:function(){

            },
            onClosed:function(){

            }
          });
          jQuery('a.targetpop-popup-gallery-link').trigger('click');
          return;
        }


        // Opening the regular generic Colorbox
        $.targetbox({
          transition:transition, // or Fade
          speed: transitionspeed, // Speed of transition in miliseconds,
          href:false, // Not positive
          inline: false, // If true, content from the current document can be displayed by passing the href property (above) a jQuery selector, or jQuery object.
          rel:false, // Not positive
          open: false, // If true, targetbox opens immediately
          scalePhotos:true,
          returnFocus:true, // when closed, focus is returned to previous element
          opacity:backopacity, // Overlay/backdrop opacity level
          trapFocus:true, // keyboard input limited to targetbox when open
          scrolling:false,
          fastIframe:false, // controls when loading animation and onComplete event finish and fire
          title:false,
          preloading:true, // pre-loads the next and previous elements, say in a slideshow or gallery
          overlayClose:overlayclose, // if false, user can't close targetbox by clicking off of it
          escKey: esckey, // if false, user can't close with esc button
          arrowKey:true, // if false, will disable arrow keys for nav in targetbox
          loop:true, //If false, will disable the ability to loop back to the beginning of the group when on the last element
          data:false, // Something about GET and POST values and ajax calls, acts like jQuery load()
          className:false, // Appends a classname to overlay and targetbox
          fadeOut:closespeed, // speed of closing
          closeButton:removebutton, // sset to false to remove close button
          iframe:false, //If true, specifies that content should be displayed in an iFrame.
          html:false, //for displaying string of html or text
          photo:false, //If true, this setting forces targetbox to display a link as a photo
          slideshow:false, //If true, adds automatic slideshow to content group/gallery
          slideshowSpeed:slidespeed, // speed of slideshot in milliseconds
          slideshowAuto:true, //to automatically start slideshow
          slideshowStart:"start slideshow", // text for slideshow start button 
          slideshowStop:"stop slideshow", // text for slideshow start button 
          fixed:false, //if true, targetbox will be displayed in a fixed position within the visitor's viewport
          width:width,
          initialWidth:width,
          top:false,
          bottom:false,
          left:false,
          right:false,
          height:height,
          initialHeight:height,
          html: content,
          onOpen:function(){

          },
          onLoad:function(){

          },
          onComplete:function(){

            // Adjust the height to fill the container just for the preview
            $('#targetbox #targetpop-template-body').css({'height':'100%'})

            // If the Pop-up type is 'Video', then start the video automatically
            if($('#targetbox #targetpop-template-video-actual').length > 0){
              $('#targetbox #targetpop-template-video-actual').get(0).load();
              $('#targetbox #targetpop-template-video-actual').get(0).play();
            } 
          },
          onCleanup:function(){

          },
          onClosed:function(){
            //Do something on close.
          },
        });
      });
      event.preventDefault ? event.preventDefault() : event.returnValue = false;
    });
  </script>
  <?php
}

// For expanding and contracting the 'Edit Trigger' rows
function targetpop_expand_cont_trigger_edit_rows_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on("click",".targetpop-edittriggers-trigger-row", function(event){

        // Reset the success div HTML content
        $('.targetpop-edit-trig-success-div').html('')
        $('.targetpop-edit-delete-trigs-arrow-img').css({'transform' : 'rotate(360deg)'});


        // Get initial height, and if it's zero, then close all other triggers and open the clicked one
        var initialHeight = $(this).next().css('height');
        if(initialHeight == '0px'){
          // Reset all heights to zero and arrows to closed
          $(this).find('.targetpop-edit-delete-trigs-arrow-img').css({'transform' : 'rotate(360deg)'});
          $('.targetpop-edittriggers-trigger-row').each(function(){
            $(this).next().animate({'height':'0px'})
          })

          $(this).find('.targetpop-edit-delete-trigs-arrow-img').css({'transform' : 'rotate(180deg)'});

          var height = $(this).next().find('.targetpop-edittrig-details-inner-container').css('height');
          height = (parseInt(height.replace('px',''))+200)+'px';
          $(this).next().animate({'height':height})
        } else {
          // Close all triggers and rotate arrow to indicate the previously-opened trigger is now closed.
          $('.targetpop-edittriggers-trigger-row').each(function(){
            $(this).next().animate({'height':'0px'})
            $(this).find('.targetpop-edit-delete-trigs-arrow-img').css({'transform' : 'rotate(360deg)'});
          })
        }
       
      });
  });
  </script>
  <?php
}



function targetpop_editpopups_expand_cont_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on("click",".targetpop-editpopupus-popup-row", function(event){

        $('.targetpop-edit-trig-success-div').html('');

        var pagetitle = $(this).attr('data-pagetitle');
        var posttitle = $(this).attr('data-posttitle');
        var initial = $(this).next().css('height');

        // Reset all html of the individual Pop-Ups
        $('.targetpop-edittrig-details-div').each(function(){
          $("#wp-targetpopeditor-wrap").detach().appendTo('#targetpop-special-for-editor');
          $("#wp-targetpopeditor2-wrap").detach().appendTo('#targetpop-special-for-editor');
          $(this).find('.targetpop-editpopupus-popup-row-id-step2-styling').html('');
          $(this).find('.targetpop-editpopupus-popup-row-id-step3-details').html('');
          $(this).find('.targetpop-editpopupus-popup-row-id-populate').html('');
          $(this).prev().find('.targetpop-edit-delete-trigs-arrow-img').css({'transform' : 'rotate(360deg)'});
        })


        if(initial == '0px'){
          $(this).find('.targetpop-edit-delete-trigs-arrow-img').css({'transform' : 'rotate(180deg)'});
        }

        if(pagetitle != ''){
          $(this).next().find('#targetpop-edit-trig-pages').val(pagetitle);
        }
        if(posttitle != ''){
          $(this).next().find('#targetpop-edit-trig-posts').val(posttitle);
        }

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}

// For opening the media library on the Pop-Up creation pages
function targetpop_add_media_image_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on('click', '#targetpop-add-more-imgs-blue', function(e) {

        var blankInput = false;
        $('.targetpop-add-img-input').each(function(){
          if($(this).val() == '' || $(this).val() == null || $(this).val() == undefined){
            blankInput = true;
          }
        })


        if(blankInput == false){
          var addoredit = $(this).attr('data-addoredit');
          var addnum = parseInt($(this).parent().prev().find('.targetpop-add-img-button').attr('data-imgnum'))+1;
          if(addoredit == 'add'){
            var newhtml = '<div id="targetpop-add-img-div-'+addnum+'" class="targetpop-add-img-div"><button style="position:relative; right:4px;" class="targetpop-add-img-button" data-imgnum="'+addnum+'">Add an Image...</button><input class="targetpop-add-img-input" id="targetpop-add-img-input-'+addnum+'" type="text"><img style="left:3px;" class="targetpop-remove-add-img-x" id="targetpop-remove-add-img-x-'+addnum+'" data-removeimgnum="'+addnum+'" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>round-delete-button.svg"/></div>';
          } else {
            var newhtml = '<div id="targetpop-add-img-div-'+addnum+'" class="targetpop-add-img-div"><button style="position:relative; right:4px;" class="targetpop-add-img-button" data-imgnum="'+addnum+'">Add an Image...</button><input class="targetpop-add-img-input" id="targetpop-add-img-input-'+addnum+'" type="text"><img style="left:3px;" class="targetpop-remove-add-img-x" id="targetpop-remove-add-img-x-'+addnum+'" data-removeimgnum="'+addnum+'" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>round-delete-button-white.svg"/></div>';
          }

          $(this).parent().before(newhtml);
        }

          //e.preventDefault();
          
      });
  });
  </script>
  <?php
}

// For removing one of the Media Library 'Image Gallery' additions
function targetpop_remove_media_image_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on('click', '.targetpop-remove-add-img-x', function(e) {

        if($('.targetpop-remove-add-img-x').length > 1){
          var num = $(this).attr('data-removeimgnum');
          $('#targetpop-popup-gallery-link-'+num).remove();
          $(this).parent().remove();
        }
          
      });
  });
  </script>
  <?php
}


// For populating the External Website preview area on the 'Create Pop-ups' page
function targetpop_external_website_populate_action_javascript() { 


  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {

      $(document).on('keyup', '#targetpop-iframe-website-url', function(e) {
        $('#targetpop-step2-ext-web-message').removeClass('targetpop-create-error');
        $('#targetpop-step2-ext-web-message').html('');
      });


      $(document).on("click","#targetpop-step2-ext-web-button-internal, #targetpop-step2-ext-web-button-external", function(event){

        var url = $('#targetpop-iframe-website-url').val();

        function isValidURL(str) {
           var a  = document.createElement('a');
           a.href = str;
           
           var tldArray = ["aaa", "aarp", "abarth", "abb", "abbott", "abbvie", "abc", "able", "abogado", "abudhabi", "ac", "academy", "accenture", "accountant", "accountants", "aco", "active", "actor", "ad", "adac", "ads", "adult", "ae", "aeg", "aero", "aetna", "af", "afamilycompany", "afl", "africa", "ag", "agakhan", "agency", "ai", "aig", "aigo", "airbus", "airforce", "airtel", "akdn", "al", "alfaromeo", "alibaba", "alipay", "allfinanz", "allstate", "ally", "alsace", "alstom", "am", "americanexpress", "americanfamily", "amex", "amfam", "amica", "amsterdam", "analytics", "android", "anquan", "anz", "ao", "aol", "apartments", "app", "apple", "aq", "aquarelle", "ar", "arab", "aramco", "archi", "army", "arpa", "art", "arte", "as", "asda", "asia", "associates", "at", "athleta", "attorney", "au", "auction", "audi", "audible", "audio", "auspost", "author", "auto", "autos", "avianca", "aw", "aws", "ax", "axa", "az", "azure", "ba", "baby", "baidu", "banamex", "bananarepublic", "band", "bank", "bar", "barcelona", "barclaycard", "barclays", "barefoot", "bargains", "baseball", "basketball", "bauhaus", "bayern", "bb", "bbc", "bbt", "bbva", "bcg", "bcn", "bd", "be", "beats", "beauty", "beer", "bentley", "berlin", "best", "bestbuy", "bet", "bf", "bg", "bh", "bharti", "bi", "bible", "bid", "bike", "bing", "bingo", "bio", "biz", "bj", "black", "blackfriday", "blanco", "blockbuster", "blog", "bloomberg", "blue", "bm", "bms", "bmw", "bn", "bnl", "bnpparibas", "bo", "boats", "boehringer", "bofa", "bom", "bond", "boo", "book", "booking", "boots", "bosch", "bostik", "boston", "bot", "boutique", "box", "br", "bradesco", "bridgestone", "broadway", "broker", "brother", "brussels", "bs", "bt", "budapest", "bugatti", "build", "builders", "business", "buy", "buzz", "bv", "bw", "by", "bz", "bzh", "ca", "cab", "cafe", "cal", "call", "calvinklein", "cam", "camera", "camp", "cancerresearch", "canon", "capetown", "capital", "capitalone", "car", "caravan", "cards", "care", "career", "careers", "cars", "cartier", "casa", "case", "caseih", "cash", "casino", "cat", "catering", "catholic", "cba", "cbn", "cbre", "cbs", "cc", "cd", "ceb", "center", "ceo", "cern", "cf", "cfa", "cfd", "cg", "ch", "chanel", "channel", "chase", "chat", "cheap", "chintai", "christmas", "chrome", "chrysler", "church", "ci", "cipriani", "circle", "cisco", "citadel", "citi", "citic", "city", "cityeats", "ck", "cl", "claims", "cleaning", "click", "clinic", "clinique", "clothing", "cloud", "club", "clubmed", "cm", "cn", "co", "coach", "codes", "coffee", "college", "cologne", "com", "comcast", "commbank", "community", "company", "compare", "computer", "comsec", "condos", "construction", "consulting", "contact", "contractors", "cooking", "cookingchannel", "cool", "coop", "corsica", "country", "coupon", "coupons", "courses", "cr", "credit", "creditcard", "creditunion", "cricket", "crown", "crs", "cruise", "cruises", "csc", "cu", "cuisinella", "cv", "cw", "cx", "cy", "cymru", "cyou", "cz", "dabur", "dad", "dance", "data", "date", "dating", "datsun", "day", "dclk", "dds", "de", "deal", "dealer", "deals", "degree", "delivery", "dell", "deloitte", "delta", "democrat", "dental", "dentist", "desi", "design", "dev", "dhl", "diamonds", "diet", "digital", "direct", "directory", "discount", "discover", "dish", "diy", "dj", "dk", "dm", "dnp", "do", "docs", "doctor", "dodge", "dog", "doha", "domains", "dot", "download", "drive", "dtv", "dubai", "duck", "dunlop", "duns", "dupont", "durban", "dvag", "dvr", "dz", "earth", "eat", "ec", "eco", "edeka", "edu", "education", "ee", "eg", "email", "emerck", "energy", "engineer", "engineering", "enterprises", "epost", "epson", "equipment", "er", "ericsson", "erni", "es", "esq", "estate", "esurance", "et", "etisalat", "eu", "eurovision", "eus", "events", "everbank", "exchange", "expert", "exposed", "express", "extraspace", "fage", "fail", "fairwinds", "faith", "family", "fan", "fans", "farm", "farmers", "fashion", "fast", "fedex", "feedback", "ferrari", "ferrero", "fi", "fiat", "fidelity", "fido", "film", "final", "finance", "financial", "fire", "firestone", "firmdale", "fish", "fishing", "fit", "fitness", "fj", "fk", "flickr", "flights", "flir", "florist", "flowers", "fly", "fm", "fo", "foo", "food", "foodnetwork", "football", "ford", "forex", "forsale", "forum", "foundation", "fox", "fr", "free", "fresenius", "frl", "frogans", "frontdoor", "frontier", "ftr", "fujitsu", "fujixerox", "fun", "fund", "furniture", "futbol", "fyi", "ga", "gal", "gallery", "gallo", "gallup", "game", "games", "gap", "garden", "gb", "gbiz", "gd", "gdn", "ge", "gea", "gent", "genting", "george", "gf", "gg", "ggee", "gh", "gi", "gift", "gifts", "gives", "giving", "gl", "glade", "glass", "gle", "global", "globo", "gm", "gmail", "gmbh", "gmo", "gmx", "gn", "godaddy", "gold", "goldpoint", "golf", "goo", "goodhands", "goodyear", "goog", "google", "gop", "got", "gov", "gp", "gq", "gr", "grainger", "graphics", "gratis", "green", "gripe", "grocery", "group", "gs", "gt", "gu", "guardian", "gucci", "guge", "guide", "guitars", "guru", "gw", "gy", "hair", "hamburg", "hangout", "haus", "hbo", "hdfc", "hdfcbank", "health", "healthcare", "help", "helsinki", "here", "hermes", "hgtv", "hiphop", "hisamitsu", "hitachi", "hiv", "hk", "hkt", "hm", "hn", "hockey", "holdings", "holiday", "homedepot", "homegoods", "homes", "homesense", "honda", "honeywell", "horse", "hospital", "host", "hosting", "hot", "hoteles", "hotels", "hotmail", "house", "how", "hr", "hsbc", "ht", "hu", "hughes", "hyatt", "hyundai", "ibm", "icbc", "ice", "icu", "id", "ie", "ieee", "ifm", "ikano", "il", "im", "imamat", "imdb", "immo", "immobilien", "in", "industries", "infiniti", "info", "ing", "ink", "institute", "insurance", "insure", "int", "intel", "international", "intuit", "investments", "io", "ipiranga", "iq", "ir", "irish", "is", "iselect", "ismaili", "ist", "istanbul", "it", "itau", "itv", "iveco", "iwc", "jaguar", "java", "jcb", "jcp", "je", "jeep", "jetzt", "jewelry", "jio", "jlc", "jll", "jm", "jmp", "jnj", "jo", "jobs", "joburg", "jot", "joy", "jp", "jpmorgan", "jprs", "juegos", "juniper", "kaufen", "kddi", "ke", "kerryhotels", "kerrylogistics", "kerryproperties", "kfh", "kg", "kh", "ki", "kia", "kim", "kinder", "kindle", "kitchen", "kiwi", "km", "kn", "koeln", "komatsu", "kosher", "kp", "kpmg", "kpn", "kr", "krd", "kred", "kuokgroup", "kw", "ky", "kyoto", "kz", "la", "lacaixa", "ladbrokes", "lamborghini", "lamer", "lancaster", "lancia", "lancome", "land", "landrover", "lanxess", "lasalle", "lat", "latino", "latrobe", "law", "lawyer", "lb", "lc", "lds", "lease", "leclerc", "lefrak", "legal", "lego", "lexus", "lgbt", "li", "liaison", "lidl", "life", "lifeinsurance", "lifestyle", "lighting", "like", "lilly", "limited", "limo", "lincoln", "linde", "link", "lipsy", "live", "living", "lixil", "lk", "loan", "loans", "locker", "locus", "loft", "lol", "london", "lotte", "lotto", "love", "lpl", "lplfinancial", "lr", "ls", "lt", "ltd", "ltda", "lu", "lundbeck", "lupin", "luxe", "luxury", "lv", "ly", "ma", "macys", "madrid", "maif", "maison", "makeup", "man", "management", "mango", "map", "market", "marketing", "markets", "marriott", "marshalls", "maserati", "mattel", "mba", "mc", "mckinsey", "md", "me", "med", "media", "meet", "melbourne", "meme", "memorial", "men", "menu", "meo", "merckmsd", "metlife", "mg", "mh", "miami", "microsoft", "mil", "mini", "mint", "mit", "mitsubishi", "mk", "ml", "mlb", "mls", "mm", "mma", "mn", "mo", "mobi", "mobile", "mobily", "moda", "moe", "moi", "mom", "monash", "money", "monster", "mopar", "mormon", "mortgage", "moscow", "moto", "motorcycles", "mov", "movie", "movistar", "mp", "mq", "mr", "ms", "msd", "mt", "mtn", "mtr", "mu", "museum", "mutual", "mv", "mw", "mx", "my", "mz", "na", "nab", "nadex", "nagoya", "name", "nationwide", "natura", "navy", "nba", "nc", "ne", "nec", "net", "netbank", "netflix", "network", "neustar", "new", "newholland", "news", "next", "nextdirect", "nexus", "nf", "nfl", "ng", "ngo", "nhk", "ni", "nico", "nike", "nikon", "ninja", "nissan", "nissay", "nl", "no", "nokia", "northwesternmutual", "norton", "now", "nowruz", "nowtv", "np", "nr", "nra", "nrw", "ntt", "nu", "nyc", "nz", "obi", "observer", "off", "office", "okinawa", "olayan", "olayangroup", "oldnavy", "ollo", "om", "omega", "one", "ong", "onl", "online", "onyourside", "ooo", "open", "oracle", "orange", "org", "organic", "origins", "osaka", "otsuka", "ott", "ovh", "pa", "page", "panasonic", "panerai", "paris", "pars", "partners", "parts", "party", "passagens", "pay", "pccw", "pe", "pet", "pf", "pfizer", "pg", "ph", "pharmacy", "phd", "philips", "phone", "photo", "photography", "photos", "physio", "piaget", "pics", "pictet", "pictures", "pid", "pin", "ping", "pink", "pioneer", "pizza", "pk", "pl", "place", "play", "playstation", "plumbing", "plus", "pm", "pn", "pnc", "pohl", "poker", "politie", "porn", "post", "pr", "pramerica", "praxi", "press", "prime", "pro", "prod", "productions", "prof", "progressive", "promo", "properties", "property", "protection", "pru", "prudential", "ps", "pt", "pub", "pw", "pwc", "py", "qa", "qpon", "quebec", "quest", "qvc", "racing", "radio", "raid", "re", "read", "realestate", "realtor", "realty", "recipes", "red", "redstone", "redumbrella", "rehab", "reise", "reisen", "reit", "reliance", "ren", "rent", "rentals", "repair", "report", "republican", "rest", "restaurant", "review", "reviews", "rexroth", "rich", "richardli", "ricoh", "rightathome", "ril", "rio", "rip", "rmit", "ro", "rocher", "rocks", "rodeo", "rogers", "room", "rs", "rsvp", "ru", "rugby", "ruhr", "run", "rw", "rwe", "ryukyu", "sa", "saarland", "safe", "safety", "sakura", "sale", "salon", "samsclub", "samsung", "sandvik", "sandvikcoromant", "sanofi", "sap", "sapo", "sarl", "sas", "save", "saxo", "sb", "sbi", "sbs", "sc", "sca", "scb", "schaeffler", "schmidt", "scholarships", "school", "schule", "schwarz", "science", "scjohnson", "scor", "scot", "sd", "se", "search", "seat", "secure", "security", "seek", "select", "sener", "services", "ses", "seven", "sew", "sex", "sexy", "sfr", "sg", "sh", "shangrila", "sharp", "shaw", "shell", "shia", "shiksha", "shoes", "shop", "shopping", "shouji", "show", "showtime", "shriram", "si", "silk", "sina", "singles", "site", "sj", "sk", "ski", "skin", "sky", "skype", "sl", "sling", "sm", "smart", "smile", "sn", "sncf", "so", "soccer", "social", "softbank", "software", "sohu", "solar", "solutions", "song", "sony", "soy", "space", "spiegel", "spot", "spreadbetting", "sr", "srl", "srt", "st", "stada", "staples", "star", "starhub", "statebank", "statefarm", "statoil", "stc", "stcgroup", "stockholm", "storage", "store", "stream", "studio", "study", "style", "su", "sucks", "supplies", "supply", "support", "surf", "surgery", "suzuki", "sv", "swatch", "swiftcover", "swiss", "sx", "sy", "sydney", "symantec", "systems", "sz", "tab", "taipei", "talk", "taobao", "target", "tatamotors", "tatar", "tattoo", "tax", "taxi", "tc", "tci", "td", "tdk", "team", "tech", "technology", "tel", "telecity", "telefonica", "temasek", "tennis", "teva", "tf", "tg", "th", "thd", "theater", "theatre", "tiaa", "tickets", "tienda", "tiffany", "tips", "tires", "tirol", "tj", "tjmaxx", "tjx", "tk", "tkmaxx", "tl", "tm", "tmall", "tn", "to", "today", "tokyo", "tools", "top", "toray", "toshiba", "total", "tours", "town", "toyota", "toys", "tr", "trade", "trading", "training", "travel", "travelchannel", "travelers", "travelersinsurance", "trust", "trv", "tt", "tube", "tui", "tunes", "tushu", "tv", "tvs", "tw", "tz", "ua", "ubank", "ubs", "uconnect", "ug", "uk", "unicom", "university", "uno", "uol", "ups", "us", "uy", "uz", "va", "vacations", "vana", "vanguard", "vc", "ve", "vegas", "ventures", "verisign", "versicherung", "vet", "vg", "vi", "viajes", "video", "vig", "viking", "villas", "vin", "vip", "virgin", "visa", "vision", "vista", "vistaprint", "viva", "vivo", "vlaanderen", "vn", "vodka", "volkswagen", "volvo", "vote", "voting", "voto", "voyage", "vu", "vuelos", "wales", "walmart", "walter", "wang", "wanggou", "warman", "watch", "watches", "weather", "weatherchannel", "webcam", "weber", "website", "wed", "wedding", "weibo", "weir", "wf", "whoswho", "wien", "wiki", "williamhill", "win", "windows", "wine", "winners", "wme", "wolterskluwer", "woodside", "work", "works", "world", "wow", "ws", "wtc", "wtf", "xbox", "xerox", "xfinity", "xihuan", "xin", "xn--11b4c3d", "xn--1ck2e1b", "xn--1qqw23a", "xn--2scrj9c", "xn--30rr7y", "xn--3bst00m", "xn--3ds443g", "xn--3e0b707e", "xn--3hcrj9c", "xn--3oq18vl8pn36a", "xn--3pxu8k", "xn--42c2d9a", "xn--45br5cyl", "xn--45brj9c", "xn--45q11c", "xn--4gbrim", "xn--54b7fta0cc", "xn--55qw42g", "xn--55qx5d", "xn--5su34j936bgsg", "xn--5tzm5g", "xn--6frz82g", "xn--6qq986b3xl", "xn--80adxhks", "xn--80ao21a", "xn--80aqecdr1a", "xn--80asehdb", "xn--80aswg", "xn--8y0a063a", "xn--90a3ac", "xn--90ae", "xn--90ais", "xn--9dbq2a", "xn--9et52u", "xn--9krt00a", "xn--b4w605ferd", "xn--bck1b9a5dre4c", "xn--c1avg", "xn--c2br7g", "xn--cck2b3b", "xn--cg4bki", "xn--clchc0ea0b2g2a9gcd", "xn--czr694b", "xn--czrs0t", "xn--czru2d", "xn--d1acj3b", "xn--d1alf", "xn--e1a4c", "xn--eckvdtc9d", "xn--efvy88h", "xn--estv75g", "xn--fct429k", "xn--fhbei", "xn--fiq228c5hs", "xn--fiq64b", "xn--fiqs8s", "xn--fiqz9s", "xn--fjq720a", "xn--flw351e", "xn--fpcrj9c3d", "xn--fzc2c9e2c", "xn--fzys8d69uvgm", "xn--g2xx48c", "xn--gckr3f0f", "xn--gecrj9c", "xn--gk3at1e", "xn--h2breg3eve", "xn--h2brj9c", "xn--h2brj9c8c", "xn--hxt814e", "xn--i1b6b1a6a2e", "xn--imr513n", "xn--io0a7i", "xn--j1aef", "xn--j1amh", "xn--j6w193g", "xn--jlq61u9w7b", "xn--jvr189m", "xn--kcrx77d1x4a", "xn--kprw13d", "xn--kpry57d", "xn--kpu716f", "xn--kput3i", "xn--l1acc", "xn--lgbbat1ad8j", "xn--mgb9awbf", "xn--mgba3a3ejt", "xn--mgba3a4f16a", "xn--mgba7c0bbn0a", "xn--mgbaakc7dvf", "xn--mgbaam7a8h", "xn--mgbab2bd", "xn--mgbai9azgqp6j", "xn--mgbayh7gpa", "xn--mgbb9fbpob", "xn--mgbbh1a", "xn--mgbbh1a71e", "xn--mgbc0a9azcg", "xn--mgbca7dzdo", "xn--mgberp4a5d4ar", "xn--mgbgu82a", "xn--mgbi4ecexp", "xn--mgbpl2fh", "xn--mgbt3dhd", "xn--mgbtx2b", "xn--mgbx4cd0ab", "xn--mix891f", "xn--mk1bu44c", "xn--mxtq1m", "xn--ngbc5azd", "xn--ngbe9e0a", "xn--ngbrx", "xn--node", "xn--nqv7f", "xn--nqv7fs00ema", "xn--nyqy26a", "xn--o3cw4h", "xn--ogbpf8fl", "xn--p1acf", "xn--p1ai", "xn--pbt977c", "xn--pgbs0dh", "xn--pssy2u", "xn--q9jyb4c", "xn--qcka1pmc", "xn--qxam", "xn--rhqv96g", "xn--rovu88b", "xn--rvc1e0am3e", "xn--s9brj9c", "xn--ses554g", "xn--t60b56a", "xn--tckwe", "xn--tiq49xqyj", "xn--unup4y", "xn--vermgensberater-ctb", "xn--vermgensberatung-pwb", "xn--vhquv", "xn--vuq861b", "xn--w4r85el8fhu5dnra", "xn--w4rs40l", "xn--wgbh1c", "xn--wgbl6a", "xn--xhq521b", "xn--xkc2al3hye2a", "xn--xkc2dl3a5ee0h", "xn--y9a3aq", "xn--yfro4i67o", "xn--ygbi2ammx", "xn--zfr164b", "xperia", "xxx", "xyz", "yachts", "yahoo", "yamaxun", "yandex", "ye", "yodobashi", "yoga", "yokohama", "you", "youtube", "yt", "yun", "za", "zappos", "zara", "zero", "zip", "zippo", "zm", "zone", "zuerich", "zw"];

          if(str.includes(window.location.host)){
            if(a.host){
              for (var i = 0; i < tldArray.length; i++) {
                if(str.includes('.'+tldArray[i])){
                  return true;
                }
              }
            }
          } else {
            if(a.host && a.host != window.location.host){
              for (var i = 0; i < tldArray.length; i++) {
                if(str.includes('.'+tldArray[i])){
                  return true;
                }
              }
            }
          }
           //return (a.host && a.host != window.location.host);;
        }


        if(isValidURL(url)){

          // Remove the www
          if(url.includes('www.')){
            url = url.replace('www.', '');
          }

          // Get the website's protocol and modify pop-up url if need be to prevent mixed content
          if(location.protocol == 'https:'){
            if(url.includes('http:')){
              url = url.replace('http:', 'https:');
            }
          }

          // Checks to make sure the URLs match the type of Pop-up the user has selected
          if($(this).attr('id') == 'targetpop-step2-ext-web-button-internal'){
            if(!url.includes(window.location.hostname)){
              $('#targetpop-step2-ext-web-message').addClass('targetpop-create-error')
              $('#targetpop-step2-ext-web-message').html('Whoa, Wait a minute! Looks like your Internal URL isn\'t actually an Internal URL! Just to be clear, we\'re looking for a URL from THIS website. Make sure the URL in the text box above contains "'+window.location.hostname+'." Maybe you meant to select "External Webpage" from the checkboxes above?<br/><img class="targetpop-frown-icon" id="targetpop-frown-icon-1" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown.svg">');
              return;
            }
          }
          if($(this).attr('id') == 'targetpop-step2-ext-web-button-external'){
            if(url.includes(window.location.hostname)){
              $('#targetpop-step2-ext-web-message').addClass('targetpop-create-error')
              $('#targetpop-step2-ext-web-message').html('Whoa, Wait a minute! Looks like your External Webpage isn\'t actually an External Webpage! Just to be clear, we\'re looking for a URL DIFFERENT from this website. Make sure the URL in the text box above does not contain "'+window.location.hostname+'." Maybe you meant to select "Internal URL" from the checkboxes above?<br/><img class="targetpop-frown-icon" id="targetpop-frown-icon-1" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown.svg">');
              return;
            }
          }

          $('#targetpop-template-iframe-actual').attr('src', url);
          $('#wpbooklist-spinner-external').animate({'opacity':1})


          $('#targetpop-template-iframe-actual').on('load', function() {
            // Append something to the iframe to make sure we've tested it
            $('#targetpop-template-iframe-actual').attr('data-tested', 'true');
            $('#wpbooklist-spinner-external').animate({'opacity':0})
          });

        } else {
          $('#targetpop-step2-ext-web-message').addClass('targetpop-create-error')
          $('#targetpop-step2-ext-web-message').html('Whoa, Wait a minute! Looks like this isn\'t a valid URL! Make sure you\'ve included the "HTTP://" or "HTTPS://" at the beginning of your URL, and the ".com", ".net", ".org", etc.<br/><img class="targetpop-frown-icon" id="targetpop-frown-icon-1" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown.svg">');
        }


        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}

// For adding the image link to the preview pop-up area
function targetpop_image_link_type_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {

      $(document).on("change","#targetpop-img-type-width", function(event){
        var width = $('#targetpop-img-type-width').val();
        $('#targetpop-template-image-link-img-actual').css({'width':width+'%'})
      });

      $(document).on("change","#targetpop-transparent-body-img-type", function(event){
        if($(this).prop('checked')){
          $('#targetpop-template-body').css({'background-color':'transparent'})
        } else {
          var color = $('#targetpop-colorpicker2-step2').val();
          $('#targetpop-template-body').css({'background-color':'#'+color})
          
        }
      });

      $(document).on("change","#targetpop-transparent-header-img-type", function(event){
        if($(this).prop('checked')){
          $('#targetpop-template-top-banner').css({'background-color':'transparent'})
        } else {
          var color = $('#targetpop-colorpicker1-step2').val();
          $('#targetpop-template-top-banner').css({'background-color':'#'+color})
          
        }
      });
      

      $(document).on("keyup","#targetpop-image-link-link", function(event){

        var url = $(this).val();
        // Get the website's protocol and modify pop-up url if need be to make an accurate link
        if( !url.includes('http:') && !url.includes('https:')){
          url = location.protocol+'//'+url;
        }

        $('#targetpop-template-image-link-link-actual').attr('href',url);

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}

/*
// For opening the media library on the Pop-Up creation page
add_action( 'admin_footer', 'targetpop_boilerplate_action_javascript' );

function targetpop_boilerplate_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on("click",".targetpop", function(event){

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}
*/

?>