
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
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link href ="<?php bloginfo('stylesheet_url'); ?>" rel ="stylesheet">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
		<!-- Main navigation -->
			<div class="navbar navbar-default navbar-fixed-top">
                                    <div class="container">
                                        <a class="navbar-brand" href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/header_logo.png" title="home" alt="EESTEC" /></a>                                         
                                        
                                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                                            <span class="sr-only">Toggle navigation</span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                          </button>  
                                              <div class="collapse navbar-collapse navHeaderCollapse">
                                              
					        <?php 
							wp_nav_menu( array(
							  'menu' => 'homepage',
							  'depth' => 2,
							  'container' => false,
							  'menu_class' => 'nav navbar-nav',
							  //Process nav menu using our custom nav walker
							  'walker' => new wp_bootstrap_navwalker())
							);
							?>
                                                  <div class="row">
                                                      
                                                  <ul class="nav navbar-nav navbar-right signin" title="Login/register">
                                                    <li class="dropdown">
                                                        <a class="dropdown-toggle" href="#" data-toggle="dropdown" title="Sign In / Out">
                                                          <div class="visible-xs">Sign In/Out</div>
                                                      </a>
                                                      <div class="dropdown-menu" style="padding: 15px; padding-bottom: 10px;">
                                                      <?php if (is_user_logged_in()):                                                          
                                                          $current_user = wp_get_current_user();
                                                      
                                                          echo '<p>Hi '.$current_user->first_name.' '.$current_user->last_name.'!</p>';
                                                          echo '<p>You are logged in as <a href="'.get_edit_user_link($current_user->ID).'">'
                                                          . $current_user->user_login.'</a></p>';
                                                          
                                                      ?>
                                                          <a href="<?php echo wp_logout_url(site_url()); ?>">Log out</a>
                                                      <?php else: ?>
                                                         <?php wp_login_form( $args );
                                                         if ( !is_user_logged_in()):?>
                                                          <br />
                                                          <b>New member?</b>
                                                          <br />
                                                         <?php wp_register('','');endif; ?>
                                                        <?php endif; ?>
                                                      </div>
                                                    </li>
                                                  </ul>                                                      
                                                  
                                                  <div class="nav navbar-nav col-sm-3 pull-right">
                                                  <?php get_search_form(); ?>
                                                  </div>
                                                      
                                                  </div>
					    </div>                              
					  </div>
			</div>
                
		<!-- Main navigation end -->
		<header id="masthead" class="site-header" role="banner">
                    
		</header><!-- #masthead -->
		<div id="main" class="container site-main">
                    <div class="row">
