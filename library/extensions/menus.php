<?php
/**
 * Menus
 * ========================================================================
 * menus.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 *
 * For more menu locations, use:
 *   register_nav_menu('menu_name_location', 'Description of Navigation Menu');
 *
 * For more info: http://codex.wordpress.org/Function_Reference/register_nav_menus.
 *
 * To use in a theme template, use:
 *   wp_nav_menu(array('menu' => 'Menu Name'));
 *
 * For more info, and variations: http://codex.wordpress.org/Function_Reference/wp_nav_menu.
 * ======================================================================== */

/* Register Menu Locations
   ======================================================================== */
if (function_exists('register_nav_menu'))
{
  /**
   * Main Navigation Menu
   */
  register_nav_menu('main_navigation_menu', 'Main Navigation Menu');

  /**
   * Register other menus here.
   */
}

/* Menu Declarations
   ======================================================================== */

/**
 * Page Header Menu
 * ========================================================================
 * lt3_page_header_menu()
 * ======================================================================== */
function lt3_main_navigation_menu()
{
  wp_nav_menu(
    array(
      'theme_location'  => 'main_navigation_menu',
      'container'       => 'nav',
      'container_class' => 'main-navigation-menu',
      'menu_class'      => 'main-navigation-menu-list',
      'items_wrap'      => '<ul class="%2$s" role="navigation">%3$s</ul>',
      'fallback_cb'     => false
    )
  );

  /**
   * Declare other menu render functions here.
   */
}
