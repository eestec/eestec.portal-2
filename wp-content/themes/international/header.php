
<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage International
 * @since International 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link href ="<?php bloginfo('stylesheet_url'); ?>" rel ="stylesheet">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<!-- Main navigation -->
			<div class="navbar row">
					  <div class="navbar-inner">
					    <div class="container">					 
					      <!-- Be sure to leave the brand out there if you want it shown -->
                                              <div class="span2">
                                                <a class="brand" href="#">EESTEC logo</a>
                                              </div>                                              
					      <!-- Everything you want hidden at 940px or less, place within here -->                                              
                                              
					      <div class="nav-collapse collapse">
                                              <div class="span6">
					        <!-- .nav, .navbar-search, .navbar-form, etc -->
					        <?php /* Primary navigation */
							wp_nav_menu( array(
							  'menu' => 'homepage',
							  'depth' => 2,
							  'container' => false,
							  'menu_class' => 'nav',
							  //Process nav menu using our custom nav walker
							  'walker' => new wp_bootstrap_navwalker())
							);
							?>
                                             </div>
                                             <div class="span4">
							<?php get_search_form(); ?>
							<?php wp_loginout(); ?>
                                             </div>                                                  
                                             </div>
					 
					    </div>
					  </div>
			</div>
                
		<!-- Main navigation end -->
		<header id="masthead" class="site-header" role="banner">
                    
		</header><!-- #masthead -->
                
		<div id="main" class="site-main">
