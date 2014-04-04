<?php 
/**
* Plugin Name: Top 25 Social Icons
* Version: 1.0
* Description: Add Social Icons in your wordpress site. you can Share your Social Networks' profile withe users. Multi Color tooltips and also manage the Size of the  Social Icons.  You can easily Manage the social icon Images. Following Social Networks are added:Facebook, Twitter, Pinterest, Youtube, Google+, Digg, Reddit, LinkedIn, Instagram, Flicker, Dribble, Email, InstaGram, Vimeo, YELP, Tumblar, StumbleUpon, Skype, Evernote, Github, RSS, MySpace, Forrst, Deviantart, Last.fm, Xing
* Author:  Vyas Dipen
* Author URI: http://vyasdipen.wordpress.com/
*Plugin URI:http://vyasdipen.wordpress.com/


*/

 
add_action('wp_enqueue_scripts', 'add_scripts');

add_action('admin_menu', 'menu_admin_type');

add_action('admin_init', 'register_toptwenfive_settings');
 
function menu_admin_type() {

add_submenu_page( 'options-general.php', 'Top 25 Social Icons -  Manage Options', 'Top25 Social Icons', 'manage_options', 'top25-social-icons', toptwenfive_backend_sub_menu );

} 

function toptwenfive_backend_menu(){
 
include('admin/toptwenfive-socials.php');

}

function toptwenfive_backend_sub_menu(){

include('admin/options.php');

}
   
  
function register_toptwenfive_settings(){    
	register_setting( 'toptwenfive-setting-items', 'tooltips' );
	register_setting( 'toptwenfive-setting-items', 'color-tips' );
	register_setting( 'toptwenfive-setting-items', 'imgw' );
	register_setting( 'toptwenfive-setting-items', 'imgh' );
	register_setting( 'toptwenfive-setting-items', 'targetlinks' ); 
	register_setting( 'toptwenfive-setting-items', 'images-type' );
	
} 

function add_scripts(){  

if( !is_admin() ){
if(get_option('images-type') == 'circle48'){ $ttps = '-48';}
if(get_option('images-type') == 'square48'){ $ttps = '-s48';}
if(get_option('images-type') == 'circle64'){ $ttps = '-64';}
wp_enqueue_style('Toptwenfive-social-icons',plugins_url('css/toptwenfive.css',__FILE__));

$col = get_option('color-tips'); $tp = get_option('tooltips');




if($tp == '1'){

		 wp_enqueue_style('Toptwenfive-social-tool-icons',plugins_url('css/tips/'.$col.'/'.$col.$ttps.'.css',__FILE__));

			   }

  				}
}

/*-------  Widget Code -------*/

include('admin/widget.php');