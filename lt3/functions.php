<?php if (!defined('ABSPATH')) exit;
/**
 * Functions
 * ========================================================================
 * functions.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 *
 * lt3 Functions and Theme Setup
 *
 * For each theme: custom code, snippets and functions should be placed in
 * library/project and included from this functions.php file.
 */

/* ========================================================================
   Required Constants
   ======================================================================== */
define('LT3_FULL_PROJECT_PATH', get_template_directory() . '/library/project');

define('LT3_FULL_EXTENSIONS_PATH', get_template_directory() . '/library/extensions');

define('LT3_FULL_DASHBOARD_PATH', get_template_directory() . '/library/dashboard');

define('LT3_SCRIPTS_PATH', 'library/javascripts');

define('LT3_FULL_SCRIPTS_PATH', get_template_directory_uri() . '/' . LT3_SCRIPTS_PATH);

define('LT3_STYLES_PATH', 'library/stylesheets');

define('LT3_FULL_STYLES_PATH', get_template_directory_uri() . '/' . LT3_STYLES_PATH);

define('LT3_IMAGES_PATH', 'library/images');

define('LT3_FULL_IMAGES_PATH', get_template_directory_uri() . '/' . LT3_IMAGES_PATH);

define('LT3_TEMPLATE_PARTS_PATH', 'library/template_parts');

/* ========================================================================
   Site Configuration
   ======================================================================== */
require_once(LT3_FULL_PROJECT_PATH . '/config.php');

/* ========================================================================
   Required Extention Files
   ======================================================================== */

/* Initial Theme Setup
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/initial-theme-setup.php');

/* Helper Functions
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/helpers.php');

/* Site Settings
   ======================================================================== */
// require_once(LT3_FULL_EXTENSIONS_PATH . '/site-settings.php');

/* Admin Functions
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/admin.php');

/* Editor Functions
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/editor.php');

/* Media
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/media.php');

/* Template Options
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/template-options.php');

/* Template Filters
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/template-filters.php');

/* Template Snippets
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/template-snippets.php');

/* Custom Post Types
   ======================================================================== */
// require_once(LT3_FULL_EXTENSIONS_PATH . '/custom-post-type.php');

/* Custom Taxonomies
   ======================================================================== */
// require_once(LT3_FULL_EXTENSIONS_PATH . '/custom-taxonomy.php');

/* Loop Functions
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/loop.php');

/* Theme Widgets
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/widgets.php');

/* Theme Menus
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/menus.php');

/* Theme Scripts
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/scripts.php');

/* Theme Styles
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/styles.php');

/* Template Hooks
   ======================================================================== */
// require_once(LT3_FULL_EXTENSIONS_PATH . '/template-hooks.php');

/* ========================================================================
   Project Extensions
   ======================================================================== */

/* Site Settings Init
   ======================================================================== */
// require_once(LT3_FULL_PROJECT_PATH . '/site-settings-init.php');

/* Custom Post Types Init
   ======================================================================== */
// require_once(LT3_FULL_PROJECT_PATH . '/custom-post-types-init.php');

/* Custom Taxonomies Init
   ======================================================================== */
// require_once(LT3_FULL_PROJECT_PATH . '/custom-taxonomies-init.php');

/**
 * Include more files as needed.
 */
