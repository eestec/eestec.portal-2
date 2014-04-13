<?php
/**
 * International functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage International
 * @since International 1.0
 */

/**
 * Sets up theme defaults and registers the various WordPress features that
 * International supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since International 1.0
 *
 * @return void
 */
require_once('wp_bootstrap_navwalker.php');
// custom menu example @ http://digwp.com/2011/11/html-formatting-custom-menus/
function clean_custom_menus() {
	$menu_name = 'nav-primary'; // specify custom menu slug
	if (($locations = get_nav_menu_locations()) && isset($locations[$menu_name])) {
		$menu = wp_get_nav_menu_object($locations[$menu_name]);
		$menu_items = wp_get_nav_menu_items($menu->term_id);

		
		$menu_list .= "\t\t\t\t". '<ul class="nav">' ."\n";
		foreach ((array) $menu_items as $key => $menu_item) {
			$title = $menu_item->title;
			$url = $menu_item->url;
			$menu_list .= "\t\t\t\t\t". '<li><a href="'. $url .'">'. $title .'</a></li>' ."\n";
		}
		$menu_list .= "\t\t\t\t". '</ul>' ."\n";
		
	} else {
		// $menu_list = '<!-- no list defined -->';
	}
	echo $menu_list;
}

function international_setup() {
    
	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	
        //add_editor_style( array( 'css/editor-style.css', 'fonts/genericons.css', international_fonts_url() ) );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
        
        /*
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );
         */
        
        //register_nav_menu( 'default', 'Default', 'international' );
        register_nav_menu( 'homepage', 'Homepage Menu', 'international' );
        //register_nav_menu( 'student', 'Student Menu', 'international' );
        //register_nav_menu( 'company', 'Company Menu', 'international' );        
        register_nav_menu( 'sitemap', 'Sitemap', 'international' );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'international_setup' );


/* the bootstrap is taking care of our thumbnail sizing so we have to remove the atributes */
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}

/**
 * Enqueues scripts and styles for front end.
 *
 * @since International 1.0
 *
 * @return void
 */
function international_scripts_styles() {
	// Add Open Sans and Bitter fonts, used in the main stylesheet.
	//wp_enqueue_style( 'international-fonts', international_fonts_url(), array(), null );

	// Add Genericons font, used in the main stylesheet.
	//wp_enqueue_style( 'genericons', get_template_directory_uri() . '/fonts/genericons.css', array(), '2.09' );

	// Loads our main stylesheet.
	wp_enqueue_style( 'international-style', get_stylesheet_uri(), array(), '2014-03-14' );
        
        //include the jquery
        wp_deregister_script('jquery');
   		wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js", false, '1.11.0');
   		wp_enqueue_script('jquery');
        
        // Load bootstrap javascript
        wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.js', array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'international_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since International 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function international_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'international' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'international_wp_title', 10, 2 );

/**
 * Registers two widget areas.
 *
 * @return void
 */
function international_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'international' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the footer section of the site.', 'international' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => 'Secondary Widget Area',
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'international' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'international_widgets_init' );

if ( ! function_exists( 'international_paging_nav' ) ) :
/**
 * Displays navigation to next/previous set of posts when applicable.
 *
 * @since International 1.0
 *
 * @return void
 */
function international_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'international' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'international' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'international' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'international_post_nav' ) ) :
/**
 * Displays navigation to next/previous post when applicable.
*
* @since International 1.0
*
* @return void
*/
function international_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'international' ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'international' ) ); ?>
			<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'international' ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'international_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own international_entry_meta() to override in a child theme.
 *
 * @since International 1.0
 *
 * @return void
 */
function international_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . __( 'Sticky', 'international' ) . '</span>';

	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		international_entry_date();

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'international' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'international' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	// Post author
	if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'international' ), get_the_author() ) ),
			get_the_author()
		);
	}
}
endif;

if ( ! function_exists( 'international_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own international_entry_date() to override in a child theme.
 *
 * @since International 1.0
 *
 * @param boolean $echo Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function international_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'international' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'international' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

if ( ! function_exists( 'international_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 *
 * @since International 1.0
 *
 * @return void
 */
function international_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'international_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Returns the URL from the post.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since International 1.0
 *
 * @return string The Link format URL.
 */
function international_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Extends the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since International 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function international_body_class( $classes ) {
	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )
		$classes[] = 'sidebar';

	if ( ! get_option( 'show_avatars' ) )
		$classes[] = 'no-avatars';

	return $classes;
}
add_filter( 'body_class', 'international_body_class' );

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since International 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @return void
 */
function international_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'international_customize_register' );

/**
 * Binds JavaScript handlers to make Customizer preview reload changes
 * asynchronously.
 *
 * @since International 1.0
 */

// Replaces the excerpt "more" text by a link
function new_excerpt_more($more) {
       global $post;
       if(is_home())
	return '<a class="moretag" href="'. get_permalink($post->ID) . '"> ...More>></a>';
       else
           return'...';
}
add_filter('excerpt_more', 'new_excerpt_more');


date_default_timezone_set ('Europe/Ljubljana');
function date_parse_timestamp($date)
{
	$date=date_parse($date);
	return mktime(23,59, 59, $date['month'], $date['day'], $date['year']);
}

//Function for general date priting use
function print_date($date)
{
	$timestamp = date_parse_timestamp($date);
	echo date('d.m.Y', $timestamp);
}

//A function used to calculate the remaining time until deadline
function remaining_time($time)
{
	$result='';
	if($time->y){
		$result.=$time->y.' year  ';
		if($time->m)
			$result.=$time->m.' months  ';}
	else
	{
	if($time->m){
		$result.=$time->m.' months  ';
		if($time->d)
			$result.=$time->d.' days  ';}
	else
	{
	if($time->d)
			$result.=$time->d.' days  ';
	if($time->d<8)
		{
		if($time->h)
			$result.=$time->h.' hours  ';
		if($time->i)
			$result.=$time->i.' minutes  ';
	}}}
		return $result;
}


// Function for getting the root parrent of a page
function get_root_parent_id( $page_id ) {
	global $wpdb;
	$parent = $wpdb->get_var( "SELECT post_parent FROM $wpdb->posts WHERE post_type='page' AND post_status='publish' AND ID = '$page_id'" );
	if( $parent == 0 ) return $page_id;
	else return get_root_parent_id( $parent );
}


//A function that when called, returns what kind of visitor/content is beeing displayed (company, sutdent, university, neutral)
function get_visitor_type(){
    global $post;
    $page_id=get_root_parent_id($post->ID);
    if($page_id == 3952)
            return 'student';
    if($page_id == 3957)
            return 'company';
    return 'homepage';
}


/* declaration of event post type */
$labels = array(
	'name' => _x( 'Events', 'post type general name' ),
	'singular_name' => _x( 'Event', 'post type singular name' ),
	'add_new' => __( 'Add New Event' ),
	'add_new_item' => __( 'Add New Event' ),
	'edit_item' => __( 'Edit Event' ),
	'new_item' => __( 'New Event' ),
	'view_item' => __( 'View Event' ),
	'search_items' => __( 'Search Events' ),
	'not_found' => __( 'No events found.' ),
	'not_found_in_trash' => __( 'No events found in Trash.' ),
	'menu_name' => __( 'Events' ),
);
$args = array(
	'labels' => $labels,
	'description' => 'An eestec organized event with applications.',
	'public' => true,
	'publicly_queryable' => true,
	'exclude_from_search' => false,
	'show_ui' => true,
	'menu_position' => 5,
	'menu_icon' => null,
	'capability_type' => post,
	'hierarchical' => false,
	'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'revisions', 'page-attributes', ),
	'taxonomies' => array(),
	'rewrite' => array('slug' => events, 'with_front' => true, ),
	'query_var' => true,
	'can_export' => true,
	'show_in_nav_menus' => true,
);
register_post_type('events', $args);

/* declaration of LC post type */

$labels = array(
	'name' => _x( 'LCs', 'post type general name' ),
	'singular_name' => _x( 'LC', 'post type singular name' ),
	'add_new' => __( 'Add New LC' ),
	'add_new_item' => __( 'Add New LC' ),
	'edit_item' => __( 'Edit LC' ),
	'new_item' => __( 'New LC' ),
	'view_item' => __( 'View LC' ),
	'search_items' => __( 'Search LCs' ),
	'not_found' => __( 'No lcs found.' ),
	'not_found_in_trash' => __( 'No lcs found in Trash.' ),
	'menu_name' => __( 'LCs' ),
);
$args = array(
	'labels' => $labels,
	'description' => 'A LC-s main info page.',
	'public' => true,
	'publicly_queryable' => true,
	'exclude_from_search' => true,
	'show_ui' => true,
	'menu_position' => 20,
	'menu_icon' => null,
	'capability_type' => post,
	'hierarchical' => false,
	'supports' => array('title', 'editor', 'author', 'revisions', ),
	'taxonomies' => array(),
	'rewrite' => array('slug' => LC, 'with_front' => true, ),
	'query_var' => true,
	'can_export' => true,
	'show_in_nav_menus' => true,
);
register_post_type('LCs', $args);