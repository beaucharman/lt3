<?php
/**
 * Template Filters
 * ========================================================================
 * template-filters.php
 * @version      1.0 | June 20th 2013
 * @package      WordPress
 * @subpackage   lt3
 *
 * Filters that alter and enhance defined WordPress features and functions
 * are managed in this file.
 */


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


/**
 * lt3 Search Form Request Filter
 * ========================================================================
 * lt3_search_form_request_filter()
 * @param  $query_vars | array
 * @return array
 *
 * Callback for the WordPress 'request' filter. A fix for some errors that
 * occur for an empty search query.
 */
add_filter('request', 'lt3_search_form_request_filter');
function lt3_search_form_request_filter($query_vars)
{
  if (isset($_GET['s']) && empty($_GET['s']))
  {
    $query_vars['s'] = " ";
  }
  return $query_vars;
}

/**
 * lt3 HTML5 Search Form
 * ========================================================================
 * lt3_html5_search_form()
 * @param  {string} $form
 * @return {string} $form
 */
add_filter('get_search_form', 'lt3_html5_search_form');
function lt3_html5_search_form($form)
{
  return ''
    . '<form class="search-form" role="search" method="get" action="' . home_url('/') . '">'
    . '<input type="text" placeholder="' . __("Search&hellip;") . '" value="" name="s" id="s">'
    . '<input type="submit" id="searchsubmit" value="Go">'
    . '</form>';
}

/* Remove more text on search page
   ======================================================================== */
add_filter('excerpt_more', 'lt3_search_excerpt_more');
function lt3_search_excerpt_more($more)
{
  if (is_search())
  {
    global $post;
    return '&hellip;';
  }
}

/* Use Shortcodes in Widgets
   ======================================================================== */
add_filter('widget_text', 'do_shortcode');

/* Custom post excerpt: Remove <script> tags, set
   'Read More' and 'Excerpt Length', allow links
   ======================================================================== */
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'lt3_trim_excerpt');
function lt3_trim_excerpt($text)
{
  global $post;
  if ('' == $text)
  {
    $text = get_the_content('');
    $text = apply_filters('the_content', $text);
    $text = str_replace('\]\]\>', ']]&gt;', $text);
    $text = strip_shortcodes($text);
    $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
    $text = strip_tags($text, '<a>');
    $excerpt_length = apply_filters('excerpt_length', LT3_EXCERPT_LENGTH);
    $excerpt_more = apply_filters('excerpt_more', ' '
      . '&hellip; <a href="' . get_permalink($post->ID)
      . '" class="excerpt-read-more" title="link to article: '
      . the_title_attribute(array('echo' => 0))
      . '">' . LT3_EXCERPT_MORE
      . '</a>'
    );
    $text = wp_trim_words($text, $excerpt_length, $excerpt_more);
  }
  return $text;
}

/* Add browser type to body class
   ======================================================================== */
add_filter('body_class','lt3_browser_body_class');
function lt3_browser_body_class($classes)
{
  global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
  if ($is_lynx) $classes[] = 'browser-lynx';
  elseif ($is_gecko) $classes[] = 'browser-gecko';
  elseif ($is_opera) $classes[] = 'browser-opera';
  elseif ($is_NS4) $classes[] = 'browser-ns4';
  elseif ($is_safari) $classes[] = 'browser-safari';
  elseif ($is_chrome) $classes[] = 'browser-chrome';
  elseif ($is_IE) $classes[] = 'browser-ie';
  else $classes[] = 'browser-unknown';
  if ($is_iphone) $classes[] = 'browser-iphone';
  return $classes;
}

/**
 * Add to the Body Class filter
 */
if(! is_admin())
{
  add_filter('post_class', 'lt3_add_to_body_class');
  add_filter('body_class', 'lt3_add_to_body_class');
  function lt3_add_to_body_class($classes)
  {
    global $post;

    /**
     * Flag if is the front page or not
     */
    if (is_404())
    {
      $classes[] = 'error-page';
    }
    elseif (! is_front_page() && ! is_search() && isset($post->post_name))
    {
      $classes[] = 'not-front-page';
      $classes[] = 'page-' . $post->post_name;
    }
    elseif (is_front_page())
    {
      $classes[] = 'front-page';
    }

    if (! is_404() && ! is_search())
    {
      /**
       * Get terms allocated to the current post type
       * and display as taxonomy--term pairs.
       */
      $taxonomies = get_taxonomies('', 'names');
      foreach ($taxonomies as $taxonomy)
      {
        $post_type_terms = get_the_terms($post->ID, $taxonomy);
        if ($post_type_terms && !is_wp_error($post_type_terms))
        {
          foreach ($post_type_terms as $term)
          {
            $classes[] = 'taxonomy-' . $taxonomy . ' term-' . $term->slug;
          }
        }
      }
    }
    return $classes;
  }
}

/* HTML5 friendly figure tags instead of captions
   ======================================================================== */
add_filter('img_caption_shortcode', 'lt3_img_caption_shortcode_filter',10,3);
function lt3_img_caption_shortcode_filter($val, $attr, $content = null)
{
  extract(shortcode_atts(array(
    'id'      => '',
    'align'   => '',
    'width'   => '',
    'caption' => ''
  ), $attr));

  if (1 > (int) $width || empty($caption))
  {
    return $val;
  }
  $capid = '';

  if ($id)
  {
    $id = esc_attr($id);
    $capid = 'id="figcaption_'. $id . '" ';
    $id = 'id="' . $id . '" aria-labelledby="figcaption_' . $id . '" ';
  }
  return '<figure ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: '
    . (10 + (int) $width) . 'px">' . do_shortcode($content) . '<figcaption ' . $capid
    . 'class="wp-caption-text">' . $caption . '</figcaption></figure>';
}

/**
 * Remove empty paragraph tags from the_content
 * Optional: $content = str_replace('<p>&nbsp;</p>', '', $content);
 * ========================================================================
 */
add_filter('the_content', 'lt3_remove_empty_paragraphs', 20, 1);
function lt3_remove_empty_paragraphs($content)
{
  $pattern = "/<p[^>]*><\\/p[^>]*>/";
  $content = preg_replace($pattern, '', $content);
  $content = str_replace('<p></p>', '', $content);
  return $content;
}

/* Remove <p> tags around images in the editor
   ======================================================================== */
add_filter('the_content', 'lt3_filter_ptags_on_images');
function lt3_filter_ptags_on_images($content)
{
  return preg_replace(
    '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU',
    '\1\2\3',
    $content
 );
}

/* Add Video Mode Transparent to all WP Embed Files
   ======================================================================== */
add_filter('embed_oembed_html', 'lt3_add_video_wmode_transparent', 10, 3);
function lt3_add_video_wmode_transparent($html, $url, $attr)
{
  if (strpos($html, "<embed src=") !== false)
  {
    return str_replace(
      '</param><embed',
      '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ',
      $html
   );
  }
  elseif (strpos ($html, 'feature=oembed') !== false)
  {
    return str_replace('feature=oembed', 'feature=oembed&wmode=opaque', $html);
  }
  else
  {
    return $html;
  }
}
