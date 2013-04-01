<?php
/*

  lt3 Helper Functions

------------------------------------------------
  helper-functions.php
  @version 2.0 | April 1st 2013
  @package lt3
  @author  Beau Charman | @beaucharman | http://beaucharman.me
  @link    https://github.com/beaucharman/lt3
  @licence GNU http://www.gnu.org/licenses/lgpl.txt

  This files contains the functions and file references
  that are used to alter and enhance the general administration area.
------------------------------------------------ */

/*

  Logic and conditional functions

------------------------------------------------*/

/* Function to check if page is child of $post_id
------------------------------------------------ */
function lt3_is_child_of_page($post_id)
{
  global $post;
  $parent = $post->post_parent;
  $grandparents_get = get_post($parent);
  $grandparent = $grandparents_get->post_parent;
  $greatgrandparents_get = get_post($grandparent);
  $greatgrandparent = $greatgrandparents_get->post_parent;
  if((!$post_id) && (
    ($parent) ||
    ($grandparent) ||
    ($greatgrandparent)
  ))
  {
    return true;
  }
  elseif((is_page()) && (
    (get_the_title($parent) == $post_id) ||
    ($parent == $post_id) ||
    (get_the_title($grandparent) == $post_id) ||
    ($grandparent == $post_id) ||
    (get_the_title($greatgrandparent) == $post_id) ||
    ($greatgrandparent == $post_id)
  ))
  {
    return true;
  }
  else
  {
    return false;
  }
}

/* Function to check if current category is a child of $parent_category category
------------------------------------------------ */
function lt3_is_child_of_category($parent_category)
{
  if(is_category())
  {
    $categories = get_categories('include='.get_query_var('cat'));
    return ($categories[0]->category_parent == $parent_category) ? true : false;
  }
}

/* Function to check if Custom Post Type
------------------------------------------------ */
function lt3_is_post_type($type = '')
{
  global $post, $wp_query;
  if($type == '')
  {
    if(get_post_type($wp_query->post->ID))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  else
  {
    if($type == get_post_type($wp_query->post->ID))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
}

/* Return true if has pagination.
------------------------------------------------ */
function lt3_has_page_pagination()
{
  if(wp_link_pages('echo=0'))
  {
    return TRUE;
  }
  else
  {
    return FALSE;
  }
}

/* Tests if any of a post's assigned categories are descendants of target categories
------------------------------------------------ */
function lt3_post_is_in_descendant_category($cats, $_post = null)
{
  foreach((array) $cats as $cat)
  {
    $descendants = get_term_children((int) $cat, 'category');
    if($descendants && in_category($descendants, $_post))
      return true;
  }
  return false;
}

/* gets the data from a URL
------------------------------------------------ */
function lt3_get_data_with_curl($url = '')
{
  if(!LT3_DEVELOPMENT_MODE)
  {
    if(function_exists('curl_init'))
    {
      $ch = curl_init();
      $timeout = 5;
      curl_setopt($ch,CURLOPT_URL,$url);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
    }
    else
    {
      /* alternative if curl_init does not exist */
      return file_get_contents($url);
    }
  }
  return file_get_contents($url);
}

/*  Debug the template files and display which ones are being used
------------------------------------------------ */
if(LT3_ENABLE_TEMPLATE_DEBUG && LT3_DEVELOPMENT_MODE)
{
  add_action('all','lt3_template_debug');
  function lt3_template_debug()
  {
    $args = func_get_args();
    if(!is_admin() and $args[0])
    {
      if($args[0] == 'template_include')
      {
        echo "<!-- debug: Base Template: {$args[1]} -->\n";
      }
      elseif(strpos($args[0],'get_template_part_') === 0)
      {
        global $last_template_snoop;
        if($last_template_snoop) echo "\n\n<!-- debug: End Template Part: {$last_template_snoop} -->";
        $tpl = rtrim(join('-',  array_slice($args,1)),'-').'.php';
        echo "\n<!-- debug: Template Part: {$tpl} -->\n\n";
        $last_template_snoop = $tpl;
      }
    }
  }
}