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

/*
if ( is_admin() )
	require_once dirname( __FILE__ ) . '/admin.php';
*/

add_action('init', 'akismet_init');

add_filter( 'posts_where' , 'posts_where' );

function posts_where( $where ) {
	if( is_admin() ) {
		global $wpdb;
		
		if ( isset( $_GET['author_restrict_posts'] ) && !empty( $_GET['author_restrict_posts'] ) && intval( $_GET['author_restrict_posts'] ) != 0 ) {
			$author = intval( $_GET['author_restrict_posts'] );
		
			$where .= "AND ID IN (SELECT object_id FROM {$wpdb->term_relationships} WHERE term_taxonomy_id=$author )";
		}
	}
	return $where;
}

add_action( $hook, $function_to_add);