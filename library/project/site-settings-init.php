<?php
/**
 * Site Settings Init
 * ========================================================================
 * site-settings-init.php
 * @version    2.1 | 6th June 2013
 * @package    WordPress
 * @subpackage lt3/library/extensions/site-settings.php
 * @author     Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link       https://github.com/beaucharman/lt3
 * @license    MIT license
 * ======================================================================== */

/* Declare the Site Settings options
   ======================================================================== */
$group = 'lt3_site_settings';
$name = 'lt3_settings';
$menu_name = 'Site Settings';
$title = get_bloginfo('name') . ' Site Setings';

/* Declare the Site Settings fields
   ======================================================================== */
$args = array(
  array(
    'type'    => 'divider',
    'content' => '<p>There are currently no site settings.</p>'
  )
);

/* Declare a new instance of the Site Settings class
   ======================================================================== */
new LT3_Site_Settings_Page($group, $name, $args, $menu_name, $title);

/* Create a global variable of the Site Settings
   ======================================================================== */
if (! is_admin())
{
  $lt3_site_settings = get_option($name);
}