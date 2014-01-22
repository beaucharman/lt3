<?php
/**
 * Menus Class
 * ========================================================================
 * menus.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 */

class LT3_Menu
{

  public $name;
  public $theme_location;
  public $container;
  public $menu_class;
  public $items_wrap;
  public $fallback_cb;



  public function __construct($args)
  {
    /**
     * Set class values
     */
    if (! is_array($args))
    {
      $name = $args;
      $args = array();
    }
    else
    {
      $name = $args['name'];
    }

    $args = array_merge(
      array(
        'name'           => $name,
        'theme_location' => $this->uglify_words($name),
        'container'      => '',
        'menu_class'     => $this->urify_words($name) . '__list',
        'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
        'fallback_cb'    => false
      ),
      $args
    );

    $this->name = $args['name'];
    $this->theme_location = $args['theme_location'];
    $this->container = $args['container'];
    $this->menu_class = $args['menu_class'];
    $this->items_wrap = $args['items_wrap'];
    $this->fallback_cb = $args['fallback_cb'];

    /**
     * Register and Enqeue local scripts
     */
    add_action('init', array(&$this, 'register_nav_menus'));
  }



  /**
   *
   * Register Menu Locations
   *
   */
  public function register_nav_menus()
  {

    register_nav_menu($this->theme_location, $this->name);
  }



  /**
   *
   * Menu Declarations
   *
   */
  public function render()
  {
    wp_nav_menu(
      array(
        'theme_location' => $this->theme_location,
        'container'      => $this->container,
        'menu_class'     => $this->menu_class,
        'items_wrap'     => $this->items_wrap,
        'fallback_cb'    => $this->fallback_cb
      )
    );
  }



  /**
   *
   * Format helpers
   *
   */
  private function uglify_words($words)
  {
    return strToLower(str_replace(' ', '_', $words));
  }

  private function urify_words($words)
  {
    return strToLower(str_replace(' ', '-', $words));
  }
}



/**
 *
 * Main Navigation Menu
 *
 */
$Main_Navigation_Menu = new lt3_Menu(
  array(
   'name' => 'Main Navigation Menu'
  )
);
