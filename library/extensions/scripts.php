<?php
/**
 * Scripts
 * ========================================================================
 * scripts.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 *
 * To include scripts correctly, use the wp_register_script, and wp_enqueue_script functions:
 * http://codex.wordpress.org/Function_Reference/wp_register_script
 * http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 *
 * Use wp_deregister_script to unregister an unneeded or troublesome script:
 * http://codex.wordpress.org/Function_Reference/wp_deregister_script
 * ======================================================================== */

/**
 * Enqeue jQuery from Google, rather than the included WordPress version.
 * Consider bundling jQuery with your build scripts for deployment.
 */
if (LT3_LOAD_GOOGLE_JQUERY_LIBRARY)
{
  add_action('wp_enqueue_scripts', 'lt3_load_google_jquery');
  function lt3_load_google_jquery()
  {
    if (! is_admin())
    {
      wp_deregister_script('jquery');
      wp_register_script('jquery',
        'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js',
        false,
        '1',
        true
      );
    }
  }
}

/* Register and Enqeue local scripts
   ======================================================================== */
add_action('wp_enqueue_scripts', 'lt3_load_scripts');
function lt3_load_scripts()
{

  /**
   * Register scripts here
   */
  wp_register_script('lt3_plugins', LT3_FULL_SCRIPTS_PATH . '/plugins.js', array(), LT3_SCRIPTS_CACHE_BREAK, true);
  wp_register_script('lt3_main', LT3_FULL_SCRIPTS_PATH . '/main.js', array(), LT3_SCRIPTS_CACHE_BREAK, true);

  /**
   * Enqueue frontend scripts here
   */
  if (! is_admin())
  {

    /**
     * jQuery
     */
    wp_dequeue_script('jquery');

    if (is_singular() && get_option('thread_comments') && LT3_ENABLE_GLOBAL_COMMENTS)
    {
      wp_enqueue_script('comment-reply');
    }

    /**
     * Load in separate scripts for development, change this to a concatenated
     * file for deployment. See library/project/config.php
     */
    if (LT3_DEVELOPMENT_MODE)
    {
      //wp_enqueue_script('jquery');
      wp_enqueue_script('lt3_plugins');
      // Enqueue other theme template scripts here
    }

    wp_enqueue_script('lt3_main');
  }
}
