<?php if (!defined('ABSPATH')) exit;
/**
 * Functions
 *
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 *
 * lt3 Functions and Theme Setup.
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

define('LT3_VIEWS_PATH', 'library/views');


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

/* Loop Functions
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/loop.php');

/* Template Filters
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/filters.php');

/* Template Snippets
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/template-snippets.php');

/* Pagination
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/pagination.php');

/* Custom Post Types
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/custom-post-type.php');

/* Custom Taxonomies
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/custom-taxonomy.php');

/* Theme Menus
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/menus.php');

/* Theme Scripts
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/scripts.php');

/* Theme Styles
   ======================================================================== */
require_once(LT3_FULL_EXTENSIONS_PATH . '/styles.php');


/* ========================================================================
   Project Extensions
   ======================================================================== */


/* Site Settings Init
   ======================================================================== */
// require_once(LT3_FULL_PROJECT_PATH . '/site-settings-init.php');

/* Models
   ======================================================================== */
require_once(LT3_FULL_PROJECT_PATH . '/models.php');

/**
 * Include more files as needed.
 */
