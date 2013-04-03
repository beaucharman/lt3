<?php
/*

  lt3 Custom Post Types

------------------------------------------------
  custom-post-types.php
  @version 2.0 | April 1st 2013
  @package lt3
  @author  Beau Charman | @beaucharman | http://beaucharman.me
  @link    https://github.com/beaucharman/lt3
  @licence GNU http://www.gnu.org/licenses/lgpl.txt

  For more information about registering Post Types:
  http://codex.wordpress.org/Function_Reference/register_post_type

  For information about setting up custom columns:
  http://tareq.wedevs.com/2011/07/add-your-custom-columns-to-wordpress-admin-panel-tables/

  You can also turn the custom post types declarations into a plugin.
  For more information: http://codex.wordpress.org/Writing_a_Plugin

  To declare a custom post type, simply add a new custom post type array to the
  `lt3_$custom_post_types` master array, with required key and value pairs of:
  array(
    'name'           => '',
    'label_singular' => '',
    'label_plural'   => '',
    //and optional pairs of:
    'menu_label'     => '',
    'description'    => '',
    'public'         => true,
    'menu_position'  => 20,
    'menu_icon'      => null,
    'hierarchical'   => false,
    'supports'       => array(''),
    'taxonomies'     => array(''),
    'has_archive'    => true,
    'rewrite'        => true
  )
------------------------------------------------ */

/*

 Declare custom post types

------------------------------------------------ */
$lt3_custom_post_types_array = array();

/*

  Register custom post types

------------------------------------------------ */
add_action('init', 'lt3_create_custom_post_types');
function lt3_create_custom_post_types()
{
  global $lt3_custom_post_types_array;
  foreach($lt3_custom_post_types_array as $cpt)
  {
    $labels = array(
      'name'               => __($cpt['label_plural']),
      'singular_name'      => __($cpt['label_singular']),
      'menu_name'          => ($cpt['menu_label']) ? __($cpt['menu_label']) : __($cpt['label_plural']),
      'add_new_item'       => __('Add New '. $cpt['label_singular']),
      'edit_item'          => __('Edit '. $cpt['label_singular']),
      'new_item'           => __('New '. $cpt['label_singular']),
      'all_items'          => __('All '. $cpt['label_plural']),
      'view_item'          => __('View '. $cpt['label_singular']),
      'search_items'       => __('Search '. $cpt['label_plural']),
      'not_found'          => __('No '. $cpt['label_plural'] .' found'),
      'not_found_in_trash' => __('No '. $cpt['label_plural'] .' found in Trash'),
    );
    register_post_type(
      $cpt['name'], array(
        'labels'           => $labels,
        'description'      => ($cpt['description'])   ? $cpt['description'] : '',
        'public'           => ($cpt['public'])        ? $cpt['public'] : true,
        'menu_position'    => ($cpt['menu_position']) ? $cpt['menu_position'] : 20,
        'menu_icon'        => ($cpt['menu_icon'])     ? $cpt['menu_icon'] : null,
        'hierarchical'     => ($cpt['hierarchical'])  ? $cpt['hierarchical'] : false,
        'supports'         => ($cpt['supports'])      ? $cpt['supports'] : array('title', 'editor', 'thumbnail'),
        'taxonomies'       => ($cpt['taxonomies'])    ? $cpt['taxonomies'] : array(),
        'has_archive'      => ($cpt['has_archive'])   ? $cpt['has_archive'] : true,
        'rewrite'          => ($cpt['rewrite'])       ? $cpt['rewrite'] : true
      )
    );
  }
}

/*

  Change title placeholder for custom post types

------------------------------------------------ */
add_filter('enter_title_here', 'custom_post_type_title_text');
function custom_post_type_title_text()
{
  global $lt3_custom_post_types_array;
  $screen = get_current_screen();
  foreach($lt3_custom_post_types_array as $cpt)
  {
    if ($cpt['name'] == $screen->post_type)
    {
      $title = 'Enter '. $cpt['label_singular'] .' Title Here';
      break;
    }
  }
  return $title;
}

/*

  Flush permalink rewrites after creating custom post types and taxonomies

------------------------------------------------ */
add_action('init', 'lt3_post_type_and_taxonomy_flush_rewrites');
function lt3_post_type_and_taxonomy_flush_rewrites()
{
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}