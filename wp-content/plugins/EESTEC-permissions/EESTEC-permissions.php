<?php
/**
 * @package EESTEC permissions
 */
/*
Plugin Name: EESTEC permissions
Plugin URI: http://erik.plestenjak.com
Description: The plugin implement EESTEC specific access permissions which are not available by using the other plugins.

Version: 1.0
Author: Erik Plestenjak
Author URI: http://erik.plestenjak.com
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Make sure we don't expose any info if called directly
/*if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}*/

define('EESTEC_PERMISSIONS_VERSION', '1.0');
define('EESTEC_PERMISSIONS_PLUGIN_URL', plugin_dir_url( __FILE__ ));


//give int board access to editing menu
//give lc board permssion to add events
//automate locking meta of lc on events
//store organizer lc on the event
//restrict user editing to same lc
//correct the user confirmation plugin to support can user edit (confirming only editable users)
//remap all events

function get_current_user_roles(){
	global $current_user;
	return $current_user->roles;
	return $user_roles;
}

function current_user_has_role($role)
{
	return in_array($role,get_current_user_roles());
}

add_filter( 'user_has_cap', 'edit_lcs', 100, 3 );
function edit_lcs($allcaps, $cap, $args)
{	
	global $current_user;        
	if(array_key_exists('manage_options',$allcaps))//user is admin
		return $allcaps;
                
	if(get_post_type()=='lcs'){
            
		if(current_user_has_role('lcboard'))
                    if($args[0]=='edit_post')
                    $allcaps[$cap[0]] = ($args[2]==get_cimyFieldValue($current_user->ID,'lc'));//only members of the LC can edit the lc                  
                    }
	return $allcaps;
}


add_filter( 'user_has_cap', 'edit_users', 100, 3 );//restricts editable users to same LC only
function edit_users($allcaps, $cap, $args)
{	
	global $current_user;
	if(array_key_exists('manage_options',$allcaps))//user is admin
		return $allcaps;

	//print_r($cap);
	//print_r($args);
	
	if($args[0]=='edit_user')
	if(get_cimyFieldValue($args[2],'lc')!=get_cimyFieldValue($current_user->ID,'lc'))
        {
		$allcaps['edit_users']=false;
                $allcaps['edit_user']=false;
                
        }        
	return $allcaps;
}


add_action('save_post', 'link_event_to_lc'); // the temporary organizer has to be removed! Not working :(
function link_event_to_lc($post_id)
{
        global $current_user;
        if(get_post_meta($post_id,'lc', true)=='')
        {
		$lc=get_cimyFieldValue($current_user->ID,'lc');
                add_post_meta($post_id,'lc', $lc, true);
        }	
}

add_filter( 'user_has_cap', 'edit_events', 100, 3 );
function edit_events($allcaps, $cap, $args)
{	
	global $current_user;
	//if(array_key_exists('manage_options',$allcaps))//user is admin
    //		return $allcaps;
        
	if(get_post_type()=='events'){
            	//print_r($cap);
                //print_r($allcaps);
                //print_r($args);
                if(current_user_has_role('lcboard'))
                {                    
                    $allcaps['delete_published_eventss']=false;
                    //$allcaps['edit_eventss']=false;
                    $allcaps['edit_others_eventss']=false;                    
                    $allcaps['delete_others_eventss']=false;
                    if(is_admin()) 
                        $allcaps['read_private_eventss'] = False;
                    
		$lc=get_cimyFieldValue($current_user->ID,'lc');    //only members of the LC can edit the lc events
                    if (get_post_meta($args[2],'lc',true)==$lc)
                    {
                        $allcaps['delete_published_eventss']=true;
                        $allcaps['edit_eventss']=true;
                        $allcaps['edit_others_eventss']=true;                    
                        $allcaps['delete_others_eventss']=true;
                    }
                }         
        }
	return $allcaps;
}


add_action( 'admin_menu', 'remove_menus',100,3 ); //cleaning up the menu for average users.
function remove_menus(){
    
    global $submenu;
    if( !current_user_can( 'manage_options' ))
    {
        remove_menu_page( 'tools.php' );                  //Tools
        remove_menu_page( 'rs-category-restrictions_t' ); //Removing role scoper menu
        remove_menu_page( 'rs-general_roles' );           // role scoper menu
        remove_menu_page( 'tools.php' );                  //Tools
        remove_submenu_page( 'users.php','rs-groups' );   // removing role scoper option from users menu
    }    
}


?>