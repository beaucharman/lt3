<?php
/**
 * Styles
 * ========================================================================
 * styles.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 *
 * To include styles correctly, use the wp_register_style, and wp_enqueue_style functions:
 * http://codex.wordpress.org/Function_Reference/wp_register_style
 * http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 *
 * Use wp_deregister_style to unregister an unneeded or troublesome style.
 * http://codex.wordpress.org/Function_Reference/wp_deregister_style
 */

/* Register and enqeue styles
   ======================================================================== */
add_action('init', 'lt3_load_styles');
function lt3_load_styles()
{

  /**
   * Register styles here
   */
  wp_register_style('lt3_custom_admin_styles', LT3_FULL_STYLES_PATH
    . '/admin/custom-admin-styles.css', array(), LT3_SCRIPTS_CACHE_BREAK);
  wp_register_style('lt3_main_stylesheet', LT3_FULL_STYLES_PATH
    . '/main.css', array(), LT3_STYLES_CACHE_BREAK);

  /**
   * Enqueue styles here
   */
  if (!is_admin())
  {
    /**
     * Front end stylesheets
     */

    /* Main stylesheet */
    wp_enqueue_style('lt3_main_stylesheet');

    /**
     * Enqueue theme styles here.
     * Consider seperate files for development, then bundle into style.css
     * for deployment. Conditional styles would be appropriate to be loaded here.
     */
  }
  elseif (is_admin())
  {
    /**
     * Admin stylesheets
     */

    /* Add consistency to site settings inputs */
    wp_enqueue_style('lt3_custom_admin_styles');

    // Enqueue admin styles here.
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
