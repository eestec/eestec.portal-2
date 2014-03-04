<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'cookie_confirm_options', 'cookie_confirm_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_options_page( __( 'Cookie Confirm', 'cookie_confirm' ), __( 'Cookie Confirm', 'cookie_confirm' ), 'edit_theme_options', 'cookie_confirm', 'theme_options_do_page' );
}

/**
 * Create arrays for our select and radio options
 */

$cookies = array(
	'social_media' => array(
		'title' => __( 'Social Media', 'cookie_confirm' ),
		'description' => __( 'Facebook, Twitter and other social websites need to know who you are to work properly.', 'cookie_confirm' ),
		'link' => ''
	),
	'analytics' => array(
		'title' => __( 'Analytics', 'cookie_confirm' ),
		'description' => __( 'We anonymously measure your use of this website to improve your experience.', 'cookie_confirm' ),
		'link' => ''
	),
	'advertising' => array(
		'title' => __( 'Advertising', 'cookie_confirm' ),
		'description' => __( 'Adverts will be chosen for you automatically based on your past behaviour and interests.', 'cookie_confirm' ),
		'link' => ''
	)
);

$style_options = array(
	'dark' => array(
		'value' => 'dark',
		'label' => __( 'Dark', 'cookie_confirm' )
	),
	'light' => array(
		'value' => 'light',
		'label' => __( 'Light', 'cookie_confirm' )
	)
);

$position_options = array(
	'top' => array(
		'value' => 'top',
		'label' => __( 'Top', 'cookie_confirm' )
	),
	'bottom' => array(
		'value' => 'bottom',
		'label' => __( 'Bottom', 'cookie_confirm' )
	),
	'push' => array(
		'value' => 'push',
		'label' => __( 'Push (experimental)', 'cookie_confirm' )
	)
);

$tag_options = array(
	'bottom-right' => array(
		'value' => 'bottom-right',
		'label' => __( 'Bottom Right', 'cookie_confirm' )
	),
	'bottom-left' => array(
		'value' => 'bottom-left',
		'label' => __( 'Bottom Left', 'cookie_confirm' )
	),
	'vertical-left' => array(
		'value' => 'vertical-left',
		'label' => __( 'Vertical Left', 'cookie_confirm' )
	),
	'vertical-right' => array(
		'value' => 'vertical-right',
		'label' => __( 'Vertical Right', 'cookie_confirm' )
	)
);

$consent_options = array(
	'explicit' => array(
		'value' => 'explicit',
		'label' => __( 'Explicit', 'cookie_confirm' )
	),
	'implicit' => array(
		'value' => 'implicit',
		'label' => __( 'Implicit', 'cookie_confirm' )
	)
);

/**
 * Create the options page
 */
function theme_options_do_page() {
	global $style_options, $position_options, $tag_options, $consent_options, $cookies;

	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;

	?>
	
	<script>
	
		jQuery(document).ready(function() {
				
			jQuery('.cookie_select').each(function(){
				if(jQuery(this).is(':checked')) {
					jQuery(this).parent().next().show();
				}else{
					jQuery(this).parent().next().hide();
				}
			});
	
			jQuery('.cookie_select').click(function(){
				if(jQuery(this).is(':checked')) {
					jQuery(this).parent().next().slideDown();
				}else{
					jQuery(this).parent().next().slideUp();
				}
			});
		
		});
	
	</script>
	
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . __( ' Cookie Confirm Settings', 'cookie_confirm' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
<!-- 		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'cookie_confirm' ); ?></strong></p></div> -->
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'cookie_confirm_options' ); ?>
			<?php $options = get_option( 'cookie_confirm_options' ); ?>

			<table class="form-table">

				<tr valign="top"><th scope="row"><?php _e( 'Cookies you use on your site', 'cookie_confirm' ); ?></th>
					<td>
					
						<?php foreach($cookies as $key => $cookie){ ?>
						
							<h3><?php echo $cookie['title']; ?><input id="cookie_confirm_options[<?php echo $key; ?>][checked]" name="cookie_confirm_options[<?php echo $key; ?>][checked]" class="cookie_select" type="checkbox" value="1" <?php checked( '1', (isset($options[$key]['checked']) ? $options[$key]['checked'] : '' )); ?> />
</h3>
							
							<div class="cookie_detail">
						
								<?php _e( 'Title', 'cookie_confirm' ); ?>: <input id="cookie_confirm_options[<?php echo $key; ?>][title]" class="regular-text" type="text" name="cookie_confirm_options[<?php echo $key; ?>][title]" value="<?php esc_attr_e( (isset($options[$key]['title']) ? $options[$key]['title'] : $cookie['title'] )); ?>" />
								<br>
								<?php _e( 'Description', 'cookie_confirm' ); ?>: <input id="cookie_confirm_options[<?php echo $key; ?>][description]" class="regular-text" type="text" name="cookie_confirm_options[<?php echo $key; ?>][description]" value="<?php esc_attr_e( (isset($options[$key]['description']) ? $options[$key]['description'] : $cookie['description'] )); ?>" />
								<br>
								<?php _e( 'Link', 'cookie_confirm' ); ?>: <input id="cookie_confirm_options[<?php echo $key; ?>][link]" class="regular-text" type="text" name="cookie_confirm_options[<?php echo $key; ?>][link]" value="<?php esc_attr_e( (isset($options[$key]['link']) ? $options[$key]['link'] : $cookie['link'] )); ?>" />
						
							</div>
							
						<?php } ?>

					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Refresh on 	Consent?', 'cookie_confirm' ); ?></th>
					<td>
						<input id="cookie_confirm_options[refreshOnConsent]" name="cookie_confirm_options[refreshOnConsent]" type="checkbox" value="1" <?php checked( '1', (isset($options['refreshOnConsent']) ? $options['refreshOnConsent'] : '' )); ?> />
						<label class="description" for="cookie_confirm_options[refreshOnConsent]"><?php _e( 'When set, the plugin will refresh the page after a change in consent.', 'cookie_confirm' ); ?></label>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( 'Style', 'cookie_confirm' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Style', 'cookie_confirm' ); ?></span></legend>
						<?php
							if ( ! isset( $checked ) )
								$checked = '';
							foreach ( $style_options as $option ) {
								$radio_setting = (isset($options['style']) ? $options['style'] : 'dark' );

								if ( '' != $radio_setting ) {
									if ( isset($options['style']) &&  $options['style'] == $option['value'] ) {
										$checked = "checked=\"checked\"";
									} else {
										$checked = '';
									}
								}
								?>
								<label class="description"><input type="radio" name="cookie_confirm_options[style]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label><br />
								<?php
							}
						?>
						</fieldset>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( 'Banner Position', 'cookie_confirm' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Banner Position', 'cookie_confirm' ); ?></span></legend>
						<?php
							if ( ! isset( $checked ) )
								$checked = '';
							foreach ( $position_options as $option ) {
								$radio_setting = (isset($options['bannerPosition']) ? $options['bannerPosition'] : 'top' );

								if ( '' != $radio_setting ) {
									if ( isset($options['bannerPosition']) && $options['bannerPosition'] == $option['value'] ) {
										$checked = "checked=\"checked\"";
									} else {
										$checked = '';
									}
								}
								?>
								<label class="description"><input type="radio" name="cookie_confirm_options[bannerPosition]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label><br />
								<?php
							}
						?>
						</fieldset>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( 'Tag Position', 'cookie_confirm' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Tag Position', 'cookie_confirm' ); ?></span></legend>
						<?php
							if ( ! isset( $checked ) )
								$checked = '';
							foreach ( $tag_options as $option ) {
								$radio_setting = (isset($options['tagPosition']) ? $options['tagPosition'] : 'bottom-right' );

								if ( '' != $radio_setting ) {
									if ( isset($options['tagPosition']) && $options['tagPosition'] == $option['value'] ) {
										$checked = "checked=\"checked\"";
									} else {
										$checked = '';
									}
								}
								?>
								<label class="description"><input type="radio" name="cookie_confirm_options[tagPosition]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label><br />
								<?php
							}
						?>
						</fieldset>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( 'Use SSL?', 'cookie_confirm' ); ?></th>
					<td>
						<input id="cookie_confirm_options[useSSL]" name="cookie_confirm_options[useSSL]" type="checkbox" value="1" <?php checked( '1', (isset($options['useSSL']) ? $options['useSSL'] : '' )); ?> />
						<label class="description" for="cookie_confirm_options[useSSL]"><?php _e( 'Whether or not the plugin should use SSL.', 'cookie_confirm' ); ?></label>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( 'Consent Type', 'cookie_confirm' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Consent Type', 'cookie_confirm' ); ?></span></legend>
						<?php
							if ( ! isset( $checked ) )
								$checked = '';
							foreach ( $consent_options as $option ) {
								$radio_setting = (isset($options['consenttype']) ? $options['consenttype'] : 'dark' );

								if ( '' != $radio_setting ) {
									if ( isset($options['consenttype']) &&  $options['consenttype'] == $option['value'] ) {
										$checked = "checked=\"checked\"";
									} else {
										$checked = '';
									}
								}
								?>
								<label class="description"><input type="radio" name="cookie_confirm_options[consenttype]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?></label><br />
								<?php
							}
						?>
						</fieldset>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( 'Only show banner once?', 'cookie_confirm' ); ?></th>
					<td>
						<input id="cookie_confirm_options[refreshOnConsent]" name="cookie_confirm_options[onlyshowbanneronce]" type="checkbox" value="1" <?php checked( '1', (isset($options['onlyshowbanneronce']) ? $options['onlyshowbanneronce'] : '' )); ?> />
						<label class="description" for="cookie_confirm_options[onlyshowbanneronce]"><?php _e( 'This option can only be used when Consent Type is set to "implicit". The consent slide-down notification will only be shown once if set to true even if the visitor does not respond to the banner (on subsequent pages, just the privacy settings tab will be shown).', 'cookie_confirm' ); ?></label>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( 'Hide all sites button?', 'cookie_confirm' ); ?></th>
					<td>
						<input id="cookie_confirm_options[hideallsitesbutton]" name="cookie_confirm_options[hideallsitesbutton]" type="checkbox" value="1" <?php checked( '1', (isset($options['hideallsitesbutton']) ? $options['hideallsitesbutton'] : '' )); ?> />
						<label class="description" for="cookie_confirm_options[hideallsitesbutton]"><?php _e( 'The "Save for all sites"/"Accept for all sites" button can be hidden.', 'cookie_confirm' ); ?></label>
					</td>
				</tr>
				
				<tr valign="top"><th scope="row"><?php _e( 'Hide privacy settings tab?', 'cookie_confirm' ); ?></th>
					<td>
						<input id="cookie_confirm_options[hideprivacysettingstab]" name="cookie_confirm_options[hideprivacysettingstab]" type="checkbox" value="1" <?php checked( '1', (isset($options['hideprivacysettingstab']) ? $options['hideprivacysettingstab'] : '' )); ?> />
						<label class="description" for="cookie_confirm_options[hideprivacysettingstab]"><?php _e( 'The privacy tab can be hidden.', 'cookie_confirm' ); ?></label>
					</td>
				</tr>

			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'cookie_confirm' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
	global $style_options, $position_options;
/*
	echo '<pre>';
	print_r($input);
	echo '</pre>';
*/
	// Our checkbox value is either 0 or 1
	//if ( ! isset( $input['option1'] ) )
	//	$input['option1'] = null;
	//$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

	// Say our text option must be safe text with no HTML tags
	//$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );

	// Our select option must actually be in our array of select options
	//if ( ! array_key_exists( $input['selectinput'], $select_options ) )
	//	$input['selectinput'] = null;

	// Our radio option must actually be in our array of radio options
	//if ( ! isset( $input['radioinput'] ) )
	//	$input['radioinput'] = null;
	//if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
	//	$input['radioinput'] = null;

	// Say our textarea option must be safe text with the allowed tags for posts
	//$input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );

	return $input;
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/