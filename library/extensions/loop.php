<?php
/**
 * Loop
 * ========================================================================
 * loop.php
 * @version    2.1 | 6th June 2013
 * @package    WordPress
 * @subpackage lt3
 * @author     Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link       https://github.com/beaucharman/lt3
 * @license    MIT license
 *
 * Control specific loop outputs.
 * Loops altered from these functions are executed when the requested is made,
 * long before the page is rendered, reducing redundant database calls.
 * This also keeps the core files untouched.
 *
 * By default, all pages with order posts by title, acending.
 *
 * Use: $query->set($loop_variable, $value); to alter the loop output.
 *   Example, hide cat 4 site wide by default:
 *   $query->set('cat', '-12');
 *
 * Use: $query->query_vars[], or conditional statements belonging to the $query array
 *   to select the required loop to alter.  Also use print_r($query->query_vars) to see
 *   all avaliable query vars for a particular template page.
 *   Example, show 3 posts per page if viewing post type 'books':
 *   if ($query->query_vars['post_type'] == 'books') $query->set('posts_per_page','3');
 *
 * Example: Randomly order posts when viewing the search template page.
 *   if ($query->is_search) $query->set('orderby','rand');
 *
 * For more information:
 *   http://codex.wordpress.org/Class_Reference/WP_Query
 *   http://codex.wordpress.org/Function_Reference/query_posts
 *   http://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
 * ======================================================================== */

/* Set all posts to be sorted alphabetically
   ======================================================================== */
add_action('pre_get_posts', 'lt3_default_loop_outputs');
function lt3_default_loop_outputs($query)
{
  global $wp_the_query;
  if (($wp_the_query === $query) && (!is_admin()))
  {

    /* Order all posts all by title, acensding by default
       ======================================================================== */
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');

    // Place other loop alterations here

  }
  return $query;
}