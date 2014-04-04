   <div class="wrapper">  
<?php 
	$tooltips = get_option('tooltips');
	$color = get_option('color-tips');  
	$imgW = get_option('imgw'); 
  $imgh = get_option('imgh'); 
  $targetlinks = get_option('targetlinks'); 
  $imgtype = get_option('images-type');
  	if($tooltips =='1') $tooltips = 'checked="checked"';
	if($targetlinks =='1') $targetlinks = 'checked="checked"';

?>
<form name="options-toptwenfive"  method="post" action="options.php">
<?php settings_fields( 'toptwenfive-setting-items' ); ?>
<?php do_settings_sections('toptwenfive-setting-items'); ?>
<table>

        <tr>
			<th><h1>Top 25 Social Icons</h1></th>        
        
        </tr>
<tr>

<th style="text-align:left;"><?php _e('Display Tips'); ?></th>
<td  ><input <?php echo $tooltips; ?> type="checkbox" name="tooltips" value="1" /><label for="tooltips">&nbsp;<span class="description"><?php _e('Display ToolTips on Social Icons');?></span></label> </td>
<?php /*?><div style="position:relative;"> <img src="<?php echo plugins_url( '/toptwenfive-icons-lite/admin/images/tips.JPG')?>"  width="200" class="tips-img" style="position:absolute;"/> <?php */?>
</tr>
<tr>
<th style="text-align:left;"><?php _e('Width:');?></th>
<td><input type="text" name="imgw" value="<?php echo $imgW; ?>" id="top25_width" /><label for="tooltips">&nbsp;<span class="description"><?php _e('Enter the Width of the Social Icons images for Ex: 32px');?></span></label>  </td>
</tr>

<tr>
<th style="text-align:left;"><?php _e('Height:');?></th>
<td><input type="text" name="imgh" value="<?php echo $imgh; ?>"  id="top25_height"/> <label for="tooltips">&nbsp;<span class="description"><?php _e('Enter the Height of the Social Icons for Ex: 32px');?></span></label> </td>
</tr>

<tr>
<th style="text-align:left;"><?php _e('Display Link in Tab:');?></th>
<td><input <?php echo $targetlinks; ?> type="checkbox" name="targetlinks" value="1"  /> <label for="tooltips">&nbsp;<span class="description"><?php _e('Open Link in Tab');?></span></label> </td>
</tr>

<tr>
<th style="text-align:left;"><?php _e('Tips Color'); ?></th>
<td> 
<select name ="<?php _e('color-tips');?>">
<?php  ?>
<option value="black" <?php if ($color=='black') { echo 'selected'; } ?> >Black</option>
<option value="green" <?php if ($color=='green') { echo 'selected'; } ?> >Green</option>
<option value="red" <?php if ($color=='red') { echo 'selected'; } ?> >Red</option>
<option value="yellow" <?php if ($color=='yellow') { echo 'selected'; } ?>>Yellow</option>
<option value="blue" <?php if ($color=='blue') { echo 'selected'; } ?>>Blue</option>
<option value="white" <?php if ($color=='white') { echo 'selected'; } ?>>White</option>
<option value="grey" <?php if ($color=='grey') { echo 'selected'; } ?>>Grey</option>
<option value="orange" <?php if ($color=='orange') { echo 'selected'; } ?>>Orange</option>
</select>
 
</td>
</tr>
<tr>
<th style="text-align:left;"><?php _e('Images Type');?></th>
<td>

<select id="image-type" name ="<?php _e('images-type');?>" onchange="trackinfo();">
<option value="circle" <?php if ($imgtype =='circle') { echo 'selected'; } ?>>Circle</option>
<option value="square" <?php if ($imgtype =='square') { echo 'selected'; } ?>>Square</option>
<option value="square48" <?php if ($imgtype =='square48') { echo 'selected'; } ?>>Square 48px</option>
<option value="3Di" <?php if ($imgtype =='3Di') { echo 'selected'; } ?>>3D Buttons</option>
<option value="leaf" <?php if ($imgtype =='leaf') { echo 'selected'; } ?>>Leaf Shape</option>
<option value="circle64" <?php if ($imgtype =='circle64') { echo 'selected'; } ?>>Circle 64px</option>
<option value="circle48" <?php if ($imgtype =='circle48') { echo 'selected'; } ?>>Circle 48px</option>
</select>

</td>
</tr>
<tr>
<th>&nbsp;</th> 
<td style="text-align:left;"><input type="submit" name="submit"  class="button-primary sbt-color" value="<?php esc_attr_e('Save Changes')?>"/></td>
</tr>

</table>
</form>
 
 <div style="margin-top:25px;"> 50+ Image Types Available. Send Your request for All Image types.  <a style="color:red;" href="http://vyasdipen.wordpress.com/contact/">Get in touch with me</a> </td>
 
</div>
<script>
function trackinfo(){
var e = document.getElementById("image-type");
var strUser = e.options[e.selectedIndex].value;



if(strUser == 'circle48' || strUser == 'circle64' || strUser == 'square48' ){


var sWidth =document.getElementById("top25_width");
var sHeig = document.getElementById("top25_height");

if(sWidth.value != 'auto' || sHeig.value != 'auto'  ){

alert("Width and Height Must Be Auto.");

sWidth.value="auto";
sHeig.value="auto";
return false;
}

}
else{


}
 }

//var shight = document.getElementById("top25_height");
//var swidth = document.getElementById("top25_width");

 
 

</script>
<?php 

if ( $_POST['options-toptwenfive'] == 'true' ) { toptwenfive_backend_sub_menu(); }



?>