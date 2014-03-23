<?php
/*
Plugin Name: Force-profile-update
Plugin URI: 
Description: A plugin that forces the imported users to fill their missing info on first login. If the user doen't have all the required fields filled in, it is redirected to the profile page.
Version: 1.0.0
Author: Erik Plestenjak
Author URI: 
License: GPLv2
*/

define('FORCE_PROFILE_UPDATE_VERSION', '1.0');
define('FORCE_PROFILE_UPDATE_PLUGIN_URL', plugin_dir_url( __FILE__ ));

add_action('wp_loaded', 'redirect_to_profile');
function redirect_to_profile() 
{
    if(!check_user_fields())
        if(strpos($_SERVER["REQUEST_URI"],'profile.php')== false)
        {
            wp_redirect( get_bloginfo('url').'/wp-admin/profile.php',302); exit;
        }
}


function check_user_fields()//the funcion check if the required fields have been filled in. If not it returns false.
{
    $user_id = get_current_user_id( );
    
    if($user_id)
    {    
        global $current_user;
 
        if(!$current_user->user_firstname)
                return false;
        if(!$current_user->user_lastname)
                return false;
        if(!get_cimyFieldValue($user_id, 'LC'))
                return false; 
        if(!get_cimyFieldValue($user_id, 'STUDY_FIELD'))
                return false; 
        if(!get_cimyFieldValue($user_id, 'GENDER'))
                return false; 
        if(!get_cimyFieldValue($user_id, 'BIRTH_DATE'))
                return false; 
        if(!get_cimyFieldValue($user_id, 'PROFILE_PICTURE'))
                return false;
    }    
    return true;
}


add_action( 'admin_notices', 'my_admin_notice' );
function my_admin_notice(){
     global $current_screen;
     if(!check_user_fields())
          echo '<div class="error"><p>NOTIFICATION: Your user profile info is incomplete. After you fill in the required information you will be able to access the webpage.</p></div>';
}

