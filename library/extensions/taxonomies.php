<?php
/**
 * Taxonomies
 * ------------------------------------------------------------------------
 * taxonomies.php
 * @version 2.0 | April 1st 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license GNU http://www.gnu.org/licenses/lgpl.txt
 *
 * Properties
 *  $Taxonomy->name | sring
 *  $Taxonomy->lables | array
 *
 * Methods
 *  $Taxonomy->get()
 *  $Taxonomy->achive_link()
 *
 * For more information about registering Taxonomies:
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
 *
 * You can also turn the custom post types declarations into a plugin.
 * For more information: http://codex.wordpress.org/Writing_a_Plugin
 *
 * To declare a taxonomy, simply add a new LT3_Custom_Taxonomy class
 * with the following arguments:
 */

/*
// Required
$name = '';
// Optional
$post_type = ''; // string or array
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
$help = '';
$Taxonomy = new LT3_Custom_Taxonomy( $name, $post_type, $labels, $options, $help );
 */

/* ------------------------------------------------------------------------
   Custom taxonomy class
   ------------------------------------------------------------------------ */
class LT3_Custom_Taxonomy
{
  public $name;
  public $post_type;
  public $labels;
  public $options;
  public $help;

  /* Class constructor */
  public function __construct( $name, $post_type = array(), $labels = array(), $options = array(), $help = null )
  {
    $this->name      = $this->uglify_words( $name );
    $this->post_type = $post_type;
    $this->labels    = $labels;
    $this->options   = $options;
    $this->help      = $help;

    if ( !taxonomy_exists( $this->name ) )
    {
      add_action( 'init', array( &$this, 'register_custom_taxonomies' ), 0 );
      if ( $this->help ) add_action( 'contextual_help', array( &$this, 'add_custom_contextual_help' ), 10, 3 );
    }
  }

  /**
   * Register Taxonomies
   * ------------------------------------------------------------------------
   * register_custom_taxonomies()
   * @param  null
   * @return taxonomy
   * ------------------------------------------------------------------------ */
  public function register_custom_taxonomies()
  {
    /* Create the labels */
    $this->labels['label_singular'] = ( isset( $this->labels['label_singular'] ) )
      ? $this->labels['label_singular'] : $this->prettify_words( $this->name );
    $this->labels['label_plural'] = ( isset( $this->labels['label_plural'] ) )
      ? $this->labels['label_plural'] : $this->plurafy_words( $this->labels['label_singular'] );
    $this->labels['menu_label'] = ( isset( $this->labels['menu_label'] ) )
      ? $this->labels['menu_label'] : $this->labels['label_plural'];

    $labels = array(
      'name'                  => __( $this->labels['label_plural'], $this->labels['label_plural'] . ' general name' ),
      'singular_name'         => __( $this->labels['label_singular'], $this->labels['label_singular'] . ' singular name' ),
      'menu_name'             => __( $this->labels['menu_label'] ),
      'search_items'          => __( 'Search ' . $this->labels['label_plural'] ),
      'all_items'             => __( 'All ' . $this->labels['label_plural'] ),
      'parent_item'           => __( 'Parent ' . $this->labels['label_singular'] ),
      'parent_item_colon'     => __( 'Parent '. $this->labels['label_singular'] . ':' ),
      'edit_item'             => __( 'Edit ' . $this->labels['label_singular'] ),
      'update_item'           => __( 'Update ' . $this->labels['label_singular'] ),
      'add_new_item'          => __( 'Add New ' . $this->labels['label_singular'] ),
      'new_item_name'         => __( 'New ' . $this->labels['label_singular'] ),

     );

    /* Configure the options */
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

    /* Register the new taxonomy */
    register_taxonomy( $this->name, $this->post_type, $options );
  }

  /**
   * Add custom contextual help
   * ------------------------------------------------------------------------
   * add_custom_contextual_help()
   * ------------------------------------------------------------------------ */
  public function add_custom_contextual_help( $contextual_help, $screen_id, $screen )
  {
    $context = 'edit-' . $this->name;
    if ( $context == $screen->id )
    {
      $contextual_help = $this->help;
    }
    return $contextual_help;
  }

  /**
   * Get
   * ------------------------------------------------------------------------
   * get()
   * @param  $user_args | array
   * @return term data
   * ------------------------------------------------------------------------ */
  public function get( $user_args = array(), $single = false )
  {
    $args = array_merge(
      array(
        'orderby'       => 'name',
        'order'         => 'ASC',
        'hide_empty'    => false,
        'exclude'       => array(),
        'exclude_tree'  => array(),
        'include'       => array(),
        'number'        => '',
        'fields'        => 'all',
        'slug'          => '',
        'parent'        => '',
        'hierarchical'  => true,
        'child_of'      => 0,
        'get'           => '',
        'name__like'    => '',
        'pad_counts'    => false,
        'offset'        => '',
        'search'        => '',
        'cache_domain'  => 'core'
      ), $user_args
    );
    if ( $single )
    {
      $items = get_terms( $this->name, $args );
      return $items[0];
    }
    return get_terms( $this->name, $args );
  }

  /**
   * Archive Link
   * ------------------------------------------------------------------------
   * archive_link()
   * @param  none
   * @return string
   * ------------------------------------------------------------------------ */
  public function archive_link()
  {
    return home_url('/'.$this->name);
  }

  /**
   * Prettify words
   * ------------------------------------------------------------------------
   * prettify_words()
   * @param  $words | string
   * @return string
   *
   * Creates a pretty version of a string, like
   * a pug version of a dog.
   * ------------------------------------------------------------------------ */
  public function prettify_words( $words )
  {
    return ucwords( str_replace( '_', ' ', $words ) );
  }

  /**
   * Uglify words
   * ------------------------------------------------------------------------
   * uglify_words()
   * @param  $words | string
   * @return string
   *
   * creates a url firendly version of the given string.
   * ------------------------------------------------------------------------ */
  public function uglify_words( $words )
  {
    return strToLower( str_replace( ' ', '_', $words ) );
  }

  /**
   * Plurify words
   * ------------------------------------------------------------------------
   * plurafy_words()
   * @param  $words | string
   * @return $words | string
   *
   * Plurifies most common words. Not currently working
   * proper nouns, or more complex words, for example
   * knife -> knives, leaf -> leaves.
   * ------------------------------------------------------------------------ */
  public function plurafy_words( $words )
  {
    if ( strToLower( substr( $words, -1 ) ) == 'y' )
    {
      return substr_replace( $words, 'ies', -1 );
    }
    if ( strToLower( substr( $words, -1 ) ) == 's' )
    {
      return $words . 'es';
    }
    else
    {
      return $words . 's';
    }
  }
}
