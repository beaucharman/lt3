<?php
/**
 * Config
 * ========================================================================
 * config.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 *
 * lt3 project configuration
 * ======================================================================== */

/* Development mode
   ======================================================================== */
/**
 * Set the production environment for conditional statements.
 * true for development, false for deployment mode.
 */
define('LT3_DEVELOPMENT_MODE', true);

/* Front end layout and design options
   ======================================================================== */

/**
 * Set full page content width
 */
define('LT3_PAGE_CONTENT_WIDTH', 960);

/* Front end functionality and logic options
   ======================================================================== */

/**
 *  Set the global Excerpt length
 */
define('LT3_EXCERPT_LENGTH', 40);

/**
 * Set the global Excerpt More info
 */
define('LT3_EXCERPT_MORE', 'more &rarr;');

/**
 * Enable global comments
 */
define('LT3_ENABLE_GLOBAL_COMMENTS', false);

/**
 * Enable site search
 */
define('LT3_ENABLE_SITE_SEARCH', true);

/**
 * Show post meta data on pages
 */
define('LT3_ENABLE_META_DATA', false);

/* Script, style and behaviour options
   ======================================================================== */

/**
 * stylesheet cache break
 */
define('LT3_STYLES_CACHE_BREAK', '0.1');

/**
 * javascript cache break
 */
define('LT3_SCRIPTS_CACHE_BREAK', '0.1');

/**
 * Use the Google hosted jQuery library
 */
define('LT3_USE_GOOGLE_JQUERY_LIBRARY', false);

/* Theme and editor options
   ======================================================================== */

/**
 * Enable extra TinyMCE buttons
 */
define('LT3_ENABLE_EXTRA_TINYMCE_BUTTONS', false);

/**
 * Use the custom-editor-style.css file for the TinyMCE
 */
define('LT3_USE_CUSTOM_EDITOR_STYLES', false);

/* Utility options
   ======================================================================== */

/**
 * Enable template files debug mode
 */
define('LT3_ENABLE_TEMPLATE_DEBUG', false);

/**
 * Use the custom-login-style.css file for the Login screen
 */
define('LT3_USE_CUSTOM_LOGIN_STYLES', false);

/**
 * Enable admin tutorial section. true/ false
 */
define('LT3_ENABLE_TUTORIAL_SECTION', false);

// End project configuration
