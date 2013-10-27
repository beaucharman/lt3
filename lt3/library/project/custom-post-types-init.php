<?php
/**
 * Custom Post Types Init
 * ========================================================================
 * custom-post-types-init.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3/library/extensions/custom-post-type.php
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 *
 * To declare a custom post type, simply create a new instance of the
 * LT3_Custom_Post_Type class.
 *
 * Configuration guide:
 * https://github.com/beaucharman/wordpress-custom-post-types
 */

LT3_Custom_Post_Type::get_font_awesome();

$Movie = new LT3_Custom_Post_Type('movie', array(), array(), 'f143');