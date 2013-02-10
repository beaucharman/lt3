<?php
/*
  
  lt3-theme Custom Taxonomies
  
------------------------------------------------
  Version: 1.0
  Notes:

  For more information about registering Taxonomies:
  http://codex.wordpress.org/Function_Reference/register_taxonomy

  You can also turn the custom post types declarations into a plugin. for more information: http://codex.wordpress.org/Writing_a_Plugin
  
  To declare a taxonomy, simply add a taxonomy array to the $custom_taxonomies array variable, with required values of:
    'slug_singluar'         => '',
    'slug_plural'           => '',
    'name_singular'         => '',
    'name_plural'           => '',
  
  and optional values of:       
    'public'                => true,
    'show_in_nav_menus'     => true,
    'show_ui'               => true,
    'show_tagcloud'	        => true,
    'hierarchical'          => true,
    'update_count_callback' => NULL,
    'query_var'             => true,
    'rewrite'               => '',
    'sort'                  => NULL,
    'post_type'             => array('')
------------------------------------------------ */

/* 

  Declare Taxonomies

------------------------------------------------ */
$custom_taxonomies = array();

/*

  Register Taxonomies

------------------------------------------------ */
add_action('init', 'lt3_register_taxonomies', 0);
function lt3_register_taxonomies()
{
  global $custom_taxonomies;
  foreach($custom_taxonomies as $custom_taxonomy)
  {
    $labels = array(
      'name'                  => __($custom_taxonomy['name_plural'], $custom_taxonomy['name_plural'] . ' general name'),
      'singular_name'         => __($custom_taxonomy['name_singular'], $custom_taxonomy['name_singular'] . ' singular name'),
      'search_items'          => __('Search ' . $custom_taxonomy['name_plural']),
      'all_items'             => __('All ' . $custom_taxonomy['name_plural']),
      'parent_item'           => __('Parent ' . $custom_taxonomy['name_singular']),
      'parent_item_colon'     => __('Parent '. $custom_taxonomy['name_singular'] .':'),
      'edit_item'             => __('Edit '. $custom_taxonomy['name_singular']),
      'update_item'           => __('Update ' . $custom_taxonomy['name_singular']),
      'add_new_item'          => __('Add New ' . $custom_taxonomy['name_singular']),
      'new_item_name'         => __('New ' . $custom_taxonomy['name_singular']),
      'menu_name'             => __($custom_taxonomy['name_plural'])
    );
    register_taxonomy($custom_taxonomy['slug_plural'], $custom_taxonomy['post_type'], array(
      'labels'                => $labels,
      'public'                => $custom_taxonomy['public'],
      'show_in_nav_menus'     => $custom_taxonomy['show_in_nav_menus'],
      'show_ui'               => $custom_taxonomy['show_ui'],
      'show_tagcloud'         => $custom_taxonomy['show_tagcloud'],
      'hierarchical'          => $custom_taxonomy['hierarchical'],
      'update_count_callback' => $custom_taxonomy['update_count_callback'],
      'query_var'             => $custom_taxonomy['query_var'],
      'rewrite'               => $custom_taxonomy['rewrite'],
      'sort'                  => $custom_taxonomy['sort']
    ));
  }
}

/*

  Create Taxonomy drop downs for all post types

------------------------------------------------ */
add_action('restrict_manage_posts', 'lt3_todo_restrict_manage_posts');
add_filter('parse_query','lt3_todo_convert_restrict');
function lt3_todo_restrict_manage_posts() 
{
  global $typenow;
  $args=array('public' => true, '_builtin' => false);
  $post_types = get_post_types($args);
  if (in_array($typenow, $post_types)) 
  {
    $filters = get_object_taxonomies($typenow);
    foreach ($filters as $tax_slug) 
    {
      $tax_obj = get_taxonomy($tax_slug);
      wp_dropdown_categories(array(
        'show_option_all' => __('Show All '.$tax_obj->label),
        'taxonomy' => $tax_slug,
        'name' => $tax_obj->name,
        'orderby' => 'term_order',
        'selected' => $_GET[$tax_obj->query_var],
        'hierarchical' => $tax_obj->hierarchical,
        'show_count' => false,
        'hide_empty' => true
      ));
    }
  }
}

function lt3_todo_convert_restrict($query) 
{
  global $pagenow,  $typenow;
  if ($pagenow=='edit.php') 
  {
    $filters = get_object_taxonomies($typenow);
    foreach ($filters as $tax_slug) 
    {
      $var = &$query->query_vars[$tax_slug];
      if (isset($var)) 
      {
        $term = get_term_by('id',$var,$tax_slug);
        $var = $term->slug;
      }
    }
  }
}