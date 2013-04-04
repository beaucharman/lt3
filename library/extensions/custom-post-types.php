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

  To declare a custom post type, simply add a new class.

  $labels = array(
    'label_singular' => '',
    'label_plural'   => '',
    'menu_label'     => '' // optional
  );

  $options = array( // optional
    'description'    => '',
    'public'         => true,
    'menu_position'  => 20,
    'menu_icon'      => null,
    'hierarchical'   => false,
    'supports'       => array(''),
    'taxonomies'     => array(''),
    'has_archive'    => true,
    'rewrite'        => true
  );

  $help = array(
    array(
      'message'      => ''
    ),
    array(
      'context'      => 'edit',
      'message'      => ''
    )
  );

  new LT3_Custom_Post_Type('name', $labels, $options, $help);

------------------------------------------------ */

/*

 Declare custom post types

------------------------------------------------ */
class LT3_Custom_Post_Type
{
  public $name;
  public $labels;
  public $options;
  public $help;

  /* Class constructor
  ------------------------------------------------ */
  public function __construct($name, $labels, $options = array(), $help = null)
  {
    $this->name    = strtolower(str_replace(' ', '_', $name));
    $this->labels  = $labels;
    $this->options = $options;
    $this->help    = $help;

    if(!post_type_exists($this->name))
    {
      add_action('init', array(&$this, 'register_custom_post_type'));
      add_filter('enter_title_here', array(&$this, 'custom_post_type_title_text'));
      if($this->help) add_action('contextual_help', array(&$this, 'add_custom_contextual_help'), 10, 3);
    }
  }

  /*

  Register the custom post type

  ------------------------------------------------ */
  public function register_custom_post_type()
  {
    $labels = array(
      'name'               => __($this->labels['label_plural']),
      'singular_name'      => __($this->labels['label_singular']),
      'menu_name'          => ($this->labels['menu_label'])
        ? __($this->labels['menu_label']) : __($this->labels['label_plural']),
      'add_new_item'       => __('Add New '. $this->labels['label_singular']),
      'edit_item'          => __('Edit '. $this->labels['label_singular']),
      'new_item'           => __('New '. $this->labels['label_singular']),
      'all_items'          => __('All '. $this->labels['label_plural']),
      'view_item'          => __('View '. $this->labels['label_singular']),
      'search_items'       => __('Search '. $this->labels['label_plural']),
      'not_found'          => __('No '. $this->labels['label_plural'] .' found'),
      'not_found_in_trash' => __('No '. $this->labels['label_plural'] .' found in Trash')
    );

    $options = array_merge(
      array(
        'labels'           => $labels,
        'description'      => '',
        'public'           => true,
        'menu_position'    => 20,
        'menu_icon'        => null,
        'hierarchical'     => false,
        'supports'         => array('title', 'editor', 'thumbnail'),
        'taxonomies'       => array(),
        'has_archive'      => true,
        'rewrite'          => true
      ),
      $this->options
    );

    register_post_type($this->name, $options);
  }

  /*

    Change title placeholder for custom post types

  ------------------------------------------------ */
  public function custom_post_type_title_text()
  {
    $screen = get_current_screen();
    if ($this->name == $screen->post_type)
    {
      $title = 'Enter '. $this->labels['label_singular'] .' Title Here';
    }
    return $title;
  }

  /*

    Add contextual help for custom post types

  ------------------------------------------------ */
  public function add_custom_contextual_help($contextual_help, $screen_id, $screen)
  {
    foreach($this->help as $help)
    {
      if(!$help['context'])
      {
        $context = $this->name;
      }
      else
      {
        $context = $help['context'] . '-' . $this->name;
      }

      if ($context == $screen->id)
      {
        $contextual_help = $help['message'];
      }
    }
    return $contextual_help;
  }
}
