<?php
/*
Plugin Name: Advanced Custom Fields: Edit Featured Image
Plugin URI: http://bitbucket.org/jupitercow/acf-featured-image
Description: Takes a particular field named "featured_image" (which can be customized), and uses it to update the featured image.
Version: 0.1
Author: Jake Snyder
Author URI: http://Jupitercow.com/
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

------------------------------------------------------------------------
Copyright 2013 Jupitercow, Inc.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/

if (! class_exists('acf_edit_featured_image') ) :

add_action( 'init', array('acf_edit_featured_image', 'init') );

class acf_edit_featured_image
{
	/**
	 * Class prefix
	 *
	 * @since 	0.1
	 * @var 	string
	 */
	public static $prefix = 'edit_featured_image';

	/**
	 * Current version of plugin
	 *
	 * @since 	0.1
	 * @var 	string
	 */
	public static $version = '0.1';

	/**
	 * The field name to use
	 *
	 * @since 	0.1
	 * @var 	array
	 */
	private static $field_name = 'featured_image';

	/**
	 * Initialize the Class
	 *
	 * @author  Jake Snyder
	 * @since	0.1
	 * @return	void
	 */
	public function init()
	{
		if (! self::test_requirements() ) return;

		// Allow the field name to be changed
		self::$field_name = apply_filters( 'acf/' . self::$prefix . '/field_name', self::$field_name );

		// Update the featured image field
		add_filter( 'acf/update_value/name=' . self::$field_name, array(__CLASS__, 'set_featured_image'), 10, 3 );
	}

	/**
	 * Make sure that any neccessary dependancies exist
	 *
	 * @author  Jake Snyder
	 * @since	0.1
	 * @return	bool True if everything exists
	 */
	public static function test_requirements()
	{
		// Look for ACF
		if (! class_exists('Acf') ) return false;
		return true;
	}

	/**
	 * Set the featured image when editing a post using ACF for a field named "featured_image" (or whatever it was changed to)
	 *
	 * @since	0.1
	 * @return	string value
	 */
	public static function set_featured_image( $value, $post_id, $field )
	{
		if ( $value )
		{
			// Add the value which is the image ID to the _thumbnail_id meta data for the current post
			update_post_meta( $post_id, '_thumbnail_id', $value );
		}
		return $value;
	}
}

endif;