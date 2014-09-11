<?php
/*
 * Custom Share Buttons With Floating Sidebar (C)
 * @get_csbwf_sidebar_options()
 * @get_csbwf_sidebar_content()
 * */
?>
<?php 
// get all options value for "Custom Share Buttons with Floating Sidebar"
	function get_csbwf_sidebar_options() {
		global $wpdb;
		$ctOptions = $wpdb->get_results("SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE 'csbwfs_%'");
								
		foreach ($ctOptions as $option) {
			$ctOptions[$option->option_name] =  $option->option_value;
		}
	
		return $ctOptions;	
	}
	
// Get plugin options

$pluginOptionsVal=get_csbwf_sidebar_options();
//check plugin in enable or not
if(isset($pluginOptionsVal['csbwfs_active']) && $pluginOptionsVal['csbwfs_active']==1){
add_action('wp_footer','get_csbwf_sidebar_content');
add_action( 'wp_enqueue_scripts', 'csbwf_sidebar_scripts' );
add_action('wp_footer','csbwf_sidebar_load_inline_js');
add_action('wp_footer','csbwfs_cookie');
}

function csbwfs_cookie()
{
	echo $cookieVal='<script>csbwfsCheckCookie();function csbwfsSetCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname+"="+cvalue+"; "+expires;
}

function csbwfsGetCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(\';\');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==\' \') c = c.substring(1);
        if (c.indexOf(name) != -1) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function csbwfsCheckCookie() {
    var button_status=csbwfsGetCookie("csbwfs_show_hide_status");
    if (button_status != "") {
        
    } else {
      // user = prompt("Please enter your name:","");
     //  if (user != "" && user != null) {
        csbwfsSetCookie("csbwfs_show_hide_status", "active",1);
      // }
    }
}

</script>';


}

if(isset($pluginOptionsVal['csbwfs_buttons_active']) && $pluginOptionsVal['csbwfs_buttons_active']==1){
add_filter( 'the_content', 'csbfs_the_content_filter', 20);
add_action('wp_head','csbuttons_style');
}

function csbuttons_style(){
  	$csbstylee='<style>/* Custom Share Buttons Style*/ #socialButtonOnPage {width:100%; padding-top:5px; padding-bottom:5px;}#socialButtonOnPage .sbutton-post {float:left; padding:5px 1px;}#socialButtonOnPage .sbutton-post img {width:31px; height:30px;opacity:0.7; border-radius:3px 3px 3px 3px;box-shadow:0 1px 4px rgba(0, 0, 0, 0.2);}#socialButtonOnPage .sbutton-post img:hover{opacity:1;}#socialButtonOnPage .sharethis-arrow{float:left;padding:5px 10px 5px 1px;}</style>';
	echo $csbstylee;
	}
//register style and scrip files
function csbwf_sidebar_scripts() {
wp_enqueue_script( 'jquery' ); // wordpress jQuery
wp_register_style( 'csbwf_sidebar_style', plugins_url( 'css/csbwfs.css',__FILE__ ) );
wp_enqueue_style( 'csbwf_sidebar_style' );
}

/*
-----------------------------------------------------------------------------------------------
                              "Add the jQuery code in head section using hooks"
-----------------------------------------------------------------------------------------------
*/


function csbwf_sidebar_load_inline_js()
{
   $pluginOptionsVal=get_csbwf_sidebar_options();
	$jscnt='<script>jQuery(document).ready(function()
  { ';
 
 
  if($pluginOptionsVal['csbwfs_delayTimeBtn']!='0'):
   $jscnt.='jQuery("#delaydiv").hide();
	setTimeout(function(){
	 jQuery("#delaydiv").fadeIn();}, '.$pluginOptionsVal['csbwfs_delayTimeBtn'].');';
  endif;  
  
  if($pluginOptionsVal['csbwfs_tpublishBtn']!=''):
  $jscnt.='jQuery("div#tw a").hover(function(){
  jQuery("div#tw a").animate({width:"60px"});
  },function(){
    jQuery("div#tw a").stop( true, true ).animate({width:"45px"});
  });';
  endif;
  
  if($pluginOptionsVal['csbwfs_fpublishBtn']!=''):
  $jscnt.='jQuery("div#fb a").hover(function(){
    jQuery("div#fb a").animate({width:"60px"});
  },function(){
    jQuery("div#fb a").stop( true, true ).animate({width:"45px"});
  });';
  endif;
  
  if($pluginOptionsVal['csbwfs_mpublishBtn']!=''):
  $jscnt.='jQuery("div#ml a").hover(function(){
    jQuery("div#ml a").animate({width:"60px"});
  },function(){
    jQuery("div#ml a").stop( true, true ).animate({width:"45px"});
  });';
  endif;
  
  if($pluginOptionsVal['csbwfs_gpublishBtn']!=''):
  $jscnt.='jQuery("div#gp a").hover(function(){
    jQuery("div#gp a").animate({width:"60px"});
  },function(){
    jQuery("div#gp a").stop( true, true ).animate({width:"45px"});
  });';
  endif;
  
  if($pluginOptionsVal['csbwfs_lpublishBtn']!=''):
  $jscnt.='jQuery("div#li a").hover(function(){
    jQuery("div#li a").animate({width:"60px"});
  },function(){
    jQuery("div#li a").stop( true, true ).animate({width:"45px"});
  });';
  endif;
  
   if($pluginOptionsVal['csbwfs_ppublishBtn']!=''):
  $jscnt.='jQuery("div#pin a").hover(function(){
    jQuery("div#pin a").animate({width:"60px"});
  },function(){
    jQuery("div#pin a").stop( true, true ).animate({width:"45px"});
  });';
  endif;

  $jscnt.='jQuery("div.show").hide();
  jQuery("div.show a").click(function(){
    jQuery("div#social-inner").show(500);
     jQuery("div.show").hide(500);
    jQuery("div.hide").show(500);
    csbwfsSetCookie("csbwfs_show_hide_status","active","1");
  });
  
  jQuery("div.hide a").click(function(){
     jQuery("div.show").show(500);
      jQuery("div.hide").hide(500);
     jQuery("div#social-inner").hide(500);
     csbwfsSetCookie("csbwfs_show_hide_status","in_active","1");
  });';
  
   $jscnt.='var button_status=csbwfsGetCookie("csbwfs_show_hide_status");
    if (button_status =="in_active") {
      jQuery("div.show").show();
      jQuery("div.hide").hide();
     jQuery("div#social-inner").hide();
    } else {
      jQuery("div#social-inner").show();
     jQuery("div.show").hide();
    jQuery("div.hide").show();
    }';
  
$jscnt.='});</script>';
	
	echo $jscnt;
}	
 
/*
-----------------------------------------------------------------------------------------------
                              "Custom Share Buttons with Floating Sidebar" HTML
-----------------------------------------------------------------------------------------------
*/


function get_csbwf_sidebar_content() {
global $post;
$pluginOptionsVal=get_csbwf_sidebar_options();

if(is_category())
	{
	   $category_id = get_query_var('cat');
	   $shareurl =get_category_link( $category_id );   
	   $cats = get_the_category();
	   $ShareTitle=$cats[0]->name;
	}elseif(is_page() || is_single())
	{
	   $shareurl=get_permalink($post->ID);
	   $ShareTitle=$post->post_title;
	}
	else
	{
        $shareurl =home_url('/');
        $ShareTitle=get_bloginfo('name');
		}

/* Get All buttons Image */

//get facebook button image
if($pluginOptionsVal['csbwfs_fb_image']!=''){ $fImg=$pluginOptionsVal['csbwfs_fb_image'];} 
   else{$fImg=plugins_url('images/fb.png',__FILE__);}   
//get twitter button image  
if($pluginOptionsVal['csbwfs_tw_image']!=''){ $tImg=$pluginOptionsVal['csbwfs_tw_image'];} 
   else{$tImg=plugins_url('images/tw.png',__FILE__);}   
//get linkdin button image
if($pluginOptionsVal['csbwfs_li_image']!=''){ $lImg=$pluginOptionsVal['csbwfs_li_image'];} 
   else{$lImg=plugins_url('images/in.png',__FILE__);}   
//get mail button image  
if($pluginOptionsVal['csbwfs_mail_image']!=''){ $mImg=$pluginOptionsVal['csbwfs_mail_image'];} 
   else{$mImg=plugins_url('images/ml.png',__FILE__);}   
//get google plus button image 
if($pluginOptionsVal['csbwfs_gp_image']!=''){ $gImg=$pluginOptionsVal['csbwfs_gp_image'];} 
   else{$gImg=plugins_url('images/gp.png',__FILE__);}  
//get pinterest button image   
if($pluginOptionsVal['csbwfs_pin_image']!=''){ $pImg=$pluginOptionsVal['csbwfs_pin_image'];} 
   else{$pImg=plugins_url('images/pinit.png',__FILE__);}   
//get email message
if(is_page() || is_single() || is_category() || is_archive()){
	
		if($pluginOptionsVal['csbwfs_mailMessage']!=''){ $mailMsg=$pluginOptionsVal['csbwfs_mailMessage'];} else{
		 $mailMsg='?subject='.get_the_title().'&body='.get_the_permalink();}
 }else
 {
	 $mailMsg='?subject='.get_bloginfo('name').'&body='.home_url('/');
	 }
 

// Top Margin
if($pluginOptionsVal['csbwfs_top_margin']!=''){
	$margin=$pluginOptionsVal['csbwfs_top_margin'];
}else
{
	$margin='25%';
	}

//Sidebar Position
if($pluginOptionsVal['csbwfs_position']=='right'){
	$style=' style="top:'.$margin.';right:-5px;"';
	$idName=' id="csbwfs-right"';
	$showImg='hide.png';
	$hideImg='show.png';
	
}else
{
	$idName=' id="csbwfs-left"';
	$style=' style="top:'.$margin.';left:0;"';
    $showImg='show.png';
	$hideImg='hide.png';
	}
	
 
   
/* Get All buttons background color */

//get facebook button image background color 
if($pluginOptionsVal['csbwfs_fb_bg']!=''){ $fImgbg=' style="background:'.$pluginOptionsVal['csbwfs_fb_bg'].';"';} 
   else{$fImgbg='';}   
//get twitter button image  background color 
if($pluginOptionsVal['csbwfs_tw_bg']!=''){ $tImgbg=' style="background:'.$pluginOptionsVal['csbwfs_tw_bg'].';"';} 
   else{$tImgbg='';}   
//get linkdin button image background color 
if($pluginOptionsVal['csbwfs_li_bg']!=''){ $lImgbg=' style="background:'.$pluginOptionsVal['csbwfs_li_bg'].';"';} 
   else{$lImgbg='';}   
//get mail button image  background color 
if($pluginOptionsVal['csbwfs_mail_bg']!=''){ $mImgbg=' style="background:'.$pluginOptionsVal['csbwfs_mail_bg'].';"';} 
   else{$mImgbg='';}   
//get google plus button image  background color 
if($pluginOptionsVal['csbwfs_gp_bg']!=''){ $gImgbg=' style="background:'.$pluginOptionsVal['csbwfs_gp_bg'].';"';} 
   else{$gImgbg='';}  
//get pinterest button image   background color 
if($pluginOptionsVal['csbwfs_pin_bg']!=''){ $pImgbg=' style="background:'.$pluginOptionsVal['csbwfs_pin_bg'].';"';} 
   else{$pImgbg='';}   

/** Message */ 

if($pluginOptionsVal['csbwfs_show_btn']!=''){ $showbtn=$pluginOptionsVal['csbwfs_show_btn'];} 
   else{$showbtn='Show Buttons';}   
//get mail button image  background color 
if($pluginOptionsVal['csbwfs_hide_btn']!=''){ $hidebtn=$pluginOptionsVal['csbwfs_hide_btn'];} 
   else{$hidebtn='Hide Buttons';}   
//get mail button image  background color 
if($pluginOptionsVal['csbwfs_share_msg']!=''){ $sharemsg=$pluginOptionsVal['csbwfs_share_msg'];} 
   else{$sharemsg='Share This With Your Friends';}   

   
?>
<div id="delaydiv">
<div class='social-widget' <?php echo $idName;?> title="<?php echo $sharemsg; ?>" <?php echo $style;?> >

<div class="show"><a href="javascript:" alt="<?php echo $showbtn;?>" id="show"><img src="<?php echo plugins_url('custom-share-buttons-with-floating-sidebar/images/'.$showImg);?>" title="<?php echo $showbtn;?>"></a></div>

<div id="social-inner">
	<?php if($pluginOptionsVal['csbwfs_fpublishBtn']!=''):?>
	<!-- Facebook -->
	<div class="sbutton">
		<div id="fb">
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $shareurl;?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
   target="_blank" alt="Share on Facebook" <?php echo $fImgbg;?>> <img src="<?php echo $fImg;?>"></a></div>
	</div>
    <?php endif;?>
    <?php if($pluginOptionsVal['csbwfs_tpublishBtn']!=''):?>
	<!-- Twitter -->
	<div class="sbutton">
	<div id="tw"><a href="javascript:" onclick="window.open('https://twitter.com/?status=<?php echo $ShareTitle;?>&nbsp;&nbsp;<?php echo $shareurl;?>','_blank','width=800,height=300')" alt="Twitter" <?php echo $tImgbg;?>><img src="<?php echo $tImg;?>"></a></div>
	</div>
	 <?php endif;?>
	<?php if($pluginOptionsVal['csbwfs_gpublishBtn']!=''):?>
	<!-- Google plus -->
	<div class="sbutton">

	<div id="gp"><a href="https://plus.google.com/share?url=<?php echo $shareurl;?>" onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" alt="Google Plus" <?php echo $gImgbg;?> >    
  <img src="<?php echo $gImg;?>"></a></div>
	</div>
	 <?php endif;?>
	<?php if($pluginOptionsVal['csbwfs_lpublishBtn']!=''):?>
	<!-- Linkdin -->
	<div class="sbutton">

	<div id="li">
		<a href="https://www.linkedin.com/cws/share?url=<?php echo $shareurl;?>" onclick="javascript:window.open(this.href,'','menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" alt="Google Plus" <?php echo $lImgbg;?>>
  <img src="<?php echo $lImg;?>"></a></div>
	</div>
	 <?php endif;?>
	<?php if($pluginOptionsVal['csbwfs_ppublishBtn']!=''):?>
	<!-- Pinterest -->
	<div class="sbutton">

	<div id="pin"><a onclick="window.open('http://pinterest.com/pin/create/button/?url=<?php echo $shareurl;?>&amp;media=http://www.mrwebsolution.in/wp-content/themes/mrweb/images/logo.png&amp;description=<?php echo $ShareTitle;?> :<?php echo $shareurl;?>','pinIt','toolbar=0,status=0,width=620,height=500');" href="javascript:void(0);" <?php echo $pImgbg;?>><img src="<?php echo $pImg;?>"></a></div>
	</div>
	 <?php endif;?>
   <?php if($pluginOptionsVal['csbwfs_mpublishBtn']!=''):?>
	<!-- Mail-->
	<div class="sbutton">
    <div id="ml"><a href="mailto:<?php echo $mailMsg;?>" alt="Email" <?php echo $mImgbg;?>><img src="<?php echo $mImg;?>"></a></div>
	</div>
	 <?php endif;?>
</div>

<div class="hide"><a href="javascript:" alt="<?php echo $hidebtn;?>" id="hide"><img src="<?php echo plugins_url('custom-share-buttons-with-floating-sidebar/images/'.$hideImg);?>" title="<?php echo $hidebtn;?>"></a></div>

</div>
</div>
<?php
}
/**
 * Add social share bottons to the end of every post/page.
 *
 * @uses is_home()
 * @uses is_page()
 * @uses is_single()
 */
function csbfs_the_content_filter( $content ) {

global $post;
$pluginOptionsVal=get_csbwf_sidebar_options();

if(is_category())
	{
	   $category_id = get_query_var('cat');
	   $shareurl =get_category_link( $category_id );   
	   $cats = get_the_category();
	   $ShareTitle=$cats[0]->name;
	}elseif(is_page() || is_single())
	{
	   $shareurl=get_permalink($post->ID);
	   $ShareTitle=$post->post_title;
	}
	else
	{
        $shareurl =home_url('/');
        $ShareTitle=get_bloginfo('name');
		}

/* Get All buttons Image */

//get facebook button image
if($pluginOptionsVal['csbwfs_fb_image']!=''){ $fImg=$pluginOptionsVal['csbwfs_fb_image'];} 
   else{$fImg=plugins_url('images/fb-p.png',__FILE__);}   
//get twitter button image  
if($pluginOptionsVal['csbwfs_tw_image']!=''){ $tImg=$pluginOptionsVal['csbwfs_tw_image'];} 
   else{$tImg=plugins_url('images/tw-p.png',__FILE__);}   
//get linkdin button image
if($pluginOptionsVal['csbwfs_li_image']!=''){ $lImg=$pluginOptionsVal['csbwfs_li_image'];} 
   else{$lImg=plugins_url('images/in-p.png',__FILE__);}   
//get mail button image  
if($pluginOptionsVal['csbwfs_mail_image']!=''){ $mImg=$pluginOptionsVal['csbwfs_mail_image'];} 
   else{$mImg=plugins_url('images/ml-p.png',__FILE__);}   
//get google plus button image 
if($pluginOptionsVal['csbwfs_gp_image']!=''){ $gImg=$pluginOptionsVal['csbwfs_gp_image'];} 
   else{$gImg=plugins_url('images/gp-p.png',__FILE__);}  
//get pinterest button image   
if($pluginOptionsVal['csbwfs_pin_image']!=''){ $pImg=$pluginOptionsVal['csbwfs_pin_image'];} 
   else{$pImg=plugins_url('images/pinit-p.png',__FILE__);}   

//get email message 
if(is_page() || is_single() || is_category() || is_archive()){
	
		if($pluginOptionsVal['csbwfs_mailMessage']!=''){ $mailMsg=$pluginOptionsVal['csbwfs_mailMessage'];} else{
		 $mailMsg='?subject='.get_the_title().'&body='.get_the_permalink();}
 }else
 {
	 $mailMsg='?subject='.get_bloginfo('name').'&body='.home_url('/');
	 }
	 
$shareButtonContent='<div id="socialButtonOnPage"><div class="sharethis-arrow"><img src="'.plugins_url('images/sharethis.png',__FILE__).'"></div>';
/* Facebook*/
if($pluginOptionsVal['csbwfs_fpublishBtn']!=''):
	$shareButtonContent.='<div class="sbutton-post"><div id="fb-p"><a href="https://www.facebook.com/sharer/sharer.php?u='.$shareurl.'" onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600\');return false;"
   target="_blank" alt="Share on Facebook"> <img src="'.$fImg.'"></a></div></div>';
endif;

/* Twitter */
if($pluginOptionsVal['csbwfs_tpublishBtn']!=''):
	$shareButtonContent.='<div class="sbutton-post"><div id="tw-p"><a href="javascript:" onclick="window.open(\'https://twitter.com/?status='.$ShareTitle.'&nbsp;&nbsp;'.$shareurl.'\', \'_blank\', \'width=800,height=300\')" alt="Twitter"><img src="'.$tImg.'"></a></div></div>';
endif;

/* Google Plus */
if($pluginOptionsVal['csbwfs_gpublishBtn']!=''):
	$shareButtonContent.='<div class="sbutton-post"><div id="gp-p"><a href="https://plus.google.com/share?url='.$shareurl.'" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;" alt="Google Plus">    
  <img src="'.$gImg.'"></a></div>
	</div>';
endif;

/* Linkedin */
if($pluginOptionsVal['csbwfs_lpublishBtn']!=''):
$shareButtonContent.='<div class="sbutton-post"><div id="li-p"><a href="https://www.linkedin.com/cws/share?url='.$shareurl.'" onclick="javascript:window.open(this.href,\'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;" alt="Google Plus"><img src="'.$lImg.'"></a></div></div>';
endif;

/* Pinterest */
if($pluginOptionsVal['csbwfs_ppublishBtn']!=''):
$shareButtonContent.='<div class="sbutton-post"><div id="pin-p"><a onclick="window.open(\'http://pinterest.com/pin/create/button/?url='.$shareurl.'&amp;media=http://www.mrwebsolution.in/wp-content/themes/mrweb/images/logo.png&amp;description='.$ShareTitle.':'.$shareurl.'\',\'pinIt\',\'toolbar=0,status=0,width=620,height=500\');" href="javascript:void(0);" style="width: 45px;"><img src="'.$pImg.'"></a></div></div>';
endif;

/* Email */
if($pluginOptionsVal['csbwfs_mpublishBtn']!=''):
$shareButtonContent.='<div class="sbutton-post"><div id="ml-p"><a href="mailto:'.$mailMsg.'" alt="Email"><img src="'.$mImg.'"></a></div></div>';
endif;
$shareButtonContent.='</div>';


	//add_filter( 'the_content', array($this, 'add_share_buttons_to_content'));	
    // Returns the content.
    if(is_home() && $pluginOptionsVal['csbwfs_page_hide_home']!='yes'):
    $shareButtonContent='';
    endif;
    
     if(is_single() && $pluginOptionsVal['csbwfs_page_hide_post']!='yes'):
     $shareButtonContent='';
    endif;
    
     if(is_page() && $pluginOptionsVal['csbwfs_page_hide_page']!='yes'):
     $shareButtonContent='';
    endif;
    
   if($shareButtonContent!=''): 
   return sprintf('%s'.$shareButtonContent,$content);
    else:
    return $content;
    endif;
}
?>
