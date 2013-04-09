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

  For more information on registering post types:
  http://codex.wordpress.org/Function_Reference/register_post_type

  To declare a custom post type, simply add a new class:

  // Required
  $name = '';

  // Optional
  $labels = array(
    'label_singular' => '',
    'label_plural'   => '',
    'menu_label'     => ''
  );

  $options = array(
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

  new LT3_Custom_Post_Type($name, $labels, $options, $help);
------------------------------------------------ */

/*

 Declare custom post types class

------------------------------------------------ */
class LT3_Custom_Post_Type
{
  public $name;
  public $labels;
  public $options;
  public $help;

  /* Class constructor
  ------------------------------------------------
    __construct()
    @param  $name | string
    @param  $labels | array
    @param  $options | array
    @param  $help | array
    @return post_type object
  ------------------------------------------------ */
  public function __construct($name, $labels = array(), $options = array(), $help = null)
  {
    $this->name    = $this->uglify_words($name);
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

  /* Register custom post type
  ------------------------------------------------
    register_custom_post_type()
    @param  null
    @return post_type
  ------------------------------------------------ */
  public function register_custom_post_type()
  {
    /* Create the labels */
    $label_singular = (isset($this->labels['label_singular'])) ? $this->labels['label_singular'] : $this->prettify_words($this->name);
    $label_plural   = (isset($this->labels['label_plural'])) ? $this->labels['label_plural'] : $this->plurafy_words($label_singular);
    $menu_name      = (isset($this->labels['menu_label'])) ? $this->labels['menu_label'] : $label_plural;
    $labels = array(
      'name'               => __($label_plural),
      'singular_name'      => __($label_singular),
      'menu_name'          => __($menu_name),
      'add_new_item'       => __('Add New '. $label_singular),
      'edit_item'          => __('Edit '. $label_singular),
      'new_item'           => __('New '. $label_singular),
      'all_items'          => __('All '. $label_plural),
      'view_item'          => __('View '. $label_singular),
      'search_items'       => __('Search '. $label_plural),
      'not_found'          => __('No '. $label_plural .' found'),
      'not_found_in_trash' => __('No '. $label_plural .' found in Trash')
    );

    /* Configure the options */
    $options = array_merge(
      array(
        'labels'           => $labels,
        'description'      => '',
        'public'           => true,
        'menu_position'    => 20,
        'menu_icon'        => null,
        'hierarchical'     => false,
        'supports'         => array('title', 'editor'),
        'taxonomies'       => array(),
        'has_archive'      => true,
        'rewrite'          => true
      ),
      $this->options
    );

    /* Register the new post type */
    register_post_type($this->name, $options);
  }

  /* Custom post type title text
  ------------------------------------------------
    custom_post_type_title_text()
    @param  null
    @return $title | string
    Change title placeholder for custom post types
  ------------------------------------------------ */
  public function custom_post_type_title_text()
  {
    $screen = get_current_screen();
    if ($this->name == $screen->post_type)
    {
      $title = 'Enter '. $this->prettify_words($this->name) .' Title Here';
    }
    return $title;
  }

  /* Add contextual help for custom post types
  ------------------------------------------------
    add_custom_contextual_help()
    @param  $contextual_help
    @param  $screen_id | integer
    @param  $screen
    @return $contextual_help
    Creates a pretty version of a string, like
    a pug version of a dog.
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

  /* Prettify words
  ------------------------------------------------
    prettify_words()
    @param  $words | string
    @return string
    Creates a pretty version of a string, like
    a pug version of a dog.
  ------------------------------------------------ */
  public function prettify_words($words)
  {
    return ucwords(str_replace('_', ' ', $words));
  }

  /* Uglify words
  ------------------------------------------------
    uglify_words()
    @param  $words | string
    @return string
    creates a url firendly version of the given string.
  ------------------------------------------------ */
  public function uglify_words($words)
  {
    return strToLower(str_replace(' ', '_', $words));
  }

  /* Plurify words
  ------------------------------------------------
    plurafy_words()
    @param  $words | string
    @return $words | string
    Plurifies most common words. Not currently working
    proper nouns, or more complex words, for example
    knife -> knives, leaf -> leaves.
  ------------------------------------------------ */
  public function plurafy_words($words)
  {
    if(strToLower(substr($words, -1)) == 'y')
    {
      return substr_replace($words, 'ies', -1);
    }
    if(strToLower(substr($words, -1)) == 's')
    {
      return $words . 'es';
    }
    else
    {
      return $words . 's';
    }
  }
}
