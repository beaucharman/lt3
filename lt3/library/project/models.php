<?php
/**
 * Models
 *
 * @package      WordPress
 * @subpackage   samurai/library/extensions/custom-post-type.php
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/samurai
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


class Model
{



  function __construct()
  {

    /**
     * Include Font Awesome
     */
    Katana_Custom_Post_Type::get_font_awesome();

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
   * Create Taxonomies
   *
   */
  function create_taxonomies()
  {

    //
    // Example - Genre
    //
    $Genre = new Katana_Custom_Taxonomy(
      array(
        'name'      => 'genre',
        'post_type' => 'movie'
       )
    );

  }


  /**
   *
   * Create Post Types
   *
   */
  function create_post_types()
  {

    //
    // Example - Movie
    //
    $Movie = new Katana_Custom_Post_Type(
      array(
        'name' => 'movie'
      )
    );

  }

}

new Model;
