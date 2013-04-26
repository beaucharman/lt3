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
  public $_name;
  public $_post_type;
  public $_labels;
  public $_options;
  public $_help;

  /* Class constructor */
  public function __construct( $name, $post_type = array(), $labels = array(), $options = array(), $help = null )
  {
    $this->_name      = $this->uglify_words( $name );
    $this->_post_type = $post_type;
    $this->_labels    = $labels;
    $this->_options   = $options;
    $this->_help      = $help;

    if ( !taxonomy_exists( $this->_name ) )
    {
      add_action( 'init', array( &$this, 'register_custom_taxonomies' ), 0 );
      if ( $this->_help ) add_action( 'contextual_help', array( &$this, 'add_custom_contextual_help' ), 10, 3 );
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
    $label_singular = ( isset( $this->_labels['label_singular'] ) )
      ? $this->_labels['label_singular'] : $this->prettify_words( $this->_name );
    $label_plural   = ( isset( $this->_labels['label_plural'] ) )
      ? $this->_labels['label_plural'] : $this->plurafy_words( $label_singular );
    $menu_name      = ( isset( $this->_labels['menu_label'] ) )
      ? $this->_labels['menu_label'] : $label_plural;

    /* TODO: Clean this up */
    $this->_labels['label_singular'] = $label_singular;
    $this->_labels['label_plural'] = $label_plural;
    $this->_labels['menu_label'] = $menu_name;

    $labels = array(
      'name'                  => __( $label_plural, $label_plural . ' general name' ),
      'singular_name'         => __( $label_singular, $label_singular . ' singular name' ),
      'menu_name'             => __( $menu_name ),
      'search_items'          => __( 'Search ' . $label_plural ),
      'all_items'             => __( 'All ' . $label_plural ),
      'parent_item'           => __( 'Parent ' . $label_singular ),
      'parent_item_colon'     => __( 'Parent '. $label_singular . ':' ),
      'edit_item'             => __( 'Edit ' . $label_singular ),
      'update_item'           => __( 'Update ' . $label_singular ),
      'add_new_item'          => __( 'Add New ' . $label_singular ),
      'new_item_name'         => __( 'New ' . $label_singular ),

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
        'query_var'             => $this->_name,
        'rewrite'               => true,
        'capabilities'          => array(),
        'sort'                  => null
       ),
      $this->_options
     );

    /* Register the new taxonomy */
    register_taxonomy( $this->_name, $this->_post_type, $options );
  }

  /**
   * Get
   * ------------------------------------------------------------------------
   * get()
   * @param  $user_args | array
   * @return term data
   * ------------------------------------------------------------------------ */
  public function get( $user_args = array() )
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
    return get_terms( $this->_name, $args );
  }

  /**
   * Add custom contextual help
   * ------------------------------------------------------------------------
   * add_custom_contextual_help()
   * ------------------------------------------------------------------------ */
  public function add_custom_contextual_help( $contextual_help, $screen_id, $screen )
  {
    $context = 'edit-' . $this->_name;
    if ( $context == $screen->id )
    {
      $contextual_help = $this->_help;
    }
    return $contextual_help;
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
