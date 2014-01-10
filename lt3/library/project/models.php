<?php
/**
 * Models
 *
 * @package      WordPress
 * @subpackage   lt3/library/extensions/custom-post-type.php
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 *
 * Data structures, taxonomies and custom post types
 *
 * To declare a custom post type, simply create a new instance of the
 * Bamboo_Custom_Taxonomy class.
 *
 * Configuration guide:
 * https://github.com/beaucharman/wordpress-custom-post-types
 * https://github.com/beaucharman/wordpress-custom-taxonomies
 */


class LT3_Model {

  /**
   * Taxonomy and Post Type vaiable declarations
   */
  // examples
  // public static $Taxonomy;
  // public static $Post_Type;

  function __construct()
  {

    /**
     * Include Font Awesome
     */
    // Bamboo_Custom_Post_Type::get_font_awesome();

    /**
     * register taxonomies
     */
    self::create_taxonomies();

    /**
     * register post types
     */
    self::create_post_types();

  }



  /**
   *
   * Taxonomies
   *
   */
  function create_taxonomies()
  {

    // example
    // LT3_Model::$Taxonomy = new Bamboo_Custom_Taxonomy(array('name', 'post_type'));

  }



  /**
   *
   * Post Types
   *
   */
  function create_post_types()
  {

    // example
    // LT3_Model::$Post_Type = new Bamboo_Custom_Post_Type('name');

  }
}

new LT3_Model;
