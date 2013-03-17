<?php
/*

  lt3-theme Custom Post Types

------------------------------------------------
	Version:   1.0
	Notes:

  For more information about registering Post Types:
  http://codex.wordpress.org/Function_Reference/register_post_type

  For information about setting up custom columns:
  http://tareq.wedevs.com/2011/07/add-your-custom-columns-to-wordpress-admin-panel-tables/

  You can also turn the custom post types declarations into a plugin. for more information: http://codex.wordpress.org/Writing_a_Plugin

  To declare a post type, simply add a custom post type array to the $custom_post_types array variable, with required values of:
    'slug_singluar' => '',
    'slug_plural'   => '',
    'name_singular' => '',
    'name_plural'   => '',

  and optional values of:
    'description'   => '',
    'public'        => true,
    'menu_position' => 20,
    'menu_icon'     => NULL,
    'hierarchical'  => true,
    'supports'      => array(''),
    'taxonomies'    => array(''),
    'has_archive'   => true,
    'rewrite'       => ''
------------------------------------------------ */

/*

 Declare Post Types

------------------------------------------------ */
$custom_post_types = array();

/*

  Register Post Types

------------------------------------------------ */
add_action('init', 'lt3_create_post_types');
function lt3_create_post_types()
{
  global $custom_post_types;
  foreach($custom_post_types as $custom_post_type)
  {
    $labels = array(
      'name'                => __($custom_post_type['name_plural']),
      'singular_name'       => __($custom_post_type['name_singular']),
      'add_new_item'        => __('Add New '. $custom_post_type['name_singular']),
      'edit_item'           => __('Edit '. $custom_post_type['name_singular']),
      'new_item'            => __('New '. $custom_post_type['name_singular']),
      'view_item'           => __('View '. $custom_post_type['name_singular']),
      'search_items'        => __('Search '. $custom_post_type['name_plural']),
      'not_found'           => __('No '. $custom_post_type['name_plural'] .' found'),
      'not_found_in_trash'  => __('No '. $custom_post_type['name_plural'] .' found in Trash')
    );
    register_post_type(
      $custom_post_type['slug_singular'], array(
        'labels'        => $labels,
        'description'   => ($custom_post_type['description']) ? $custom_post_type['description'] : '',
        'public'        => ($custom_post_type['public']) ? $custom_post_type['public'] : true,
        'menu_position' => ($custom_post_type['menu_position']) ? $custom_post_type['menu_position'] : 20,
        'menu_icon'     => ($custom_post_type['menu_icon']) ? $custom_post_type['menu_icon'] : NULL,
        'hierarchical'  => ($custom_post_type['hierarchical']) ? $custom_post_type['hierarchical'] : false,
        'supports'      => ($custom_post_type['supports']) ? $custom_post_type['supports'] : array('title', 'editor', 'thumbnail'),
        'taxonomies'    => ($custom_post_type['taxonomies']) ? $custom_post_type['taxonomies'] : array(),
        'has_archive'   => ($custom_post_type['has_archive']) ? $custom_post_type['has_archive'] : true,
        'rewrite'       => ($custom_post_type['rewrite']) ? $custom_post_type['rewrite'] : $custom_post_type['name_plural']
      )
    );
  }
}

/*

  Change Title for post types

------------------------------------------------ */
add_filter('enter_title_here', 'lt3_custom_title_text');
function lt3_custom_title_text()
{
  global $custom_post_types;
  $screen = get_current_screen();
  foreach($custom_post_types as $custom_post_type)
  {
    if ($custom_post_type['slug_singular'] == $screen->post_type)
    {
      $title = 'Enter '. $custom_post_type['name_singular'] .' Title Here';
      break;
    }
  }
  return $title;
}

/*

  Custom Columns

------------------------------------------------ */

/* Change the columns for the REPLACE
------------------------------------------------ */
//add_filter('manage_REPLACE_posts_columns', 'change_columns');
//add_action('manage_REPLACE_posts_custom_column', 'custom_columns', 10, 2);
function change_columns($cols)
{
  $cols = array(
    'cb'       => '<input type="checkbox" />',
    'title'      => __('Title',      'trans'),
    'department' => __('Department', 'trans')
  );
  return $cols;
}

function custom_columns($column, $post_id)
{
  switch ($column)
  {
    case "title":
      $title = get_the_title($post_id);
      echo '<a href="' . get_permalink() . '">' . $title. '</a>';
      break;
    case "department":
      $department = get_post_meta($post_id, 'departments_details_id', true);
      echo '<a href="' . get_permalink($department) . '">' . get_the_title($department) . '</a>';
      break;
  }
}

/* Make these columns sortable
------------------------------------- */
//add_filter('manage_edit-services_sortable_columns', 'sortable_columns');
function sortable_columns() {
  return array(
    'title'      => 'title',
    'department' => 'department'
  );
}


/*

  Remove Posts from admin area

------------------------------------------------ */
//add_action('admin_menu', 'lt3_remove_menus');
function lt3_remove_menus()
{
  global $menu;
  $restricted = array(__('Posts'), __('Comments'));
  end ($menu);
  while (prev($menu))
  {
    $value = explode(' ',$menu[key($menu)][0]);
    if(in_array($value[0] != NULL?$value[0]:"" , $restricted)) unset($menu[key($menu)]);
  }
}

/*

  Flush permalink rewrite after creating custom post types and taxonomies

------------------------------------------------ */
//add_action('init', 'lt3_post_and_taxonomy_flush_rewrite');
function lt3_post_and_taxonomy_flush_rewrite()
{
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}