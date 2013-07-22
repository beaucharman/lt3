<?php
/**
 * Template Hooks
 * ========================================================================
 * template-hooks.php
 * @version      2.1 | 6th June 2013
 * @package      WordPress
 * @subpackage   lt3
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 *
 * All custom action and filter hook declarations and functions for the theme.
 */

/* ========================================================================
   Template Hook Declaration
   ======================================================================== */
function lt3_hook($hook_name)
{
  do_action($hook_name);
}
