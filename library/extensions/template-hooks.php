<?php
/**
 * Template Hooks
 * ========================================================================
 * template-hooks.php
 * @version    2.1 | 6th June 2013
 * @package    WordPress
 * @subpackage lt3
 * @author     Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link       https://github.com/beaucharman/lt3
 * @license    MIT license
 *
 * All action and filter hook declarations and functions for the theme.
 * To remove parnet hooks and filter, it is recomended to use an action tied
 * to the init hook, for example:
 */
/*
  add_action('init', 'remove_parent_actions');
  function remove_parent_actions()
  {
    // remove_action functions
  }
*/

/* ========================================================================
   Template Hook Declaration
   ======================================================================== */
function lt3_hook($hook_name)
{
  do_action($hook_name);
}