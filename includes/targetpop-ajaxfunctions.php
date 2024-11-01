<?php

function targetpop_dismiss_notice_forever_action_javascript(){
?>
<script>

  jQuery("#targetpop-my-notice-dismiss-forever").click(function(){

    var data = {
      'action': 'targetpop_dismiss_notice_forever_action',
      'security': '<?php echo wp_create_nonce( "targetpop_dismiss_notice_forever_action" ); ?>',
    };

    var request = $.ajax({
      url: ajaxurl,
      type: "POST",
      data:data,
      timeout: 0,
      success: function(response) {
        document.location.reload();
      },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(errorThrown);
      console.log(textStatus);
      console.log(jqXHR);
    }
  });


  });

  </script> <?php
}

function targetpop_dismiss_notice_forever_action_callback(){
  global $wpdb; // this is how you get access to the database
  check_ajax_referer( 'targetpop_dismiss_notice_forever_action', 'security' );
  $table_name = $wpdb->prefix . 'targetpop_general_settings_log';

  $data = array(
      'admindismiss' => 0
  );
  $where = array( 'ID' => 1 );
  $format = array( '%d');  
  $where_format = array( '%d' );
  echo $wpdb->update( $table_name, $data, $where, $format, $where_format );
  wp_die();
}

function targetpop_stepone_template_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(".targetpop-create-checkbox").click(function(event){

        
        // Actions that need to be reset each time a checkbox is checked
        //console.log($('#targetpopeditor').data("events"))
        //$('#targetpopeditor').off('click')
        //$("#wp-targetpopeditor-wrap").detach().appendTo('#targetpop-special-for-editor');


        // Resetting values and whatnot
        $('.targetpop-create-checkbox').css({'pointer-events':'none'})
        $('#targetpop-create-popup-step2-div').remove();
        $('#targetpop-step2-ext-web-container').remove();
        $('#targetpop-step2-styling-div').remove();
        $('#targetpop-step2-img-gal-container').remove();
        $('#targetpop-create-popup-step3-div').remove();
        $('#targetpop-popup-preview-div').css({'pointer-events':'none'})
        $('.targetpop-spinner').animate({'opacity':'1'}, 500)

        $('#targetpop-create-popup-step2-div').remove();

        var id = $(this).attr('id');
        $('.targetpop-create-checkbox').each(function(){
          $(this).prop('checked', false);
          $('#'+id).prop('checked', true);
          $(this).prop('disabled', true);
        })

        $('#wpbooklist-spinner-1').animate({'opacity':'1'})

        // Removing existing drop-down
        var myNode = document.getElementById("targetpop-step-1-template-div");
        while (myNode.firstChild) {
            myNode.removeChild(myNode.firstChild);
        }

        var selectedPopup = $(this).prev().html();

        var data = {
          'action': 'targetpop_stepone_template_action',
          'security': '<?php echo wp_create_nonce( "targetpop_stepone_template_action_callback" ); ?>',
          'selectedPopup':selectedPopup
        };

        console.log('This is the data that was sent to the server after checking a checkbox:');
        console.log(data);

        var request = $.ajax({
          url: ajaxurl,
          type: "POST",
          data:data,
          timeout: 0,
          success: function(response) {

            $('#targetpop-step-1-template-div').append('<label>Select a Template</label><select id="targetpop-create-popup-template"><option selected="" disabled="">Select a Pop-Up Template...</option>'+response+'</select>')

            $('#wpbooklist-spinner-1').animate({'opacity':'0'})
            $('.targetpop-create-checkbox').css({'pointer-events':'all'})
            $('html, body').animate({
                scrollTop: $("#targetpop-step-1-template-div").offset().top-100
            }, 1000);

          },
          error: function(jqXHR, textStatus, errorThrown) {

          }
        });
      });
  });
  </script>
  <?php 
}

// Callback function for creating backups
function targetpop_stepone_template_action_callback(){
  global $wpdb;
  check_ajax_referer( 'targetpop_stepone_template_action_callback', 'security' );
  $selected_popup = filter_var($_POST['selectedPopup'],FILTER_SANITIZE_STRING);
  $string = '';


  switch ($selected_popup) {
    case 'E-Mail/Subscriptions':
      $uploadpath = '';
      foreach(glob(TARGETPOP_TEMPLATES_DIR.'*.*') as $filename){
        if(strpos($filename, 'email') !== false){
              $filename = basename($filename);
              $display_name = explode('-', $filename);
              $num = explode('.', $display_name[2]);
              $string = $string.'<option value="'.$filename.'">'.ucfirst($display_name[0]).' Template '.$num[0].'</option>';
          }
        }
      break;
    case 'Plain Text/HTML':
      $uploadpath = '';
      foreach(glob(TARGETPOP_TEMPLATES_DIR.'*.*') as $filename){
        if(strpos($filename, 'text') !== false){
              $filename = basename($filename);
              $display_name = explode('-', $filename);
              $num = explode('.', $display_name[2]);
              $string = $string.'<option value="'.$filename.'">'.ucfirst($display_name[0]).' Template '.$num[0].'</option>';
          }
        }
      break;
    case 'Recent Posts':
      $uploadpath = '';
      foreach(glob(TARGETPOP_TEMPLATES_DIR.'*.*') as $filename){
        if(strpos($filename, 'post') !== false){
              $filename = basename($filename);
              $display_name = explode('-', $filename);
              $num = explode('.', $display_name[2]);
              $string = $string.'<option value="'.$filename.'">'.ucfirst($display_name[0]).' Template '.$num[0].'</option>';
          }
        }
      break;
    case 'Image Gallery':
      $uploadpath = '';
      foreach(glob(TARGETPOP_TEMPLATES_DIR.'*.*') as $filename){
        if(strpos($filename, 'gallery') !== false){
              $filename = basename($filename);
              $display_name = explode('-', $filename);
              $num = explode('.', $display_name[2]);
              $string = $string.'<option value="'.$filename.'">'.ucfirst($display_name[0]).' Template '.$num[0].'</option>';
          }
        }
      break;
    case 'External Website':
      $uploadpath = '';
      foreach(glob(TARGETPOP_TEMPLATES_DIR.'*.*') as $filename){
        if(strpos($filename, 'external') !== false){
              $filename = basename($filename);
              $display_name = explode('-', $filename);
              $num = explode('.', $display_name[2]);
              $string = $string.'<option value="'.$filename.'">'.ucfirst($display_name[0]).' Template '.$num[0].'</option>';
          }
        }
      break;
    case 'Internal URL':
      $uploadpath = '';
      foreach(glob(TARGETPOP_TEMPLATES_DIR.'*.*') as $filename){
        if(strpos($filename, 'internal') !== false){
              $filename = basename($filename);
              $display_name = explode('-', $filename);
              $num = explode('.', $display_name[2]);
              $string = $string.'<option value="'.$filename.'">'.ucfirst($display_name[0]).' Template '.$num[0].'</option>';
          }
        }
      break;
    case 'Single Image w/ Link':
      $uploadpath = '';
      foreach(glob(TARGETPOP_TEMPLATES_DIR.'*.*') as $filename){
        if(strpos($filename, 'imagelink') !== false){
              $filename = basename($filename);
              $display_name = explode('-', $filename);
              $num = explode('.', $display_name[2]);
              $string = $string.'<option value="'.$filename.'">'.ucfirst($display_name[0]).' Template '.$num[0].'</option>';
          }
        }
      break;
    case 'Video':
      $uploadpath = '';
      foreach(glob(TARGETPOP_TEMPLATES_DIR.'*.*') as $filename){
        if(strpos($filename, 'video') !== false){
              $filename = basename($filename);
              $display_name = explode('-', $filename);
              $num = explode('.', $display_name[2]);
              $string = $string.'<option value="'.$filename.'">'.ucfirst($display_name[0]).' Template '.$num[0].'</option>';
          }
        }
      break;
    case 'E-Mail Capture':
      $uploadpath = '';
      foreach(glob(TARGETPOP_TEMPLATES_DIR.'*.*') as $filename){
        if(strpos($filename, 'email') !== false){
              $filename = basename($filename);
              $display_name = explode('-', $filename);
              $num = explode('.', $display_name[2]);
              $string = $string.'<option value="'.$filename.'">'.ucfirst($display_name[0]).' Template '.$num[0].'</option>';
          }
        }
      break;
    case 'Slideshow':
      $uploadpath = '';
      foreach(glob(TARGETPOP_TEMPLATES_DIR.'*.*') as $filename){
        if(strpos($filename, 'slideshow') !== false){
              $filename = basename($filename);
              $display_name = explode('-', $filename);
              $num = explode('.', $display_name[2]);
              $string = $string.'<option value="'.$filename.'">'.ucfirst($display_name[0]).' Template '.$num[0].'</option>';
          }
        }
      break;
    
    default:
      # code...
      break;
  }




  echo $string;
  wp_die();
}


function targetpop_popup_steptwo_action_javascript() {
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on("change","#targetpop-create-popup-template", function(event){

        $('#targetpop-create-popup-template').prop('disabled', true);

        // Resetting values and whatnot, calling the function to create the jscolor inputs as well
        $('#targetpop-create-popup-step2-div').remove();
        $('#targetpop-step2-styling-div').remove();
        $('#targetpop-create-popup-step3-div').remove();
        $('#targetpop-popup-preview-div').css({'pointer-events':'none'})
        $('.targetpop-spinner').animate({'opacity':'1'}, 500)
        displaypop.checkForColorInputs();

        var selectedTemplate = $(this).val();
        var selectedPopup = '';
        $('.targetpop-create-checkbox').each(function(){
          if($(this).prop('checked') == true){
            selectedPopup = $(this).prev().html();
          }
          $(this).prop('disabled', true);
        });

        $('.targetpop-create-checkbox').each(function(){
          $('#targetpop-create-popup-checkbox-div label, .targetpop-icon-image-question-create-step-1').css({'opacity':'0.3', 'pointer-events':'none'});
        })
        

        var data = {
          'action': 'targetpop_popup_steptwo_action',
          'security': '<?php echo wp_create_nonce( "targetpop_popup_steptwo_action_callback" ); ?>',
          'selectedPopup':selectedPopup,
          'selectedTemplate':selectedTemplate
        };

        console.log('This is the data that was sent to the server after selecting a template:');
        console.log(data);

        var request = $.ajax({
          url: ajaxurl,
          type: "POST",
          data:data,
          timeout: 0,
          success: function(response) {

            console.log('... and this is the response:');
            console.log(response);

            /*BEGIN VARIOUS STANDALONE JAVASCRIPT FUNCTIONS FOR EDITORS AND SHORTCODE CHECKS*/
            // Function the check for the existence of a shortcode in the content - if it exists, make ajax call to convert that shortcode to html
            function targetpop_check_for_shortcodes(content, id, templatePart){

              // Check for the existence of a shortcode
              var shortcode = content.substring(content.lastIndexOf("[")+1,content.lastIndexOf("]"));
              console.log('This is the derived shortcode without it\'s brackets:')
              console.log(shortcode)

              // If there is a shortcode, make the Ajax call
              if(shortcode != '' && shortcode != null && shortcode != undefined){

                var lastchar = content.substr(content.length - 1);
                if(lastchar == ']'){

                  var data = {
                    'action': 'targetpop_popup_steptwo_action',
                    'security': '<?php echo wp_create_nonce( "targetpop_popup_steptwo_action_callback" ); ?>',
                    'shortcode':shortcode,
                    'content':content,
                    'id':id
                  };

                  console.log('This is the data being sent to the server with the derived shortcode and the current Editor content.')
                    console.log(data)

                  var request = $.ajax({
                    url: ajaxurl,
                    type: "POST",
                    data:data,
                    timeout: 0,
                    success: function(response) {
                      response = response.split('--sep---seperator---sep--')

                      response[2] = response[2].replace('['+response[1]+']',response[0]);
                      shortcode = '['+response[1]+']';
                      var content = targetpop_get_tinymce_content2_popup_steptwo('#targetpopeditor');
                      content = content.replace(shortcode,response[0]);

                      console.log('This is the output of the shortcode, after returning from the do_shortcode function on the PHP side:')
                      console.log(response[0]);

                      // Update both the Preview and the Editor with the translated shortcode code
                      $('#'+templatePart).html(content);
                      jQuery('#targetpopeditor').val(content)
 
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                    
                          
                          
                    }
                  });
                } else {
                  $('#'+templatePart).html(content)
                }
              } else {
                $('#'+templatePart).html(content)
              }
            }

            // This function will bind the keyups/changes to the 'Text' tab of the
            function targetpop_editor_bindings_popup_steptwo(popuptype){


              if(popuptype == 'Plain Text/HTML'){
                $(document).on("keyup","#targetpopeditor", function(event){
                  var templatepart = 'targetpop-template-body';
                  var content = targetpop_get_tinymce_content2_popup_steptwo('#targetpopeditor');
                  targetpop_check_for_shortcodes(content, $(this).attr('id'), templatepart);
                });

                $(document).on("click","#targetpopeditor", function(event){
                  var templatepart = 'targetpop-template-body';
                  var content = targetpop_get_tinymce_content2_popup_steptwo('#targetpopeditor');
                  targetpop_check_for_shortcodes(content, $(this).attr('id'), templatepart);
                });
              }

              if(popuptype == 'Recent Posts'){
                $(document).on("keyup","#targetpopeditor", function(event){
                  var templatepart = 'targetpop-template-top-banner';
                  var content = targetpop_get_tinymce_content2_popup_steptwo('#targetpopeditor');
                  targetpop_check_for_shortcodes(content, $(this).attr('id'), templatepart);
                });

                $(document).on("click","#targetpopeditor", function(event){
                  var templatepart = 'targetpop-template-top-banner';
                  var content = targetpop_get_tinymce_content2_popup_steptwo('#targetpopeditor');
                  targetpop_check_for_shortcodes(content, $(this).attr('id'), templatepart);
                });
              }


            }

            function targetpop_get_tinymce_content2_popup_steptwo(id){


              if(id == '#targetpopeditor'){
                if (jQuery("#wp-targetpopeditor-wrap").hasClass("tmce-active")){
                    return tinyMCE.activeEditor.getContent();
                }else{
                    return jQuery('#targetpopeditor').val();
                }
              }

              if(id == '#targetpopeditor2'){
                if (jQuery("#wp-targetpopeditor2-wrap").hasClass("tmce-active")){
                    return tinyMCE.activeEditor.getContent();
                }else{
                    return jQuery('#targetpopeditor2').val();
                }
              }
            }

            // This function handles the binding of keyup/changes for the 'Visual' tab of the editor. This function will keep being called until the 'Visual' editor is initialized. 
            function targetpop_bindToTinyMce_2_popup_steptwo(popuptype){
              var editors = $('.wp-editor-wrap').length;
              for (var i = 0; i < tinyMCE.editors.length; i++) {

                if(popuptype == 'Plain Text/HTML'){
                  tinyMCE.editors[i].onKeyUp.add(function (ed, e) {
                    // Update HTML view textarea (that is the one used to send the data to server).
                    $('#targetpop-template-body').html(targetpop_get_tinymce_content2_popup_steptwo('#targetpopeditor'));
                  });
                  
                  tinyMCE.editors[i].onNodeChange.add(function (ed, e) {
                    // Update HTML view textarea (that is the one used to send the data to server).
                    $('#targetpop-template-body').html(targetpop_get_tinymce_content2_popup_steptwo('#targetpopeditor'));
                  });
                }

                if(popuptype == 'Recent Posts'){
                  tinyMCE.editors[i].onKeyUp.add(function (ed, e) {
                    // Update HTML view textarea (that is the one used to send the data to server).
                    $('#targetpop-template-top-banner').html(targetpop_get_tinymce_content2_popup_steptwo('#targetpopeditor'));
                  });
                  
                  tinyMCE.editors[i].onNodeChange.add(function (ed, e) {
                    // Update HTML view textarea (that is the one used to send the data to server).
                    $('#targetpop-template-top-banner').html(targetpop_get_tinymce_content2_popup_steptwo('#targetpopeditor'));
                  });
                }



              }


              if(tinyMCE.editors.length != editors){

                setTimeout(function() {
                    targetpop_bindToTinyMce_2_popup_steptwo(popuptype);
                }, 500)
              }
            };
            /*END VARIOUS STANDALONE JAVASCRIPT FUNCTIONS FOR EDITORS AND SHORTCODE CHECKS*/

            // Split up the response
            response = response.split('--sep---seperator---sep--');

            $('.targetpop-create-checkbox').each(function(){
              $(this).prop('disabled', true);
              $('#targetpop-create-popup-checkbox-div label, .targetpop-icon-image-question-create-step-1').css({'opacity':'1', 'pointer-events':'all'});
            })

            // Decoding any possible HTML Entities in the response
            var textArea = document.createElement('textarea');
            textArea.innerHTML = response[0];

            // Inserting the template into the DOM 
            $('#targetpop-create-popup-step1-div').after(textArea.value);

            // Actions specific to which checkbox was checked and what Template was selected.
            if(response[1] == 'E-Mail/Subscriptions'){

              if(selectedTemplate == 'default-email-1.html'){

                // Hide various Styling elements and controls we won't be using
                $('#targetpop-step2-box-shadow-total-row').css({'display':'none'})
                $('#targetpop-step2-body-text-shadow-total-row').css({'display':'none'})
                $('#targetpop-step2-body-padding-total-row').css({'display':'none'})

                // Add in the Image button and the Title and Subtitle input boxes
                var imgButton = '<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image targetpop-icon-img-title-img" data-label="emailimage" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>question.svg" /><label class="targetpop-email-labels" id="targetpop-email-labels-title-text">Title Text:</label><input value="This is the Title for Your Pop-Up!" class="targetpop-add-img-input" id="targetpop-email-title-input" type="text" /><br/><img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image targetpop-icon-img-subtitle-img" data-label="emailimage" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>question.svg" /><label class="targetpop-email-labels" id="targetpop-email-labels-subtitle-text">Sub-Title Text:</label><input value="This is a sub-title!" class="targetpop-add-img-input" id="targetpop-email-subtitle-input" type="text" />'

                // Register the listeners for the Title and Subtitle inputs
                $(document).on("change","#targetpop-email-title-input", function(event){
                  var newtext = $(this).val();
                  $('#targetpop-template-email-one-title').html(newtext)
                });

                // Register the listeners for the Title and Subtitle inputs
                $(document).on("change","#targetpop-email-subtitle-input", function(event){
                  var newtext = $(this).val();
                  $('#targetpop-template-email-one-subtitle').html(newtext)
                });

                // Register the listener for the Image text input
                $(document).on("change","#targetpop-add-img-email-1", function(event){
                  var newimgsrc = $(this).val();
                  $('#targetpop-template-email-one-image').attr('src', newimgsrc)
                });

                $('#targetpop-create-popup-step2-div').append('<div id="targetpop-div-for-email-popup-options">'+imgButton+'</div>')


                // Remove the editor as it's not needed
                $("#wp-targetpopeditor-wrap").detach()

                $('#targetpop-auto-height-checkbox').prop('checked', true)
                $('#targetpop-auto-width-checkbox').prop('checked', true)
                $('#targetpop-height-text-input').val('');
                $('#targetpop-width-text-input').val('');
                $('#targetpop-auto-height-checkbox').trigger('click')
                $('#targetpop-auto-width-checkbox').trigger('click')

                

              }

              if(selectedTemplate == 'default-email-2.html'){

                // Hide various Styling elements and controls we won't be using
                $('#targetpop-step2-box-shadow-total-row').css({'display':'none'})
                $('#targetpop-step2-body-text-shadow-total-row').css({'display':'none'})
                $('#targetpop-step2-body-padding-total-row').css({'display':'none'})

                // Add in the Image button and the Title and Subtitle input boxes
                var imgButton = '<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image targetpop-icon-img-title-img" data-label="emailimage" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>question.svg" /><label class="targetpop-email-labels" id="targetpop-email-labels-title-text">Title Text:</label><input value="This is the Title for Your Pop-Up!" class="targetpop-add-img-input" id="targetpop-email-title-input" type="text" /><br/><img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image targetpop-icon-img-subtitle-img" data-label="emailimage" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>question.svg" /><label class="targetpop-email-labels" id="targetpop-email-labels-subtitle-text">Sub-Title Text:</label><input value="This is a sub-title!" class="targetpop-add-img-input" id="targetpop-email-subtitle-input" type="text" /><br/><img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image targetpop-icon-img-email-img" data-label="emailimage" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>question.svg" /><button class="targetpop-add-img-button targetpop-add-img-button-email" data-imgnum="1">Add an Image...</button><input class="targetpop-add-img-input" id="targetpop-add-img-email-1" type="text" />'

                // Register the listeners for the Title and Subtitle inputs
                $(document).on("change","#targetpop-email-title-input", function(event){
                  var newtext = $(this).val();
                  $('#targetpop-template-email-one-title').html(newtext)
                });

                // Register the listeners for the Title and Subtitle inputs
                $(document).on("change","#targetpop-email-subtitle-input", function(event){
                  var newtext = $(this).val();
                  $('#targetpop-template-email-one-subtitle').html(newtext)
                });

                // Register the listener for the Image text input
                $(document).on("change","#targetpop-add-img-email-1", function(event){
                  var newimgsrc = $(this).val();
                  $('#targetpop-template-email-one-image').attr('src', newimgsrc)
                });

                $('#targetpop-create-popup-step2-div').append('<div id="targetpop-div-for-email-popup-options">'+imgButton+'</div>')


                // Remove the editor as it's not needed
                $("#wp-targetpopeditor-wrap").detach()

                $('#targetpop-height-text-input').val('460')
                $('#targetpop-height-text-input').trigger('change')

                $('#targetpop-width-text-input').val('750')
                $('#targetpop-width-text-input').trigger('change')
              }
            }

            // Actions specific to which checkbox was checked and what Template was selected.
            if(response[1] == 'Plain Text/HTML'){

              if(selectedTemplate == 'default-text-1.html' || selectedTemplate == 'default-text-2.html'){

                $("#targetpopeditor").val('Place Header Content Here!');
                $("#targetpopeditor2").val('Place Pop-Up Content Here!');

                $("#wp-targetpopeditor-wrap").detach().appendTo('#targetpop-create-popup-step2-div');
                $("#wp-targetpopeditor-wrap").css({'display':'initial'})

                $("#wp-targetpopeditor2-wrap").detach().appendTo('#targetpop-create-popup-step2-div');
                $("#wp-targetpopeditor2-wrap").css({'display':'initial'})

                targetpop_bindToTinyMce_2_popup_steptwo(response[1]);
                targetpop_editor_bindings_popup_steptwo(response[1]);
              }
            }

            // Actions specific to which checkbox was checked and what Template was selected.
            if(response[1] == 'Recent Posts'){

              if(selectedTemplate == 'default-post-1.html'){

                $("#targetpopeditor").val('Check Out Our Recent Posts');

                $("#wp-targetpopeditor-wrap").detach().appendTo('#targetpop-create-popup-step2-div');
                $("#wp-targetpopeditor-wrap").css({'display':'initial'})

                $('#targetpop-height-text-input').val('500');
                $('#targetpop-height-text-input').trigger('change');

                $('#targetpop-width-text-input').val('700');
                $('#targetpop-width-text-input').trigger('change');

                targetpop_bindToTinyMce_2_popup_steptwo(response[1]);
                targetpop_editor_bindings_popup_steptwo(response[1]);

              }
            }

            // Actions specific to which checkbox was checked and what Template was selected.
            if(response[1] == 'Image Gallery'){

              if(selectedTemplate == 'default-gallery-1.html'){

                $('#targetpop-step2-template-bones-div').css({'display':'none'})
                $('#targetpop-step2-styling-div').css({'display':'none'})
                $('#targetpop-slideshow-speed-div').css({'display':'none'})
                $('#targetpop-autostart-slideshow-row').css({'display':'none'})
              }
            }

            // Actions specific to which checkbox was checked and what Template was selected.
            if(response[1] == 'External Website'){

              if(selectedTemplate == 'default-external-1.html'){

                $('#targetpop-slideshow-speed-div').css({'display':'none'})
                $('#targetpop-autostart-slideshow-row').css({'display':'none'})
                $('#targetpop-step2-box-shadow-total-row').css({'display':'none'})
                $('#targetpop-step2-body-padding-total-row').css({'display':'none'})
                $('#targetpop-step2-body-text-shadow-total-row').css({'display':'none'})
                $('#targetpop-step2-color-2-total-row').css({'display':'none'})

                $("#targetpopeditor").val('Place Header Content Here!');

                $("#wp-targetpopeditor-wrap").detach().appendTo('#targetpop-create-popup-step2-div');
                $("#wp-targetpopeditor-wrap").css({'display':'initial'})

                targetpop_bindToTinyMce_2_popup_steptwo(response[1]);
                targetpop_editor_bindings_popup_steptwo(response[1]);
              }
            }

            // Actions specific to which checkbox was checked and what Template was selected.
            if(response[1] == 'Internal URL'){

              if(selectedTemplate == 'default-internal-1.html'){
                $('#targetpop-slideshow-speed-div').css({'display':'none'})
                $('#targetpop-autostart-slideshow-row').css({'display':'none'})
                $('#targetpop-step2-box-shadow-total-row').css({'display':'none'})
                $('#targetpop-step2-body-padding-total-row').css({'display':'none'})
                $('#targetpop-step2-body-text-shadow-total-row').css({'display':'none'})
                $('#targetpop-step2-color-2-total-row').css({'display':'none'})

                $("#targetpopeditor").val('Place Header Content Here!');

                $("#wp-targetpopeditor-wrap").detach().appendTo('#targetpop-create-popup-step2-div');
                $("#wp-targetpopeditor-wrap").css({'display':'initial'})

                targetpop_bindToTinyMce_2_popup_steptwo(response[1]);
                targetpop_editor_bindings_popup_steptwo(response[1]);
              }
            }

            // Actions specific to which checkbox was checked and what Template was selected.
            if(response[1] == 'Single Image w/ Link'){

              if(selectedTemplate == 'default-imagelink-1.html'){
                $('#targetpop-slideshow-speed-div').css({'display':'none'})
                $('#targetpop-autostart-slideshow-row').css({'display':'none'})
                $('#targetpop-step2-box-shadow-total-row').css({'display':'none'})
                $('#targetpop-step2-body-padding-total-row').css({'display':'none'})
                $('#targetpop-step2-body-text-shadow-total-row').css({'display':'none'})

                $("#targetpopeditor").val('Place Header Content Here!');

                $("#wp-targetpopeditor-wrap").detach().appendTo('#targetpop-create-popup-step2-div');
                $("#wp-targetpopeditor-wrap").css({'display':'initial'})

                targetpop_bindToTinyMce_2_popup_steptwo(response[1]);
                targetpop_editor_bindings_popup_steptwo(response[1]);
              }
            }

            // Actions specific to which checkbox was checked and what Template was selected.
            if(response[1] == 'Video'){
              if(selectedTemplate == 'default-video-1.html'){


                $("#targetpopeditor").val('Place Header Content Here!');

                $("#wp-targetpopeditor-wrap").detach().appendTo('#targetpop-create-popup-step2-div');
                $("#wp-targetpopeditor-wrap").css({'display':'initial'})

                targetpop_bindToTinyMce_2_popup_steptwo(response[1]);
                targetpop_editor_bindings_popup_steptwo(response[1]);
              }
            }

            // Setting default style values
            $('#targetpop-step2-styling-border-px').val('0');
            $('#targetpop-step2-styling-border-radius-px').val('0');
            $('#targetpop-step2-styling-border-radius-px').trigger('change');

            $('#targetpop-step2-styling-box-shadow-x').val('0');
            $('#targetpop-step2-styling-box-shadow-y').val('0');
            $('#targetpop-step2-styling-box-shadow-blur').val('0');
            $('#targetpop-step2-styling-box-shadow-spread').val('0');

            function waitForJscolor(){
              if($('#targetpop-colorpicker3-step2').length != 1){
                setTimeout(function(){
                  waitForJscolor()
                }, 2000);
              } else {
                $('#targetpop-colorpicker3-step2').val('000000');
                $('#targetpop-step2-styling-box-shadow-spread').trigger('change');
              }
            }
            waitForJscolor();

            $('#targetpop-step2-styling-padding-header-top').val('0');
            $('#targetpop-step2-styling-padding-header-bottom').val('0');
            $('#targetpop-step2-styling-padding-header-left').val('0');
            $('#targetpop-step2-styling-padding-header-right').val('0');
            $('#targetpop-step2-styling-padding-header-right').trigger('change');

            $('#targetpop-step2-styling-text-shadow-header-x').val('0');
            $('#targetpop-step2-styling-text-shadow-header-y').val('0');
            $('#targetpop-step2-styling-text-shadow-header-blur').val('0');
            function waitForJscolor2(){
              if($('#targetpop-colorpicker4-step2').length != 1){
                setTimeout(function(){
                  waitForJscolor2()
                }, 2000);
              } else {
                $('#targetpop-colorpicker4-step2').val('000000');
                $('#targetpop-step2-styling-text-shadow-header-blur').trigger('change');
              }
            }
            waitForJscolor2();

            $('#targetpop-step2-styling-padding-body-top').val('0');
            $('#targetpop-step2-styling-padding-body-bottom').val('0');
            $('#targetpop-step2-styling-padding-body-left').val('0');
            $('#targetpop-step2-styling-padding-body-right').val('0');
            $('#targetpop-step2-styling-padding-body-right').trigger('change');

            $('#targetpop-step2-styling-text-shadow-body-x').val('0');
            $('#targetpop-step2-styling-text-shadow-body-y').val('0');
            $('#targetpop-step2-styling-text-shadow-body-blur').val('0');
            $('#targetpop-step2-styling-text-shadow-body-blur').trigger('change');

            function waitForJscolor3(){
              if($('#targetpop-colorpicker5-step2').length != 1){
                setTimeout(function(){
                  waitForJscolor3()
                }, 2000);
              } else {
                $('#targetpop-colorpicker5-step2').val('000000');
                $('#targetpop-step2-styling-text-shadow-body-blur').trigger('change');

                // Get the border size from the Pop-Up preview and load into step 3
                var borderWidth = $('#targetpop-template-inner-bones').css('border');
                borderWidth = borderWidth.split(' ');
                borderWidth = borderWidth[0].replace('px', '');
                $('#targetpop-step2-styling-border-px').val(borderWidth);


                finallyDisplayStep3();

              }
            }

            // Now we display step 3 in it's entirety
            function finallyDisplayStep3(){
              $('#targetpop-create-popup-step3-div').animate({'opacity':'1'}, 2000)
              $('.targetpop-spinner').animate({'opacity':'0'}, 2000)
              $('#targetpop-popup-preview-div').animate({'opacity':'1'}, 2000)
              $('#targetpop-create-popup-step2-div').animate({'opacity':'1'}, 2000)
              $('#targetpop-step2-styling-div').animate({'opacity':'1'}, 2000);
              $('#targetpop-step2-img-gal-container').animate({'opacity':'1'}, 2000);
              $('#targetpop-popup-preview-div').css({'pointer-events':'all'})

              $('html, body').animate({
                  scrollTop: $("#targetpop-create-popup-step2-div").offset().top-100
              }, 1000);
            }

            // Call this to display the final jscolor, and once that happens, this function will call the finallyDisplayStep3 function
            waitForJscolor3();

            // This code enables the Image Gallery button for the Image Gallery Pop-Up Type
          if ($('.targetpop-add-img-button').length > 0) {
            if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
                $(document).on('click', '.targetpop-add-img-button', function(e) {
                    e.preventDefault();
                    var button = $(this);
                    var id = button.prev();
                    var idpart = button.attr('data-imgnum');
                    wp.media.editor.send.attachment = function(props, attachment) {


                      // Populate the Pop-Up preview if the Pop-Up type is 'VIDEO' 
                      if($('#targetpop-template-video-div').length > 0){
                        $('#targetpop-incorrect-video-div').remove();

                        if(attachment.subtype == 'mp4' || attachment.subtype == 'webm' || attachment.subtype == 'ogg'){
                          $('#targetpop-template-video-actual').animate({'opacity':'1'})
                          $('#targetpop-template-video-tag').attr('src', attachment.url);
                          $('#targetpop-template-video-actual').get(0).load();
                           //$('#'+videoID).attr('poster', newposter); //Change video poster
                          $('#targetpop-template-video-actual').get(0).play();
                        } else {
                          $('#targetpop-template-video-actual').animate({'opacity':'0'})
                          $('#targetpop-add-img-div-1').append('<div id="targetpop-incorrect-video-div">Uh-Oh! Looks like you\'ve selected a video file that your browser is unable to play! Please select a video file with the \'.mp4\', \'.webm\', or \'.ogg\' extension type. <img class="targetpop-frown-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown.svg"></div>')
                        }
                      }
                

                      // Populate the Pop-Up preview if the Pop-Up type is 'Single image w/ Link' 
                      if($('#targetpop-template-image-link-img-actual').length > 0){
                        $('#targetpop-template-image-link-img-actual').attr('src',attachment.url)
                        $('#targetpop-template-image-link-img-actual').animate({'opacity':'1'}, 2000)
                      }

                      // Populate the Pop-Up preview if the Pop-Up type is 'E-Mail/Subscription' 
                      if($('#targetpop-template-email-one-image').length > 0){
                        $('#targetpop-template-email-one-image').attr('src',attachment.url)
                        $('#targetpop-add-img-email-1').val(attachment.url)
                      }

                      $('#targetpop-add-img-input-'+idpart).val(attachment.url);
                      var count = $('.targetpop-popup-gallery-link').length;
                      var newhtml = "<a style='display:none;opacity:0;' class='targetpop-popup-gallery-link' id='targetpop-popup-gallery-link-"+(parseInt(count)+1)+"' data-imgnumhiddenlink='"+(parseInt(count)+1)+"' href='"+attachment.url+"'>test</a>";
                    $('#targetpop-add-more-imgs-blue').before(newhtml);
                    jQuery('a.targetpop-popup-gallery-link').targetbox()


                    };
                    wp.media.editor.open(button);
                    return false;
                });
            }
          }

          },
        error: function(jqXHR, textStatus, errorThrown) {
          
                
                


                $('.targetpop-create-checkbox').each(function(){
              $(this).prop('checked', false);
              $(this).prop('disabled', true);
              $('#targetpop-create-popup-checkbox-div label, .targetpop-icon-image-question-create-step-1').css({'opacity':'0.3', 'pointer-events':'none'});
            })
            $('.targetpop-spinner').animate({'opacity':'1'}, 0)
        }
      });

      });
  });
  </script>
  <?php
}

// Callback function for creating backups
function targetpop_popup_steptwo_action_callback(){
  global $wpdb;
  check_ajax_referer( 'targetpop_popup_steptwo_action_callback', 'security' );
  $selected_popup = filter_var($_POST['selectedPopup'],FILTER_SANITIZE_STRING);
  $selected_template = filter_var($_POST['selectedTemplate'],FILTER_SANITIZE_STRING);

  if(isset($_POST['shortcode'])){
    $shortcode = filter_var($_POST['shortcode'],FILTER_SANITIZE_STRING);
    $shortcode = str_replace('&#34;', '"', $shortcode);
    $shortcode = stripslashes($shortcode);
    $id = filter_var($_POST['id'],FILTER_SANITIZE_STRING);
    $content = filter_var($_POST['content'],FILTER_SANITIZE_STRING);
    $content = str_replace('&#34;', '"', $content);
    $content = stripslashes($content);
    error_log('SHORTCODE IS: '.$shortcode);
    echo $shortcode_output = do_shortcode('['.$shortcode.']').'--sep---seperator---sep--'.$shortcode.'--sep---seperator---sep--'.$content.'--sep---seperator---sep--'.$id.'--sep---seperator---sep--'.$shortcode;
  } else {
    require_once(TARGETPOP_CLASSES_UI_DISPLAY_DIR.'class-create-pop-up-form.php');
    // Instantiate the class
    $form = new TargetPop_Create_Pop_Up_Form($selected_popup, $selected_template);
    echo '--sep---seperator---sep--'.$selected_popup;
  }
  
  



  wp_die();
}

function targetpop_create_popup_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {

      // Setting up proper checkbox behavior for things in step 3
      $(document).on("click","#targetpop-auto-height-checkbox", function(event){
        if($(this).prop('checked') == true){
          $('#targetpop-auto-width-checkbox').prop('checked', true)
          $('#targetpop-height-text-input').val('')
          $('#targetpop-height-text-input').prop('disabled', true)
          $('#targetpop-width-text-input').val('')
          $('#targetpop-width-text-input').prop('disabled', true)
        } else {
          $('#targetpop-auto-width-checkbox').prop('checked', false)
          $('#targetpop-height-text-input').prop('disabled', false)
          $('#targetpop-width-text-input').prop('disabled', false)
        }
      });
      // Setting up proper checkbox behavior for things in step 3
      $(document).on("click","#targetpop-auto-width-checkbox", function(event){
        if($(this).prop('checked') == true){
          $('#targetpop-auto-height-checkbox').prop('checked', true)
          $('#targetpop-height-text-input').val('')
          $('#targetpop-height-text-input').prop('disabled', true)
          $('#targetpop-width-text-input').val('')
          $('#targetpop-width-text-input').prop('disabled', true)
        } else {
          $('#targetpop-auto-height-checkbox').prop('checked', false)
          $('#targetpop-height-text-input').prop('disabled', false)
          $('#targetpop-width-text-input').prop('disabled', false)
        }
      });
      // Setting up proper checkbox behavior for things in step 3
      $(document).on("click","#targetpop-create-popup-trackyes", function(event){
        if($(this).prop('checked') == true){
          $('#targetpop-create-popup-trackno').prop('checked', false)
        }
      });
      // Setting up proper checkbox behavior for things in step 3
      $(document).on("click","#targetpop-create-popup-trackno", function(event){
        if($(this).prop('checked') == true){
          $('#targetpop-create-popup-trackyes').prop('checked', false)
        }
      });
      // Setting up proper checkbox behavior for things in step 3
      $(document).on("click","#targetpop-create-popup-disablemobileyes", function(event){
        if($(this).prop('checked') == true){
          $('#targetpop-create-popup-disablemobileno').prop('checked', false)
        }
      });
      // Setting up proper checkbox behavior for things in step 3
      $(document).on("click","#targetpop-create-popup-disablemobileno", function(event){
        if($(this).prop('checked') == true){
          $('#targetpop-create-popup-disablemobileyes').prop('checked', false)
        }
      });
      // Setting up proper checkbox behavior for things in step 3
      $(document).on("click","#targetpop-create-popup-removecloseno", function(event){
        if($(this).prop('checked') == true){
          $('#targetpop-create-popup-removecloseyes').prop('checked', false)
        }
      });
      // Setting up proper checkbox behavior for things in step 3
      $(document).on("click","#targetpop-create-popup-removecloseyes", function(event){
        if($(this).prop('checked') == true){
          $('#targetpop-create-popup-removecloseno').prop('checked', false)
          if($('#targetpop-create-popup-close-trigger').val() == "Bottom 'X' button is clicked"){
            $('#targetpop-create-popup-close-trigger').val('Visitor clicks outside of Pop-Up')
          }
        }
      });
      // Setting up proper checkbox behavior for things in step 3
      $(document).on("click","#targetpop-create-popup-removecloseno", function(event){
        if($(this).prop('checked') == true){
          $('#targetpop-create-popup-removecloseyes').prop('checked', false)
        }
      });
      // Setting up proper checkbox behavior for things in step 3
      $(document).on("click","#targetpop-create-popup-startslideyes", function(event){
        if($(this).prop('checked') == true){
          $('#targetpop-create-popup-startslideno').prop('checked', false)
        }
      });
      // Setting up proper checkbox behavior for things in step 3
      $(document).on("click","#targetpop-create-popup-startslideno", function(event){
        if($(this).prop('checked') == true){
          $('#targetpop-create-popup-startslideyes').prop('checked', false)
        }
      });



      $(document).on("click","#targetpop-create-popup-button, .targetpop-editpopup-edit-button", function(event){

        var popupuid = '';
        if( $(this).attr('class') == 'targetpop-editpopup-edit-button' ){
          popupuid = $(this).attr('data-popupuid');
        }

        // Reset some UI elements
        $('.targetpop-results-div').removeClass('targetpop-create-error');
        $('.targetpop-results-div').html('');

        $('#targetpop-results-div').removeClass('targetpop-create-error');
        $('#targetpop-results-div').html('');

        // Defining variables
        var popuptype = '';
        var contenttext = '';
        var contenthtml = '';
        var popupname = '';
        var popuptemplate = '';
        var popupheight = 0;
        var popupautoheight = true;
        var popupwidth = 0;
        var popupautowidth = true;
        var popuptransition = '';
        var popupopenspeed = 350;
        var popupclosingspeed = 350;
        var popupslidespeed = 2500;
        var popupclosetrigger = '';
        var popupopenspeed = 350;
        var popuptrigger = '';
        var popupbackdropcolor = '';
        var popupbackdropopacity = 0.85;
        var popupappeardelay = 0;
        var popupmobile = true;
        var popupremoveclose = true;
        var popuptrackstats = false;
        var popupslideauto = true;
        var goforinitial = false;

        var popupborder1 = 0;
        var popupborder2 = 0;
        var popupborder3 = 0;
        var popupborderradius = 0;
        var popupcolor1 = 0;
        var popupcolor2 = 0;
        var popupboxshadow1 = 0;
        var popupboxshadow2 = 0;
        var popupboxshadow3 = 0;
        var popupboxshadow4 = 0;
        var popupboxshadow5 = 0;
        var popupboxshadow6 = 0;
        var popupheadertextshadow1 = 0;
        var popupheadertextshadow2 = 0;
        var popupheadertextshadow3 = 0;
        var popupheadertextshadow4 = 0;
        var popupbodytextshadow1 = 0;
        var popupbodytextshadow2 = 0;
        var popupbodytextshadow3 = 0;
        var popupbodytextshadow4 = 0;
        var popupbodyheaderpadding1 = 0;
        var popupbodyheaderpadding2 = 0;
        var popupbodyheaderpadding3 = 0;
        var popupbodyheaderpadding4 = 0;
        var popupbodybodypadding1 = 0;
        var popupbodybodypadding2 = 0;
        var popupbodybodypadding3 = 0;
        var popupbodybodypadding4 = 0;

        var popupstylestring = '';

        // Getting pop-up type by it's ID
        $('.targetpop-create-checkbox').each(function(){
          if($(this).prop('checked') == true){
            popuptype = $(this).attr('id');
          }
        })

        if(popuptype == ''){
          popuptype = $(this).attr('data-popuptype');
        }

        // Getting the Content of the pop-up based on it's id
        if(popuptype == 'targetpop-create-type-plain-html'){
          contenttext = $('#targetpop-step2-template-bones-div').html();
        }

        // Getting the Content of the pop-up based on it's id
        if(popuptype == 'targetpop-create-type-page-or-post'){
          contenttext = $('#targetpop-step2-template-bones-div').html();
        }

        if(popuptype == 'targetpop-create-type-gallery'){
          // If user hasn't actually provided an image...
          if($('.targetpop-popup-gallery-link').length == 0){
            var responsediv = $('#targetpop-results-div');
            responsediv.addClass('targetpop-create-error');
            responsediv.html('Whoops! Looks like you forgot to select the images for your Image Gallery Pop-Up. Choose some images in Step 2 above and try again <img class="targetpop-frown-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown.svg">');
            responsediv.animate({'height':'70px'});
            $('.targetpop-spinner-white').animate({'opacity':'0'})
            $('#wpbooklist-spinner-2').animate({'opacity':'0'})
            return;
          } else {
            $('.targetpop-popup-gallery-link').each(function(index){
                contenttext = contenttext+','+$('.targetpop-popup-gallery-link')[index].outerHTML;
            })
            contenttext = contenttext.replace(',', '');
          } 
        }

        // Getting the Content of the pop-up based on it's id
        if(popuptype == 'targetpop-create-type-iframe'){
          contenttext = $('#targetpop-step2-template-bones-div').html();

          if($('#targetpop-template-iframe-actual').attr('data-tested') != 'true'){
            var responsediv = $('#targetpop-results-div');
            responsediv.addClass('targetpop-create-error');
            responsediv.html('Whoops! Looks like you forgot to test your URL! Enter a valid URL, click the "Test URL" button above in Step 2, and then try creating your Pop-Up again.<img class="targetpop-frown-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown.svg">');
            responsediv.animate({'height':'70px'});
            $('.targetpop-spinner').animate({'opacity':'0'})
            $('#wpbooklist-spinner').animate({'opacity':'0'})
            return;
          }

        }

        // Getting the Content of the pop-up based on it's id
        if(popuptype == 'targetpop-create-type-internal-url'){
          contenttext = $('#targetpop-step2-template-bones-div').html();

          if($('#targetpop-template-iframe-actual').attr('data-tested') != 'true'){
            var responsediv = $('#targetpop-results-div');
            responsediv.addClass('targetpop-create-error');
            responsediv.html('Whoops! Looks like you forgot to test your URL! Enter a valid URL, click the "Test URL" button above in Step 2, and then try creating your Pop-Up again.<img class="targetpop-frown-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown.svg">');
            responsediv.animate({'height':'70px'});
            $('.targetpop-spinner').animate({'opacity':'0'})
            $('#wpbooklist-spinner').animate({'opacity':'0'})
            return;
          }
        }

        // Getting the Content of the pop-up based on it's id
        if(popuptype == 'targetpop-create-type-image'){
          contenttext = $('#targetpop-step2-template-bones-div').html();
        }

        // Getting the Content of the pop-up based on it's id
        if(popuptype == 'targetpop-create-type-video'){
          contenttext = $('#targetpop-step2-template-bones-div').html();
        }

        // Getting the Content of the pop-up based on it's id
        if(popuptype == 'targetpop-create-type-email-subscribe'){
          contenttext = $('#targetpop-step2-template-bones-div').html();
        }
        
        // Getting Step 2 Styling section
        popupborder1 = $('#targetpop-step2-styling-border').val();
        popupborder2 = $('#targetpop-step2-styling-border-px').val();
        popupborder3 = $('#targetpop-colorpicker6-step2').val();
        popupborderradius = $('#targetpop-step2-styling-border-radius-px').val();
        popupcolor1 = $('#targetpop-colorpicker1-step2').val();
        popupcolor2 = $('#targetpop-colorpicker2-step2').val();
        popupboxshadow1 = $('#targetpop-step2-styling-box-shadow-type').val();
        popupboxshadow2 = $('#targetpop-step2-styling-box-shadow-x').val();
        popupboxshadow3 = $('#targetpop-step2-styling-box-shadow-y').val();
        popupboxshadow4 = $('#targetpop-step2-styling-box-shadow-blur').val();
        popupboxshadow5 = $('#targetpop-step2-styling-box-shadow-spread').val();
        popupboxshadow6 = $('#targetpop-colorpicker3-step2').val();
        popupheadertextshadow1 = $('#targetpop-step2-styling-text-shadow-header-x').val();
        popupheadertextshadow2 = $('#targetpop-step2-styling-text-shadow-header-y').val();
        popupheadertextshadow3 = $('#targetpop-step2-styling-text-shadow-header-blur').val();
        popupheadertextshadow4 = $('#targetpop-colorpicker4-step2').val();
        popupbodytextshadow1 = $('#targetpop-step2-styling-text-shadow-body-x').val();
        popupbodytextshadow2 = $('#targetpop-step2-styling-text-shadow-body-y').val();
        popupbodytextshadow3 = $('#targetpop-step2-styling-text-shadow-body-blur').val();
        popupbodytextshadow4 = $('#targetpop-colorpicker5-step2').val();
        popupbodyheaderpadding1 = $('#targetpop-step2-styling-padding-header-top').val();
        popupbodyheaderpadding2 = $('#targetpop-step2-styling-padding-header-bottom').val();
        popupbodyheaderpadding3 = $('#targetpop-step2-styling-padding-header-left').val();
        popupbodyheaderpadding4 = $('#targetpop-step2-styling-padding-header-right').val();
        popupbodybodypadding1 = $('#targetpop-step2-styling-padding-body-top').val();
        popupbodybodypadding2 = $('#targetpop-step2-styling-padding-body-bottom').val();
        popupbodybodypadding3 = $('#targetpop-step2-styling-padding-body-left').val();
        popupbodybodypadding4 = $('#targetpop-step2-styling-padding-body-right').val();

        var styleArray = [
          popupborder1,
          popupborder2,
          popupborder3,
          popupborderradius,
          popupcolor1,
          popupcolor2,
          popupboxshadow1,
          popupboxshadow2,
          popupboxshadow3,
          popupboxshadow4,
          popupboxshadow5,
          popupboxshadow6,
          popupheadertextshadow1,
          popupheadertextshadow2,
          popupheadertextshadow3,
          popupheadertextshadow4,
          popupbodytextshadow1,
          popupbodytextshadow2,
          popupbodytextshadow3,
          popupbodytextshadow4,
          popupbodyheaderpadding1,
          popupbodyheaderpadding2,
          popupbodyheaderpadding3,
          popupbodyheaderpadding4,
          popupbodybodypadding1,
          popupbodybodypadding2,
          popupbodybodypadding3,
          popupbodybodypadding4
        ];

        // Building style string
        for (var i = 0; i < styleArray.length; i++) {
          if(styleArray[i] == '' || styleArray[i] == 'undefined'){
            styleArray[i] = 0;
          }
          popupstylestring = popupstylestring+styleArray[i]+'-';
        };


        // Getting Step 3 Details section
        popupname = $('#targetpop-create-popup-name').val();
        popuptemplate = $('#targetpop-create-popup-template').val();
        popupheight = $('#targetpop-height-text-input').val();
        popupwidth = $('#targetpop-width-text-input').val();
        popupautoheight = $('#targetpop-auto-height-checkbox').prop('checked')
        popupautowidth = $('#targetpop-auto-width-checkbox').prop('checked')
        popuptransition = $('#targetpop-create-popup-transition').val();
        popupopenspeed = $('#targetpop-open-speed-input').val();
        popupclosingspeed = $('#targetpop-closing-speed-input').val();
        popupslidespeed = $('#targetpop-slideshow-speed-input').val();
        popupclosetrigger = $('#targetpop-create-popup-close-trigger').val();
        popuptrigger = $('#targetpop-create-popup-trigger').val();
        popupbackdropcolor = $('#targetpop-backdropcolor-input').val();
        popupbackdropopacity = $('#targetpop-backdrop-opacity-input').val();
        popupappeardelay = $('#targetpop-create-popup-open-delay').val();
        popupmobile = $('#targetpop-create-popup-disablemobileyes').prop('checked')
        popupremoveclose = $('#targetpop-create-popup-removecloseyes').prop('checked')
        popuptrackstats = $('#targetpop-create-popup-trackyes').prop('checked')
        popupslideauto = $('#targetpop-create-popup-startslideyes').prop('checked')

        // Special considerations for editing a pop-up
        if(popupname == undefined || popupname == ''){
          popupname = $(this).parent().parent().find('.targetpop-trig-name-trigedit-text-input').val();
        }
        if(contenttext == undefined || contenttext == ''){
          contenttext = $(this).parent().parent().find('.targetpop-edit-popup-template-container').html();
        }
        if(popuptemplate == '' || popuptemplate == undefined){
          popuptemplate = $(this).attr('data-popuptemplate');
        }
        if(popuptype == '' || popuptype == undefined){
          popuptype = $(this).attr('data-popuptype');
        }

        if(popupname == undefined){
          popupname = '';
        }

        if(contenttext == undefined){
          contenttext = '';
        }

        // Verifiying that required fields have been filled out
        if(popupname != '' && contenttext != ''){
          goforinitial = true;
        } else {
          var resultsdiv = $('#targetpop-results-div');
          var editerror = false;
          if(resultsdiv == undefined || resultsdiv.length == 0){
            editerror = true;
            resultsdiv = $(this).parent().find('.targetpop-results-div');
          }

          if(popupname == '' && contenttext == ''){
            if(editerror == true){
              resultsdiv.html('Whoa, Wait a minute! You haven\'t named this Pop-Up or provided any content! Name your Pop-Up and provide some content and then try again <img class="targetpop-frown-icon" id="targetpop-frown-icon-1" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown-white.svg">');
              resultsdiv.addClass('targetpop-edit-error');
            } else {
              resultsdiv.html('Whoa, Wait a minute! You haven\'t named this Pop-Up or provided any content! Name your Pop-Up and provide some content and then try again <img class="targetpop-frown-icon" id="targetpop-frown-icon-1" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown.svg">');
              resultsdiv.addClass('targetpop-create-error');
              resultsdiv.animate({'height':'330px'});
            }
          }

          if(popupname == '' && contenttext != ''){
            if(editerror == true){
              resultsdiv.html('Whoa, Wait a minute! You haven\'t named this Pop-Up! Name your Pop-Up and then try again <br/><img class="targetpop-frown-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown-white.svg">');
              resultsdiv.addClass('targetpop-edit-error');
            } else {
              resultsdiv.html('Whoa, Wait a minute! You haven\'t named this Pop-Up! Name your Pop-Up and then try again <br/><img class="targetpop-frown-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown.svg">');
              resultsdiv.addClass('targetpop-create-error');
              resultsdiv.animate({'height':'330px'});
            }
          }

          if(popupname != '' && contenttext == ''){
            if(editerror == true){
              resultsdiv.html('Whoa, Wait a minute! You haven\'t provided any content for this Pop-Up! Provide some content and then try again <img class="targetpop-frown-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown-white.svg">');
              resultsdiv.addClass('targetpop-edit-error');
            } else {
              resultsdiv.html('Whoa, Wait a minute! You haven\'t provided any content for this Pop-Up! Provide some content and then try again <img class="targetpop-frown-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown.svg">');
              resultsdiv.addClass('targetpop-create-error');
              resultsdiv.animate({'height':'330px'});
            }
          }
        }

        // Send ajax request to simply make sure the Pop-Up name hasn't already been used
        if(goforinitial == true){

          // Spinner action
          $('.targetpop-spinner-white').animate({'opacity':'1'})
          $('#wpbooklist-spinner-2').animate({'opacity':'1'})

          var data = {
          'action': 'targetpop_create_popup_action',
          'security': '<?php echo wp_create_nonce( "targetpop_create_popup_action_callback" ); ?>',
          'popupname':popupname,
          'editid':$(this).attr('id'),
          'goforinitial':goforinitial
        };

          var request = $.ajax({
            url: ajaxurl,
            type: "POST",
            data:data,
            timeout: 0,
            success: function(response) {
              
              response = response.split('--sep--seperate--sep--')
              // If Pop-Up name isn't taken, proceed with saving popup
              if(response[0] == 1){
                  var data = {
                  'action': 'targetpop_create_popup_action',
                  'security': '<?php echo wp_create_nonce( "targetpop_create_popup_action_callback" ); ?>',
                  'popupuid':popupuid,
                  'contenttext':contenttext,
                  'popuptype':popuptype,
                  'popupname':popupname,
                  'popuptemplate':popuptemplate,
                  'popupheight':popupheight,
                  'popupwidth':popupwidth,
                  'popupautoheight':popupautoheight,
                  'popupautowidth':popupautowidth,
                  'popuptransition':popuptransition,
                  'popupopenspeed':popupopenspeed,
                  'popupclosingspeed':popupclosingspeed,
                  'popupslidespeed':popupslidespeed,
                  'popupclosetrigger':popupclosetrigger,
                  'popuptrigger':popuptrigger,
                  'popupbackdropcolor':popupbackdropcolor,
                  'popupbackdropopacity':popupbackdropopacity,
                  'popupappeardelay':popupappeardelay,
                  'popuptrackstats':popuptrackstats,
                  'popupmobile':popupmobile,
                  'popupremoveclose':popupremoveclose,
                  'popupslideauto':popupslideauto,
                  'popupstylestring':popupstylestring,
                  'goforsave':'goforsave',
                  'editid':response[1]
                };

                console.log('Data to be sent in next Ajax call after checking to see if proposed Pop-Up name is available. Should be all data gathered from the "Edit" and/or "Create" Pop-Up forms.')
                console.log(data)

                  var request = $.ajax({
                    url: ajaxurl,
                    type: "POST",
                    data:data,
                    timeout: 0,
                    success: function(response) {


                      $('#wpbooklist-spinner-2').animate({'opacity':'0'})

                      response = response.split('--sep--seperate--sep--')
                      console.log('The full ".split()" response from the server after attempting to create/edit Pop-Up - this also means the Ajax call itself was succesfull')
                      console.log(response)

                      var phpValues = JSON.parse(response[2])
                      console.log('These are the values the PHP callback function had to work with, after retreiving them from POST:')
                      console.log(phpValues)

                      var phpClassPopupValues = JSON.parse(response[3])
                      console.log('These are the values the PHP class-pop-up.php file tried to save:')
                      console.log(phpClassPopupValues)

                      if(response[1] == 'targetpop-create-popup-button'){
                        console.log("Supposedly, the Pop-Up has been succesfully created.")
                        $('#targetpop-results-div').html('<span class="targetpop-action-success-span">Success!</span> You\'ve just created a new Pop-Up! <img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smile.svg"><br/><br/>By default, <span class="targetpop-color-blue-italic">TargetPop</span> will set your new Pop-Up to "inactive" until you choose to activate it. This way, your website visitors won\'t see something that isn\'t quite ready yet. <br/><a href="<?php echo menu_page_url( "TargetPop-Options-pop-ups", false ); ?>&tab=editdeletepopups&uid='+response[0]+'">To Edit This Pop-Up, Click Here</a><br/><a href="<?php echo menu_page_url( "TargetPop-Options-triggers", false ); ?>&tab=triggers">To Create and Edit Triggers, Click Here</a><br/> <a href="" id="targetpop-activate-new-popup" data-uid="'+response[0]+'">To Activate your new Pop-Up, Click Here.</a><br/></br>Thanks for using TargetPop! Feel free to <a href="https://wordpress.org/support/plugin/targetpop/reviews/?filter=5">leave us a 5-star review here,</a> and for Templates, Extensions, and everything else TargetPop, visit <a href="http://www.targetpop.io">TargetPop.io!</a><br/><img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smile.svg">');
                        $('html, body').animate({
                            scrollTop: $("#targetpop-results-div").offset().top-100
                        }, 1000);
                        $('#targetpop-results-div').animate({'height':'330px'});
                        $('.targetpop-spinner-white').animate({'opacity':'0'})
                      } else {
                        console.log("Supposedly, the Pop-Up has been succesfully edited.")
                        var responsediv = $('#'+response[1]).parent().find('.targetpop-results-div');
                        responsediv.html('<span class="targetpop-action-success-span-white">Success!</span> You\'ve just edited a Pop-Up! <img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smilewhite.svg"><br/><br/>Thanks for using TargetPop! Feel free to <a href="https://wordpress.org/support/plugin/targetpop/reviews/?filter=5">leave us a 5-star review here</a>, and for Templates, Extensions, and everything else TargetPop, visit <a href="http://www.targetpop.io">TargetPop.io!</a><br/><img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smilewhite.svg">');
                        $('.targetpop-spinner-white').animate({'opacity':'0'})
                      }
                    },
                  error: function(jqXHR, textStatus, errorThrown) {
                    
                          
                          
                  }
                });
              } else {

                console.log("The Ajax call that checks for available Pop-Up names says that the name is not available.")

                if(response[1] == 'targetpop-create-popup-button'){
                  var responsediv = $('#targetpop-results-div');
                  responsediv.addClass('targetpop-create-error');
                  responsediv.html('Whoops! Looks like you already have a popup named "'+response[0]+'". Choose a different name and try again <img class="targetpop-frown-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown.svg">');
                  responsediv.animate({'height':'330px'});
                  $('.targetpop-spinner-white').animate({'opacity':'0'})
                  $('#wpbooklist-spinner-2').animate({'opacity':'0'})
                } else {
                  var responsediv = $('#'+response[1]).parent().find('.targetpop-results-div');
                  responsediv.addClass('targetpop-edit-error');
                  responsediv.html('Whoops! Looks like you already have a popup named "'+response[0]+'". Choose a different name and try again <img class="targetpop-frown-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown-white.svg">');
                  $('.targetpop-spinner-white').animate({'opacity':'0'})
                  $('#wpbooklist-spinner-2').animate({'opacity':'0'})
                }
              }
            },
          error: function(jqXHR, textStatus, errorThrown) {
            
            console.log("The Ajax call itself for creating and/or editing a Pop-Up has failed.")
            console.log(jqXHR)
            console.log(textStatus)
            console.log(errorThrown)
          }
        });

        }

      event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}

// Callback function for creating Pop-ups
function targetpop_create_popup_action_callback(){
  global $wpdb;
  check_ajax_referer( 'targetpop_create_popup_action_callback', 'security' );

  $savedpopupstable = $wpdb->prefix . 'targetpop_saved_popups_log';

  // Check to make sure Pop-Up name isn't already in use
  if(isset($_POST['goforinitial'])){
    $popupname = filter_var($_POST['popupname'], FILTER_SANITIZE_STRING);
    $editid = filter_var($_POST['editid'], FILTER_SANITIZE_STRING);
    $result = $wpdb->get_results($wpdb->prepare("SELECT * FROM $savedpopupstable WHERE popupname = %s", $popupname));


    if($editid != 'targetpop-create-popup-button'){
      if($result == null || ($result[0]->popupname == $popupname && sizeof($result) == 1) ){
        echo '1--sep--seperate--sep--'.$editid;
      } else {
        echo $popupname.'--sep--seperate--sep--'.$editid;
      }

    } else {
      if($result == null){
        echo '1--sep--seperate--sep--'.$editid;
      } else {
        echo $popupname.'--sep--seperate--sep--'.$editid;
      }
    }
    
    wp_die();
  }

  // Everything checks out, now let's try to save the Pop-Up
  if(isset($_POST['goforsave'])){

    $editid = filter_var($_POST['editid'], FILTER_SANITIZE_STRING);
    $contenttext =  str_replace('<?php', '', str_replace('<script>', '', stripslashes($_POST['contenttext'])));
    $popupuid = filter_var($_POST['popupuid'],FILTER_SANITIZE_STRING);
    $popuptype = filter_var($_POST['popuptype'],FILTER_SANITIZE_STRING);
    $popupname = filter_var($_POST['popupname'],FILTER_SANITIZE_STRING);
    $popuptemplate = filter_var($_POST['popuptemplate'],FILTER_SANITIZE_STRING);
    $popupheight = filter_var($_POST['popupheight'],FILTER_SANITIZE_NUMBER_INT);
    $popupwidth = filter_var($_POST['popupwidth'],FILTER_SANITIZE_NUMBER_INT);
    $popupautoheight = filter_var($_POST['popupautoheight'],FILTER_SANITIZE_STRING);
    $popupautowidth = filter_var($_POST['popupautowidth'],FILTER_SANITIZE_STRING);
    $popuptransition = filter_var($_POST['popuptransition'],FILTER_SANITIZE_STRING);
    $popupopenspeed = filter_var($_POST['popupopenspeed'],FILTER_SANITIZE_STRING);
    $popupclosingspeed = filter_var($_POST['popupclosingspeed'],FILTER_SANITIZE_STRING);
    $popupslidespeed = filter_var($_POST['popupslidespeed'],FILTER_SANITIZE_STRING);
    $popupclosetrigger = filter_var($_POST['popupclosetrigger'],FILTER_SANITIZE_STRING);
    $popuptrigger = filter_var($_POST['popuptrigger'],FILTER_SANITIZE_STRING);
    $popupbackdropcolor = filter_var($_POST['popupbackdropcolor'],FILTER_SANITIZE_STRING);
    $popupbackdropopacity = filter_var($_POST['popupbackdropopacity'],FILTER_SANITIZE_NUMBER_INT);
    $popupappeardelay = filter_var($_POST['popupappeardelay'],FILTER_SANITIZE_NUMBER_INT);
    $popuptrackstats = filter_var($_POST['popuptrackstats'],FILTER_SANITIZE_STRING);
    $popupmobile = filter_var($_POST['popupmobile'],FILTER_SANITIZE_STRING);
    $popupremoveclose = filter_var($_POST['popupremoveclose'],FILTER_SANITIZE_STRING);
    $popupslideauto = filter_var($_POST['popupslideauto'],FILTER_SANITIZE_STRING);
    $popupstylestring = filter_var($_POST['popupstylestring'],FILTER_SANITIZE_STRING);

    $popup_array = array('popuptype' => $popuptype,
            'popupuid' => $popupuid,
            'popupname' => $popupname,
            'popuptemplate' => $popuptemplate,
            'popupheight' => $popupheight,  
            'popupwidth' => $popupwidth,
            'popupautoheight' => $popupautoheight,
            'popupautowidth' => $popupautowidth,
            'popuptransition' =>$popuptransition,
            'popupopenspeed' => $popupopenspeed,
            'popupclosingspeed' => $popupclosingspeed,
            'popupslidespeed' => $popupslidespeed,
            'popupclosetrigger' => $popupclosetrigger,
            'popuptrigger' => $popuptrigger,
            'popupbackdropcolor' => $popupbackdropcolor,
            'popupbackdropopacity' => $popupbackdropopacity,
            'popupappeardelay' => $popupappeardelay,
            'popuptrackstats' => $popuptrackstats,
            'popupmobile' => $popupmobile,
            'popupremoveclose' => $popupremoveclose,
            'popupslideauto'=>$popupslideauto,
            'popupstylestring'=>$popupstylestring,  
            'contenttext' => $contenttext);

    // If we're editing an existing pop-up, else...
    if($popupuid != ''){
      // Calling class-pop-up.php to edit our existing pop-up
      require_once(TARGETPOP_CLASS_DIR.'class-pop-up.php');
      $popup = new TargetPop_Pop_Up('edit', $popup_array);
      echo $popup->popupuid.'--sep--seperate--sep--'.$editid.'--sep--seperate--sep--'.json_encode($popup_array).'--sep--seperate--sep--'.json_encode($popup->edit_data);
    } else {
      // Calling class-pop-up.php to create our new pop-up
      require_once(TARGETPOP_CLASS_DIR.'class-pop-up.php');
      $popup = new TargetPop_Pop_Up('create', $popup_array);
      echo $popup->popupuid.'--sep--seperate--sep--'.$editid.'--sep--seperate--sep--'.json_encode($popup_array).'--sep--seperate--sep--'.json_encode($popup->create_data);
    }

    
    wp_die();
  }

  wp_die();
}

function targetpop_create_trigger_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {

    // The click event for the 'Create New Trigger' button
      $("#targetpop-create-trigger-button").click(function(event){

        $('#wpbooklist-spinner-3').animate({'opacity':'1'})

        // Reset some UI elements
        //$('#targetpop-create-trig-results-div').css({'height':'0px'});
        $('#targetpop-create-trig-results-div').removeClass('targetpop-create-error');
        $('#targetpop-create-trig-results-div').html('');

        var boxid = '';
        var triggername = $('#targetpop-create-trig-name').val();

        $('.targetpop-trigger-actions-checkbox').each(function(){
          if($(this).prop('checked') == true){
            boxid = $(this).attr('id');
          }
      })

        // If name has been provided
        if(triggername != '' && triggername != undefined && boxid != ''){

          // Check if name has been taken already
          var data = {
          'action': 'targetpop_create_trigger_action',
          'security': '<?php echo wp_create_nonce( "targetpop_create_trigger_action_callback" ); ?>',
          'triggername':triggername,
          'namecheck':'namecheck',
          'boxid':boxid
        };
        
          var request = $.ajax({
            url: ajaxurl,
            type: "POST",
            data:data,
            timeout: 0,
            success: function(response) {

              response = response.split('---');

              // If name is free
              if(response[0] == 1){

                var seconds = '';
                var page = '';
                var post = '';
                var scrollpercentage = '';
                var triggername = $('#targetpop-create-trig-name').val();

                switch(response[1]) {
                  case 'targetpop-create-triggers-1':
                    seconds = $('#targetpop-create-trig-step3-seconds').val();
                      break;
                  case 'targetpop-create-triggers-2':
                    seconds = $('#targetpop-create-trig-step3-seconds').val();
                      break;
                  case 'targetpop-create-triggers-3':
                      break;
                  case 'targetpop-create-triggers-4':
                    page = $('#targetpop-create-trig-step3-pages').val();
                      break;
                  case 'targetpop-create-triggers-5':
                      break;
                  case 'targetpop-create-triggers-6':
                    scrollpercentage = $('#targetpop-create-trig-step3-percentage').val();
                      break;
                  case 'targetpop-create-triggers-7':
                    seconds = $('#targetpop-create-trig-step3-seconds').val();
                    page = $('#targetpop-create-trig-step3-pages').val();
                      break;
                  case 'targetpop-create-triggers-8':
                    seconds = $('#targetpop-create-trig-step3-seconds').val();
                    post = $('#targetpop-create-trig-step3-pages').val();
                      break;
                  case 'targetpop-create-triggers-9':
                    seconds = $('#targetpop-create-trig-step3-seconds').val();
                    post = $('#targetpop-create-trig-step3-pages').val();
                      break;
                  case 'targetpop-create-triggers-10':
                    post = $('#targetpop-create-trig-step3-pages').val();
                      break;
                  case 'targetpop-create-triggers-11':
                      break;
                  default:
              }

              // Check if name has been taken already
                var data = {
                'action': 'targetpop_create_trigger_action',
                'security': '<?php echo wp_create_nonce( "targetpop_create_trigger_action_callback" ); ?>',
                'triggername':triggername,
                'seconds':seconds,
                'page':page,
                'post':post,
                'scrollpercentage':scrollpercentage,
                'savetrigger':'savetrigger',
                'boxid':response[1]
              };
              
                var request = $.ajax({
                  url: ajaxurl,
                  type: "POST",
                  data:data,
                  timeout: 0,
                  success: function(response) {
                    if(response == 1){
                      $('#wpbooklist-spinner-3').animate({'opacity':'0'})
                      $('#targetpop-create-trig-results-div').removeClass('targetpop-create-error');
                      $('#targetpop-create-trig-results-div').animate({'height':'200px'});
                      $('#targetpop-create-trig-results-div').html('<span class="targetpop-action-success-span">Success!</span> You\'ve just created a new Trigger! <img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smile.svg"><br><br>This Trigger will now appear as an option in the \'Assign a Trigger\' drop-down box on the <a href="<?php echo menu_page_url( "TargetPop-Options-pop-ups", false ); ?>&tab=pop">\'Create Pop-Ups\'</a> page.<br><br>Thanks for using TargetPop! Feel free to <a href="https://wordpress.org/support/plugin/targetpop/reviews/?filter=5">leave us a 5-star review here</a>, and for Templates, Extensions, and everything else TargetPop, visit <a href="http://www.targetpop.io">TargetPop.io!</a><br><img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smile.svg">');

                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  
                        
                        
                }
              });
              } else {
                $('#targetpop-create-trig-results-div').addClass('targetpop-create-error');
                $('#targetpop-create-trig-results-div').animate({'height':'80px'});

                $('#wpbooklist-spinner-3').animate({'opacity':'0'})
                $('#targetpop-create-trig-results-div').html('Uh-oh! Looks like you already have a Trigger with this name! Name your Trigger something unique and then try again <br><img class="targetpop-frown-icon" id="targetpop-frown-icon-1" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown.svg"></div>');
              }
            },
          error: function(jqXHR, textStatus, errorThrown) {
            
                  
                  
          }
        });

        } else {

          // If name hasn't been provided but an action has
          if((triggername == '' || triggername == undefined) && boxid != ''){

            $('#targetpop-create-trig-results-div').addClass('targetpop-create-error');
            $('#targetpop-create-trig-results-div').animate({'height':'80px'});
            $('#wpbooklist-spinner-3').animate({'opacity':'0'})
            $('#targetpop-create-trig-results-div').html('Whoa, Wait a minute! You haven\'t named this Trigger! Name your Trigger and then try again <br><img class="targetpop-frown-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown.svg"></div>');

          }

          // If action has been provided but a name hasn't
          if((triggername != '' && triggername != undefined) && boxid == ''){

            $('#targetpop-create-trig-results-div').addClass('targetpop-create-error');
            $('#targetpop-create-trig-results-div').animate({'height':'80px'});
            $('#wpbooklist-spinner-3').animate({'opacity':'0'})
            $('#targetpop-create-trig-results-div').html('Whoa, Wait a minute! You haven\'t selected an Action! Select an Action and then try again <br><img class="targetpop-frown-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown.svg"></div>');

          }

          // If neither have been provided
          if((triggername == '' || triggername == undefined) && boxid == ''){

            $('#targetpop-create-trig-results-div').addClass('targetpop-create-error');
            $('#targetpop-create-trig-results-div').animate({'height':'80px'});
            $('#wpbooklist-spinner-3').animate({'opacity':'0'})
            $('#targetpop-create-trig-results-div').html('Whoa, Wait a minute! You haven\'t named your Trigger, nor selected an Action! Name your Trigger, select an Action and then try again <br><img class="targetpop-frown-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>frown.svg"></div>');

          }
        }
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}

// Callback function for creating new triggers
function targetpop_create_trigger_action_callback(){
  global $wpdb;
  check_ajax_referer( 'targetpop_create_trigger_action_callback', 'security' );

  $table = $wpdb->prefix.'targetpop_triggers_log';

  // Just check if the name is free
  if(isset($_POST['namecheck'])){
    $triggername = filter_var($_POST['triggername'],FILTER_SANITIZE_STRING);
    $boxid = filter_var($_POST['boxid'],FILTER_SANITIZE_STRING);

    $results = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE name = %s", $triggername));

    if($results == null){
      echo '1---'.$boxid;
      wp_die();
    }

  } else {
    $triggername = filter_var($_POST['triggername'],FILTER_SANITIZE_STRING);
    $boxid = filter_var($_POST['boxid'],FILTER_SANITIZE_STRING);
    $page = filter_var($_POST['page'],FILTER_SANITIZE_NUMBER_INT);
    $post = filter_var($_POST['post'],FILTER_SANITIZE_NUMBER_INT);
    $scrollpercentage = filter_var($_POST['scrollpercentage'],FILTER_SANITIZE_STRING);
    $seconds = filter_var($_POST['seconds'],FILTER_SANITIZE_STRING);
    $created = time();
    $active = 'false';
    $statement == '';
    $pagetitle = '';
    $posttitle = '';

    if($page != null){
      $pagetitle = get_the_title($page);
    }

    if($post != null){
      $posttitle = get_the_title($post);
    }


    switch ($boxid) {
      case 'targetpop-create-triggers-1':
        $statement = 'Visitor must remain on any Page for '.$seconds.' seconds before Pop-Up appears';
        break;
      case 'targetpop-create-triggers-2':
        $statement = 'Visitor must remain on any Post for '.$seconds.' seconds before Pop-Up appears';
        break;
      case 'targetpop-create-triggers-3':
        $statement = 'Visitor must click on an Internal Link before Pop-Up appears';
        break;
      case 'targetpop-create-triggers-4':
        $statement = 'Visitor must visit the Page titled \''.$pagetitle.'\' before Pop-Up appears';
        break;
      case 'targetpop-create-triggers-5':
        $statement = 'Visitor must view an embedded video before Pop-Up appears';
        break;
      case 'targetpop-create-triggers-6':
        $statement = 'Visitor must scroll down '.$scrollpercentage.'% of the Page or Post before Pop-Up appears';
        break;
      case 'targetpop-create-triggers-7':
        $statement = 'Visitor must spend at least '.$seconds.' seconds on the Page titled \''.$pagetitle.'\' before Pop-Up appears';
        break;
      case 'targetpop-create-triggers-8':
        $statement = 'Visitor must spend at least '.$seconds.' seconds on the Post titled \''.$posttitle.'\' before Pop-Up appears';
        break;
      case 'targetpop-create-triggers-9':
        $statement = 'Visitor must click on an External Link before Pop-Up appears';
        break;
      case 'targetpop-create-triggers-10':
        $statement = 'Visitor must visit the Post titled \''.$posttitle.'\' before Pop-Up appears';
        break;
      case 'targetpop-create-triggers-11':
        $statement = 'Visitor must leave a comment before Pop-Up appears';
        break;
      default:
        # code...
        break;
    }


    $triggers_array = array('triggersname' => $triggername,
                 'triggerscreated' => $created,
                 'triggerspercentage' => $percentage,
                 'triggersstatement' => $statement,
                 'triggersactive' => $active,
                 'triggersscrollpercentage' => $scrollpercentage,
                 'triggersseconds' => $seconds,
                 'triggerspage' => $page,
                 'triggerspost' => $post,
                 'triggerstype' => $boxid);

    require_once(TARGETPOP_CLASS_DIR.'class-triggers.php');
    $triggers_class = new Targetpop_Triggers('create', $triggers_array, null);
    echo $triggers_class->addresult;



  }

  wp_die();
}


function targetpop_create_trig_step3_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      
      
      $(document).on("click",".targetpop-trigger-actions-checkbox", function(event){

        //$('#targetpop-create-trig-results-div').animate({'height':'0px'});
        $('#targetpop-create-trig-results-div').html('');

        var trigaction = $(this).attr('id');
        var specifics = $('#targetpop-create-triggers-specific-details-div');
        var html = '';
        specifics.html('');

        // Checkbox behavior for checkboxes in Step 2 of new trigger creation
        $('.targetpop-trigger-actions-checkbox').each(function(){
          $(this).prop('checked', false);
        })
        $(this).prop('checked', true);
        $('#wpbooklist-spinner-1').animate({'opacity':'1'})
        $('#targetpop-create-triggers-details-div').animate({'opacity':'0', 'margin-top':'0px'})

        if(trigaction == 'targetpop-create-triggers-4' ||
           trigaction == 'targetpop-create-triggers-7' ||
           trigaction == 'targetpop-create-triggers-8' ||
           trigaction == 'targetpop-create-triggers-10'){

          var data = {
          'action': 'targetpop_create_trig_step3_action',
          'security': '<?php echo wp_create_nonce( "targetpop_create_trig_step3_action_callback" ); ?>',
          'trigaction':trigaction
        };

        var request = $.ajax({
            url: ajaxurl,
            type: "POST",
            data:data,
            timeout: 0,
            success: function(response) {
              switch(trigaction) {
                case 'targetpop-create-triggers-4':
                  html = '<label id="targetpop-create-trig-step3-label">Select Specific Page:</label>';
                  html = html+response;
                    break;
                case 'targetpop-create-triggers-7':
                  html = '<label id="targetpop-create-trig-step3-label">Select Specific Page:</label>';
                  html = html+response;
                  html = html+'<label id="targetpop-create-trig-step3-label">Set amount of seconds the visitor must remain<br/>on page before Pop-Up appears:</label><input id="targetpop-create-trig-step3-seconds" type="number" min="0" placeholder="30 Seconds" />';
                    break;
                case 'targetpop-create-triggers-8':
                  html = '<label id="targetpop-create-trig-step3-label">Select Specific Post:</label>';
                  html = html+response;
                  html = html+'<label id="targetpop-create-trig-step3-label">Set amount of seconds the visitor must remain<br/>on post before Pop-Up appears:</label><input id="targetpop-create-trig-step3-seconds" type="number" min="0" placeholder="30 Seconds" />';
                    break;
                case 'targetpop-create-triggers-10':
                  html = '<label id="targetpop-create-trig-step3-label">Select Specific Post:</label>';
                  html = html+response;
                    break;
                default:
            }

              specifics.html(html)
              $('#targetpop-create-triggers-details-div').animate({'opacity':'1', 'margin-top':'26px'})
              $('#wpbooklist-spinner-1').animate({'opacity':'0'})
            $('html, body').animate({
                  scrollTop: specifics.offset().top-100
              }, 1000);

            },
          error: function(jqXHR, textStatus, errorThrown) {
            
                  
                  
          }
        });
        } else {
          $('#wpbooklist-spinner-1').animate({'opacity':'0'})
        $('html, body').animate({
              scrollTop: specifics.offset().top-100
          }, 1000);

        if(trigaction == 'targetpop-create-triggers-1'){
          $('#targetpop-create-triggers-details-div').animate({'opacity':'1', 'margin-top':'26px'})
          html = '<label id="targetpop-create-trig-step3-label">Set amount of seconds the visitor must remain<br/>on any Page before the Pop-Up appears:</label><input id="targetpop-create-trig-step3-seconds" type="number" min="0" placeholder="30 Seconds" />';
          specifics.html(html)
        }

        if(trigaction == 'targetpop-create-triggers-2'){
          $('#targetpop-create-triggers-details-div').animate({'opacity':'1', 'margin-top':'26px'})
          html = '<label id="targetpop-create-trig-step3-label">Set amount of seconds the visitor must remain<br/>on any Post before the Pop-Up appears:</label><input id="targetpop-create-trig-step3-seconds" type="number" min="0" placeholder="30 Seconds" />';
          specifics.html(html)
        }

        if(trigaction == 'targetpop-create-triggers-6'){
          $('#targetpop-create-triggers-details-div').animate({'opacity':'1', 'margin-top':'26px'})
          html = '<label id="targetpop-create-trig-step3-label">Set the percentage of the Page or Post the visitor <br/>must scroll dowm before the Pop-Up appears:</label><input id="targetpop-create-trig-step3-percentage" type="number" min="0" placeholder="30%" />';
          specifics.html(html)
        }






        }
      });
  });
  </script>
  <?php
}

// Callback function for creating backups
function targetpop_create_trig_step3_action_callback(){
  global $wpdb;
  check_ajax_referer( 'targetpop_create_trig_step3_action_callback', 'security' );
  $trigaction = filter_var($_POST['trigaction'],FILTER_SANITIZE_STRING);
  $pagestring = '<select id="targetpop-create-trig-step3-pages"><option selected default >Select a Page...</option>';
  $poststring = '<select id="targetpop-create-trig-step3-pages"><option selected default >Select a Post...</option>';
  global $wpdb;


  switch ($trigaction) {
    case 'targetpop-create-triggers-4':
        $pages = get_pages();
        foreach ($pages as $key => $page) {
          $pagestring = $pagestring.'<option value="'.$page->ID.'">'.stripslashes($page->post_title).'</option>';
        }
        $pagestring = $pagestring.'</select>';
        echo $pagestring;
        wp_die();
      break;
    case 'targetpop-create-triggers-7':
        $pages = get_pages();
        foreach ($pages as $key => $page) {
          $pagestring = $pagestring.'<option value="'.$page->ID.'">'.stripslashes($page->post_title).'</option>';
        }
        $pagestring = $pagestring.'</select>';
        echo $pagestring;
        wp_die();
      break;
    case 'targetpop-create-triggers-8':
        $posts = get_posts(array('numberposts' => -1));
        foreach ($posts as $key => $post) {
          $poststring = $poststring.'<option value="'.$post->ID.'">'.stripslashes($post->post_title).'</option>';
        }
        $poststring = $poststring.'</select>';
        echo $poststring;
        wp_die();
      break;
    case 'targetpop-create-triggers-10':
        $posts = get_posts(array('numberposts' => -1));
        foreach ($posts as $key => $post) {
          $poststring = $poststring.'<option value="'.$post->ID.'">'.stripslashes($post->post_title).'</option>';
        }
        $poststring = $poststring.'</select>';
        echo $poststring;
        wp_die();
      break;
    
    default:
      # code...
      break;
  }


}

// For deleting an existing trigger
function targetpop_delete_trigger_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on("click",".targetpop-edittrig-delete-button", function(event){

        var id = $(this).attr('data-uniqueid');
        $('#targetpop-spinner-'+id).animate({'opacity':'1'})

        var data = {
          'action': 'targetpop_delete_trigger_action',
          'security': '<?php echo wp_create_nonce( "targetpop_delete_trigger_action_callback" ); ?>',
          'id':id
        };

        console.log('This is the data sent to the server via AJAX when initially clicking on the "Delete Trigger" button.')
        console.log(data)

        var request = $.ajax({
          url: ajaxurl,
          type: "POST",
          data:data,
          timeout: 0,
          success: function(response) {
          response = response.split('---');

            if(response[0] == 1){

              $('#targetpop-results-div-'+response[1]).html('<span style="font-style:italic;">Success!</span> You\'ve just deleted a Trigger! <img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smilewhite.svg"><br/><br/>All existing Pop-Ups that used this Trigger <em style="color:red;">HAVE BEEN DEACTIVATED</em> - you\'ll need to <a href="<?php echo menu_page_url( "TargetPop-Options-pop-ups", false ); ?>&tab=editdeletepopups" style="color:white; text-decoration:underline;">assign a new Trigger to those Pop-Ups before they will appear to your visitors.</a><br/></br>Thanks for using TargetPop! Feel free to <a href="https://wordpress.org/support/plugin/targetpop/reviews/?filter=5" style="color:white; text-decoration:underline;">leave us a 5-star review here</a>, and for Templates, Extensions, and everything else TargetPop, visit <a href="http://www.targetpop.io" style="color:white; text-decoration:underline;">TargetPop.io!</a><br/><img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smilewhite.svg">');

              $('#targetpop-results-div-'+response[1]).parent().parent().parent().animate({'height':'600px'})
            $('#targetpop-results-div-'+response[1]).animate({'height':'105px', 'opacity':'1'});
            $('#targetpop-spinner-'+response[1]).animate({'opacity':'0'})
            }
          },
        error: function(jqXHR, textStatus, errorThrown) {
          
                
                
        }
      });

      event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}

// Callback function for deleting an existing trigger
function targetpop_delete_trigger_action_callback(){
  global $wpdb;
  check_ajax_referer( 'targetpop_delete_trigger_action_callback', 'security' );
  $id = filter_var($_POST['id'],FILTER_SANITIZE_STRING);


  require_once(TARGETPOP_CLASS_DIR.'class-triggers.php');
  $triggers_class = new Targetpop_Triggers('delete', $triggers_array, $id);
  echo $triggers_class->trigdelete.'---'.$id;

  wp_die();
}

// For editing a trigger
function targetpop_edit_trig_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on("click",".targetpop-edittrig-edit-button", function(event){

        $('.targetpop-edit-trig-success-div').html('');
        $('.targetpop-spinner-white').animate({'opacity':'1'});

        var id = $(this).attr('id');
        var trigname = $(this).parent().parent().find('.targetpop-trig-name-trigedit-text-input').val();
        var trigtype = $(this).attr('data-trigtype');
        var triguid = $(this).attr('data-triguid');
        var seconds = 0;
        var scrollpercentage = 0;
        var page = '';
        var post = '';

        switch(trigtype) {
          case 'targetpop-create-triggers-1':
            seconds = $(this).parent().parent().find('.targetpop-specific-fields-trigedit-text-input').val();
              break;
          case 'targetpop-create-triggers-2':
              seconds = $(this).parent().parent().find('.targetpop-specific-fields-trigedit-text-input').val();
              break;
           case 'targetpop-create-triggers-4':
              page = $(this).parent().parent().find('#targetpop-edit-trig-pages').val();
              break;
          case 'targetpop-create-triggers-6':
              scrollpercentage = $(this).parent().parent().find('.targetpop-specific-fields-trigedit-text-input').val();
              break;
          case 'targetpop-create-triggers-7':
              seconds = $(this).parent().parent().find('.targetpop-specific-fields-trigedit-text-input').val();
              page = $(this).parent().parent().find('#targetpop-edit-trig-pages').val();
              break;
          case 'targetpop-create-triggers-8':
              seconds = $(this).parent().parent().find('.targetpop-specific-fields-trigedit-text-input').val();
              post = $(this).parent().parent().find('#targetpop-edit-trig-posts').val();
              break;
          case 'targetpop-create-triggers-10':
              post = $(this).parent().parent().find('#targetpop-edit-trig-posts').val();
              break;
          default:

      }

        var data = {
        'action': 'targetpop_edit_trig_action',
        'security': '<?php echo wp_create_nonce( "targetpop_edit_trig_action_callback" ); ?>',
        'trigname':trigname,
        'triguid':triguid,
        'trigtype':trigtype,
        'seconds':seconds,
        'page':page,
        'post':post,
        'scrollpercentage':scrollpercentage,
        'id':id
      };

        var request = $.ajax({
          url: ajaxurl,
          type: "POST",
          data:data,
          timeout: 0,
          success: function(response) {
            if(response.includes('targetpop-editbutton-id-')){
              $('.targetpop-edit-trig-success-div').html('<span class="targetpop-action-success-span-white">Success!</span> You\'ve just edited your Trigger! <img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smilewhite.svg"><br/><br/>Thanks for using TargetPop! Feel free to <a href="https://wordpress.org/support/plugin/targetpop/reviews/?filter=5">leave us a 5-star review here</a>, and for Templates, Extensions, and everything else TargetPop, visit <a href="http://www.targetpop.io">TargetPop.io!</a><br/><img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smilewhite.svg">');
              $('.targetpop-spinner-white').animate({'opacity':'0'});
              $('#'+response).parent().parent().parent().height(function (index, height) {
                return (height + 80);
            });
            }
          },
        error: function(jqXHR, textStatus, errorThrown) {
          
                
                
        }
      });

      event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}

// Callback function for creating backups
function targetpop_edit_trig_action_callback(){
  global $wpdb;
  check_ajax_referer( 'targetpop_edit_trig_action_callback', 'security' );
  $name = filter_var($_POST['trigname'],FILTER_SANITIZE_STRING);
  $id = filter_var($_POST['id'],FILTER_SANITIZE_STRING);
  $uniqueid = filter_var($_POST['triguid'],FILTER_SANITIZE_STRING);
  $trigtype = filter_var($_POST['trigtype'],FILTER_SANITIZE_STRING);
  $seconds = filter_var($_POST['seconds'],FILTER_SANITIZE_NUMBER_INT);
  $page = filter_var($_POST['page'],FILTER_SANITIZE_NUMBER_INT);
  $post = filter_var($_POST['post'],FILTER_SANITIZE_NUMBER_INT);
  $scrollpercentage = filter_var($_POST['scrollpercentage'],FILTER_SANITIZE_NUMBER_INT);

  $triggers_array = array(
    'triggersname'=>$name,
    'triggersuniqueid'=>$uniqueid,
    'triggersseconds'=>$seconds,
    'triggerspage'=>$page,
    'triggerspost'=>$post,
    'triggersscrollpercentage'=>$scrollpercentage,
    'triggerstype'=>$trigtype
  );

  require_once(TARGETPOP_CLASS_DIR.'class-triggers.php');
  $triggers_class = new Targetpop_Triggers('edit', $triggers_array, null);
  if($triggers_class->editresult == 1){
    echo $id;
  }


  wp_die();
}

// For enabling/disabling a Pop-Up
function targetpop_active_toggle_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on("click",".targetpop-edittrig-activate-popup", function(event){

        var toggleHandle = $(this).find('.targetpop-edit-popup-active-toggle-img');
        var label = $(this).find('label');
        var status = $(this).attr('data-popupactive');
        var uid = $(this).attr('data-popupuid');

        if(status == 'true'){
          toggleHandle.animate({'margin-right':'55px'})
          label.text('Activate Pop-Up');
          $(this).attr('data-popupactive', 'false');
        } else {
          toggleHandle.animate({'margin-right':'72px'});
          label.text('Deactivate Pop-Up');
          $(this).attr('data-popupactive', 'true');
        }

        var data = {
        'action': 'targetpop_active_toggle_action',
        'security': '<?php echo wp_create_nonce( "targetpop_active_toggle_action_callback" ); ?>',
        'status':status,
        'uid':uid
      };


        var request = $.ajax({
          url: ajaxurl,
          type: "POST",
          data:data,
          timeout: 0,
          success: function(response) {

          },
        error: function(jqXHR, textStatus, errorThrown) {
          
                
                
        }
      });

      event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}

// Callback function for creating backups
function targetpop_active_toggle_action_callback(){
  global $wpdb;
  check_ajax_referer( 'targetpop_active_toggle_action_callback', 'security' );
  $status = filter_var($_POST['status'],FILTER_SANITIZE_STRING);
  $uid = filter_var($_POST['uid'],FILTER_SANITIZE_STRING);

  if($status == 'true'){
    $status = 'inactive';
  }

  if($status == 'false'){
    $status = 'active';
  }

  $table = $wpdb->prefix.'targetpop_saved_popups_log';
  $data = array(
        'popupactive' => $status
    );
  $format = array( '%s'); 
  $where = array( 'popupuid' => $uid );
  $where_format = array( '%s' );
  echo $wpdb->update( $table, $data, $where, $format, $where_format );
  wp_die();
}

// For deleting an existing popup
function targetpop_delete_popup_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on("click",".targetpop-editpopup-delete-button", function(event){

        // Disable any other clicks
        $('.targetpop-editpopup-delete-button').css({'pointer-events':'none'})
        $('.targetpop-editpopupus-popup-row').css({'pointer-events':'none'})


        var id = $(this).attr('data-uniqueid');
        $('#targetpop-spinner-'+id).animate({'opacity':'1'})

        var data = {
          'action': 'targetpop_delete_popup_action',
          'security': '<?php echo wp_create_nonce( "targetpop_delete_popup_action_callback" ); ?>',
          'id':id
        };


        var request = $.ajax({
          url: ajaxurl,
          type: "POST",
          data:data,
          timeout: 0,
          success: function(response) {
          response = response.split('---');

            if(response[0] == 1){
              function targetpop_reload_countdown(){
                var container = $('#targetpop-results-div-countdown-'+response[1]);
                container = container.text().split(' ');
                container = container[2].replace('...','');
                var html = parseInt(container);
                var newhtml = html-1;
                if(newhtml == 0){
                  document.location.reload(true);
                } else {
                  setTimeout(function(){
                    targetpop_reload_countdown();
                  },1000)
                }

                newhtml = 'Reloading in '+newhtml+'...'
                $('#targetpop-results-div-countdown-'+response[1]).html(newhtml)

              }
              
              
              $('#targetpop-results-div-'+response[1]).html('<span style="font-style:italic;">Success!</span> You\'ve just deleted a Pop-Up! <img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smilewhite.svg"><br/><br/>Thanks for using TargetPop! Feel free to <a href="https://wordpress.org/support/plugin/targetpop/reviews/?filter=5" style="color:white; text-decoration:underline;">leave us a 5-star review here</a>, and for Templates, Extensions, and everything else TargetPop, visit <a href="http://www.targetpop.io" style="color:white; text-decoration:underline;">TargetPop.io!</a><br/><img class="targetpop-smile-icon" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>smilewhite.svg">');

              $('#targetpop-results-div-'+response[1]).animate({'height':'105px', 'opacity':'1'});

              // Start the countdown once spinner has finished fading
              $('#targetpop-spinner-'+response[1]).animate({
                 opacity: '0'
                },
                {
                 easing: 'swing',
                 duration: 500,
                 complete: function(){
                    $('.targetpop-edittrig-countdown-results-div').animate({
                     opacity: '1'
                    },
                    {
                     easing: 'swing',
                     duration: 1000,
                     complete: function(){
                        targetpop_reload_countdown();
                    }
                  });
                }
              });

            }
          },
        error: function(jqXHR, textStatus, errorThrown) {
          
                
                
        }
      });

      event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}

// Callback function for deleting an existing triggers
function targetpop_delete_popup_action_callback(){
  global $wpdb;
  check_ajax_referer( 'targetpop_delete_popup_action_callback', 'security' );
  $id = filter_var($_POST['id'],FILTER_SANITIZE_STRING);


  require_once(TARGETPOP_CLASS_DIR.'class-pop-up.php');
  $popup_class = new TargetPop_Pop_Up('delete', $popup_array, $id);
  //echo $popup_class->popupdelete.'---'.$id;
  echo '1---'.$id;

  wp_die();
}

// For populating the Pop-Up editor fields
function targetpop_editpopups_populate_action_javascript() { 
  wp_enqueue_media();
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on("click",".targetpop-editpopupus-popup-row", function(event){

      $('.targetpop-spinner-forpop-edit').animate({'opacity':'1'});

      // Reset some UI elements
      var id = $(this).attr('id');
      templateid = id+'-populate'; 
      stylingid = id+'-step2-styling'; 
      detailsid = id+'-step3-details'; 
      var templateid = $('#'+id+'-populate');
      var stylingid = $('#'+id+'-step2-styling');
      var detailsid = $('#'+id+'-step3-details');
      templateid.html('');
      stylingid.html('');
      detailsid.html('');
      templateid.animate({'opacity':'0'});
      stylingid.animate({'opacity':'0'});
      detailsid.animate({'opacity':'0'});
      var imgWidth;
      var headerBackColor = '';
      var bannerBackColor = '';
      var returnflag = false;

      // Reset the height of all the Pop-Ups on the 'Edit Popups' page to 0, and at the end of this function, compute the new height and expand it. If clicking on an already-expanded Pop-Up, we'll colapse it and completely end this click event 
      $('.targetpop-edittrig-details-div').each(function(){
        if($('#'+id).next().css('height') != '0px'){
          $(this).css({'height':'0px', 'padding-bottom':'0px'})
          returnflag = true;
        } else {
          $(this).css({'height':'0px', 'padding-bottom':'0px'})
        }
      });

      // Completely ending this click event, as the user simply wanted to colapse an already-expanded Pop-Up
      if(returnflag == true){
        return false;
      }


    
        var initial = $(this).next().css('height');
        if(initial == '0px'){

          var popupuid = $(this).attr('data-popupuid');

          var data = {
            'action': 'targetpop_editpopups_populate_action',
            'security': '<?php echo wp_create_nonce( "targetpop_editpopups_populate_action_callback" ); ?>',
            'popupuid':popupuid,
            'id':id
          };


          var request = $.ajax({
            url: ajaxurl,
            type: "POST",
            data:data,
            timeout: 0,
            success: function(response) {

              $('.targetpop-spinner-forpop-edit').animate({'opacity':'0'});
              response = response.split('--sep--seperator--sep--');
              var container = $('#'+response[0]+'-populate');
              var styleblock = $('#'+response[0]+'-step2-styling');
              var detailsblock = $('#'+response[0]+'-step3-details');
              var template = $('#'+response[0]).attr('data-popuptemplate');
              var details = JSON.parse(response[5]);

              container.html(response[1]);
              styleblock.html(response[2]);
              detailsblock.html(response[3]);

              container.animate({'opacity':'1'});
              styleblock.animate({'opacity':'1'});
              detailsblock.animate({'opacity':'1'});

              container.find('.targetpop-edit-popup-template-container').animate({'opacity':'1'});
              styleblock.find('#targetpop-step2-edit-styling-div').animate({'opacity':'1'});
              detailsblock.find('#targetpop-create-popup-step3-div').animate({'opacity':'1'});

              // Filling in the color inputs
              var color1 = '';
              var color2 = 'white';
              var shadow = 'black';
              var type = $('#'+response[0]).next().find('.targetpop-edittrig-statement-text').text();


              // Function the check for the existence of a shortcode in the content - if it exists, make ajax call to convert that shortcode to html
              function targetpop_check_for_shortcodes_editpopups_populate(content, id, templatePart){

                // Check for the existence of a shortcode
                var shortcode = content.substring(content.lastIndexOf("[")+1,content.lastIndexOf("]"));
                console.log("This is the derived shortcode without it's brackets:")
                console.log(shortcode)

                // If there is a shortcode, make the Ajax call
                if(shortcode != '' && shortcode != null && shortcode != undefined){

                  var lastchar = content.substr(content.length - 1);
                  if(lastchar == ']'){

                    var data = {
                      'action': 'targetpop_editpopups_populate_action',
                      'security': '<?php echo wp_create_nonce( "targetpop_editpopups_populate_action_callback" ); ?>',
                      'shortcode':shortcode,
                      'content':content,
                      'id':id
                    };

                    console.log('This is the data being sent to the server with the derived shortcode and the current Editor content.')
                    console.log(data)

                    var request = $.ajax({
                      url: ajaxurl,
                      type: "POST",
                      data:data,
                      timeout: 0,
                      success: function(response) {
                        response = response.split('--sep---seperator---sep--')
                       
                        response[2] = response[2].replace('['+response[1]+']',response[0]);
                        shortcode = '['+response[1]+']';
                        var content = jQuery('#targetpopeditor').val();
                        content = content.replace(shortcode,response[0]);

                        console.log('This is the output of the shortcode, after returning from the do_shortcode function on the PHP side:')
                        console.log(response[0]);

                        // Update both the Preview and the Editor with the translated shortcode code
                        $('#'+templatePart).html(content);
                        jQuery('#targetpopeditor').val(content)


                      },
                      error: function(jqXHR, textStatus, errorThrown) {
                      
                            
                            
                      }
                    });
                  } else {
                    $('#'+templatePart).html(content);
                  }
                } else {
                  $('#'+templatePart).html(content);
                }
              }






              function output_two_editors(type){

                $("#wp-targetpopeditor-wrap").detach().appendTo('#'+response[0]+'-populate');
                $("#wp-targetpopeditor-wrap").css({'display':'initial'})
  
                // Populate the editor depending on what type of Pop-up is in play (and possibly which template in the future)
                switch(type) {
                  case 'Plain Text/HTML':
                        $('#'+response[0]+'-populate').find('#wp-targetpopeditor-wrap .wp-editor-area').val($('#targetpop-template-body').html())
                      break;
                  case 'targetpop-create-type-page-or-post':
                      
                      break;
                  default:
                }

                


                function targetpop_get_tinymce_content2_editpopups_populate(id){
                  if(id == '#targetpopeditor'){
                    if (jQuery("#wp-targetpopeditor-wrap").hasClass("tmce-active")){
                        return tinyMCE.activeEditor.getContent();
                    }else{
                        return jQuery('#targetpopeditor').val();
                    }
                  }

                  if(id == '#targetpopeditor2'){
                    if (jQuery("#wp-targetpopeditor2-wrap").hasClass("tmce-active")){
                        return tinyMCE.activeEditor.getContent();
                    }else{
                        return jQuery('#targetpopeditor2').val();
                    }
                  }
                }



              (function targetpop_bindToTinyMce_2_editpopups_populate(popuptype){
                  var editors = $('.wp-editor-wrap').length;
                  for (var i = 0; i < tinyMCE.editors.length; i++) {

                    if(popuptype == 'targetpop-create-type-plain-html'){
                      tinyMCE.editors[i].onKeyUp.add(function (ed, e) {
                        // Update HTML view textarea (that is the one used to send the data to server).
                        $('#targetpop-template-body').html(targetpop_get_tinymce_content2_editpopups_populate('#targetpopeditor'));
                      });
                      
                      tinyMCE.editors[i].onNodeChange.add(function (ed, e) {
                        // Update HTML view textarea (that is the one used to send the data to server).
                        $('#targetpop-template-body').html(targetpop_get_tinymce_content2_editpopups_populate('#targetpopeditor'));
                      });
                    }

                    if(popuptype == 'Recent Posts'){
                      tinyMCE.editors[i].onKeyUp.add(function (ed, e) {
                        // Update HTML view textarea (that is the one used to send the data to server).
                        $('#targetpop-template-top-banner').html(targetpop_get_tinymce_content2_editpopups_populate('#targetpopeditor'));
                      });
                      
                      tinyMCE.editors[i].onNodeChange.add(function (ed, e) {
                        // Update HTML view textarea (that is the one used to send the data to server).
                        $('#targetpop-template-top-banner').html(targetpop_get_tinymce_content2_editpopups_populate('#targetpopeditor'));
                      });
                    }
                  }

                if(tinyMCE.editors.length != editors){
                  setTimeout(function() {
                    targetpop_bindToTinyMce_2_editpopups_populate(popuptype);
                  }, 500)
                }

              })(details[16]);



              if(details[16] == 'targetpop-create-type-plain-html'){
                $(document).on("keyup","#targetpopeditor", function(event){
                  var templatepart = 'targetpop-template-body';
                  var content = targetpop_get_tinymce_content2_editpopups_populate('#targetpopeditor');
                  targetpop_check_for_shortcodes_editpopups_populate(content, $(this).attr('id'), templatepart);
                });

                $(document).on("click","#targetpopeditor", function(event){
                  var templatepart = 'targetpop-template-body';
                  var content = targetpop_get_tinymce_content2_editpopups_populate('#targetpopeditor');
                  targetpop_check_for_shortcodes_editpopups_populate(content, $(this).attr('id'), templatepart);
                });
              }

              if(details[16] == 'Recent Posts'){
                $(document).on("keyup","#targetpopeditor", function(event){
                  var templatepart = 'targetpop-template-top-banner';
                  var content = targetpop_get_tinymce_content2_editpopups_populate('#targetpopeditor');
                  targetpop_check_for_shortcodes_editpopups_populate(content, $(this).attr('id'), templatepart);
                });

                $(document).on("click","#targetpopeditor", function(event){
                  var templatepart = 'targetpop-template-top-banner';
                  var content = targetpop_get_tinymce_content2_editpopups_populate('#targetpopeditor');
                  targetpop_check_for_shortcodes_editpopups_populate(content, $(this).attr('id'), templatepart);
                });
              }


/*
              // Bind the keyup events between the editors and the template parts
              $(document).on("keyup","#targetpopeditor", function(event){
                $('#targetpop-template-top-banner').html(targetpop_get_tinymce_content2_editpopups_populate('#targetpopeditor'));
              });
              $(document).on("keyup","#targetpopeditor2", function(event){
                $('#targetpop-template-body').html(targetpop_get_tinymce_content2_editpopups_populate('#targetpopeditor2'));
              });
              // Bind the keyup events between the editors and the template parts
              $(document).on("click","#targetpopeditor", function(event){
                $('#targetpop-template-top-banner').html(targetpop_get_tinymce_content2_editpopups_populate('#targetpopeditor'));
              });
              $(document).on("click","#targetpopeditor2", function(event){
                $('#targetpop-template-body').html(targetpop_get_tinymce_content2_editpopups_populate('#targetpopeditor2'));
              });
*/
              }

              function output_header_editor(){
                //$("#targetpopeditor").val('Place Header Content Here!');
                $("#wp-targetpopeditor-wrap").detach().appendTo('#'+response[0]+'-populate');
                $("#wp-targetpopeditor-wrap").css({'display':'initial'})
                // Populate the editors with the saved html
                $('#'+response[0]+'-populate').find('#wp-targetpopeditor-wrap .wp-editor-area').val($('#targetpop-template-top-banner').html())


                function targetpop_get_header_tinymce_content2(id){
                  if(id == '#targetpopeditor'){
                    if (jQuery("#wp-targetpopeditor-wrap").hasClass("tmce-active")){
                        return tinyMCE.activeEditor.getContent();
                    }else{
                        return jQuery('#targetpopeditor').val();
                    }
                  }
                }

                (function targetpop_bindToTinyMce_header(){
                    var editors = $('.wp-editor-wrap').length;
                        for (var i = 0; i < tinyMCE.editors.length; i++) {
                    }

                    if(tinyMCE.editors.length != editors){
                        setTimeout( targetpop_bindToTinyMce_header, 500 );
                      }

                })();

                // Bind the keyup events between the editors and the template parts
                $(document).on("keyup","#targetpopeditor", function(event){
                  $('#targetpop-template-top-banner').html(targetpop_get_header_tinymce_content2('#targetpopeditor'));
                });
                $(document).on("keyup","#targetpopeditor2", function(event){
                  $('#targetpop-template-body').html(targetpop_get_header_tinymce_content2('#targetpopeditor2'));
                });
                // Bind the keyup events between the editors and the template parts
                $(document).on("click","#targetpopeditor", function(event){
                  $('#targetpop-template-top-banner').html(targetpop_get_header_tinymce_content2('#targetpopeditor'));
                });
                $(document).on("click","#targetpopeditor2", function(event){
                  $('#targetpop-template-body').html(targetpop_get_header_tinymce_content2('#targetpopeditor2'));
                });
              }

              // Special checks/allowances depending on the Pop-Up type
              switch(type) {
                  case 'targetpop-create-type-email-subscribe':

                    if(template =='default-email-1.html'){

                      // Get saved title text of E-mail Pop-Up 
                      var titletext = $('#targetpop-template-email-one-title').html();
                      var subtitletext = $('#targetpop-template-email-one-subtitle').html();
                      var imgsrc = $('#targetpop-template-email-one-image').attr('src')

                      // Hide various Styling elements and controls we won't be using
                      $('.targetpop-step2-style-block').css({'display':'none'})
                      
                      // Add in the Image button and the Title and Subtitle input boxes
                      var imgButton = '<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image targetpop-icon-img-title-img" data-label="emailimage" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>question-white.svg" /><label class="targetpop-email-labels" id="targetpop-email-labels-title-text" style="color:#fff;">Title Text:</label><input value="'+titletext+'" class="targetpop-add-img-input" id="targetpop-email-title-input" type="text" /><br/><img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image targetpop-icon-img-subtitle-img" data-label="emailimage" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>question-white.svg" /><label class="targetpop-email-labels" id="targetpop-email-labels-subtitle-text" style="color:#fff;">Sub-Title Text:</label><input value="'+subtitletext+'" class="targetpop-add-img-input" id="targetpop-email-subtitle-input" type="text" />'

                      // Register the listeners for the Title and Subtitle inputs
                      $(document).on("change","#targetpop-email-title-input", function(event){
                        var newtext = $(this).val();
                        $('#targetpop-template-email-one-title').html(newtext)
                      });

                      // Register the listeners for the Title and Subtitle inputs
                      $(document).on("change","#targetpop-email-subtitle-input", function(event){
                        var newtext = $(this).val();
                        $('#targetpop-template-email-one-subtitle').html(newtext)
                      });

                      // Register the listener for the Image text input
                      $(document).on("change","#targetpop-add-img-email-1", function(event){
                        var newimgsrc = $(this).val();
                        $('#targetpop-template-email-one-image').attr('src', newimgsrc)
                      });

                      $('#'+response[0]+'-populate').append('<div id="targetpop-div-for-email-popup-options">'+imgButton+'</div>')

                    }

                    if(template =='default-email-2.html'){

                      // Get saved title text of E-mail Pop-Up 
                      var titletext = $('#targetpop-template-email-one-title').html();
                      var subtitletext = $('#targetpop-template-email-one-subtitle').html();
                      var imgsrc = $('#targetpop-template-email-one-image').attr('src')

                      // Hide various Styling elements and controls we won't be using
                      $('.targetpop-step2-style-block').css({'display':'none'})
                      
                      // Add in the Image button and the Title and Subtitle input boxes
                      var imgButton = '<img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image targetpop-icon-img-title-img" data-label="emailimage" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>question-white.svg" /><label class="targetpop-email-labels" id="targetpop-email-labels-title-text" style="color:#fff;">Title Text:</label><input value="'+titletext+'" class="targetpop-add-img-input" id="targetpop-email-title-input" type="text" /><br/><img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image targetpop-icon-img-subtitle-img" data-label="emailimage" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>question-white.svg" /><label class="targetpop-email-labels" id="targetpop-email-labels-subtitle-text" style="color:#fff;">Sub-Title Text:</label><input value="'+subtitletext+'" class="targetpop-add-img-input" id="targetpop-email-subtitle-input" type="text" /><br/><img class="targetpop-icon-image-question-styling-step-2 targetpop-icon-image targetpop-icon-img-email-img" data-label="emailimage" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>question-white.svg" /><button class="targetpop-add-img-button targetpop-add-img-button-email" data-imgnum="1">Add an Image...</button><input class="targetpop-add-img-input" id="targetpop-add-img-email-1" type="text" value="'+imgsrc+'"/>'

                      // Register the listeners for the Title and Subtitle inputs
                      $(document).on("change","#targetpop-email-title-input", function(event){
                        var newtext = $(this).val();
                        $('#targetpop-template-email-one-title').html(newtext)
                      });

                      // Register the listeners for the Title and Subtitle inputs
                      $(document).on("change","#targetpop-email-subtitle-input", function(event){
                        var newtext = $(this).val();
                        $('#targetpop-template-email-one-subtitle').html(newtext)
                      });

                      // Register the listener for the Image text input
                      $(document).on("change","#targetpop-add-img-email-1", function(event){
                        var newimgsrc = $(this).val();
                        $('#targetpop-template-email-one-image').attr('src', newimgsrc)
                      });

                      $('#'+response[0]+'-populate').append('<div id="targetpop-div-for-email-popup-options">'+imgButton+'</div>')

                      // This code enables the Image Gallery button for the E-Mail/Subscriptions Pop-Up Type
                      if ($('.targetpop-add-img-button-email').length > 0) {
                        if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
                            $(document).on('click', '.targetpop-add-img-button-email', function(e) {


                                var href = $(this).next().val();
                                $('.targetpop-popup-gallery-link').each(function(){
                                  if($(this).attr('href') == href){
                                    $(this).remove();
                                  }
                                })

                                e.preventDefault();
                                var button = $(this);
                                var id = button.prev();
                                var idpart = button.attr('data-imgnum');
                                wp.media.editor.send.attachment = function(props, attachment) {

                                  // Populate the Pop-Up preview if the Pop-Up type is 'E-Mail/Subscription' 
                                  if($('#targetpop-template-email-one-image').length > 0){
                                    $('#targetpop-template-email-one-image').attr('src',attachment.url)
                                    $('#targetpop-add-img-email-1').val(attachment.url)
                                  }
                                };
                                wp.media.editor.open(button);
                                return false;
                            });
                        }
                      }

                    }

                      break;
                  case 'Plain Text/HTML':
                      if(template =='default-text-1.html'){
                        color1 = 'FFFFFF';
                        output_two_editors(type);
                      }
                      if(template =='default-text-2.html'){
                        color1 = 'F05A1A';
                        output_two_editors(type);
                      }
                      if(template =='default-text-3.html'){
                        color1 = '14871C';
                      }
                      break;
                  case 'targetpop-create-type-page-or-post':
                      if(template =='default-post-1.html'){
                        //color1 = 'CA0813';
                        output_header_editor(type);
                      }
                      break;
                  case 'targetpop-create-type-gallery':
                      if(template == 'default-gallery-1.html'){

                        // Reset container html
                        container.html('');

                        // Strip out unneeded html from db response
                        var modresponse = response[1].replace('<div class="targetpop-spinner-white targetpop-spinner-forpop-edit" id="targetpop-spinner-"></div><div class="targetpop-edit-popup-template-container">','');

                        // Create array of just the hrefs of the images
                        modresponse = modresponse.split(',')                          
                        for (var i = 0; i < modresponse.length; i++) {
                          $('#'+response[0]+'-populate').append(modresponse[i])
                        };

                        // Create html to append to dom
                        var finalhtml = '';
                        $('#'+response[0]+'-populate').find('.targetpop-popup-gallery-link').each(function(index){
                          var href = $(this).attr('href');
                          finalhtml = finalhtml+'<div id="targetpop-add-img-div-'+(index+1)+'" class="targetpop-add-img-div" data-imgnum="'+(index+1)+'"><button style="position:relative; right:4px;" class="targetpop-add-img-button" data-imgnum="'+(index+1)+'">Add an Image...</button><input style="left:3px;" class="targetpop-add-img-input" id="targetpop-add-img-input-'+(index+1)+'" type="text" value="'+href+'" /><img style="left:3px;" class="targetpop-remove-add-img-x" id="targetpop-remove-add-img-x-'+(index+1)+'" data-removeimgnum="'+(index+1)+'" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>round-delete-button-white.svg"/></div>'

                        })

                        // Add the 'add more images' button
                        finalhtml = finalhtml+'<div id="targetpop-add-additional-img-gal"><div data-addoredit="edit" id="targetpop-add-more-imgs-blue"><img id="targetpop-settings-addmore-img" src="<?php echo TARGETPOP_ROOT_IMG_ICONS_URL; ?>add.svg">Add More Images</div></div>';
                        
                        // Hide unneeded stuff
                        $('#targetpop-step2-template-bones-div').css({'display':'none'})
                        $('#targetpop-step2-styling-div').css({'display':'none'})
                        $('#targetpop-slideshow-speed-div').css({'display':'none'})
                        $('#targetpop-autostart-slideshow-row').css({'display':'none'})
                        $('#targetpop-step2-edit-styling-div').css({'display':'none'})

                        // Append saved images html to dom
                        $('#'+response[0]+'-populate').append(finalhtml);   


                        // This code enables the Image Gallery button for the Image Gallery Pop-Up Type
                        if ($('.targetpop-add-img-button').length > 0) {
                          if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
                              $(document).on('click', '.targetpop-add-img-button', function(e) {


                                  var href = $(this).next().val();
                                  $('.targetpop-popup-gallery-link').each(function(){
                                    if($(this).attr('href') == href){
                                      $(this).remove();
                                    }
                                  })

                                  e.preventDefault();
                                  var button = $(this);
                                  var id = button.prev();
                                  var idpart = button.attr('data-imgnum');
                                  wp.media.editor.send.attachment = function(props, attachment) {

                                    $('#targetpop-add-img-input-'+idpart).val(attachment.url);
                                    var count = $('.targetpop-popup-gallery-link').length;
                                    var newhtml = "<a style='display:none;opacity:0;' class='targetpop-popup-gallery-link' id='targetpop-popup-gallery-link-"+(parseInt(count)+1)+"' data-imgnumhiddenlink='"+(parseInt(count)+1)+"' href='"+attachment.url+"'>test</a>";
                                    $('#targetpop-add-more-imgs-blue').before(newhtml);
                                    jQuery('a.targetpop-popup-gallery-link').targetbox()
                                  };
                                  wp.media.editor.open(button);
                                  return false;
                              });
                          }
                        }




                      }
                      break;
                  case 'targetpop-create-type-iframe':
                      if(template =='default-external-1.html'){
                        
                        //color1 = 'CA0813';
                        output_header_editor();

                        // Get the iframe's src for the input below
                        var src = $('#'+response[0]+'-populate').find('#targetpop-template-iframe-actual').attr('src');

                        var finalhtml = '<div style="color:white;" id="targetpop-step2-ext-web-container"><div><label>Input the URL of the External Website Below:</label><br><input value="'+src+'" id="targetpop-iframe-website-url" type="text" placeholder="https://www.example.com"><button id="targetpop-step2-ext-web-button-external">Test URL</button><div id="targetpop-step2-ext-web-iframe-message">Note: If the website does not appear in the preview area above, there\'s either something wrong with the address you provided, or the website doesn\'t allow itself to be used this way - if that\'s the case, you\'ll have to choose a different website. Also, if your site is secure (see an "https" in your address bar?), then the only external websites you can display are other secure websites.</div></div><div class="targetpop-spinner-white" id="wpbooklist-spinner-external" style="opacity: 0;"></div><div id="targetpop-step2-ext-web-message"></div></div>';

                        // Append special stuff to dom specific to this Pop-up type
                        $('#'+response[0]+'-populate').append(finalhtml);


                      }
                      break;
                  case 'targetpop-create-type-internal-url':
                      if(template =='default-internal-1.html'){
                        
                        //color1 = 'CA0813';
                        output_header_editor();

                        // Get the iframe's src for the input below
                        var src = $('#'+response[0]+'-populate').find('#targetpop-template-iframe-actual').attr('src');

                        var finalhtml = '<div style="color:white;" id="targetpop-step2-ext-web-container"><div><label>Input the URL of the Internal Website Below:</label><br><input value="'+src+'" id="targetpop-iframe-website-url" type="text" placeholder="https://www.example.com"><button id="targetpop-step2-ext-web-button-internal">Test URL</button></div>';

                        // Append special stuff to dom specific to this Pop-up type
                        $('#'+response[0]+'-populate').append(finalhtml);


                      }
                      break;
                  case 'targetpop-create-type-image':
                      if(template =='default-imagelink-1.html'){
                        
                        //color1 = 'CA0813';
                        output_header_editor();

                        var finalhtml = '<div id="targetpop-step2-img-gal-container" style="opacity: 1; color:white;"><div id="targetpop-add-img-div-1" class="targetpop-add-img-div" data-imgnum="1"><button class="targetpop-add-img-button" data-imgnum="1">Add an Image...</button><input class="targetpop-add-img-input" id="targetpop-add-img-input-1" type="text"></div><div class="targetpop-image-link-opts-row" id="targetpop-image-link-opts-row-id"><label>Image Width:</label><input id="targetpop-img-type-width" type="number" placeholder="50"><label>%</label></div><div class="targetpop-image-link-opts-row" id="targetpop-image-link-opts-row"><label>Transparent Body Background:</label><input id="targetpop-transparent-body-img-type" type="checkbox"></div><div class="targetpop-image-link-opts-row" id="targetpop-image-link-opts-row"><label>Transparent Header Background:</label><input id="targetpop-transparent-header-img-type" type="checkbox"></div><div><label id="targetpop-add-img-input-2">Input the Link URL:</label><input placeholder="https://www.example.com" id="targetpop-image-link-link" type="text"></div></div>'

                        // Append special stuff to dom specific to this Pop-up type
                        $('#'+response[0]+'-populate').append(finalhtml); 

                        // Convert the width of the image in pixels back to percent
                        var width = $('#targetpop-template-image-link-img-actual').width(); 
                        var parentWidth = $('#targetpop-template-image-link-img-actual').offsetParent().width();
                        var percent = Math.ceil(100*width/parentWidth);
                        $('#targetpop-img-type-width').val(percent);

                        // Get the image src and set it in the input
                        var src = $('#'+response[0]+'-populate').find('#targetpop-template-image-link-img-actual').attr('src');
                        $('#'+response[0]+'-populate').find('#targetpop-add-img-input-1').val(src);

                        // Get the header and banner background-color, if they're transparent, check the boxes
                        headerBackColor = $('#targetpop-template-top-banner').css('background-color');
                        bannerBackColor = $('#targetpop-template-body').css('background-color');

                        if(headerBackColor == 'rgba(0, 0, 0, 0)'){
                          $('#targetpop-transparent-header-img-type').prop('checked', true);
                        }

                        if(bannerBackColor == 'rgba(0, 0, 0, 0)'){
                          $('#targetpop-transparent-body-img-type').prop('checked', true);
                        }

                        // Get the link href and set it in the input
                        var link = $('#'+response[0]+'-populate').find('#targetpop-template-image-link-link-actual').attr('href');
                        $('#'+response[0]+'-populate').find('#targetpop-image-link-link').val(link);

                        // This code enables the Image Gallery button for the Image Gallery Pop-Up Type
                        if ($('.targetpop-add-img-button').length > 0) {
                          if ( typeof wp !== 'undefined' && wp.media && wp.media.editor) {
                              $(document).on('click', '.targetpop-add-img-button', function(e) {


                                  var href = $(this).next().val();
                                  $('.targetpop-popup-gallery-link').each(function(){
                                    if($(this).attr('href') == href){
                                      $(this).remove();
                                    }
                                  })

                                  e.preventDefault();
                                  var button = $(this);
                                  var id = button.prev();
                                  var idpart = button.attr('data-imgnum');
                                  wp.media.editor.send.attachment = function(props, attachment) {

                                    // Populate the Pop-Up preview if the Pop-Up type is 'Single image w/ Link' 
                                    if($('#targetpop-template-image-link-img-actual').length > 0){
                                      $('#targetpop-template-image-link-img-actual').attr('src',attachment.url)
                                      $('#targetpop-template-image-link-img-actual').animate({'opacity':'1'},2000)
                                    }

                                    $('#targetpop-add-img-input-'+idpart).val(attachment.url);

                                    var count = $('.targetpop-popup-gallery-link').length;
                                    var newhtml = "<a style='display:none;opacity:0;' class='targetpop-popup-gallery-link' id='targetpop-popup-gallery-link-"+(parseInt(count)+1)+"' data-imgnumhiddenlink='"+(parseInt(count)+1)+"' href='"+attachment.url+"'>test</a>";
                                  $('#targetpop-add-more-imgs-blue').before(newhtml);
                                  jQuery('a.targetpop-popup-gallery-link').targetbox()


                                  };
                                  wp.media.editor.open(button);
                                  return false;
                              });
                          }
                        }










                      }
                      break;
                  case 'targetpop-create-type-video':
                      if(template =='default-video-1.html'){
                        
                        //color1 = 'CA0813';
                        output_header_editor();

                      }
                      break;
                  default:
              }
          

              var input = document.createElement('INPUT')
              var picker = new jscolor(input)
              input.className = 'targetpop-colorpicker-class jscolor';
              input.type = 'text';
              input.style.color = "#ffffff";
              input.id = 'targetpop-backdropcolor-input';

              var parent = document.getElementById('targetpop-row-for-colorpicker');
              if(parent != undefined){
                parent.appendChild(input)
              } 

              var input1 = document.createElement('input')
              var picker = new jscolor(input1)
              input1.className = 'targetpop-colorpicker-class jscolor';
              input1.type = 'text';
              input1.id = 'targetpop-colorpicker1-step2';
              input1.value = color1;
              input1.style.background = '#'+color1;
              input1.style.color = color2;

              var parent = document.getElementById('targetpop-row-for-colorpicker1-step2');
              if(parent != undefined){
                //parent.appendChild(input1)
              } 

              var input2 = document.createElement('input')
              var picker = new jscolor(input2)
              input2.className = 'targetpop-colorpicker-class jscolor';
              input2.type = 'text';
              input2.id = 'targetpop-colorpicker2-step2';

              var parent = document.getElementById('targetpop-row-for-colorpicker2-step2');
              if(parent != undefined){
                parent.appendChild(input2)
              } 

              var input3 = document.createElement('input')
              var picker = new jscolor(input3)
              input3.className = 'targetpop-colorpicker-class jscolor';
              input3.type = 'text';
              input3.id = 'targetpop-colorpicker3-step2';
              input3.value = '000000';
              input3.style.background = shadow;
              input3.style.color = color2;

              var parent = document.getElementById('targetpop-row-for-colorpicker3-step2');
              if(parent != undefined){
                parent.appendChild(input3)
              }

              var input4 = document.createElement('input')
              var picker = new jscolor(input4)
              input4.className = 'targetpop-colorpicker-class jscolor';
              input4.type = 'text';
              input4.id = 'targetpop-colorpicker4-step2';
              input4.value = '000000';
              input4.style.background = shadow;
              input4.style.color = color2;

              var parent = document.getElementById('targetpop-row-for-colorpicker4-step2');
              if(parent != undefined){
                parent.appendChild(input4)
              }

              var input5 = document.createElement('input')
              var picker = new jscolor(input5)
              input5.className = 'targetpop-colorpicker-class jscolor';
              input5.type = 'text';
              input5.id = 'targetpop-colorpicker5-step2';
              input5.value = '000000';
              input5.style.background = shadow;
              input5.style.color = color2;

              var parent = document.getElementById('targetpop-row-for-colorpicker5-step2');
              if(parent != undefined){
                parent.appendChild(input5)
              }

              var input6 = document.createElement('input')
              var picker = new jscolor(input6)
              input6.className = 'targetpop-colorpicker-class jscolor';
              input6.type = 'text';
              input6.id = 'targetpop-colorpicker6-step2';
              input6.value = color1;
              input6.style.background = '#'+color1;
              input6.style.color = color2;

              var parent = document.getElementById('targetpop-row-for-colorpicker6-step2');
              if(parent != undefined){
                parent.appendChild(input6)
              }
              var styleArray = response[4].split('-');
              $('#targetpop-step2-styling-border').val(styleArray[0]);
              $('#targetpop-step2-styling-border-px').val(styleArray[1]);
              $('#targetpop-colorpicker6-step2').val(styleArray[2]);
              $('#targetpop-colorpicker6-step2').css({'background':'#'+styleArray[2]})
              $('#targetpop-colorpicker6-step2').trigger('change');

              $('#targetpop-step2-styling-border-radius-px').val(styleArray[3]);
              $('#targetpop-step2-styling-border-radius-px').trigger('change');

              $('#targetpop-colorpicker1-step2').val(styleArray[4]);
              $('#targetpop-colorpicker1-step2').css({'background':'#'+styleArray[4]})

              // If the header color is transparent of the 'Single Image w/ Link' type, don't trigger the jscolor input
              if(headerBackColor != 'rgba(0, 0, 0, 0)'){
                $('#targetpop-colorpicker1-step2').trigger('change');
              }
              
              $('#targetpop-colorpicker2-step2').val(styleArray[5]);
              $('#targetpop-colorpicker2-step2').css({'background':'#'+styleArray[5]})

              // If the banner color is transparent of the 'Single Image w/ Link' type, don't trigger the jscolor input
              if(bannerBackColor != 'rgba(0, 0, 0, 0)'){
                $('#targetpop-colorpicker2-step2').trigger('change');
              }

              $('#targetpop-step2-styling-box-shadow-type').val(styleArray[6]);
              $('#targetpop-step2-styling-box-shadow-x').val(styleArray[7]);
              $('#targetpop-step2-styling-box-shadow-y').val(styleArray[8]);
              $('#targetpop-step2-styling-box-shadow-blur').val(styleArray[9]);
              $('#targetpop-step2-styling-box-shadow-spread').val(styleArray[10]);
              $('#targetpop-colorpicker3-step2').val(styleArray[11]);
              $('#targetpop-colorpicker3-step2').css({'background':'#'+styleArray[11]})
              $('#targetpop-colorpicker3-step2').trigger('change');

              $('#targetpop-step2-styling-text-shadow-header-x').val(styleArray[12]);
              $('#targetpop-step2-styling-text-shadow-header-y').val(styleArray[13]);
              $('#targetpop-step2-styling-text-shadow-header-blur').val(styleArray[14]);
              $('#targetpop-step2-styling-text-shadow-header-blur').trigger('change');

              $('#targetpop-colorpicker4-step2').val(styleArray[15]);
              $('#targetpop-colorpicker4-step2').css({'background':'#'+styleArray[15]})
              $('#targetpop-colorpicker4-step2').trigger('change');

              $('#targetpop-step2-styling-text-shadow-body-x').val(styleArray[16]);
              $('#targetpop-step2-styling-text-shadow-body-y').val(styleArray[17]);
              $('#targetpop-step2-styling-text-shadow-body-blur').val(styleArray[18]);
              $('#targetpop-step2-styling-text-shadow-body-blur').trigger('change');

              $('#targetpop-colorpicker5-step2').val(styleArray[19]);
              $('#targetpop-colorpicker5-step2').css({'background':'#'+styleArray[19]})
              $('#targetpop-colorpicker5-step2').trigger('change');

              $('#targetpop-step2-styling-padding-header-top').val(styleArray[20]);
              $('#targetpop-step2-styling-padding-header-bottom').val(styleArray[21]);
              $('#targetpop-step2-styling-padding-header-left').val(styleArray[22]);
              $('#targetpop-step2-styling-padding-header-right').val(styleArray[23]);
              $('#targetpop-step2-styling-padding-header-right').trigger('change');

              $('#targetpop-step2-styling-padding-body-top').val(styleArray[24]);
              $('#targetpop-step2-styling-padding-body-bottom').val(styleArray[25]);
              $('#targetpop-step2-styling-padding-body-left').val(styleArray[26]);
              $('#targetpop-step2-styling-padding-body-right').val(styleArray[27]);
              $('#targetpop-step2-styling-padding-body-right').trigger('change');

              // Filling in the Details section
              console.log('These are the details that are used to fill in the UI elements starting with "Pop-Up Height" and ending with "Remove Close Button".')
              console.log(details)

              if(details[0] == 0){
                $('#targetpop-auto-height-checkbox').prop('checked', true);
              } else {
                $('#targetpop-height-text-input').val(details[0])
              }

              if(details[1] == 0){
                $('#targetpop-auto-width-checkbox').prop('checked', true);
              } else {
                $('#targetpop-width-text-input').val(details[1])
              }

              if(details[2] == ''){
                $('#targetpop-create-popup-transition').val('Elastic');
              } else {
                $('#targetpop-create-popup-transition').val(details[2]);
              }
              

              $('#targetpop-open-speed-input').val(details[3]);
              $('#targetpop-closing-speed-input').val(details[4]);
              $('#targetpop-slideshow-speed-input').val(details[5]);

              if(details[6] == ''){
                if(details[13] == 'false'){
                  $('#targetpop-create-popup-close-trigger').val('All of the above');
                } else {
                  $('#targetpop-create-popup-close-trigger').val('Visitor clicks outside of Pop-Up');
                }
              } else {
                $('#targetpop-create-popup-close-trigger').val(details[6]);
              }

              if(details[7] == ''){
                $('#targetpop-create-popup-trigger').val('Default Trigger');
              } else {
                $('#targetpop-create-popup-trigger').val(details[7]);
              }

              $('#targetpop-backdropcolor-input').val(details[8]);
              $('#targetpop-backdropcolor-input').css({'background-color':'#'+details[8]})

              if(details[9] == null){
                $('#targetpop-backdrop-opacity-input').val('85');
              } else {
                $('#targetpop-backdrop-opacity-input').val(details[9]);
              }

              $('#targetpop-create-popup-open-delay').val(details[10]);
              
              if(details[11] == 'false'){
                $('#targetpop-create-popup-disablemobileno').prop('checked', true);
              } else {
                $('#targetpop-create-popup-disablemobileyes').prop('checked', true);
              }

              if(details[12] == 'false'){
                $('#targetpop-create-popup-removecloseno').prop('checked', true);
                $('#targetpop-popup-preview-div').attr('data-removeclose','true')
              } else {
                $('#targetpop-create-popup-removecloseyes').prop('checked', true);
                $('#targetpop-popup-preview-div').attr('data-removeclose','false')
              }

              if(details[13] == 'false'){
                $('#targetpop-create-popup-trackno').prop('checked', true);
              } else {
                $('#targetpop-create-popup-trackyes').prop('checked', true);
              }


              if(details[14] == 'false'){
                $('#targetpop-create-popup-startslideno').prop('checked', true);
              } else {
                $('#targetpop-create-popup-startslideyes').prop('checked', true);
              }

              // Triggering events to add pop-up elements to the preview Div
              $('.targetpop-edittrig-details-div').each(function(){
                  if($(this).css('height') != '0px'){
                    $('#targetpop-popup-preview-div').attr('data-type', $(this).prev().attr('data-popuptype'));
                  }
                })
              $('#targetpopeditor').trigger('keyup');
              $('#targetpop-create-popup-name').trigger('keyup');
              $('#targetpop-create-popup-template').trigger('change');
              $('#targetpop-height-text-input').trigger('change');
              $('#targetpop-height-text-input').trigger('keyup');
              $('#targetpop-width-text-input').trigger('change');
              $('#targetpop-width-text-input').trigger('keyup');
              $('#targetpop-create-popup-transition').trigger('change');
              $('#targetpop-trans-speed-input').trigger('change');
              $('#targetpop-closing-speed-input').trigger('change');
              $('#targetpop-slideshow-speed-input').trigger('change');
              $('#targetpop-backdrop-opacity-input').trigger('change');
              $('#targetpop-auto-width-checkbox').trigger('change');
              $('#targetpop-auto-height-checkbox').trigger('change');
              $('#targetpop-create-popup-close-trigger').trigger('change');
              $('#targetpop-backdropcolor-input').trigger('change');
              //$('#targetpop-create-popup-removecloseyes').trigger('click');
              //$('#targetpop-create-popup-removecloseno').trigger('click');


              // Enable the preview div
              $('#targetpop-popup-preview-div').css({'pointer-events':'all'});
              $('#targetpop-popup-preview-div').animate({'opacity':'1'}, 1000);


              // Let's set up the height of the entire expanded popup editing area based on the popup type (change the padding as needed)
              console.log('The type of Pop-Up that was just expanded is:')
              console.log(type)
              console.log(container)
              switch(type) {
                  case 'Plain Text/HTML':
                      container.parent().parent().parent().css({'height':'auto', 'padding-bottom':'250px'})
                      break;
                  case 'targetpop-create-type-email-subscribe':
                      container.parent().parent().parent().css({'height':'auto', 'padding-bottom':'250px'})
                      console.log(container.parent().parent().parent().css('height'))
                      console.log(container.parent().parent().parent().attr('class'))
                      break;
                  case 'targetpop-create-type-page-or-post':
                      container.parent().parent().parent().css({'height':'auto', 'padding-bottom':'250px'})
                      break;
                  case 'targetpop-create-type-gallery':
                  default:

              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                
            }
          });
        } else {
          // Disable the preview div
          var previewdiv = $('#targetpop-popup-preview-div');
          previewdiv.css({'pointer-events':'none'});
          previewdiv.animate({'opacity':'0'}, 1000);

          // Reset all attributes of preview div
          previewdiv.removeAttr('data-type')
          previewdiv.removeAttr('data-content')
          previewdiv.removeAttr('data-height')
          previewdiv.removeAttr('data-autowidth')
          previewdiv.removeAttr('data-autoheight')
          previewdiv.removeAttr('data-width')
          previewdiv.removeAttr('data-transition')
          previewdiv.removeAttr('data-closespeed')
          previewdiv.removeAttr('data-slidespeed')
          previewdiv.removeAttr('data-backopacity')
          previewdiv.removeAttr('data-backdrop')
        }

      event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}

// Callback function for creating backups
function targetpop_editpopups_populate_action_callback(){
  global $wpdb;
  check_ajax_referer( 'targetpop_editpopups_populate_action_callback', 'security' );

  if(isset($_POST['shortcode'])){
    $shortcode = filter_var($_POST['shortcode'],FILTER_SANITIZE_STRING);
    $shortcode = str_replace('&#34;', '"', $shortcode);
    $shortcode = stripslashes($shortcode);
    $id = filter_var($_POST['id'],FILTER_SANITIZE_STRING);
    $content = filter_var($_POST['content'],FILTER_SANITIZE_STRING);
    $content = str_replace('&#34;', '"', $content);
    $content = stripslashes($content);
    error_log('SHORTCODE IS: '.$shortcode);
    echo $shortcode_output = do_shortcode('['.$shortcode.']').'--sep---seperator---sep--'.$shortcode.'--sep---seperator---sep--'.$content.'--sep---seperator---sep--'.$id.'--sep---seperator---sep--'.$shortcode;
  } else {
    $popupuid = filter_var($_POST['popupuid'],FILTER_SANITIZE_STRING);
    $id = filter_var($_POST['id'],FILTER_SANITIZE_STRING);
    $table = $wpdb->prefix.'targetpop_saved_popups_log';
    $savedpopup = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE popupuid = %s", $popupuid));

    $triggerstable = $wpdb->prefix.'targetpop_triggers_log';
    $savedtriggers = $wpdb->get_row($wpdb->prepare("SELECT * FROM $triggerstable WHERE uniqueid = %s", $savedpopup->popuptrigger));

    // Calling class-pop-up.php to create our new pop-up
    require_once(TARGETPOP_CLASS_DIR.'class-pop-up.php');
    $popup = new TargetPop_Pop_Up('edit_populate', null, $popupuid);

    $details_array = array(
      $savedpopup->popupheight,
      $savedpopup->popupwidth,
      $savedpopup->popuptransition,
      $savedpopup->popupopenspeed,
      $savedpopup->popupclosingspeed,
      $savedpopup->popupslidespeed,
      $savedpopup->popupclosetrigger,
      $savedpopup->popuptrigger,
      $savedpopup->popupbackdropcolor,
      $savedpopup->popupbackdropopacity,
      $savedpopup->popupappeardelay,
      $savedpopup->popupmobile,
      $savedpopup->popupremoveclose,
      $savedpopup->popuptrackstats,
      $savedpopup->popupslideauto,
      $savedpopup->popuptemplate,
      $savedpopup->popuptype,
      $savedpopup->popupname,
      $savedpopup->ID
    );
    $details_array = json_encode($details_array);


    echo $id.'--sep--seperator--sep--'.$popup->edit_populate_html.'--sep--seperator--sep--'.$savedpopup->popupstylestring.'--sep--seperator--sep--'.$details_array;

  }
  wp_die();
}


// For activaing/deactivating a pop-up
function targetpop_toggle_popup_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on("click",".targetpop-edittrig-activate-popup", function(event){

        var status = $(this).attr('data-popupactive');
        var popupuid = $(this).attr('data-popupuid');

        if(status == 'false'){
          status = 'inactive';
        } else {
          status = 'active';
        }

        var data = {
        'action': 'targetpop_toggle_popup_action',
        'security': '<?php echo wp_create_nonce( "targetpop_toggle_popup_action_callback" ); ?>',
        'status':status,
        'popupuid':popupuid
      };
      

        var request = $.ajax({
          url: ajaxurl,
          type: "POST",
          data:data,
          timeout: 0,
          success: function(response) {

          },
        error: function(jqXHR, textStatus, errorThrown) {
          
                
                
        }
      });

      event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}

// Callback function for creating backups
function targetpop_toggle_popup_action_callback(){
  global $wpdb;
  check_ajax_referer( 'targetpop_toggle_popup_action_callback', 'security' );
  $status = filter_var($_POST['status'],FILTER_SANITIZE_STRING);
  $popupuid = filter_var($_POST['popupuid'],FILTER_SANITIZE_STRING);

  // Calling class-pop-up.php to create our new pop-up
  require_once(TARGETPOP_CLASS_DIR.'class-pop-up.php');
  $popup = new TargetPop_Pop_Up('toggle', null, $popupuid, $status);

  echo $popup->toggleresponse;
  wp_die();
}



// For displaying a saved Pop-Up to the visitor
function targetpop_display_popup_action_javascript() { 

  // Getting misc. things
  $pageid = get_the_id();
  $page = is_page($pageid);
  $post = is_single($pageid);

  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {


        var data = {
        'action': 'targetpop_display_popup_action',
        'security': '<?php echo wp_create_nonce( "targetpop_display_popup_action_callback" ); ?>',
      };


        var request = $.ajax({
          url: ajaxurl,
          type: "POST",
          data:data,
          timeout: 0,
          success: function(response) {

            response = response.split('--sep---seperator---sep--');
            var popupresponse = JSON.parse(response[0]);
            var triggerresponse = JSON.parse(response[1]);
            var miscArray = ['<?php echo $page;?>','<?php echo $post;?>','<?php echo $pageid;?>', 'novideo'];
            
            // Call the Javascript 'class' that will handle the client-side pop-up functions
            displaypop.determineTriggers(popupresponse, triggerresponse, miscArray, 0);

          },
        error: function(jqXHR, textStatus, errorThrown) {
          
                
                
        }
      });
  });
  </script>
  <?php
}

// Callback function for creating backups
function targetpop_display_popup_action_callback(){
  global $wpdb;
  global $post;
  check_ajax_referer( 'targetpop_display_popup_action_callback', 'security' );

  // Calling class-pop-up.php to check if any pop-ups should be displayed
  require_once(TARGETPOP_CLASS_DIR.'class-pop-up.php');
  $popup = new TargetPop_Pop_Up('trip');

  // Get additional misc data
  $misc_array = array(
    'page'=>is_page($post),
    'post'=>is_singular($post)
  );

  // Determine if user is on a mobile device
  // Include and instantiate the class.
  require_once TARGETPOP_INCLUDES_DIR.'mobile-detect/mobile-detect.php';
  $detect = new Mobile_Detect;

  // Any mobile device (phones or tablets).
  if ($detect->isMobile()) {
    foreach ($popup->tripped as $key => $pop) {
      if($pop->popupmobile == 'true'){
        // Remove this pop-up from being seen on mobile device
        unset($popup->tripped[$key]);
      }
    }
  }

  // Get popup and it's trigger data
  $trig = json_encode($popup->triggers);
  $popup = json_encode($popup->tripped);
  $misc_array = json_encode($misc_array);

  


  echo $popup.'--sep---seperator---sep--'.$trig.'--sep---seperator---sep--'.$misc_array;

  wp_die();
}

function targetpop_video_tracking_action_javascript() { 

  // Getting misc. things
  $pageid = get_the_id();
  $page = is_page($pageid);
  $post = is_single($pageid);

  ?>
    <script type="text/javascript" >
    "use strict";

  var YTdeferred = jQuery.Deferred();
  window.onYouTubePlayerAPIReady = function() {
      YTdeferred.resolve(window.YT);
  };

    jQuery(document).ready(function($) {

      // Modify embedded Youtube videos to enable event monitoring
      $('iframe').each(function(index){
      var src = $(this).attr('src');
      if(src != undefined){
        if(src.includes('youtube.com')){
          $(this).css({'display':'none'});
          var height = $(this).height();
          var width = $(this).width();
          $(this).after('<div id="targetpop-predictions-youtube-tracker-id-'+index+'"></div>');
          $('#targetpop-predictions-youtube-tracker-id-'+index).height(height);
          $('#targetpop-predictions-youtube-tracker-id-'+index).width(width);
          $(this).addClass('targetpop-predictions-youtube-tracker-class');

          var videoId = src.split("/").pop();
          var tag = document.createElement('script');
            tag.src = "//www.youtube.com/player_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

          YTdeferred.done(function(YT) {
              var player2 = new YT.Player('targetpop-predictions-youtube-tracker-id-'+index, {
              width: '640',
              height: '390',
              videoId: videoId,
              events: {
                onReady: onPlayerReady,
                onStateChange: onPlayerStateChange
              }
            });

            function onPlayerReady(event) {

            }

            // when video ends
            function onPlayerStateChange(event) {  
              // If user started video    
              if(event.data === 1) {      

                var src = $('#targetpop-predictions-youtube-tracker-id-'+index).attr('src');

                var data = {
                  'src': src,
                  'action': 'targetpop_video_tracking_action',
                  'security': '<?php echo wp_create_nonce( "targetpop_video_tracking_action_callback" ); ?>',
                };
                

                  var request = $.ajax({
                    url: ajaxurl,
                    type: "POST",
                    data:data,
                    timeout: 0,
                    success: function(response) {
                      response = response.split('--sep---seperator---sep--');
            
                      var popupresponse = JSON.parse(response[0]);
                      var triggerresponse = JSON.parse(response[1]);
                      var miscArray = ['<?php echo $page;?>','<?php echo $post;?>','<?php echo $pageid;?>', 'viewedvideo'];
                      
                      // Call the Javascript 'class' that will handle the client-side pop-up functions
                      displaypop.determineTriggers(popupresponse, triggerresponse, miscArray);
                    },
                  error: function(jqXHR, textStatus, errorThrown) {
                    
                          
                          
                  }
                });
              }
            }
          });    
        }
      }
    });
  });
  </script>
  <?php
}

// Callback function for creating backups
function targetpop_video_tracking_action_callback(){
  global $wpdb;
  check_ajax_referer( 'targetpop_video_tracking_action_callback', 'security' );
  
  // Calling class-pop-up.php to check if any pop-ups should be displayed
  require_once(TARGETPOP_CLASS_DIR.'class-pop-up.php');
  $popup = new TargetPop_Pop_Up('trip');

  // Get popup and it's trigger data
  $trig = json_encode($popup->triggers);
  $popup = json_encode($popup->tripped);

  echo $popup.'--sep---seperator---sep--'.$trig;

  wp_die();
}

// For listening for a TargetBox open/closing and recording data
function targetpop_targetbox_listen_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).bind('tbox_complete', function(){

        var uid = $('#targetbox').attr('data-uid')

        var data = {
          'action': 'targetpop_targetbox_listen_action',
          'security': '<?php echo wp_create_nonce( "targetpop_targetbox_listen_action_callback" ); ?>',
          'uid':uid
        };


        var request = $.ajax({
          url: ajaxurl,
          type: "POST",
          data:data,
          timeout: 0,
          success: function(response) {
          },
          error: function(jqXHR, textStatus, errorThrown) {
            
                  
                  
          }
        });

      });

      $(document).bind('tbox_closed', function(){

      });
  });
  </script>
  <?php
}

// Callback function for creating backups
function targetpop_targetbox_listen_action_callback(){
  global $wpdb;
  check_ajax_referer( 'targetpop_targetbox_listen_action_callback', 'security' );
  $uid = filter_var($_POST['uid'],FILTER_SANITIZE_STRING);

  require_once(TARGETPOP_CLASS_DIR.'class-pop-up.php');
  $popup = new TargetPop_Pop_Up('recordopen', null, $uid);
  echo $popup->popuprecordopen;

  wp_die();
}

// For activating a newly-created popup from the activation link
function targetpop_activate_link_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on("click","#targetpop-activate-new-popup", function(event){

        $('#wpbooklist-spinner-2').animate({'opacity':'1'})
        $('#targetpop-activate-new-popup').animate({'opacity':'0'}, 1000);
        var uid = $(this).attr('data-uid');

        var data = {
        'action': 'targetpop_activate_link_action',
        'security': '<?php echo wp_create_nonce( "targetpop_activate_link_action_callback" ); ?>',
        'uid':uid
      };
      

        var request = $.ajax({
          url: ajaxurl,
          type: "POST",
          data:data,
          timeout: 0,
          success: function(response) {
            if(response == 1){
              $('#targetpop-activate-new-popup').text('Pop-Up Succesfully Activated!');
            $('#wpbooklist-spinner-2').animate({'opacity':'0'})
            $('#targetpop-activate-new-popup').animate({'opacity':'1'}, 1000);
            }
            
          },
        error: function(jqXHR, textStatus, errorThrown) {
          
                
                
        }
      });

      event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}

// Callback function for creating backups
function targetpop_activate_link_action_callback(){
  global $wpdb;
  check_ajax_referer( 'targetpop_activate_link_action_callback', 'security' );
  $uid = filter_var($_POST['uid'],FILTER_SANITIZE_STRING);
  $table = $wpdb->prefix.'targetpop_saved_popups_log';
  $data = array('popupactive'=>'active');
  $where = array( 'popupuid' => $uid );
    $where_format = array( '%s' );
    echo $wpdb->update( $table, $data, $where, $format, $where_format );

  wp_die();
}
?>