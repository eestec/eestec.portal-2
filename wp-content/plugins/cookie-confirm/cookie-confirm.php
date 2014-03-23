<?php 
/*
Plugin Name: Cookie Confirm
Plugin URI: http://fishcantwhistle.com
Description: Cookie Confirm allows you to easily insert a customisable notification for your users to choose and save their cookie preferences.
Author: Fish Can't Whistle
Version: 0.4
*/

if (!defined("CC_url")) { define("CC_url", WP_PLUGIN_URL.'/cookie-confirm'); } //NO TRAILING SLASH

if (!defined("CC_dir")) { define("CC_dir", WP_PLUGIN_DIR.'/cookie-confirm'); } //NO TRAILING SLASH

require_once ( CC_dir . '/theme-options.php' );

$cookie_confirm = new cookie_confirm;

class cookie_confirm{

	private $cc_v = 'current';

	function cookie_confirm(){
		$this->__construct();
	}
	
	function __construct(){
	
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		
		add_action('wp_footer', array($this, 'footer_js'));
		
	
	}
	
	function enqueue_scripts(){
			
		wp_enqueue_script( 
		     'cookie_consent'
		    ,'http://assets.cookieconsent.silktide.com/'.$this->cc_v.'/plugin.min.js'
		);	
		
		wp_enqueue_script(
			'jquery'
		);
		
		wp_enqueue_style(
			'cookie_consent'
			,'http://assets.cookieconsent.silktide.com/'.$this->cc_v.'/style.min.css'
		);
	
	}
	
	function footer_js(){
	
		$options = get_option( 'cookie_confirm_options' ); 
	
		echo '<script type="text/javascript">';
		
			echo '
			// <![CDATA[
			cc.initialise({
				cookies: {';
					if(isset($options['social_media']['checked'])){
						echo '
							social: {
								title: \''.$options['social_media']['title'].'\',
								description: \''.$options['social_media']['description'].'\',
								link: \''.$options['social_media']['link'].'\'
							},
						';
					};
					if(isset($options['analytics']['checked'])){
						echo '
							analytics: {
								title: \''.$options['analytics']['title'].'\',
								description: \''.$options['analytics']['description'].'\',
								link: \''.$options['analytics']['link'].'\'
							},
						';
					};
					if(isset($options['advertising']['checked'])){
						echo '
							advertising: {
								title: \''.$options['advertising']['title'].'\',
								description: \''.$options['advertising']['description'].'\',
								link: \''.$options['advertising']['link'].'\'
							},
						';
					};
				echo '},
				settings: {';
					
					if(isset($options['refreshOnConsent'])){
						echo 'refreshOnConsent: true,';
					}
					
					echo 'style: "'.$options['style'].'",';
					
					echo 'bannerPosition: "'.$options['bannerPosition'].'",';
					
					echo 'tagPosition: "'.$options['tagPosition'].'",';
					
					if(isset($options['useSSL'])){
						echo 'useSSL: true,';
					}
					
					echo 'consenttype: "'.$options['consenttype'].'",';
					
					if(isset($options['onlyshowbanneronce'])){
						echo 'onlyshowbanneronce: true,';
					}
					
					if(isset($options['hideallsitesbutton'])){
						echo 'hideallsitesbutton: true,';
					}
					
					if(isset($options['hideprivacysettingstab'])){
						echo 'hideprivacysettingstab: true,';
					}
					
				echo '}
			});
			// ]]>
			
			jQuery(document).ready(function() {
			
				check_cc();
				
			});
			
			function check_cc(){
			
				console.log(\'checking\');
			
				if(jQuery(\'#cc-notification-logo\').length > 0){
			
					add_logo();
				
				}else{
				
					setTimeout(check_cc, 200);
					
					console.log(\'set timeout\');
				
				}
			
			}
			
			function add_logo(){
			
				jQuery(\'#cc-notification-permissions\').append(\'<a id="fcw_logo" class="" target="_blank" href="http://fishcantwhistle.com" title="WordPress Plugin by FCW" style="position: absolute;bottom: 16px;right: 88px;"><img src="'.CC_url.'/logo.png" /></a>\');
				
				jQuery(\'#cc-notification-logo\').css(\'width\', \'32px\');
			
			}

			';
		
		echo '</script>';
	
	}
	
}

?>