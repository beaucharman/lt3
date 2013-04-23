<?php
/**
 * Site Settings Init
 * ------------------------------------------------------------------------
 * site-settings-init.php
 * @version    2.0 | April 12th 2013
 * @package    lt3
 * @subpackage lt3/library/extensions/site-settings.php
 * @author     Beau Charman | @beaucharman | http://beaucharman.me
 * @link       https://github.com/beaucharman/lt3
 * @license    GNU http://www.gnu.org/licenses/lgpl.txt
 * ------------------------------------------------------------------------ */

/* Declare the Site Settings options
   ------------------------------------------------------------------------ */
$group     = 'lt3_site_settings';
$name      = 'lt3_settings';
$menu_name = 'Site Settings';
$title     = get_bloginfo( 'name' ) . ' Site Setings';

/* Declare the Site Settings fields
   ------------------------------------------------------------------------ */
$args = array(
  array(
    'id'          => 'google_analytics',
    'type'        => 'text',
    'description' => 'Define the Google Analytics tracking code for the site here.',
    'placeholder' => 'UA-XXXXX-X'
   )
 );

/* Declare a new instance of the Site Settings class
   ------------------------------------------------------------------------ */
new LT3_Site_Settings_Page( $group, $name, $args, $menu_name, $title );

/* Create a global variable of the Site Settings
   ------------------------------------------------------------------------ */
if ( !is_admin() )
{
  $lt3_site_settings = get_option( $name );
}