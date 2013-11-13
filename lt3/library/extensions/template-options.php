<?php
/**
 * Template Options
 * ========================================================================
 * template-options.php
 * @version      2.1 | 6th June 2013
 * @package      WordPress
 * @subpackage   lt3
 */


/* Set the content width
   ======================================================================== */
global $content_width;
if (! isset($content_width))
{
  $content_width = LT3_PAGE_CONTENT_WIDTH;
}


/* Add excerpt field to pages
   ======================================================================== */
add_action('init', 'lt3_add_page_excerpts');
function lt3_add_page_excerpts()
{
  add_post_type_support('page', 'excerpt');
}


/* Clean up the <head>
   ======================================================================== */
add_action('init', 'lt3_remove_head_links');
function lt3_remove_head_links()
{
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'index_rel_link');
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'parent_post_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
}


/* Get the Comments Template
   ======================================================================== */
function lt3_get_comments_template()
{
  if (LT3_ENABLE_COMMENTS)
  {
    comments_template();
  }
}
