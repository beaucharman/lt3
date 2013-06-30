<?php
/**
 * Custom Taxonomy
 * ========================================================================
 * custom-taxonomy.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 *
 * Properties
 *  $Taxonomy->name   | sring
 *  $Taxonomy->lables | array
 *
 * Methods
 *  $Taxonomy->get()
 *  $Taxonomy->archive_link()
 *
 * To declare a custom taxonomy, simply create a new instance of the
 * LT3_Custom_Taxonomy class.
 *
 * Configuration guide:
 * https://github.com/beaucharman/wordpress-custom-taxonomies
 *
 * For more information about registering custom taxonomies:
 * http://codex.wordpress.org/Function_Reference/register_taxonomy
 *
 * #Protip
 * If referencing a custom taxonomy and you receive an 'invalid taxonomy'
 * error (mostly likely outside of template files), run your code *after* the
 * init function with an action hook.
 */

/* ========================================================================
   Custom Taxonomy class
   ======================================================================== */
class LT3_Custom_Taxonomy
{
  public $name;
  public $post_type;
  public $labels;
  public $options;
  public $help;

  /**
   * Class Constructor
   * ========================================================================
   * __construct()
   * @param  {string}          $name
   * @param  {array || string} $post_type
   * @param  {string}          $labels
   * @param  {array}           $options
   * @param  {string}          $help
   * @return {instance}        taxonomy
   * ======================================================================== */
  public function __construct($name, $post_type = array(), $labels = array(), $options = array(), $help = null)
  {
    /**
     * Set class values
     */
    $this->name = $this->uglify_words($name);
    $this->post_type = $post_type;
    $this->labels = $labels;
    $this->options = $options;
    $this->help = $help;

    /**
     * Create the labels
     */
    $this->labels['label_singular'] = (isset($this->labels['label_singular']))
      ? $this->labels['label_singular'] : $this->prettify_words($this->name);
    $this->labels['label_plural'] = (isset($this->labels['label_plural']))
      ? $this->labels['label_plural'] : $this->plurify_words($this->labels['label_singular']);
    $this->labels['menu_label'] = (isset($this->labels['menu_label']))
      ? $this->labels['menu_label'] : $this->labels['label_plural'];

    if (! taxonomy_exists($this->name))
    {
      add_action('init', array(&$this, 'register_custom_taxonomy'), 0);
      if ($this->help)
      {
        add_action('contextual_help',
          array(&$this, 'add_custom_contextual_help'), 10, 3);
      }
    }
  }

  /**
   * Register Custom Taxonomy
   * ========================================================================
   * register_custom_taxonomy()
   * @param  {null}
   * @return {object} | taxonomy
   * ======================================================================== */
  public function register_custom_taxonomy()
  {
    $labels = array(
      'name'              => __($this->labels['label_plural'], $this->labels['label_plural'] . ' general name'),
      'singular_name'     => __($this->labels['label_singular'], $this->labels['label_singular'] . ' singular name'),
      'menu_name'         => __($this->labels['menu_label']),
      'search_items'      => __('Search ' . $this->labels['label_plural']),
      'all_items'         => __('All ' . $this->labels['label_plural']),
      'parent_item'       => __('Parent ' . $this->labels['label_singular']),
      'parent_item_colon' => __('Parent '. $this->labels['label_singular'] . ':'),
      'edit_item'         => __('Edit ' . $this->labels['label_singular']),
      'update_item'       => __('Update ' . $this->labels['label_singular']),
      'add_new_item'      => __('Add New ' . $this->labels['label_singular']),
      'new_item_name'     => __('New ' . $this->labels['label_singular']),
   );

    /**
     * Configure the options
     */
    $options = array_merge(
      array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'query_var'         => $this->name,
        'rewrite'           => true,
        'show_admin_column' => true
      ),
      $this->options
   );

    /**
     * Register the new taxonomy
     */
    register_taxonomy($this->name, $this->post_type, $options);
  }

  /**
   * Add Custom Contextual Help
   * ========================================================================
   * add_custom_contextual_help()
   * ======================================================================== */
  public function add_custom_contextual_help($contextual_help, $screen_id, $screen)
  {
    $context = 'edit-' . $this->name;
    if ($context == $screen->id)
    {
      $contextual_help = $this->help;
    }
    return $contextual_help;
  }

  /**
   * Get
   * ========================================================================
   * get()
   * @param  {array}  $user_args
   * @return {object} | term data
   * ======================================================================== */
  public function get($user_args = array(), $single = false)
  {
    $args = array_merge(
      array(
        'orderby'    => 'name',
        'order'      => 'ASC',
        'hide_empty' => false
     ), $user_args
   );

    if ($single)
    {
      $items = get_terms($this->name, $args);
      return $items[0];
    }
    return get_terms($this->name, $args);
  }

  /**
   * Archive Link
   * ========================================================================
   * archive_link()
   * @return {string}
   * ======================================================================== */
  public function archive_link()
  {
    return home_url('/' . $this->name);
  }

  /**
   * Prettify Words
   * ========================================================================
   * prettify_words()
   * @param  {string} $words
   * @return {string}
   *
   * Creates a pretty version of a string, like
   * a pug version of a dog.
   * ======================================================================== */
  public function prettify_words($words)
  {
    return ucwords(str_replace('_', ' ', $words));
  }

  /**
   * Uglify Words
   * ========================================================================
   * uglify_words()
   * @param  {string} $word
   * @return {string}
   *
   * creates a url firendly version of the given string.
   * ======================================================================== */
  public function uglify_words($words)
  {
    return strToLower(str_replace(' ', '_', $words));
  }

  /**
   * Plurify Words
   * ========================================================================
   * plurify_words()
   * @param  {string} $words
   * @return {string}
   *
   * Plurifies most common words. Not currently working
   * proper nouns, or more complex words, for example
   * knife -> knives, leaf -> leaves.
   * ======================================================================== */
  public function plurify_words($words)
  {
    if (strToLower(substr($words, -1)) == 'y')
    {
      return substr_replace($words, 'ies', -1);
    }
    if (strToLower(substr($words, -1)) == 's')
    {
      return $words . 'es';
    }
    else
    {
      return $words . 's';
    }
  }
}
