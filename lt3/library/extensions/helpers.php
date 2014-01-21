<?php
/**
 * Helpers
 * ========================================================================
 * helpers.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 */


/* ========================================================================
   Logic and conditional functions
   ======================================================================== */


/**
 * lt3 URI
 * ========================================================================
 * @param  {string} $path
 * @return {string}
 */
function lt3_uri($path = '')
{
  return get_stylesheet_directory_uri() . $path;
}


/**
 * Get Thumbnail
 * ========================================================================
 * @param  {integer} $id
 * @param  {string}  $size
 * @param  {boolean} $attributes
 * @return {string || array}
 */
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
 * Get Attachment
 * ========================================================================
 * @param {integer} $id
 * @param {string}  $size
 * @param {boolean} $attributes
 * @return {string || array}
 */
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
 * Get ID by Slug
 * ========================================================================
 * @param {string} $slug
 * @param {string} $post_type
 * @return {integer}
 */
function lt3_get_id_by_slug($slug, $post_type = 'post')
{
  $title_query = new WP_Query(
    array(
      'name' => $slug,
      'post_type' => $post_type
    )
  );

  return $title_query->post->ID;
}


/**
 * Is Child of Page
 * ========================================================================
 * @param {integer || string} $page
 * @return {boolean}
 *
 * Function to check if page is child of $page.
 */
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
 * Is Child of Category
 * ========================================================================
 * @param {integer} $parent_category
 * @return {boolean}
 *
 * Function to check if current category is a child
 * of $parent_category category.
 */
function lt3_is_child_of_category($parent_category)
{
  if (is_category())
  {
    $categories = get_categories('include=' . get_query_var('cat'));
    return ($categories[0]->category_parent == $parent_category) ? true : false;
  }
}


/**
 * Is Post Type
 * ========================================================================
 * @param {string} $type
 * @return {boolean}
 *
 * Function to check if Custom Post Type.
 */
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
 * Has Page Pagination
 * ========================================================================
 * @param null
 * @return {boolean}
 *
 * Return true if has pagination.
 */
function lt3_has_page_pagination()
{
  if (wp_link_pages('echo=0'))
  {
    return true;
  }

  return false;
}


/**
 * Post is in Descendant Category
 * ========================================================================
 * @param {array} $cat
 * @param $_post
 * @return {boolean}
 *
 * Tests if any of a post's assigned categories are
 * descendants of target categories
 */
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
 * Get Data with cURL
 * ========================================================================
 * @param {string} $url
 * @return {string}
 *
 * Gets the data from a URL.
 */
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
 * @param {string} $raw_text
 * @param {integer} $word_limit
 * @param {boolean} $echo_result
 *
 * Limit the number of words in a given output.
 */
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
 * Get Time
 * ========================================================================
 * @param $date [WordPress date object]
 * @return string
 *
 * WordPress spits out post time with '/'s, php's date function requires '-'s.
 */
function lt3_get_time($date, $format = 'Y-m-d')
{
  $date = str_replace('/', '-', $date);
  return date($format, strtotime($date));
}


/**
 * Prettify Words
 * ========================================================================
 * @param {string} $words
 * @return {string}
 *
 * Creates a pretty version of a string, like
 * a pug version of a dog.
 */
function lt3_prettify_words($words)
{
  return ucwords(str_replace('_', ' ', $words));
}


/**
 * Uglify Words
 * ========================================================================
 * @param {string} $words
 * @return {string}
 *
 * Creates a variable firendly version of the given string.
 */
function lt3_uglify_words($words)
{
  return strToLower(str_replace(' ', '_', $words));
}


/**
 * URIfy Words
 * ========================================================================
 * @param {string} $words
 * @return {string}
 *
 * Creates a uri firendly version of the given string.
 */
function lt3_urify_words($words)
{
  return strToLower(str_replace(' ', '-', $words));
}


/**
 * Plurify Words
 * ========================================================================
 * @param {string} $words
 * @return {string}
 *
 * Plurifies most common words. Not currently working
 * proper nouns, or more complex words, for example
 * knife -> knives, leaf -> leaves.
 */
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

  return $words . 's';
}


/**
 * Template Debug
 * ========================================================================
 * @param null
 * @return {string}
 *
 * Debug the template files and display which ones are being used.
 */
if (LT3_ENABLE_TEMPLATE_DEBUG && LT3_DEVELOPMENT_MODE)
{

  add_action('all', 'lt3_template_debug');
  function lt3_template_debug()
  {
    $args = func_get_args();

    if (! is_admin() && isset($args[0]))
    {
      if ($args[0] == 'template_include')
      {
        echo "<!-- debug: Base Template: {$args[1]} [turn this debug mode off in "
          . "library/project/config.php] -->\n";
      }
      elseif (strpos($args[0], 'get_template_part_') === 0)
      {
        global $last_template_snoop;

        if ($last_template_snoop)
        {
          echo "\n\n<!-- debug: End Template Part: {$last_template_snoop} "
          . "[turn this debug mode off in library/project/config.php] -->";
        }

        $tpl = rtrim(join('-', array_slice($args, 1)), '-') . '.php';
        echo "\n<!-- debug: Template Part: {$tpl} [turn this debug mode off in "
          . "library/project/config.php] -->\n\n";
        $last_template_snoop = $tpl;
      }
    }
  }
}
