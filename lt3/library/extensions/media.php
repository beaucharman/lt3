<?php
/**
 * Menus
 * ========================================================================
 * menus.php
 * @version      1.0 | July 20th 2013
 * @package      WordPress
 * @subpackage   lt3
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 */

/* Add Theme Support
   ======================================================================== */
add_theme_support('post-thumbnails');

/**
 * Add custom image sizes
 *
 * Thumbnail, Medium and large sizes are set in the initial-theme-setup.php file.
 * If these are changed, resample images with wordpress.org/plugins/regenerate-thumbnails/
 */
add_action('init', 'lt3_add_image_sizes');
/**
 * Declare various image sizes for WordPress image size sampling
 */
function lt3_add_image_sizes()
{
  /* Add custom sizes here */
  // add_image_size('handle', $width, $height, $crop);
}

/**
 * Filter - Add image sizes for selection in the WordPress editor.
 */
add_filter('image_size_names_choose', 'lt3_show_image_sizes');
function lt3_show_image_sizes($sizes)
{
  /* Add image size handles and desired labels here */
  // $sizes['handle'] = __('Label');

  return $sizes;
}