<?php
/**
 * Site Settings Init
 * ========================================================================
 * site-settings-init.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   samurai/library/extensions/site-settings.php
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/samurai
 * @license      MIT license
 */

/* Declare the Site Settings options
   ======================================================================== */
$group = 'samurai_site_settings';
$name = 'samurai_settings';
$menu_name = 'Site Settings';
$title = get_bloginfo('name') . ' Site Setings';

/**
 * Declare the Site Settings fields
 * ========================================================================
 * See https://github.com/beaucharman/samurai/wiki/Site-Settings-Init-Example
 * for field examples.
 */
$args = array(
  array(
    'type'    => 'divider',
    'content' => '<p>There are currently no site settings.</p>'
  )
);

/* Declare a new instance of the Site Settings class
   ======================================================================== */
new Samurai_Site_Settings_Page($group, $name, $args, $menu_name, $title);

/* Create a global variable of the Site Settings
   ======================================================================== */
if (! is_admin())
{
  $samurai_site_settings = get_option($name);
}
