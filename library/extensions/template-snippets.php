<?php
/**
 * Template Snippets
 * ========================================================================
 * template-snippets.php
 * @version    1.0 | June 20th 2013
 * @package    WordPress
 * @subpackage lt3
 * @author     Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link       https://github.com/beaucharman/lt3
 * @license    MIT license
 *
 * This file contains any template related functions that:
 * Get: retrieve data based on an given parameter.
 *   (Get the post's title for example)
 * Include: simple functions that merely render pre defined code.
 *   (Include pagination for example)
 */

/**
 * lt3 Title
 * ========================================================================
 * lt3_title()
 * @param  null
 * @return string
 *
 * Render Title Function. Assign title names and attributes conditionally.
 * ======================================================================== */
function lt3_title()
{
  global $post;
  if ((is_archive()) && (! is_front_page()))
  {
    if (is_category())
    {
      single_cat_title(); echo ' &#045; ';
    }
    elseif (is_tag())
    {
      echo 'Tag Archive for "'; single_tag_title(); echo '" &#045; ';
    }
    elseif (is_day())
    {
      echo 'Archive for '; the_time('F jS, Y'); echo ' &#045; ';
    }
    elseif (is_month())
    {
      echo 'Archive for '; the_time('F, Y'); echo ' &#045; ';
    }
    elseif (is_year())
    {
      echo 'Archive for '; the_time('Y'); echo ' &#045; ';
    }
    elseif (is_author())
    {
      echo 'Author Archive &#045; ';
    }
    elseif (is_tax())
    {
      global $wp_query; $taxonomy_term = $wp_query->get_queried_object();
      echo $taxonomy_term->name; echo ' Archive &#045; ';
    }
    elseif (lt3_is_post_type())
    {
      global $wp_query; $post_type_obj = get_post_type_object(get_post_type($wp_query->post->ID));
      print $post_type_obj->labels->singular_name; echo ' Archive &#045; ';
    }
  }
  elseif (is_search())
  {
    echo 'Search results for "'; the_search_query(); echo '" &#045; ';
  }
  elseif ((! is_404()) && (get_the_title()) && (! is_front_page()) && ((is_single()) || (is_page())))
  {
    the_title(); echo ' &#045; ';
  }
  elseif (is_404())
  {
    echo 'Nothing Found Here &#040;404&#041; &#045; ';
  }
  bloginfo('name'); if (get_bloginfo('description'))
  {
    echo ' &#045; ';
    bloginfo('description');
  }
}

/**
 * lt3 Meta Tag Description
 * ========================================================================
 * lt3_meta_tag_description()
 * @param  null
 * @return string
 *
 * Default header description meta tag
 * ======================================================================== */
function lt3_meta_tag_description()
{
  global $post;
  $content = '';
  if (is_single() || is_page())
  {
    $meta_description = get_post_meta($post->ID, 'metadescription', true);
    if ($meta_description != '')
    {
      $content .= esc_attr($meta_description);
    }
    else
    {
      if (have_posts())
      {
        while (have_posts())
        {
          the_post();
          $excerpt = esc_attr(strip_tags(get_the_excerpt()));
          if (strlen($excerpt) > 140) $excerpt = substr($excerpt, 0, 137) . '&hellip;';
          $content .= $excerpt;
        }
      }
    }
  }
  elseif (is_home() || is_front_page())
  {
    $content .= get_bloginfo('description');
  }
  elseif (is_category())
  {
    $cat_desc = esc_attr(trim(strip_tags(category_description ())));
    if ($cat_desc != '')
      $content .= $cat_desc;
    else
      $content .= 'Archive for the category ' . single_cat_title('', false);
  }
  elseif (is_tag())
  {
    $tag_desc = esc_attr(trim(strip_tags(tag_description())));
    if ($tag_desc != '')
      $content .= $tag_desc;
    else
      $content .= 'Archive for the tag ' . single_tag_title('', false);
  }
  elseif (is_author())
  {
    if (isset($_GET['author_name']))
      $curauth = get_user_by('slug', $author_name);
    else
      $curauth = get_userdata(intval($author));
     $content .= 'Archive for the author ' . $curauth->display_name;
  }
  elseif (is_year())
  {
    $content .= 'Archive for ' . get_the_time('Y');
  }
  elseif (is_month())
  {
    $content .= 'Archive for ' . get_the_time('F, Y');
  }
  elseif (is_day())
  {
    $content .= 'Archive for ' . get_the_time('jS F, Y');
  }
  echo $content;
}

/**
 * lt3 Get Message
 * ========================================================================
 * lt3_get_message()
 * @param  null
 * @return string
 *
 * Function to get defined feedback and notification messages.
 * ======================================================================== */
function lt3_get_message($message_name)
{
  switch(strtoupper($message_name))
  {
    /**
     * No posts via WordPress built in post type message.
     */
    case 'NO POSTS':
      echo '<section class="error-message no-posts">' . "\n";
      echo '<h3>' . __('Oops! Nothing Found Here :(') . '</h3><div>' . "\n";
      echo '<p>' . __('There are currently no posts associated with the <strong>');
      single_cat_title();
      echo __('</strong> category.') . '</p>' . "\n";
      if (LT3_ENABLE_SITE_SEARCH)
      {
        echo '<p>' . __('Try searching our site for what you are after.') . '</p></div>' . "\n";
        get_search_form();
      }
      echo "\n" . '</section>';
      break;

    /**
     * No articles from custom post types.
     */
    case 'NO ARTICLES':
      echo '<section class="error-message no-articles">' . "\n";
      echo '<h3>' . __('Oops! Nothing Found Here :(') . '</h3><div>' . "\n";
      echo '<p>' . __('There are currently no articles here.') . '</p>' . "\n";
      if (LT3_ENABLE_SITE_SEARCH)
      {
        echo '<p>' . __('Try searching our site for what you are after.') . '</p></div>' . "\n";
        get_search_form();
      }
      echo "\n" . '</section>';
      break;

    /**
     * No search results message.
     */
    case 'NO RESULTS':
      echo '<section class="no-results">' . "\n";
      echo '<h3>' . __('Sorry! We couldn\'t find anything&hellip;') . '</h3>' . "\n";
      if (LT3_ENABLE_SITE_SEARCH)
      {
        echo '<p>' . __('Maybe try searching with a different keyword?') . '</p>' . "\n";
        get_search_form();
      }
      echo "\n" . '</section>';
      break;

    /**
     * Declare more messages here.
     */

    /**
     * Default. Page not found message, suitable for a 404 message.
     */
    default:
      echo '<section class="error-message not-found">' . "\n";
      echo '<h3>' . __('Oops! Nothing Found Here :(') . '</h3><div>' . "\n";
      echo '<p>' . __('The page you are looking for does not exist. (404)') . '</p>' . "\n";
      if (LT3_ENABLE_SITE_SEARCH)
      {
        echo '<p>' . __('Try searching our site for what you are after.') . '</p></div>' . "\n";
        get_search_form();
      }
      echo "\n" . '</section>';
      break;
  }
}

/* Function to add more edit buttons to comments
   ======================================================================== */
function lt3_delete_comment_link($id)
{
  if (current_user_can('edit_post'))
  {
    echo ' | <a href="' . admin_url("comment.php?action=cdc&c=$id") . '">Delete</a> | ';
    echo '<a href="' . admin_url("comment.php?action=cdc&dt=spam&c=$id") . '">Spam</a>';
  }
}

/**
 * Adds a back to parent category, page, etc link
 * ========================================================================
 * Need to add functionality for post type, taxonomy,
 * ======================================================================== */
function lt3_back_to_parent_link()
{
  global $post;
  $post = get_post($post);
  $category = get_the_category();
  if (is_attachment())
  {
    $post_parent = get_post($post->post_parent);
    $slug = get_permalink($post_parent->ID);
    $name = get_the_title($post_parent->ID);
  }
  if (lt3_is_post_type())
  {
    $slug = get_post_type_archive_link(get_post_type($post->ID));
    $name = lt3_prettify_words(lt3_plurify_words(get_post_type(get_the_ID())));
  }
  else
  {
    $slug = home_url();
    $name = get_bloginfo('name');
  }
  if ($name && $slug)
  {
    echo '<a class="back-to-parent-link" title="Back to ' . $name . '" href="'
      . $slug . '">&larr; Back to ' . $name . '</a>';
  }
}

/* Sticky Posts
   ======================================================================== */
function lt3_default_sticky_posts()
{
  if (LT3_ENABLE_STICKY_POSTS)
  {
    get_template_part(LT3_TEMPLATE_PARTS_PATH . '/loop', 'sticky');
  }
}

/* Get the Comments Template
   ======================================================================== */
function lt3_get_comments_template()
{
  if (LT3_ENABLE_GLOBAL_COMMENTS) comments_template();
}

/* Function to get categories and taxonomies for a post
   ======================================================================== */
function lt3_get_taxonomies_terms_links()
{
  global $post, $post_id;
  $post = &get_post($post->ID); // get post by post id
  $post_type = $post->post_type; // get post type by post
  $taxonomies = get_object_taxonomies($post_type); // get post type taxonomies
  foreach ($taxonomies as $taxonomy)
  {
    $terms = get_the_terms($post->ID, $taxonomy); // get the terms related to post
    if (! empty($terms))
    {
      $out = array();
      foreach ($terms as $term)
      {
        $out[] = '<a href="' . get_term_link($term->slug, $taxonomy) . '">' . $term->name . '</a>';
      }
      return join(', ', $out);
    }
  }
  return false;
}

/* Function to get Post Nav Links
   ======================================================================== */
function lt3_get_single_nav_links()
{
  echo '<div class="next-single">';
    next_post_link('%link', 'Next Article &rarr;', TRUE);
  echo '</div>';
  echo '<div class="previous-single">';
    previous_post_link('%link', '&larr; Previous Article', TRUE);
  echo '</div>';
}

/* Function to get Category Nav Links
   ======================================================================== */
function lt3_get_archive_nav_links()
{
  posts_nav_link(' &mdash; ', '&larr; Previous Page', 'Next Page &rarr;');
}

/* Functions to include site pagination
   A series of functions that checks for wp_pagenavi(), and conditionally
   displays the appropriate pagination method.
   ======================================================================== */
function lt3_include_single_navigation()
{
  echo '<nav class="single-navigation clear-fix">';
  lt3_get_single_nav_links();
  echo '</nav>';
}

/**
 * Include page pagination (using wp_pagenavi)
 */
function lt3_include_page_pagination()
{
  if (lt3_has_page_pagination())
  {
    if (function_exists('wp_pagenavi'))
    {
      echo '<nav class="page-pagination">';
      wp_pagenavi(array('type' => 'multipart'));
      echo '</nav>';
    }
    else
    {
      lt3_include_page_navigation();
    }
  }
}

/**
 * Include page navigation (previous and next style)
 */
function lt3_include_page_navigation()
{
  if (lt3_has_page_pagination())
  {
    wp_link_pages(array(
      'before'           => '<nav class="page-navigation">' . __('Pages:', 'lt3'),
      'after'            => '</nav>',
      'nextpagelink'     => __('Next page &rarr;', 'lt3'),
      'previouspagelink' => __('Previous &larr;', 'lt3'),
      'pagelink'         => '%')
    );
  }
}

/**
 * Include archive pagination (using wp_pagenavi)
 */
function lt3_include_archive_pagination()
{
  if (function_exists('wp_pagenavi'))
  {
    echo '<nav class="archive-pagination">';
    wp_pagenavi();
    echo '</nav>';
  }
  else
  {
    lt3_include_archive_navigation();
  }
}

/**
 * Include archive navigation (previous and next style)
 */
function lt3_include_archive_navigation()
{
  echo '<nav class="archive-navigation">';
  lt3_get_archive_nav_links();
  echo '</nav>';
}

/* Default post meta information
   ======================================================================== */
function lt3_include_post_meta()
{
  if (LT3_ENABLE_META_DATA)
  {
    echo '<p class="postmetadata">';
    echo '<span class="post-categories-time">';
    echo _e('Posted ');
    if (lt3_get_taxonomies_terms_links())
    {
      echo _e(' in ');
       echo lt3_get_taxonomies_terms_links();
       echo ', ';
    }
    echo 'on the ';
    the_time('jS \o\f F, Y');
    echo '.';
    if (LT3_ENABLE_GLOBAL_COMMENTS)
    {
      echo ' ';
      comments_popup_link('No Comments', '1 Comment &rarr;', '% Comments &rarr;', 'comments-link', '');
    }
    echo '</span><br>';
    the_tags('<span class="post-tags">Tags: ', ', ', '</span>');
    echo '</p>';
  }
}

/**
 * lt3 Read More Text
 * ========================================================================
 * lt3_read_more_text()
 * @param  null
 * @return string
 *
 * Function to change the read more text on Archive pages
 * ======================================================================== */
function lt3_read_more_text()
{
  if (is_attachment())
  {
    echo 'View Full Size Image &rarr;';
  }
  else
  {
    echo 'Read More &rarr;';
  }
}