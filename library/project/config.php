<?php
/**
 * Config
 * ========================================================================
 * config.php
 * @version 2.0 | April 1st 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license MIT license
 *
 * lt3 project configuration
 * ======================================================================== */

/* ========================================================================
   Development mode
   ======================================================================== */
/**
 * Set the production environment for conditional statements.
 * true for development, false for deployment mode.
 */
define('LT3_DEVELOPMENT_MODE', true);

/* ========================================================================
   Front end layout and design options
   ======================================================================== */

/* Set full page wrap width (including padding)
   ======================================================================== */
define('LT3_PAGE_WRAP_WIDTH', 980);

/* Set full page content width (not including padding)
   ======================================================================== */
define('LT3_PAGE_CONTENT_WIDTH', 980);

/* ========================================================================
   Front end functionality and logic options
   ======================================================================== */

/* Set the global Excerpt length
   ======================================================================== */
define('LT3_EXCERPT_LENGTH', 40);

/* Set the global Excerpt More info
   ======================================================================== */
define('LT3_EXCERPT_MORE', 'more &rarr;');

/* Enable global comments
   ======================================================================== */
define('LT3_ENABLE_GLOBAL_COMMENTS', false);

/* Enable site search
   ======================================================================== */
define('LT3_ENABLE_SITE_SEARCH', true);

/* Show post meta data on pages
   ======================================================================== */
define('LT3_ENABLE_META_DATA', false);

/* Enabled sticky posts to be display on the front-page
   ======================================================================== */
define('LT3_ENABLE_STICKY_POSTS', false);

/* Number of pticky posts to show on the front-page
   ======================================================================== */
define('LT3_NUMBER_OF_STICKY_POSTS', 2);

/* ========================================================================
   Script and behaviour Ooptions
   ======================================================================== */

/* Enable Google jQuery libraries
   ======================================================================== */
define('LT3_LOAD_GOOGLE_JQUERY_LIBRARY', false);

/* Load Modernizr
   ======================================================================== */
define('LT3_LOAD_MODERNIZR_LIBRARY', false);

/* Determine the Modernizr version number
   ======================================================================== */
define('LT3_MODERNIZR_LIBRARY_VERSION', '2.6.2');

/* ========================================================================
   Theme and editor options
   ======================================================================== */

/* Enable extra TinyMCE buttons
   ======================================================================== */
define('LT3_ENABLE_EXTRA_TINYMCE_BUTTONS', false);

/* Use the custom-editor-style.css file for the TinyMCE
   ======================================================================== */
define('LT3_USE_CUSTOM_EDITOR_STYLES', false);

/* Enable admin option to change site background
   ======================================================================== */
define('LT3_ENABLE_CUSTOM_BACKGROUND', false);

/* Set custom background default color.
   ======================================================================== */
define('LT3_CUSTOM_BACKGROUND_DEFAULT_COLOR', 'f8f8f8');

/* Enable admin option to change site header image
   ======================================================================== */
define('LT3_ENABLE_CUSTOM_HEADER', false);

/* Set the text title colour | 222222
   ======================================================================== */
define('HEADER_TEXTCOLOR', '222222');

/* Set the width of the header image
   ======================================================================== */
define('HEADER_IMAGE_WIDTH',  LT3_PAGE_CONTENT_WIDTH);

/* Set the height of the header image
   ======================================================================== */
define('HEADER_IMAGE_HEIGHT', LT3_PAGE_CONTENT_WIDTH / 3);

/* Sets the default header image.
   ======================================================================== */
define('HEADER_IMAGE',
  trailingslashit(get_stylesheet_directory_uri())
  . '/library/images/header-banner.jpg'
);

/* Set to hide the text title from the front end
   ======================================================================== */
/**
 * Also set HEADER_TEXTCOLOR to ''
 * and * the h1 a span to 'display:none'
 */
define('NO_HEADER_TEXT', false);

/* ========================================================================
   Utility options
   ======================================================================== */

/* Enable template files debug mode
   ======================================================================== */
define('LT3_ENABLE_TEMPLATE_DEBUG', false);

/* Use the custom-login-style.css file for the Login screen
   ======================================================================== */
define('LT3_USE_CUSTOM_LOGIN_STYLES', false);

/* Enable admin tutorial section. true/ false
   ======================================================================== */
define('LT3_ENABLE_TUTORIAL_SECTION', false);

/* Disallow editing of theme and plugin files
   ======================================================================== */
define('DISALLOW_FILE_EDIT', true);

// End project configuration