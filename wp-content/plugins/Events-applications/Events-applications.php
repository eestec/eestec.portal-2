<?php
/**
 * @package Events applications
 */
/*
Plugin Name: Events applications
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

define('EVENTS_APPLICATIONS_VERSION', '1.0');
define('EVENTS_APPLICATIONS_PLUGIN_URL', plugin_dir_url( __FILE__ ));


/*
<?php if ( isset( $_GET['type'] ) ) { ?>
	<input type="hidden" name="presettype" id="presettype" value="<?php echo $_GET['type']; ?>" />
<?php } ?>
*/

// registering the appications post type
add_action('init', 'applications_register');

function applications_register(){
	
$labels = array(
	'name' => _x( 'Applications', 'post type general name' ),
	'singular_name' => _x( 'Application', 'post type singular name' ),
	'add_new' => __( 'Add New Application' ),
	'add_new_item' => __( 'Add New Application' ),
	'edit_item' => __( 'Edit Application' ),
	'new_item' => __( 'New Application' ),
	'view_item' => __( 'View Application' ),
	'search_items' => __( 'Search Applications' ),
	'not_found' => __( 'No applications found.' ),
	'not_found_in_trash' => __( 'No applications found in Trash.' ),
	'menu_name' => __( 'Applications' ),
);


$args = array(
	'labels' => $labels,
	'description' => 'Applications for eestec events.',
	'public' => true,
	'publicly_queryable' => false,
	'exclude_from_search' => true,
	'show_ui' => true,
	'menu_position' => 20,
	'menu_icon' => null,
	'capability_type' => 'post',
	'hierarchical' => false,
	'supports' => array('editor', 'custom-fields', ),
	'taxonomies' => array(),
	'rewrite' => true,
	'query_var' => true,
	'can_export' => false,
	'show_in_nav_menus' => false,
);
register_post_type('Applications', $args);
}

//hiding application post type from the admin menu (except for the admin)
add_action( 'admin_menu', 'hide_applications');
function hide_applications()
{
    remove_menu_page( 'edit.php?post_type=applications' );
}

//by passing the event ID, the function returs a "create new application", "edit existing application" URL or false.
function get_application_permalink($event_id)
{
	
	$now = new DateTime();
	$ref = new DateTime();
	$ref->setTimestamp(date_parse_timestamp(get_field('application_deadline',$event_id)));
	if($now>$ref)//checking if the application deadline has passed
		return false;
				
	$event = get_post($event_id);
	if(user_can_apply($event_id))
		return get_bloginfo('url').'/wp-admin/post-new.php?post_type=applications&event='.$event_id;
	else if(get_application($event_id)){
		$application=get_application($event_id);
		return get_bloginfo('url').'/wp-admin/post.php?post='.$application->ID.'&action=edit';
		}
	return false;
}

function the_application_permalink($event_id)
{
	if (!get_application_permalink($event_id))
		return false; //if the application deadline has passed
	$event = get_post($event_id);
	if(user_can_apply($event_id))
		echo '<a href="'.get_bloginfo('url').'/wp-admin/post-new.php?post_type=applications&event='.$event_id.'" title="Apply for '.$event->post_title.'!">Apply</a>';
	else if(get_application($event_id)){
		$application=get_application($event_id);
		echo '<a href="'.get_bloginfo('url').'/wp-admin/post.php?post='.$application->ID.'&action=edit" title="Edit '.$event->post_title.' application!">Edit application</a>';}	
}


function view_applications_permalink($event_id)//a function for generating a link to list of applications
{
	//add required capability (edit_other_posts)
	echo '<a href="'.get_bloginfo('url').'/wp-admin/edit.php?post_type=applications&event='.$event_id.'" title="View event applications.">Applications</a>';
}

function user_can_apply($event_id)// maybe remove this function since its ambiguous
{			
	//if the user has previousely submmited an application for this post
	if ( get_application($event_id))
		return false;
	return true;
}

function get_application($event_id)
{
	global $current_user;
	//if the user has previousely submmited an application for this post
	$the_query = new WP_Query('post_type=applications&posts_per_page=-1&author='.$current_user->ID.'&meta_key=event&meta_value='.$event_id);
			
	//if the user has previousely submmited an application for this post
	if ( $the_query->have_posts() || !$event_id)
		return $the_query->next_post();
		
	//add filtering based on event aplication deadline
	return false;
}

add_filter('manage_events_posts_columns' , 'add_applications_column');
function add_applications_column( $columns ) {
    return array_merge( $columns, array( 'event_apply' =>'Apply', 'view_applications' => 'View applications'));
}


add_action('manage_events_posts_custom_column','application_links_list', 10, 2 );//displaying appropriate links on the events admin list.
function application_links_list($column, $post_id)
{
	if($column=='event_apply')
		the_application_permalink($post_id);
	if($column=='view_applications')
		view_applications_permalink($post_id);
}


add_filter( 'parse_query', 'applications_list_filter' ); //filtering lists of applications per event
function applications_list_filter( $query ){
    global $pagenow;
	if(isset($_GET['post_type']))
    if ($_GET['post_type'] == 'applications' && is_admin() && $pagenow=='edit.php') {
        $query->query_vars['meta_key'] = 'event';
		if(!isset($_GET['event']))//display nothing if event not set
			$query->query_vars['author'] = -1;//user with -1 does not exist so nothing gets returned
		else
        $query->query_vars['meta_value'] = $_GET['event'];
    }
    
}

/* additional colums on the applications list */
add_filter( 'manage_edit-applications_columns', 'list_applications_columns' );
function list_applications_columns($old_columns) {
    /*
    unset( $columns['title'] );
    unset( $columns['author'] );
    unset( $columns['date'] );
    */
    
    //$columns['cb'] = 'Accept';
    if($_GET['status']=='accepted')
        $columns['deny'] = 'Deny';
    else        
        $columns['accept'] = 'Accept';
    $columns['details'] = 'Application';
    $columns['name'] = 'Name';
    //$columns['author'] = 'Username';    
    $columns['lc'] = 'LC';    
    $columns['Priority'] = 'Priority';

    return $columns;
}

add_action( 'manage_applications_posts_custom_column' , 'custom_application_columns', 10, 2 );
function custom_application_columns( $column, $post_id ) {
    switch ( $column ) {      
        case 'name' :  // printing the candidates full name
            echo  get_the_author_meta('first_name').' '.get_the_author_meta('last_name');            
            break;
        case 'lc' : // printing the candidates LC
            echo get_the_title(get_the_author_meta('lc')); //random bug  
            break;
        case 'details' : // printing the candidates LC
            //echo '<a href="'.get_permalink().'">Details</a>'; 
            echo '<a href="'.get_edit_post_link().'">Details</a>'; //we need some kind of noedit view implemented
            break;
        case 'accept':
             echo '</form><form name="acceptApplication" method="post" action="" >
                 <input type="hidden" name="acceptApplication" value="true"/>                 
                 <input type="hidden" name="event" value="'.$_GET['event'].'"/>
                 <input type="hidden" name="applicationid" id="applicationid" value="'.get_the_id().'" />
                 <input type="checkbox" onclick="this.form.submit();" />
             </form>';
            break;
        case 'deny':
             echo '</form><form name="denyApplication" method="post" action="" >
                 <input type="hidden" name="denyApplication" value="true"/>               
                 <input type="hidden" name="event" value="'.$_GET['event'].'"/>
                 <input type="hidden" name="applicationid" id="applicationid" value="'.get_the_id().'" />
                 <input type="checkbox" onclick="this.form.submit();" />
             </form>';
            break;
    }
}

//accepting/denying of the applications via submited form data
add_action( 'views_edit-applications', 'applications_handle' );
function applications_handle( $views )
{
    if(isset($_POST['acceptApplication']))
    {
       update_post_meta($_POST['applicationid'], 'status', 'accepted');
       email_notification($_POST['applicationid']);
    }
    
    if(isset($_POST['denyApplication']))
        update_post_meta($_POST['applicationid'], 'status','pending');     
}

//additional tabs on the list and removing default ones
add_action( 'views_edit-applications', 'remove_edit_post_views' );
function remove_edit_post_views( $views ) {
    
    unset($views['all']);
    unset($views['draft']);
    unset($views['publish']);    
    
    // count the unaccepted applications
    $args = array(
        'post_type' => 'applications',
        'showposts' => -1,
	'meta_query' => array(
            array(
		'key'     => 'event',
		'value'   => $_GET['event'],
		'compare' => '='
                ),
            array(
		'key'     => 'status',
		'value'   => 'pending',
		'compare' => '='
                )
	)
    );
    $query = new WP_Query($args);     
    $views['pending'] = '<a href="edit.php?post_type=applications&event='.$_GET['event'].'">Pending <span class="count">('.$query->post_count.')</span></a>'; //could and numbers

    //count the accepted applications
    $args = array(
        'post_type' => 'applications',
        'showposts' => -1,
	'meta_query' => array(
            array(
		'key'     => 'event',
		'value'   => $_GET['event'],
		'compare' => '='
                ),
            array(
		'key'     => 'status',
		'value'   => 'accepted',
		'compare' => '='
                )
	)
    );    
    $query = new WP_Query($args);    
    $views['accepted'] = '<a href="edit.php?post_type=applications&event='.$_GET['event'].'&status=accepted">Accepted <span class="count">('.$query->post_count.')</span></a>';
    return $views;
}


add_action('pre_get_posts', 'my_special_list');
function my_special_list( $q ) {
  if(is_admin()){
  $scr = get_current_screen();
  if ( ( $scr->base === 'edit' ) && $q->is_main_query() ) {
    // To target only a post type uncomment following line and adjust post type name
    if ( $scr->post_type !== 'applications' ) return;
    // if you change the link in function above adjust next line accordingly
    $pre = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);
    if ( $pre === 'status' ) {
      $meta_query = array( 'key' => 'is_special', 'value' => 'yes', );
      $q->set( 'meta_query', array($meta_query) ); //correction here
    }
  }}
}

//filtering the posts on pending/accepted applications
add_filter( 'pre_get_posts', 'accepted_denied_applications_filter' );
function accepted_denied_applications_filter( $query ){
    global $pagenow;
    $type = 'post';
    if (isset($_GET['post_type'])) {
        $type = $_GET['post_type'];
    }
    if ( 'applications' == $type && is_admin() && $pagenow=='edit.php' && $query->is_main_query()) {        
        if(isset($_GET['status']) && $_GET['status']=='accepted')
        {            
            $query->query_vars['meta_key'] = 'status';
            $query->query_vars['meta_value'] = 'accepted';
        }
        else
        {
            $query->query_vars['meta_key'] = 'status';
            $query->query_vars['meta_value'] = 'pending';
        } 
        
    }
}

//removing bulk list actions
add_filter( 'bulk_actions-' . 'edit-applications', '__return_empty_array' );



add_filter( 'user_has_cap', 'add_application', 100, 3 );
function add_application($allcaps, $cap, $args)
{
        //print_r($cap);
	//print_r($args);
	global $current_user;
		
	if(get_post_type()=='applications')
	{
		
		//print_r($cap);
		//print_r($args);
		$allcaps['upload_files']=false;//disabling file upload
		
		
		/*		
		if($args[0]=='publish_posts')
		{		
			if(!isset($_GET['event']))
			{
				$allcaps['publish_posts']=false;				
				$allcaps['edit_posts']=false;
			}	
			else if (!user_can_apply($_GET['event']))
			{
				//add showing restricted screen				
				$allcaps['publish_posts']=false;				
				$allcaps['edit_posts']=false;
			}
		}*/	
		}		
			
	return $allcaps;
}


add_action('save_post', 'link_application_to_event');
function link_application_to_event($post_id)
{

	if(get_post_type($post_id)=='applications')
	{
		//writing the event ID of the application to the application meta
		add_post_meta($post_id,'event',$_GET['event'],true);
                //seting the applications as pending
                add_post_meta($post_id,'status','pending',true);
		}	
}

//put the event of the aplication on the application edit screen.
add_action( 'edit_form_after_title', 'event_name_of_application' );
function event_name_of_application() {
        if(get_post_type($post_id)=='applications')
	{
	$event = get_post(get_post_meta(get_the_ID(),'event',true));
		
    echo '<h1>'.$event->post_title.' application</h1>';
        }
}


function email_notification($application_id) //a function for sending email notifications on applications status change.
{
    $to = get_post($application_id)->post_author;
    $to = get_the_author_meta('user_email', $to);
    
    $event = get_post(get_post_meta($application_id,'event'))->title;
    $headers = 'From: EESTEC international <noreply@eestec.com>' . "\r\n";
    
    if(get_post_meta($application_id,'status')=='accepted')
    {
        $message = 'We are happy to inform you that your application to event "'.$event.'" has been accepted.'
                . ' If you have any questions or need additional information please don\'t hesitate to ask the contact person of the organizer LC. '
                . 'The CP-s email address is:';
        wp_mail( $to,'Event application accepted!', $message, $headers);
    }
    /*
    if(get_post_meta($application_id,'status')=='pending')
    {
        wp_mail( $to, $subject, $message, $headers, $attachments );
    }*/
}

?>