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
		
	//print_r($cap);
	//print_r($args);
	
	if(get_post_type()=='lcs'){		
		if(current_user_has_role('intboard'))
			return $allcaps;
		     
		$allcaps['delete_post'] = false;
		$allcaps['edit_lcss'] = false; //disable adding new lcs.
		
		
		
		if($args[0]=='edit_post')
		{
		$lc=get_user_meta($current_user->ID,'lc',true);    //only members of the LC can edit the lc
		if($args[2]!=$lc)
			$allcaps[$cap[0]] = false;
			}}		
			
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
	if(get_user_meta($args[2],'lc')!=get_user_meta($current_user->ID,'lc'))
		$allcaps['edit_users']=false;
	return $allcaps;
}

add_action('save_post', 'link_event_to_lc');
function link_event_to_lc($post_id)
{

	if(get_post_type($post_id)=='events'){
		print_r($post_id);
		$meta_value=get_user_meta(get_current_user_id(),'lc',true);
		add_post_meta($post_id,'lc', $meta_value,true);
		}	
}

add_filter( 'user_has_cap', 'edit_events', 100, 3 );

function edit_events($allcaps, $cap, $args)
{	
	global $current_user;
	if(array_key_exists('manage_options',$allcaps))//user is admin
		return $allcaps;
	
	//print_r($cap);
	//print_r($args);
	
	if(get_post_type()=='events'){     
		$allcaps['delete_post'] = false;
		
		if($args[0]=='edit_post')
		{
		$lc=get_user_meta($current_user->ID,'lc',true);    //only members of the LC can edit the lc
		if( get_post_meta($args[2],'lc',true)!=$lc)
			$allcaps[$cap[0]] = false;
			}}		
			
	return $allcaps;
}

add_action( 'restrict_manage_posts','hide_other_events');
function hide_other_events($test)
{
		print_r($test);
}

?>