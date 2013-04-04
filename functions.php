<?php if(!defined('ABSPATH')) exit;
/*

  lt3 Functions and Theme Setup

------------------------------------------------
  functions.php
  @version 2.0 | April 1st 2013
  @package lt3
  @author  Beau Charman | @beaucharman | http://beaucharman.me
  @link    https://github.com/beaucharman/lt3
  @licence GNU http://www.gnu.org/licenses/lgpl.txt
------------------------------------------------ */

/*

  Required Constants

------------------------------------------------ */
define('LT3_FULL_PROJECT_PATH', get_template_directory() . '/library/project');

define('LT3_FULL_EXTENSIONS_PATH', get_template_directory() . '/library/extensions');

define('LT3_FULL_DASHBOARD_PATH', get_template_directory() . '/library/dashboard');

define('LT3_FULL_SCRIPTS_PATH', get_template_directory_uri() . '/library/scripts');

define('LT3_SCRIPTS_PATH', 'library/scripts');

define('LT3_FULL_STYLES_PATH', get_template_directory_uri() . '/library/styles');

define('LT3_STYLES_PATH', 'library/styles');

define('LT3_FULL_IMAGES_PATH', get_template_directory_uri() . '/library/images');

define('LT3_IMAGES_PATH', 'library/images');

define('LT3_TEMPLATE_PARTS_PATH', 'library/template_parts');

/*

  Site Configuration

------------------------------------------------ */
require_once(LT3_FULL_PROJECT_PATH . '/config.php');

/*

  Required Extention Files

------------------------------------------------ */

/* Initial Theme Setup
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/initial-theme-setup.php');

/* Helper Functions
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/helper-functions.php');

/* Site Settings
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/site-settings.php');

/* Admin Functions
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/admin-functions.php');

/* Editor Functions
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/editor-functions.php');

/* Template Functions
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/template-functions.php');

/* Custom Post Types
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/custom-post-types.php');

/* Custom Taxonomies
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/custom-taxonomies.php');

/* Custom Meta Field Boxes
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/custom-meta-field-boxes.php');

/* Loop Functions
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/loop-functions.php');

/* Template Hooks
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/template-hooks.php');

/* Theme Widgets
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/widgets.php');

/* Theme Menus
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/menus.php');

/* Shortcodes
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/shortcodes.php');

/* Theme Scripts
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/scripts.php');

/* Theme Styles
------------------------------------------------ */
require_once(LT3_FULL_EXTENSIONS_PATH . '/styles.php');

/*

  Project Extensions

------------------------------------------------ */
require_once(LT3_FULL_PROJECT_PATH . '/content.php');
