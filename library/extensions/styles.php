<?php
/**
 * Styles
 * ========================================================================
 * styles.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 *
 * To include styles correctly, use the wp_register_style, and wp_enqueue_style functions:
 * http://codex.wordpress.org/Function_Reference/wp_register_style
 * http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 *
 * Use wp_deregister_style to unregister an unneeded or troublesome style.
 * http://codex.wordpress.org/Function_Reference/wp_deregister_style
 * ======================================================================== */

/* Register and enqeue stylesheets
   ======================================================================== */
add_action('init', 'lt3_load_styles');
function lt3_load_styles()
{

  /**
   * Register stylesheets here
   */
  wp_register_style('lt3_main_styles', LT3_FULL_STYLES_PATH . '/main.css'
    , array(), LT3_STYLE_CACHE_BREAK, 'all');
    
  wp_register_style('lt3_custom_admin_styles', LT3_FULL_STYLES_PATH
    . '/admin/custom-admin-styles.css');

  /**
   * Enqueue stylesheets here
   */
  if (!is_admin())
  {
    /**
     * Enqueue theme stylesheets here.
     * Consider seperate files for development, then bundle into main.css
     * for deployment. Conditional styles would be appropriate to be loaded here.
     */
     
     if (LT3_DEVELOPMENT_MODE)
     {
       // Enqueue theme template stylesheets here
     }
     
     /* Enqueue the main stylesheet*/
     wp_enqueue_style('lt3_main_styles');
  }
  elseif (is_admin())
  {
    /**
     * Admin area stylesheets
     */

    /* Add consistency to site settings and meta field inputs */
    wp_enqueue_style('lt3_custom_admin_styles');
    
    // Enqueue other admin stylesheets here.
  }
}

/**
 * Custom Editor Styles
 * ========================================================================
 * Styles the visual editor with custom-editor-style.css
 * to match the theme style.
 */
if (LT3_USE_CUSTOM_EDITOR_STYLES)
{
  add_editor_style(LT3_STYLES_PATH . '/admin/custom-editor-style.css');
}

/**
 * Custom Login Styles
 * ========================================================================
 * This function styles the admin login screen with
 * custom-login-style.css to match the theme style.
 */
if (LT3_USE_CUSTOM_LOGIN_STYLES)
{
  add_action('login_head', 'lt3_custom_login_styles');
  function lt3_custom_login_styles()
  {
    echo '<link rel="stylesheet" type="text/css" href="'
      . LT3_FULL_STYLES_PATH . '/admin/custom-login-style.css">';
  }
}
