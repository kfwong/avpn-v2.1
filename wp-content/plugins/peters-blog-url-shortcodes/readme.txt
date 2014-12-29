=== Plugin Name ===
Contributors: pkthree
Donate link: http://www.theblog.ca
Tags: shortcode, post, url, admin
Requires at least: 2.6
Tested up to: 3.9
Stable tag: trunk

Use shortcodes for blog URLs, post URLs, and template URLs so that your posts always have the correct internal links.

== Description ==

Adds shortcodes [blogurl], [posturl], [templateurl], and [childtemplateurl] for WordPress 2.6 and up. Use [blogurl] to generate your site URL. It offers the parameters "slash" and "noslash" (to add a trailing slash; [templateurl] and [childtemplateurl] also support this), as well as "uploads" to produce the URL of the uploads folder and "wordpress" to produce the URL of your WP files. Use [posturl id=3] (replace "3" with a post ID) to generate the permalink for any post.

= Features =

* [blogurl] will generate `http://www.yoursite.com/`

* [blogurl wordpress] will generate the URL to the root of your WordPress files, if they are in a different location than your site root

* [blogurl noslash] will generate `http://www.yoursite.com`

* [blogurl uploads] will generate `http://www.yoursite.com/wp-content/uploads/`

* [blogurl uploads noslash] will generate `http://www.yoursite.com/wp-content/uploads`

* [posturl id=375] will generate the correct permalink for the post with an ID of 375; for example, &lt;a href="[posturl id=375]">post about this plugin&lt;/a> would generate [post about this plugin](http://www.theblog.ca/blog-url-shortcodes "From Peter's Useful Crap")

* [templateurl] will generate the URL to your parent theme's root

* [childtemplateurl] will generate the URL to your child theme's root

= Requirements =

* WordPress 2.6 or higher

== Installation ==

Unzip blog\_url\_shortcodes.php to your WordPress plugins folder. It should work out of the box, but you can tweak some settings in the plugin file itself if needed.

== Frequently Asked Questions ==

Please visit the plugin page at http://www.theblog.ca/blog-url-shortcodes with any questions.