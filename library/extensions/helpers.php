<?php
/**
 * Helpers
 * ========================================================================
 * helpers.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 * ======================================================================== */

/* ========================================================================
   Logic and conditional functions
   ======================================================================== */

/**
 * lt3 Get Thumnbnail
 * ========================================================================
 * lt3_get_thumbnail()
 * @param  {integer} $id
 * @param  {string}  $size
 * @param  {boolean} $attributes
 * @return {string || array}
 * ======================================================================== */
function lt3_get_thumbnail($id = null, $size = 'thumbnail', $attributes = false)
{
  global $post;
  if ($id === null)
  {
    $id = $post->ID;
  }

  if (has_post_thumbnail($id))
  {
    $image_src = wp_get_attachment_image_src(get_post_thumbnail_id($id), $size);
    if (! $attributes)
    {
      return $image_src[0];
    }
    return $image_src;
  }
  return false;
}

/**
 * lt3 Get Attachment
 * ========================================================================
 * lt3_get_attachment()
 * @param  {integer} $id
 * @param  {string}  $size
 * @param  {boolean} $attributes
 * @return {string || array}
 * ======================================================================== */
function lt3_get_attachment($id, $size = 'thumbnail', $attributes = false)
{
  $image_src = wp_get_attachment_image_src($id, $size);
  if ($image_src)
  {
    if (! $attributes)
    {
      return $image_src[0];
    }
    return $image_src;
  }
  return false;
}

/**
 * lt3 Get ID by Slug
 * ========================================================================
 * lt3_get_id_by_slug()
 * @param  {string} $page_slug
 * @return {integer}
 * ======================================================================== */
function lt3_get_id_by_slug($page_slug)
{
  if ($page_slug)
  {
    $page = get_page_by_path($page_slug);
  }

  if ($page)
  {
    return $page->ID;
  }
  return null;
}

/**
 * lt3 is Child of Page
 * ========================================================================
 * lt3_is_child_of_page()
 * @param  {integer || string} $page
 * @return {boolean}
 *
 * Function to check if page is child of $page
 * ======================================================================== */
function lt3_is_child_of_page($page)
{
  global $post;
  if (is_string($page))
  {
    $page = lt3_get_id_by_slug($page);
  }
  $parent = (isset($post->post_parent) && $post->post_parent == $page);
  $ancestors = (isset($post->ancestors) && in_array($page, $post->ancestors));
  if ($parent || $ancestors)
  {
    return true;
  }
  return false;
}

/**
 * lt3 is Child of Category
 * ========================================================================
 * lt3_is_child_of_category()
 * @param  $parent_category | integer
 * @return boolean
 *
 * Function to check if current category is a child
 * of $parent_category category
 * ======================================================================== */
function lt3_is_child_of_category($parent_category)
{
  if (is_category())
  {
    $categories = get_categories('include=' . get_query_var('cat'));
    return ($categories[0]->category_parent == $parent_category) ? true : false;
  }
}

/**
 * lt3 is Post Type
 * ========================================================================
 * lt3_is_post_type()
 * @param  $type | string
 * @return boolean
 *
 * Function to check if Custom Post Type
 * ======================================================================== */
function lt3_is_post_type($type = null)
{
  global $post, $wp_query;
  if ($type)
  {
    if (isset($wp_query->post->ID) && $type == get_post_type($wp_query->post->ID))
    {
      return true;
    }
  }
  else
  {
    if (isset($wp_query->post->ID) && get_post_type($wp_query->post->ID))
    {
      return true;
    }
  }
  return false;
}

/**
 * lt3 Has Page Pagination
 * ========================================================================
 * lt3_has_page_pagination()
 * @param null
 * @return boolean
 *
 * Return true if has pagination.
 * ======================================================================== */
function lt3_has_page_pagination()
{
  if (wp_link_pages('echo=0'))
  {
    return TRUE;
  }
  else
  {
    return FALSE;
  }
}

/**
 * lt3 Post is in Descendant Category
 * ========================================================================
 * lt3_post_is_in_descendant_category()
 * @param  $cat | array
 * @param  $_post
 * @return boolean
 *
 * Tests if any of a post's assigned categories are
 * descendants of target categories
 * ======================================================================== */
function lt3_post_is_in_descendant_category($cats, $_post = null)
{
  foreach ((array) $cats as $cat)
  {
    $descendants = get_term_children((int) $cat, 'category');
    if ($descendants && in_category($descendants, $_post))
    {
      return true;
    }
  }
  return false;
}

/**
 * lt3 Get Data with cURL
 * ========================================================================
 * lt3_get_data_with_curl()
 * @param  $url | string
 * @return file output
 *
 * gets the data from a URL
 * ======================================================================== */
function lt3_get_data_with_curl($url = '')
{
  if (! LT3_DEVELOPMENT_MODE)
  {
    if (function_exists('curl_init'))
    {
      $ch = curl_init();
      $timeout = 5;
      curl_setopt($ch, CURLOPT_URL,$url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
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

/**
 * Excerpt
 * ========================================================================
 * lt3_excerpt()
 * @param {string}  $raw_text
 * @param {integer} $word_limit
 * @param {boolean} $echo_result
 *
 * Limit the number of words in a given output
 * ======================================================================== */
function lt3_excerpt($raw_text = '', $echo_result = true, $word_limit = LT3_EXCERPT_LENGTH)
{
  $text = explode(' ', strip_tags(strip_shortcodes($raw_text)));
  $ellipses = false;
  if (sizeof($text) > $word_limit)
  {
    for ($counter = sizeof($text); $counter > $word_limit; $counter--)
    {
      array_pop($text);
    }
    $output_text = implode(' ', $text);
    $ellipses = true;
  }
  else
  {
    $output_text = implode(' ', $text);
  }

  if ($ellipses)
  {
    $output_text .= '&hellip;';
  }

  if (! $echo_result)
  {
    return $output_text;
  }
  echo $output_text;
}

/**
 * lt3_template_debug
 * ========================================================================
 * lt3_template_debug()
 * @param null
 * @return debug output string
 *
 * Debug the template files and display which ones are being used
 * ======================================================================== */
if (LT3_ENABLE_TEMPLATE_DEBUG && LT3_DEVELOPMENT_MODE)
{

  add_action('all','lt3_template_debug');
  function lt3_template_debug()
  {
    $args = func_get_args();
    if (! is_admin() and $args[0])
    {
      if ($args[0] == 'template_include')
      {
        echo "<!-- debug: Base Template: {$args[1]} [turn this debug mode off in '
          . 'library/project/config.php] -->\n";
      }
      elseif (strpos($args[0], 'get_template_part_') === 0)
      {
        global $last_template_snoop;
        if ($last_template_snoop)
        {
          echo "\n\n<!-- debug: End Template Part: {$last_template_snoop} '
          . '[turn this debug mode off in library/project/config.php] -->";
        }
        $tpl = rtrim(join('-', array_slice($args, 1)), '-') . '.php';
        echo "\n<!-- debug: Template Part: {$tpl} [turn this debug mode off in '
          . 'library/project/config.php] -->\n\n";
        $last_template_snoop = $tpl;
      }
    }
  }
}

/**
 * lt3 get time
 * ========================================================================
 * lt3_get_time()
 * @param  $date | WordPress date object
 * @return string
 *
 * WordPress spits out post time with '/'s, php's date function requires '-'s
 * ======================================================================== */
function lt3_get_time($date, $format = 'Y-m-d')
{
  $date = str_replace('/', '-', $date);
  return date($format, strtotime($date));
}

/**
 * Prettify Words
 * ========================================================================
 * lt3_prettify_words()
 * @param  $words | string
 * @return string
 *
 * Creates a pretty version of a string, like
 * a pug version of a dog.
 * ======================================================================== */
function lt3_prettify_words($words)
{
  return ucwords(str_replace('_', ' ', $words));
}

/**
 * Uglify Words
 * ========================================================================
 * lt3_uglify_words()
 * @param  $words | string
 * @return string
 *
 * creates a url firendly version of the given string.
 * ======================================================================== */
function lt3_uglify_words($words)
{
  return strToLower(str_replace(' ', '_', $words));
}

/**
 * Plurify Words
 * ========================================================================
 * lt3_plurify_words()
 * @param  $words | string
 * @return string
 *
 * Plurifies most common words. Not currently working
 * proper nouns, or more complex words, for example
 * knife -> knives, leaf -> leaves.
 * ======================================================================== */
function lt3_plurify_words($words)
{
  if (strToLower(substr($words, -1)) == 'y')
  {
    return substr_replace($words, 'ies', -1);
  }
  if (strToLower(substr($words, -1)) == 's')
  {
    return $words . 'es';
  }
  else
  {
    return $words . 's';
  }
}

/**
 * Debug Tool
 * ========================================================================
 * debug_tool()
 * @param   $variable | string
 * @param   $exit     | boolean
 * @param   $label    | string
 * @param   $echo     | boolean
 * @return  mixed
 *
 * var_dump with style
 * Leave the $variable argument empty to print out a counter
 * https://gist.github.com/beaucharman/5451428
 * ======================================================================== */
if (!function_exists('debug_tool'))
{
  function debug_tool($variable = '', $exit = false, $label = 'Debug', $echo = true)
  {
    global $debug_counter;
    $breakpoint = false;
    if ($variable == 'breakpoint')
    {
      $breakpoint = true;
    }
    $background_color  = ($breakpoint) ? 'd9edf7' : 'eee';
    $text_color        = ($breakpoint) ? '3a87ad' : '444';
    $border_color      = ($breakpoint) ? 'bce8f1' : 'ddd';
    $opening_tag_array = array(
      '<pre style="',
      'line-height:1.4; ',
      'background-color: #' . $background_color . '; ',
      'color: #' . $text_color . '; ',
      'border: 1px solid #' . $border_color . '; ',
      'padding: 10px; ',
      'margin: 10px 0; ',
      'text-align: left;">'
   );
    $opening_tag  = implode($opening_tag_array);
    $closing_tag  = '</pre>';
    $exit_message = $opening_tag . 'exit();' . $closing_tag;

    if ($breakpoint)
    {
      if (!isset($debug_counter))
      {
        $debug_counter = 1;
      }
      $output = $opening_tag . $label . ' Breakpoint => ' . $debug_counter . $closing_tag;
      $debug_counter++;
    }
    else
    {
      /* Store the result of a var dump */
      ob_start();
      var_dump($variable);
      $output = ob_get_clean();

      /* Add to the result */
      $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
      $output = $opening_tag . $label . ' => ' . $output . $closing_tag;
    }

    if ($exit)
    {
      echo $output;
      exit($exit_message);
    }

    if ($echo)
    {
      echo $output;
      return;
    }
    return $output;
  }
}
