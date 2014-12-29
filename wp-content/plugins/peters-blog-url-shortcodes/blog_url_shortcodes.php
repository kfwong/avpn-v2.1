<?php
/*
Plugin Name: Peter's Blog URL Shortcodes
Plugin URI: http://www.theblog.ca/blog-url-shortcodes
Description: Adds shortcodes [blogurl], [posturl], [templateurl] and [childtemplateurl] for WordPress 2.6 and up. Use [blogurl] to generate your site URL. It offers the parameters "slash" and "noslash" (to add a trailing slash; [templateurl] and [childtemplateurl] also support this), as well as "uploads" to produce the URL of the uploads folder and "wordpress" to produce the URL of your WP files. Use [posturl id=3] (replace "3" with a post ID) to generate the permalink for any post.
Author: Peter Keung
Version: 0.4
Change Log:
2013-04-08  0.4: Small improvement to logic to output the upload URL. (Thanks ChichipioWilson!)
2011-03-06  0.3: Added [childtemplateurl] shortcode.
2010-10-16  0.2: Added [templateurl] shortcode and [blogurl wordpress] differentiation from just [blogurl]. Some code cleanup as well.
2008-11-16  0.1: First release
Author URI: http://www.theblog.ca/
*/


class blogurlShortcodes
{

    public static function userSettings()
    {
        /* -----------------------
        Start of settings
        ------------------------*/

        $blogurl_settings = array(); // Do not change this line

        // This is [blogurl] -- pointing to your site's root URL
        // This is different than [blogurl wordpress] if your WordPress files are not at the same level as your site root
        $blogurl_settings['home'] = get_option( 'home' );

        // This is the value if you enter [blogurl wordpress]: the root of your WordPress files
        $blogurl_settings['wordpress'] = get_option( 'siteurl' );

        // Set this to true if you are comfortable with [blogurl]wp-content/etc
        // Set this to false if you are more comfortable with [blogurl]/wp-content/etc
        $blogurl_settings['insertslash'] = true;

        // Template path used for [templateurl]
        $blogurl_settings['templateurl'] = get_bloginfo( 'template_directory' );
        
        // Template path used for [childtemplateurl]
        $blogurl_settings['childtemplateurl'] = get_bloginfo( 'stylesheet_directory' );
        
        /* -----------------------
        End of settings
        ------------------------*/
        
        return $blogurl_settings;
    }
    
    // [blogurl slash noslash uploads]
    public static function blogurl( $attributes )
    {
        $blogurl_settings = blogurlShortcodes::getSettings();

        if( is_array( $attributes ) )
        {
            $attributes = array_flip( $attributes );
        }
        
        if( isset( $attributes['wordpress'] ) )
        {
            $return_blogurl = $blogurl_settings['wordpress'];
        }
        elseif( isset( $attributes['uploads'] ) )
        {
            $return_blogurl = $blogurl_settings['uploads'];
        }
        else
        {
            $return_blogurl = $blogurl_settings['home'];
        }

        if( isset( $attributes['slash'] ) || ( $blogurl_settings['insertslash'] && !isset( $attributes['noslash'] ) ) )
        {
            $return_blogurl .= '/';
        }

        return $return_blogurl;
    }

    // [posturl id=3]
    // 3 being the ID of the post to link to

    public static function posturl( $attributes )
    {

        $post_id = intval( $attributes['id'] );
        $return_posturl = get_permalink( $post_id );

        return $return_posturl;
    }


    // [templateurl slash noslash]

    public static function templateurl( $attributes )
    {
        $blogurl_settings = blogurlShortcodes::getSettings();

        $return_templateurl = $blogurl_settings['templateurl'];

        if( is_array( $attributes ) )
        {
            $attributes = array_flip( $attributes );
        }
        
        if( isset( $attributes['slash'] ) || ( $blogurl_settings['insertslash'] && !isset( $attributes['noslash'] ) ) )
        {
            $return_templateurl .= '/';
        }
        
        return $return_templateurl;
    }
   
    // [childtemplateurl slash noslash]

    public static function childtemplateurl( $attributes )
    {
        $blogurl_settings = blogurlShortcodes::getSettings();

        $return_templateurl = $blogurl_settings['childtemplateurl'];

        if( is_array( $attributes ) )
        {
            $attributes = array_flip( $attributes );
        }
        
        if( isset( $attributes['slash'] ) || ( $blogurl_settings['insertslash'] && !isset( $attributes['noslash'] ) ) )
        {
            $return_templateurl .= '/';
        }
        
        return $return_templateurl;
    }
    
    public static function getSettings()
    {
        $blogurl_settings = blogurlShortcodes::userSettings();
        $upload_dir = wp_upload_dir();
        
        if( !$upload_dir['error'] )
        {
            $blogurl_settings['uploads'] = $upload_dir['baseurl'];
        }
        elseif( '' != get_option( 'upload_url_path' ) )
        {
            // Prior to WordPress 3.5, this was set in Settings > Media > Full URL path to files
            // In WordPress 3.5+ this is now hidden
            $blogurl_settings['uploads'] = get_option( 'upload_url_path' );
        }
        else
        {
            $blogurl_settings['uploads'] = $blogurl_settings['wordpress'] . '/' . get_option( 'upload_path' );
        }

        // To define your own upload URL path (for [blogurl uploads], comment out the line below
        // $blogurl_settings['uploads'] = 'http://yoursite.com/wp-content/uploads';
        
        return $blogurl_settings;
    }
}

add_shortcode( 'blogurl', array( 'blogurlShortcodes', 'blogurl' ) );
add_shortcode( 'posturl', array( 'blogurlShortcodes', 'posturl' ) );
add_shortcode( 'templateurl', array( 'blogurlShortcodes', 'templateurl' ) );
add_shortcode( 'childtemplateurl', array( 'blogurlShortcodes', 'childtemplateurl' ) );
?>