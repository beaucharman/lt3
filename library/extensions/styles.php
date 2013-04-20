<?php
/**
 * Styles
 * ------------------------------------------------------------------------
 * styles.php
 * @version 2.0 | April 1st 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license GNU http://www.gnu.org/licenses/lgpl.txt
 *
 * To include styles correctly, use the wp_register_style, and wp_enqueue_style functions:
 * http://codex.wordpress.org/Function_Reference/wp_register_style
 * http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 *
 * Use wp_deregister_style to unregister an unneeded or troublesome style.
 * http://codex.wordpress.org/Function_Reference/wp_deregister_style
 * ------------------------------------------------------------------------ */

/* Register and Enqeue local styles
   ------------------------------------------------------------------------ */
add_action('init', 'lt3_load_styles');
function lt3_load_styles()
{

	/* Register styles here: */
	wp_register_style('lt3_custom_admin_styles', LT3_FULL_STYLES_PATH .'/custom-admin-styles.css');

	/* Enqueue styles here: */
	if(!is_admin())
	{
  	// Enqueue conditional theme template styles here
	}
	else if(is_admin())
	{
    /* Add consistency to site settings and meta field inputs */
  	wp_enqueue_style('lt3_custom_admin_styles');
	}
}

/**
 * Styles the visual editor with custom-editor-style.css
 * to match the theme style.
 */
if(LT3_USE_CUSTOM_EDITOR_STYLES)
{
	add_editor_style(LT3_STYLES_PATH .'/custom-editor-style.css');
}

/**
 * This function styles the admin login screen with
 * custom-login-style.css to match the theme style.
 */
if(LT3_USE_CUSTOM_LOGIN_STYLES)
{
  add_action('login_head', 'lt3_custom_login_styles');
  function lt3_custom_login_styles()
  {
    echo '<link rel="stylesheet" type="text/css" href="' . LT3_FULL_STYLES_PATH . '/custom-login-style.css">';
  }
}