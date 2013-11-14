<?php
/*
Plugin Name: Pirobox Extended for WP V.1.0 (old version)
Plugin URI: http://wordpress.org/extend/plugins/pirobox-extended/
Description: Please visit the new pirobox wp plugin at page http://wordpress.org/extend/plugins/pirobox-extended/
Author: pirolab
Author URI: http://wordpress.org/extend/plugins/pirobox-extended/
Version: 1.0

*/
add_filter('the_content', 'addPirobox', 12);
add_filter('get_comment_text', 'addPirobox');
function addPirobox ($content)
{ global $post;
$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
$replacement = '<a$1href=$2$3.$4$5 class="pirobox_gall_'.$post->ID.'" rel="gallery"$6>$7</a>';

$content = preg_replace($pattern, $replacement, $content);
return $content;
}
function pirobox_head() {
$piro_path = WP_PLUGIN_URL.'/pirobox-extended-for-wp-v10';

?>

<!-- You can choose your style here below, the default style is "/css_pirobox/style_1/style.css"
/css_pirobox/style_1/style.css
/css_pirobox/style_2/style.css
-->

<link href="<?php echo $piro_path;?>/css_pirobox/style_1/style.css" rel="stylesheet" type="text/css" />

<!-- end styles -->

<!-- do not edit the code below -->
<script type="text/javascript" src="<?php echo $piro_path;?>/js/jquery_1.5-jquery_ui.min.js"></script>
<script type="text/javascript" src="<?php echo $piro_path;?>/js/pirobox_extended_feb_2011.js"></script>

<!-- pirobox extended options, speed , opacity background, image scroll, true = fixed, false = relative -->
<script type="text/javascript">
jQuery(document).ready(function($) {
jQuery.piroBox_ext({
piro_speed :700,
bg_alpha : 0.5,
piro_scroll : true,
piro_drag :false,
piro_nav_pos: 'bottom'
});
});
</script>

<!-- end options -->

<?php

}
add_action('wp_head', 'pirobox_head');
?>