<?php
/*
Plugin Name: Advanced Custom Fields: LC board picker
Description: LC board picker field used on LC pages.
Version: 2.0.12
Author: Erik Plestenjak
Author URI: reik.plestenjak.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


class acf_field_lcboard_picker_plugin
{
	/*
	*  Construct
	*
	*  @description:
	*  @since: 3.6
	*  @created: 1/04/13
	*/

	function __construct()
	{
		// set text domain
		//$domain = 'acf-lcboard_picker';
		//$mofile = trailingslashit(dirname(__File__)) . 'lang/' . $domain . '-' . get_locale() . '.mo';
		//load_textdomain( $domain, $mofile );


		// version 4+
		add_action('acf/register_fields', array($this, 'register_fields'));


		// version 3-
		//add_action( 'init', array( $this, 'init' ));
	}


	/*
	*  Init
	*
	*  @description:
	*  @since: 3.6
	*  @created: 1/04/13
	*/
        
        

	function init()
	{
		/*if(function_exists('register_field'))
		{
			register_field('acf_field_lc_board_picker', dirname(__File__) . '/lcboard-picker.php');
		}*/
	}
        
	/*
	*  register_fields
	*
	*  @description:
	*  @since: 3.6
	*  @created: 1/04/13
	*/

	function register_fields()
	{
		include_once('lcboard-picker.php');
	}

}

new acf_field_lcboard_picker_plugin();

?>