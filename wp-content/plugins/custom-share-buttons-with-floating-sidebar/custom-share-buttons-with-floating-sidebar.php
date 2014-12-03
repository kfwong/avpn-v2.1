<?php
/*
Plugin Name: Custom Share Buttons with Floating Sidebar
Plugin URI: http://www.mrwebsolution.in/
Description: "custom-share-buttons-with-floating-sidebar" is the very simple plugin for add to social share buttons with float sidebar. Even you can change the share buttons images if you wish
Author: Raghunath
Author URI: http://raghunathgurjar.wordpress.com
Version: 1.6
*/

/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : raghunath.0087@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Admin "Custom Share Buttons with Floating Sidebar" Menu Item

if(!function_exists('csbwf_sidebar_menu')){
add_action('admin_menu','csbwf_sidebar_menu');
function csbwf_sidebar_menu(){

	add_options_page('Custom Share Buttons With Floating Sidebar','Custom Share Buttons With Floating Sidebar','manage_options','csbwfs-settings','csbwf_sidebar_admin_option_page');

}
}

//Define Action for register "Custom Share Buttons with Floating Sidebar" Options
add_action('admin_init','csbwf_sidebar_init');

if(!function_exists('csbwf_sidebar_init')):
//Register "Custom Share Buttons with Floating Sidebar" options
function csbwf_sidebar_init(){

	register_setting('csbwf_sidebar_options','csbwfs_active');
	register_setting('csbwf_sidebar_options','csbwfs_position');
	register_setting('csbwf_sidebar_options','csbwfs_btn_position');
	register_setting('csbwf_sidebar_options','csbwfs_btn_text');
	register_setting('csbwf_sidebar_options','csbwfs_fb_image');
	register_setting('csbwf_sidebar_options','csbwfs_tw_image');
	register_setting('csbwf_sidebar_options','csbwfs_li_image');	
	register_setting('csbwf_sidebar_options','csbwfs_re_image');	
	register_setting('csbwf_sidebar_options','csbwfs_st_image');	
	register_setting('csbwf_sidebar_options','csbwfs_mail_image');	
	register_setting('csbwf_sidebar_options','csbwfs_gp_image');	
	register_setting('csbwf_sidebar_options','csbwfs_pin_image');
	register_setting('csbwf_sidebar_options','csbwfs_yt_image');	
	register_setting('csbwf_sidebar_options','csbwfs_fb_bg');
	register_setting('csbwf_sidebar_options','csbwfs_tw_bg');
	register_setting('csbwf_sidebar_options','csbwfs_li_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_mail_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_gp_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_pin_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_re_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_st_bg');
	register_setting('csbwf_sidebar_options','csbwfs_yt_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_fpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_tpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_gpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_ppublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_ytpublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_republishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_stpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_ytPath');	
	register_setting('csbwf_sidebar_options','csbwfs_lpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_mpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_mailMessage');
	register_setting('csbwf_sidebar_options','csbwfs_top_margin');
	register_setting('csbwf_sidebar_options','csbwfs_delayTimeBtn');
	
	//Options for post/pages
	register_setting('csbwf_sidebar_options','csbwfs_buttons_active');
	register_setting('csbwf_sidebar_options','csbwfs_page_hide_home');
	register_setting('csbwf_sidebar_options','csbwfs_page_hide_post');
	register_setting('csbwf_sidebar_options','csbwfs_page_hide_page');
	register_setting('csbwf_sidebar_options','csbwfs_page_hide_archive');
	
	register_setting('csbwf_sidebar_options','csbwfs_page_fb_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_tw_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_li_image');	
	register_setting('csbwf_sidebar_options','csbwfs_page_mail_image');	
	register_setting('csbwf_sidebar_options','csbwfs_page_gp_image');	
	register_setting('csbwf_sidebar_options','csbwfs_page_pin_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_re_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_st_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_yt_image');
	/** message content */	
	
	register_setting('csbwf_sidebar_options','csbwfs_show_btn');	
	register_setting('csbwf_sidebar_options','csbwfs_hide_btn');	
	register_setting('csbwf_sidebar_options','csbwfs_share_msg');
	register_setting('csbwf_sidebar_options','csbwfs_rmSHBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_featuredshrimg');	
	register_setting('csbwf_sidebar_options','csbwfs_defaultfeaturedshrimg');
	register_setting('csbwf_sidebar_options','csbwfs_deactive_for_mob');	
	
} 

endif;

if(!function_exists('csbwfs_add_settings_link')):
// Add settings link to plugin list page in admin
        function csbwfs_add_settings_link( $links ) {
            $settings_link = '<a href="options-general.php?page=csbwfs-settings">' . __( 'Settings', 'csbwfs' ) . '</a>';
            array_unshift( $links, $settings_link );
            return $links;
        }
endif;
        $plugin = plugin_basename( __FILE__ );
        add_filter( "plugin_action_links_$plugin", 'csbwfs_add_settings_link' );

add_action('admin_footer','add_csbwfs_admin_style_script');

if(!function_exists('add_csbwfs_admin_style_script')):
function add_csbwfs_admin_style_script()
{
wp_register_style( 'csbwf_admin_style', plugins_url( 'css/admin-csbwfs.css',__FILE__ ) );
wp_enqueue_style( 'csbwf_admin_style' );

echo $script='<script type="text/javascript">
	/* Custom Share Buttons With Floting Sidebar admin js*/
	jQuery(document).ready(function(){
		jQuery(".csbwfs-tab").hide();
		jQuery("#div-csbwfs-general").show();
	    jQuery(".csbwf-tab-links").click(function(){
		var divid=jQuery(this).attr("id");
		jQuery(".csbwf-tab-links").removeClass("active");
		jQuery(".csbwfs-tab").hide();
		jQuery("#"+divid).addClass("active");
		jQuery("#div-"+divid).fadeIn();
		});
		jQuery("#publish5").click(function(){
		if(jQuery("#publish5").prop("checked"))
		{jQuery("#mailmsg").show();}else{jQuery("#mailmsg").hide();} 
	    });
	    
	    jQuery("#ytBtns").click(function(){
		if(jQuery("#ytBtns").prop("checked"))
		{jQuery("#ytpath").show();}else{jQuery("#ytpath").hide();} 
	    });
		})
	</script>';

	}
endif;
/** Display the Options form for CSBWFS */
if(!function_exists('csbwf_sidebar_admin_option_page')):
function csbwf_sidebar_admin_option_page(){ ?>

	<div style="width: 80%; padding: 10px; margin: 10px;"> 

	<h1>Custom Share Buttons With Floating Sidebar Settings</h1>
<!-- Start Options Form -->

	<form action="options.php" method="post" id="csbwf-sidebar-admin-form">
		
	<div id="csbwf-tab-menu"><a id="csbwfs-general" class="csbwf-tab-links active" >General</a> <a  id="csbwfs-sidebar" class="csbwf-tab-links">Floating Sidebar</a> <a  id="csbwfs-share-buttons" class="csbwf-tab-links">Social Share Buttons</a> <a  id="csbwfs-support" class="csbwf-tab-links">Support</a> </div>

	<div class="csbwfs-setting">
	<!-- General Setting -->	
	<div class="first csbwfs-tab" id="div-csbwfs-general">
	<h2>General Settings</h2>
	<p><label>Enable:</label><input type="checkbox" id="csbwfs_active" name="csbwfs_active" value='1' <?php if(get_option('csbwfs_active')!=''){ echo ' checked="checked"'; }?>/></p>
	<p><h3><strong><?php _e('Social Share Button Publish Options:','csbwfs');?></strong></h3></p>
	<p><input type="checkbox" id="publish1" value="yes" name="csbwfs_fpublishBtn" <?php if(get_option('csbwfs_fpublishBtn')=='yes'){echo 'checked="checked"';}?>/>Facebook Button</p>
				<p><input type="checkbox" id="publish2" name="csbwfs_tpublishBtn" value="yes" <?php if(get_option('csbwfs_tpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Twitter Button</b></p>
				<p><input type="checkbox" id="publish3" name="csbwfs_gpublishBtn" value="yes" <?php if(get_option('csbwfs_gpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Google Button</b></p>
				<p><input type="checkbox" id="publish4" name="csbwfs_lpublishBtn" value="yes" <?php if(get_option('csbwfs_lpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Linkdin Button</b></p>
				<p><input type="checkbox" id="publish6" name="csbwfs_ppublishBtn" value="yes" <?php if(get_option('csbwfs_ppublishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Pinterest Button</b></p>
				<p><input type="checkbox" id="publish7" name="csbwfs_republishBtn" value="yes" <?php if(get_option('csbwfs_republishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Reddit Button</b></p>
				<p><input type="checkbox" id="publish8" name="csbwfs_stpublishBtn" value="yes" <?php if(get_option('csbwfs_stpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Stumbleupon Button</b></p>
				<p><input type="checkbox" id="publish5" name="csbwfs_mpublishBtn" value="yes" <?php if(get_option('csbwfs_mpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Mailbox Button</b></p>
				<?php if(get_option('csbwfs_mpublishBtn')=='yes'){?> 
				<p id="mailmsg"><input type="text" name="csbwfs_mailMessage" id="csbwfs_mailMessage" value="<?php echo get_option('csbwfs_mailMessage');?>" placeholder="raghunath.0087@gmail.com" size="40" class="regular-text ltr"><br>Note:add the mail message like this format <b>your@email.com?subject=Your Subject</b></p>
				<?php } ?>
				<p><input type="checkbox" id="ytBtns" name="csbwfs_ytpublishBtn" value="yes" <?php if(get_option('csbwfs_ytpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Youtube Button</b></p>
				<?php if(get_option('csbwfs_ytpublishBtn')=='yes'){?> 
				<p id="ytpath"><input type="text" name="csbwfs_ytPath" id="csbwfs_ytPath" value="<?php echo get_option('csbwfs_ytPath');?>" placeholder="http://www.youtube.com" size="40" class="regular-text ltr"><br>add youtube channel url</p>
				<?php } ?>
			

			<p><label><h3 ><strong><?php _e('Define your custom message:','csbwfs');?></strong></h3></label></p>
			<p><label><?php _e('Show:');?></label><input type="text" id="csbwfs_show_btn" name="csbwfs_show_btn" value="<?php echo get_option('csbwfs_show_btn'); ?>" placeholder="Show Buttons" size="40"/></p>
			<p><label><?php _e('Hide:');?></label><input type="text" id="csbwfs_hide_btn" name="csbwfs_hide_btn" value="<?php echo get_option('csbwfs_hide_btn'); ?>" placeholder="Hide Buttons" size="40"/></p>
			<p><label><?php _e('Message:');?></label><input type="textbox" id="csbwfs_share_msg" name="csbwfs_share_msg" value="<?php echo get_option('csbwfs_share_msg'); ?>" placeholder="Share This With Your Friends" size="40"/></p>
	        <p><h3><strong><?php _e('Pinterest Share Image Setting :'); ?></strong></h3></p>
			<p><?php _e('Default Image :');?><input type="textbox" id="csbwfs_defaultfeaturedshrimg" name="csbwfs_defaultfeaturedshrimg" value="<?php echo get_option('csbwfs_defaultfeaturedshrimg'); ?>" placeholder="" size="55"/></p>
			<p><input type="checkbox" id="featuredshrimg" name="csbwfs_featuredshrimg" value="yes" <?php if(get_option('csbwfs_featuredshrimg')=='yes'){echo 'checked="checked"';}?>/> <?php _e('Make post/page featured image as pinterest share image');?></p>
	</div>
	<!-- Floating Sidebar -->
	<div class="csbwfs-tab" id="div-csbwfs-sidebar">
	<h2>Floating Sidebar Settings</h2>
	<table>
			<tr>
				<th nowrap><?php echo 'Siderbar Position:';?></th>
				<td>
				<select id="csbwfs_position" name="csbwfs_position" >
				<option value="left" <?php if(get_option('csbwfs_position')=='left'){echo 'selected="selected"';}?>>Left</option>
				<option value="right" <?php if(get_option('csbwfs_position')=='right'){echo 'selected="selected"';}?>>Right</option>
				</select>
				</td>
			</tr>
			<tr><th nowrap valign="top"><?php echo 'Delay Time: '; ?></th><td><input type="text" name="csbwfs_delayTimeBtn" id="csbwfs_delayTimeBtn" value="<?php echo get_option('csbwfs_delayTimeBtn')?get_option('csbwfs_delayTimeBtn'):0;?>"  size="40" class="regular-text ltr"><br><i>Publish share buttons after given time(millisecond)</i></td></tr>
				<tr>
				<th>&nbsp;</th>
				<td><input type="checkbox" id="csbwfs_deactive_for_mob" name="csbwfs_deactive_for_mob" value="yes" <?php if(get_option('csbwfs_deactive_for_mob')=='yes'){echo 'checked="checked"';}?>/> <strong><?php _e('Disable Sidebar For Mobile','csbwfs');?></strong></td>
			</tr>
			<tr><td colspan="2"><strong><h4>Social Share Button Images 36X34 (Optional) :</h4></strong></td></tr>
			<tr>
				<th><?php echo 'Facebook:';?></th>
				<td>
			
				<input type="textbox" id="csbwfs_fb_image" name="csbwfs_fb_image" value="<?php echo get_option('csbwfs_fb_image'); ?>" placeholder="Insert facebook button image path" size="30"/> <input type="textbox" id="csbwfs_fb_bg" name="csbwfs_fb_bg" value="<?php echo get_option('csbwfs_fb_bg'); ?>" placeholder="BG color:#000000" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Twitter:';?></th>
				<td>
			
				<input type="textbox" id="csbwfs_tw_image" name="csbwfs_tw_image" value="<?php echo get_option('csbwfs_tw_image'); ?>" placeholder="Insert twitter button image path" size="30"/><input type="textbox" id="csbwfs_tw_bg" name="csbwfs_tw_bg" value="<?php echo get_option('csbwfs_tw_bg'); ?>" placeholder="BG color:#000000" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Linkdin:';?></th>
				<td>
			
				<input type="textbox" id="csbwfs_li_image" name="csbwfs_li_image" value="<?php echo get_option('csbwfs_li_image'); ?>" placeholder="Insert linkdin button image path" size="30"/><input type="textbox" id="csbwfs_li_bg" name="csbwfs_li_bg" value="<?php echo get_option('csbwfs_li_bg'); ?>" placeholder="BG color:#000000" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Pintrest:';?></th>
				<td>
			
				<input type="textbox" id="csbwfs_pin_image" name="csbwfs_pin_image" value="<?php echo get_option('csbwfs_pin_image'); ?>" placeholder="Insert pinterest button image path" size="30"/><input type="textbox" id="csbwfs_pin_bg" name="csbwfs_pin_bg" value="<?php echo get_option('csbwfs_pin_bg'); ?>" placeholder="BG color:#000000" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Google:';?></th>
				<td>
			
				<input type="textbox" id="csbwfs_gp_image" name="csbwfs_gp_image" value="<?php echo get_option('csbwfs_gp_image'); ?>" placeholder="Insert google button image path" size="30"/><input type="textbox" id="csbwfs_gp_image" name="csbwfs_gp_bg" value="<?php echo get_option('csbwfs_gp_bg'); ?>" placeholder="BG color:#000000" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Mail:';?></th>
				<td>
				<input type="textbox" id="csbwfs_mail_image" name="csbwfs_mail_image" value="<?php echo get_option('csbwfs_mail_image'); ?>" placeholder="Insert mail button image path" size="30"/> <input type="textbox" id="csbwfs_mail_bg" name="csbwfs_mail_bg" value="<?php echo get_option('csbwfs_mail_bg'); ?>" placeholder="BG color:#000000" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Youtube:';?></th>
				<td>
				<input type="textbox" id="csbwfs_yt_image" name="csbwfs_yt_image" value="<?php echo get_option('csbwfs_yt_image'); ?>" placeholder="Insert youtube button image path" size="30"/> <input type="textbox" id="csbwfs_yt_bg" name="csbwfs_yt_bg" value="<?php echo get_option('csbwfs_yt_bg'); ?>" placeholder="BG color:#FFFFFF" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Reddit:';?></th>
				<td>
				<input type="textbox" id="csbwfs_re_image" name="csbwfs_re_image" value="<?php echo get_option('csbwfs_re_image'); ?>" placeholder="Insert reddit button image path" size="30"/> <input type="textbox" id="csbwfs_re_bg" name="csbwfs_re_bg" value="<?php echo get_option('csbwfs_re_bg'); ?>" placeholder="BG color:#FF1A00" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Stumbleupon:';?></th>
				<td>
				<input type="textbox" id="csbwfs_st_image" name="csbwfs_st_image" value="<?php echo get_option('csbwfs_st_image'); ?>" placeholder="Insert stumbleupon button image path" size="30"/> <input type="textbox" id="csbwfs_st_bg" name="csbwfs_st_bg" value="<?php echo get_option('csbwfs_st_bg'); ?>" placeholder="BG color:#EB4924" size="20"/>
				</td>
			</tr>
			
			
			<tr><td colspan="2"><h3><strong>Style(Optional):</strong></h3></td></tr>
			
			<tr>
				<th><?php echo 'Top Margin:';?></th>
				<td>
			
				<input type="textbox" id="csbwfs_top_margin" name="csbwfs_top_margin" value="<?php echo get_option('csbwfs_top_margin'); ?>" placeholder="10% OR 10px" size="10"/>
				</td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td><input type="checkbox" id="csbwfs_rmSHBtn" name="csbwfs_rmSHBtn" value="yes" <?php if(get_option('csbwfs_rmSHBtn')=='yes'){echo 'checked="checked"';}?>/> <strong><?php _e('Remove Show/Hide Button:','csbwfs');?></strong></td>
			</tr>
			
	</table>
	</div>
	<!-- Share Buttons -->
	<div class="csbwfs-tab" id="div-csbwfs-share-buttons">
	<h2>Social Share Buttons Settings</h2>
	<table>
		    <td><?php _e('Enable:','csbwfs');?></td>
				<td colspan="2">
					<input type="checkbox" id="csbwfs_buttons_active" name="csbwfs_buttons_active" value='1' <?php if(get_option('csbwfs_buttons_active')!=''){ echo ' checked="checked"'; }?>/>
				</td>
		    </tr>
			<tr>
				<th nowrap><?php echo 'Share Button Position:';?></th>
				<td>
				<select id="csbwfs_btn_position" name="csbwfs_btn_position" >
				<option value="left" <?php if(get_option('csbwfs_btn_position')=='left'){echo 'selected="selected"';}?>>Left</option>
				<option value="right" <?php if(get_option('csbwfs_btn_position')=='right'){echo 'selected="selected"';}?>>Right</option>
				</select>
				</td>
			</tr>
			
			<tr>
				<th nowrap><?php echo 'Share Button Text:';?></th>
				<td>
				<input type="textbox" id="csbwfs_btn_text" name="csbwfs_btn_text" value="<?php echo get_option('csbwfs_btn_text'); ?>" placeholder="Share This!" size="20"/>
				</td>
			</tr>
			<tr><td colspan="2"><strong>Show Share Buttons On :</strong> Home <input type="checkbox" id="csbwfs_page_hide_home" value="yes" name="csbwfs_page_hide_home" <?php if(get_option('csbwfs_page_hide_home')!='yes'){echo '';}else{echo 'checked="checked"';}?>/> Page <input type="checkbox" id="csbwfs_page_hide_page" value="yes" name="csbwfs_page_hide_page" <?php if(get_option('csbwfs_page_hide_page')!='yes'){echo '';}else { echo 'checked="checked"';}?>/> Post <input type="checkbox" id="csbwfs_page_hide_post" value="yes" name="csbwfs_page_hide_post" <?php if(get_option('csbwfs_page_hide_post')!='yes'){echo '';}else{echo 'checked="checked"';}?>/> Archive <input type="checkbox" id="csbwfs_page_hide_archive" value="yes" name="csbwfs_page_hide_archive" <?php if(get_option('csbwfs_page_hide_archive')!='yes'){echo '';}else{echo 'checked="checked"';}?>/> <br>
			</td></tr>
			
			<tr><td colspan="2"><strong><h4>Social Share Button Images 31X30 (Optional) :</h4></strong></td></tr>
			<tr>
				<th><?php echo 'Facebook:';?></th>
				<td>
			
				<input type="textbox" id="csbwfs_page_fb_image" name="csbwfs_page_fb_image" value="<?php echo get_option('csbwfs_page_fb_image'); ?>" placeholder="Insert facebook button image path" size="40"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Twitter:';?></th>
				<td>
			
				<input type="textbox" id="csbwfs_page_tw_image" name="csbwfs_page_tw_image" value="<?php echo get_option('csbwfs_page_tw_image'); ?>" placeholder="Insert twitter button image path" size="40"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Linkdin:';?></th>
				<td>
			
				<input type="textbox" id="csbwfs_page_li_image" name="csbwfs_page_li_image" value="<?php echo get_option('csbwfs_page_li_image'); ?>" placeholder="Insert linkdin button image path" size="40"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Pintrest:';?></th>
				<td>
			
				<input type="textbox" id="csbwfs_page_pin_image" name="csbwfs_page_pin_image" value="<?php echo get_option('csbwfs_page_pin_image'); ?>" placeholder="Insert pinterest button image path" size="40"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Google:';?></th>
				<td>
			
				<input type="textbox" id="csbwfs_page_gp_image" name="csbwfs_page_gp_image" value="<?php echo get_option('csbwfs_page_gp_image'); ?>" placeholder="Insert google button image path" size="40"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Mail:';?></th>
				<td>
				<input type="textbox" id="csbwfs_page_mail_image" name="csbwfs_page_mail_image" value="<?php echo get_option('csbwfs_page_mail_image'); ?>" placeholder="Insert mail button image path" size="40"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Youtube:';?></th>
				<td>
				<input type="textbox" id="csbwfs_page_yt_image" name="csbwfs_page_yt_image" value="<?php echo get_option('csbwfs_page_yt_image'); ?>" placeholder="Insert youtube button image path" size="40"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Reddit:';?></th>
				<td>
				<input type="textbox" id="csbwfs_page_re_image" name="csbwfs_page_re_image" value="<?php echo get_option('csbwfs_page_re_image'); ?>" placeholder="Insert reddit button image path" size="40"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Stumbleupon:';?></th>
				<td>
				<input type="textbox" id="csbwfs_page_st_image" name="csbwfs_page_st_image" value="<?php echo get_option('csbwfs_page_st_image'); ?>" placeholder="Insert stumbleupon button image path" size="40"/>
				</td>
			</tr>
			
	</table>
	
	</div>
	<!-- Support -->
	<div class="last author csbwfs-tab" id="div-csbwfs-support">
	
	<h2>Plugin Support</h2>
	
	<p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WN785E5V492L4" target="_blank" style="font-size: 17px; font-weight: bold;"><img src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" title="Donate for this plugin"></a></p>
	
	<p><strong>Plugin Author:</strong><br><img src="<?php echo  plugins_url( 'images/raghu.jpg' , __FILE__ );?>" width="75" height="75"><br><a href="http://raghunathgurjar.wordpress.com" target="_blank">Raghunath Gurjar</a></p>
	<p><a href="mailto:raghunath.0087@gmail.com" target="_blank" class="contact-author">Contact Author</a></p>
	<p><strong>My Other Plugins:</strong><br>
	<ul>
		<li><a href="https://wordpress.org/plugins/protect-wp-admin/" target="_blank">Protect WP-Admin</a></li>
		<li><a href="https://wordpress.org/plugins/simple-testimonial-rutator/" target="_blank">Simple Testimonial Rutator</a></li>
		<li><a href="https://wordpress.org/plugins/wp-easy-recipe/" target="_blank">WP Easy Recipe</a></li>
		<li><a href="https://wordpress.org/plugins/wp-social-buttons/" target="_blank">WP Social Buttons</a></li>
		<li><a href="https://wordpress.org/plugins/wp-youtube-gallery/" target="_blank">WP Youtube Gallery</a></li>
		</ul></p>
	</div>

	</div>
	<span class="submit-btn"><?php echo get_submit_button('Save Settings','button-primary','submit','','');?></span>
		
    <?php settings_fields('csbwf_sidebar_options'); ?>
	
	</form>

<!-- End Options Form -->
	</div>

<?php
}
endif;

require dirname(__FILE__).'/csbwfs-class.php';
	
/* 

*Delete the options during disable the plugins 

*/

if( function_exists('register_uninstall_hook') )

	register_uninstall_hook(__FILE__,'csbwf_sidebar_uninstall');   

//Delete all Custom Tweets options after delete the plugin from admin
function csbwf_sidebar_uninstall(){
		
	delete_option('csbwfs_active');
	delete_option('csbbuttons_active');
	delete_option('csbwfs_position');
	delete_option('csbwfs_btn_position');
	delete_option('csbwfs_btn_text');
	delete_option('csbwfs_fb_image');
	delete_option('csbwfs_tw_image');
	delete_option('csbwfs_li_image');
	delete_option('csbwfs_re_image');
	delete_option('csbwfs_st_image');
	delete_option('csbwfs_mail_image');
	delete_option('csbwfs_gp_image');
	delete_option('csbwfs_pin_image');
	delete_option('csbwfs_yt_image');
	delete_option('csbwfs_re_image');
	delete_option('csbwfs_st_image');	
	delete_option('csbwfs_ytPath');
	delete_option('csbwfs_fb_bg');
	delete_option('csbwfs_tw_bg');
	delete_option('csbwfs_li_bg');
	delete_option('csbwfs_mail_bg');
	delete_option('csbwfs_gp_bg');
	delete_option('csbwfs_pin_bg');	
	delete_option('csbwfs_yt_bg');
	delete_option('csbwfs_fpublishBtn');
	delete_option('csbwfs_tpublishBtn');
	delete_option('csbwfs_gpublishBtn');	
	delete_option('csbwfs_ppublishBtn');	
	delete_option('csbwfs_lpublishBtn');	
	delete_option('csbwfs_mpublishBtn');	
	delete_option('csbwfs_republishBtn');	
	delete_option('csbwfs_stpublishBtn');
	delete_option('csbwfs_ytpublishBtn');	
	delete_option('csbwfs_mailMessage');
	delete_option('csbwfs_top_margin');
	delete_option('csbwfs_page_hide_home');
	delete_option('csbwfs_page_hide_post');
	delete_option('csbwfs_page_hide_page');
	delete_option('csbwfs_page_fb_image');
	delete_option('csbwfs_page_tw_image');
	delete_option('csbwfs_page_li_image');	
	delete_option('csbwfs_page_re_image');	
	delete_option('csbwfs_page_st_image');	
	delete_option('csbwfs_page_mail_image');	
	delete_option('csbwfs_page_gp_image');	
	delete_option('csbwfs_page_pin_image');		
	delete_option('csbwfs_page_yt_image');	
	delete_option('csbwfs_rmSHBtn');
	delete_option('csbwfs_featuredshrimg');	
	delete_option('csbwfs_defaultfeaturedshrimg');
	delete_option('csbwfs_deactive_for_mob');	
	
} 
?>
