<?php
/**
 * TargetPop UI Display Template Class
 *
 * @author   Jake Evans
 * @category Display
 * @package  Includes/Classes/UI/Display
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'TargetPop_UI_Display_Template', false ) ) :
/**
 * TargetPop_UI_Display_Template Class.
 */
class TargetPop_UI_Display_Template {

    public static function output_open_display_container($title, $iconurl){
      return '<div class="targetpop-display-tp-container">
            <p class="targetpop-display-tp-top-title"><img class="targetpop-display-tp-title-icon" src="'.$iconurl.'" />'.$title.'</p>
            <div class="targetpop-display-tp-inner-container">';
    }

    public static function output_close_display_container(){
      return '</div></div>';
    }

    public static function output_template_advert(){
      return '<div class="targetpop-display-tp-container">
              <div id="targetpop-display-tp-advert-site-div">
                  <div id="targetpop-display-tp-advert-visit-me-title">For Everything TargetPop</div>
                  <a target="_blank" id="targetpop-display-tp-advert-visit-me-link" href="http://targetpop.io/">
                    <img src="'.TARGETPOP_ROOT_IMG_URL.'targetpopwebsite.png">
                    TargetPop.io
                  </a>
              </div>
              <p id="targetpop-display-tp-advert-email-me">E-mail with questions, issues, concerns, suggestions, or anything else at <a href="mailto:general@targetpop.io">General@targetpop.io</a></p>
              <div id="targetpop-display-tp-advert-money-container">
                  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="VUVFXRUQ462UU">
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                  </form>

                  <a target="_blank" id="targetpop-patreon-link" href="http://patreon.com/user?u=3614120"><img id="targetpop-patreon-img" src="'.TARGETPOP_ROOT_IMG_URL.'patreon.png"></a>
                  <a href="https://ko-fi.com/A8385C9" target="_blank"><img height="34" style="border:0px;height:34px;" src="'.TARGETPOP_ROOT_IMG_URL.'kofi1.png" border="0" alt="Buy Me a Coffee at ko-fi.com"></a>
                  <p>And be sure to <a target="_blank" href="https://wordpress.org/support/plugin/targetpop/reviews/">leave a 5-star review of TargetPop!</a></p>
              </div>
            </div>';
    }

}

endif;


