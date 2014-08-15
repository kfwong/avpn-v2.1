# ACF { Edit Featured Image

Can be used to edit the featured image on a post.

## Compatibility

This add-on will work with:

* version 4 and up

## Note on File Access

When creating an image or file upload field for use on the frontend, take note that Advanced Custom Fields has a field setting to restrict user's Media Library access to only images and files that have been uploaded to the current post, this is usually ideal.

To make sure this restriction is used, when setting up the field, under "Library", click on "Uploaded to post" instead of "All".

## Note on Permissions

Users who are attempting to upload a file to your site using the Media Library require 3 specific capabilities:

1. edit_others_pages
1. edit_published_pages
1. upload_files

I don't know why those first two are specifically required, but they are. If you want to allow subscribers to upload a file, you will have to give them those capabilities.

## Installation

This add-on can be treated as a WP plugin.

### Install as Plugin

1. Copy the folder into your plugins folder
2. Activate the plugin via the Plugins admin page

## Use

Give an imge field, the field name "featured_image".