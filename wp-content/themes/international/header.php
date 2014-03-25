
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
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link href ="<?php bloginfo('stylesheet_url'); ?>" rel ="stylesheet">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<!-- Main navigation -->
			<div class="navbar">
					  <div class="navbar-inner">
					    <div class="container">
					 
					      <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
					      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					        <span class="icon-bar"></span>
					      </a>
					 
					      <!-- Be sure to leave the brand out there if you want it shown -->
					      <a class="brand" href="#">EESTEC logo</a>
					 
					      <!-- Everything you want hidden at 940px or less, place within here -->
					      <div class="nav-collapse collapse">
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
							<?php get_search_form(); ?>
							<?php wp_loginout(); ?>
					      </div>
					 
					    </div>
					  </div>
			</div>
		<!-- Main navigation end -->
		<header id="masthead" class="site-header" role="banner">
				<!--<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"> -->
				<!-- <h1 class="site-title"><?php bloginfo( 'name' ); ?></h1> -->
				<!-- <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2> -->
				<!--</a> -->

			
							<!-- <h3 class="menu-toggle"><?php _e( 'Menu', 'international' ); ?></h3> -->
							<!-- <a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'international' ); ?>"><?php _e( 'Skip to content', 'international' ); ?></a> -->
							
							
						
		</header><!-- #masthead -->

		<div id="main" class="site-main">
