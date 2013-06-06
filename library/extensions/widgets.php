<?php
/**
 * Widgets
 * ========================================================================
 * widgets.php
 * @version    2.1 | 6th June 2013
 * @package    WordPress
 * @subpackage lt3
 * @author     Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link       https://github.com/beaucharman/lt3
 * @license    MIT license
 *
 * For more info, and variations:
 * http://codex.wordpress.org/Function_Reference/register_sidebar
 *
 * To use in a theme template, use:
 *   dynamic_sidebar('sidebar-id');
 *
 * To unregister a sidebar to clean up the widgets area, as an example use:
 *   add_action('widgets_init', 'name_of_sidebar_init_function');
 */

/* ========================================================================
   Widget Areas
   ======================================================================== */

/**
 * Register Header Sidebar
 * ========================================================================
 * lt3_register_header_sidebar()
 * ======================================================================== */
add_action('widgets_init', 'lt3_register_header_sidebar');
function lt3_register_header_sidebar()
{
  register_sidebar(array(
    'name'          => __('Header Sidebar'),
    'id'            => 'header-sidebar-widgets',
    'description'   => __('These are widgets for the Header Sidebar.'),
    'before_widget' => '<aside class="widget header-sidebar-widget %2$s %1$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>'
  ));
}

/**
 * Register Primary Sidebar
 * ========================================================================
 * lt3_register_primary_sidebar()
 * ======================================================================== */
add_action('widgets_init', 'lt3_register_primary_sidebar');
function lt3_register_primary_sidebar()
{
  register_sidebar(array(
    'name'          => __('Primary Sidebar Widgets'),
    'id'            => 'primary-sidebar-widgets',
    'description'   => __('These are widgets for the Primary Sidebar.'),
    'before_widget' => '<div class="widget primary-sidebar-widget %2$s %1$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>'
  ));
}

/**
 * Register Footer Sidebar
 * ========================================================================
 * lt3_register_footer_sidebar()
 * ======================================================================== */
add_action('widgets_init', 'lt3_register_footer_sidebar');
function lt3_register_footer_sidebar()
{
  register_sidebar(array(
    'name'          => __('Footer Sidebar'),
    'id'            => 'footer-sidebar-widgets',
    'description'   => __('These are widgets for the Footer Sidebar.'),
    'before_widget' => '<aside class="widget footer-sidebar-widget %2$s %1$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>'
  ));
}