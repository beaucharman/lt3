<?php
/*

  lt3 Content Management Configuration

------------------------------------------------
  content.php
  @version 2.0 | April 4th 2013
  @package lt3
  @author  Beau Charman | @beaucharman | http://beaucharman.me
  @link    https://github.com/beaucharman/lt3
  @licence GNU http://www.gnu.org/licenses/lgpl.txt
------------------------------------------------ */

/*

  Flush permalink rewrites after creating custom post types and taxonomies

------------------------------------------------ */
// add_action('init', 'lt3_post_type_and_taxonomy_flush_rewrites');
function lt3_post_type_and_taxonomy_flush_rewrites()
{
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}

/*

  Declare the site settings array

------------------------------------------------
All accept id & type
library/project/config.php
------------------------------------------------ */
$lt3_site_settings_array = array(
  array(
    'id'             => 'google_analytics',
    'type'           => 'text',
    'label'          => 'Google Analytics Code',
    'description'    => 'Define the Google Analytics tracking code for the site here.',
    'placeholder'    => 'UA-XXXXX-X'
  )
);