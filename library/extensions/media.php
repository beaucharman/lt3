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
 * ======================================================================== */

/* Add Theme Support
   ======================================================================== */
add_theme_support('post-thumbnails');

/* Set post thumbnail size
   ======================================================================== */
set_post_thumbnail_size(LT3_PAGE_CONTENT_WIDTH / 4, 9999);

/* Add custom image sizes
   ======================================================================== */
add_action('init', 'lt3_add_image_sizes');
/**
 * Declare various image sizes for WordPress image size sampling
 */
function lt3_add_image_sizes()
{
  /**
   * Large hero image, usefull for hero banner / feature image fader
   */
  add_image_size('large-hero-image', HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true);

  /**
   * Small feature image, useful for a smaller feature image alternate
   */
  add_image_size('small-feature-image',  LT3_PAGE_CONTENT_WIDTH, 300, true);

  /**
   * Small editor image size, half of the content's width
   */
  add_image_size('small',  LT3_PAGE_CONTENT_WIDTH / 2, 200, false);

  /**
   * Large image size, usefull for light box output, or retina ready large content image
   */
  add_image_size('massive',  LT3_PAGE_CONTENT_WIDTH * 1.5, LT3_PAGE_CONTENT_WIDTH, false);

  /**
   * Add more sizes here.
   */
}

/**
 * Filter - Add image sizes for selection in the WordPress editor.
 */
add_filter('image_size_names_choose', 'lt3_show_image_sizes');
function lt3_show_image_sizes($sizes)
{
  $sizes['small']   = __('Small');
  $sizes['massive'] = __('Massive');
  return $sizes;
}
