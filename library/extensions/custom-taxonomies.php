<?php
/*

  lt3-theme Custom Taxonomies

------------------------------------------------
  custom-taxonomies.php
  @version 2.0 | April 1st 2013
  @package lt3
  @author  Beau Charman | @beaucharman | http://beaucharman.me
  @link    https://github.com/beaucharman/lt3
  @licence GNU http://www.gnu.org/licenses/lgpl.txt

  For more information about registering Taxonomies:
  http://codex.wordpress.org/Function_Reference/register_taxonomy

  You can also turn the custom post types declarations into a plugin. for more information: http://codex.wordpress.org/Writing_a_Plugin

  To declare a taxonomy, add a new class.

  $post_type =''; // string or array
  
  $labels = array(
    'label_singular'        => '',
    'label_plural'          => '',
    'menu_label'            => ''
  );
  
  $options = array(
    'public'                => true,
    'show_ui'               => true,
    'show_in_nav_menus'     => true,
    'show_tagcloud'         => true,
    'hierarchical'          => false,
    'update_count_callback' => null,
    'query_var'             => true,
    'rewrite'               => true,
    'capabilities'          => array(),
    'sort'                  => null
  );
  
  new LT3_Custom_Taxonomy('name', $post_type, $labels, $options)
  
------------------------------------------------ */

/*

  Declare Taxonomies

------------------------------------------------ */
class LT3_Custom_Taxonomy
{
  public $name;
  public $post_type;
  public $labels;
  public $options;

  /* Class constructor */
  public function __construct($name, $post_type, $labels, $options = array())
  {
    $this->name      = strtolower(str_replace(' ', '_', $name));
    $this->post_type = $post_type;
    $this->labels    = $labels;
    $this->options   = $options;

    if(!taxonomy_exists($this->name))
    {
      add_action('init', array(&$this, 'register_custom_taxonomies'), 0);
    }
  }

  /* Register Taxonomies
  ------------------------------------------------ */
  public function register_custom_taxonomies()
  {

    $labels = array(
      'name'                  => __($this->labels['label_plural'], $this->labels['label_plural'] . ' general name'),
      'singular_name'         => __($this->labels['label_singular'], $this->labels['label_singular'] . ' singular name'),
      'menu_name'             => ($this->labels['menu_label'])
        ? __($this->labels['menu_label']) : __($this->labels['label_plural']),
      'search_items'          => __('Search ' . $this->labels['label_plural']),
      'all_items'             => __('All ' . $this->labels['label_plural']),
      'parent_item'           => __('Parent ' . $this->labels['label_singular']),
      'parent_item_colon'     => __('Parent '. $this->labels['label_singular'] .':'),
      'edit_item'             => __('Edit '. $this->labels['label_singular']),
      'update_item'           => __('Update ' . $this->labels['label_singular']),
      'add_new_item'          => __('Add New ' . $this->labels['label_singular']),
      'new_item_name'         => __('New ' . $this->labels['label_singular']),

    );

    $options = array_merge(
      array(
        'labels'                => $labels,
        'public'                => true,
        'show_ui'               => true,
        'show_in_nav_menus'     => true,
        'show_tagcloud'         => true,
        'show_admin_column'     => false,
        'hierarchical'          => false,
        'update_count_callback' => null,
        'query_var'             => $this->name,
        'rewrite'               => true,
        'capabilities'          => array(),
        'sort'                  => null
      ),
      $this->options
    );

    register_taxonomy($this->name, $this->post_type, $options);
  }
}

/*

  Create Taxonomy drop downs for all post types

------------------------------------------------ */
add_action('restrict_manage_posts', 'lt3_todo_restrict_manage_posts');
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
        'taxonomy'        => $tax_slug,
        'name'            => $tax_obj->name,
        'orderby'         => 'term_order',
        'selected'        => $_GET[$tax_obj->query_var],
        'hierarchical'    => $tax_obj->hierarchical,
        'show_count'      => false,
        'hide_empty'      => true
      ));
    }
  }
}

add_filter('parse_query','lt3_todo_convert_restrict');
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
