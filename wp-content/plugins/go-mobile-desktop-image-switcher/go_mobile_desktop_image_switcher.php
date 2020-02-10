<?php
/**
 * Plugin Name: Go Mobile/Desktop Image Switcher
 * Plugin URI: 
 * Description: Show different image depending on if viewing from mobile or desktop.
 * Version: 1.0
 * Author: Clayton Green
 * Author URI: https://www.github.com/claytongreen
 */

 class GO_mobile_desktop_image_switcher {

   function __construct($args = array()) {
     if (is_admin()) {
       add_action('admin_head', array($this, 'admin_head'));
     }
   }

   function admin_head() {
     if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
       return;
     }

     if (get_user_option('rich_editing') === 'true') {
       add_filter('mce_external_plugins', array($this, 'mce_external_plugins'));
       add_filter('mce_buttons', array($this, 'mce_buttons'));
     }
   }

   function mce_external_plugins($plugin_array) {
     $plugin_array['go_mobile_desktop_image_switcher'] = plugins_url('js/mce-button.js', __FILE__);
     return $plugin_array;
   }

   function mce_buttons($buttons) {
     array_push($buttons, 'go_mobile_desktop_image_switcher');
     return $buttons;
   }

 }

 new GO_mobile_desktop_image_switcher();
