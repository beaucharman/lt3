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


class Bamboo_Model {


  /**
   * Global Variables
   */
  // public static $Genre;
  // public static $Movie;


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

    //
    // Example - Genre
    //
    // Bamboo_Model::$Genre = new Bamboo_Custom_Taxonomy(
    //   array(
    //     'name'   => 'genre',
    //     'post_type' => 'movie'
    //    )
    // );

  }


  /**
   *
   * Post Types
   *
   */
  function create_post_types()
  {

    //
    // Example - Movie
    //
    // Bamboo_Model::$Movie = new Bamboo_Custom_Post_Type(
    //   array(
    //     'name'   => 'movie'
    //   )
    // );

  }

}

new Bamboo_Model;
