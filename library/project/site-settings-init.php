<?php
/*

  Site Settings Init

------------------------------------------------
  site-settings-init.php
  @version 2.0 | April 12th 2013
  @package lt3
  @author  Beau Charman | @beaucharman | http://beaucharman.me
  @link    https://github.com/beaucharman/lt3
  @licence GNU http://www.gnu.org/licenses/lgpl.txt

  library/extensions/site-settings.php
------------------------------------------------ */

/* Declare the Site Settings options and fields */
$settings_group     = 'lt3_site_settings';
$settings_name      = 'lt3_settings';
$settings_menu_name = 'Site Settings';
$settings_title     = get_bloginfo('name') . ' Site Setings';
$args = array(
  array(
    'id'             => 'google_analytics',
    'type'           => 'text',
    'description'    => 'Define the Google Analytics tracking code for the site here.',
    'placeholder'    => 'UA-XXXXX-X'
  )
);

/* Declare a new instance of the Site Settings class */
new LT3_Site_Settings_Page($settings_group, $settings_name, $args, $settings_menu_name, $settings_title);

/* Create a global variable of the Site Settings */
if(!is_admin())
{
  $lt3_site_settings = get_option($settings_name);
}
