<?php if(!defined('ABSPATH')) exit;
/*	
  
  lt3 Functions and Theme Setup
  
------------------------------------------------
  Version: 1
  Notes:
------------------------------------------------ */

/* 

  Development Mode

------------------------------------------------ */

/* Set the site mode for conditional statements. TRUE for development, FALSE for production mode.
------------------------------------------------ */
define('LT3_DEVELOPMENT_MODE', TRUE);

/* 

  Front End Layout and Design Options

------------------------------------------------ */

/* Set full page wrap width (including padding)
------------------------------------------------ */
define('LT3_PAGE_WRAP_WIDTH', 980);

/* Set full page content width (not including padding)
------------------------------------------------ */
define('LT3_PAGE_CONTENT_WIDTH', 980);

/*

  Front End Functionality and Logic Options

------------------------------------------------ */

/* Set the global Excerpt length
------------------------------------------------ */
define('LT3_EXCERPT_LENGTH', 40);

/* Set the global Excerpt More info
------------------------------------------------ */
define('LT3_EXCERPT_MORE', 'more &rarr;');

/* Enable global comments
------------------------------------------------ */
define('LT3_ENABLE_GLOBAL_COMMENTS', TRUE);

/* Enable site search
------------------------------------------------ */
define('LT3_ENABLE_SITE_SEARCH', TRUE);

/* Show Page and Post Meta Data on pages
------------------------------------------------ */
define('LT3_ENABLE_META_DATA', TRUE);

/* Enabled Sticky posts  to be display on the Home Page
------------------------------------------------ */
define('LT3_ENABLE_STICKY_POSTS', TRUE);

/* Number of Sticky Posts to show on the Home Page
------------------------------------------------ */
define('LT3_NUMBER_OF_STICKY_POSTS', 2);

/* 

  Script and Behaviour Options

------------------------------------------------ */

/* Enable Google jQuery libraries
------------------------------------------------ */
define('LT3_LOAD_GOOGLE_JQUERY_LIBRARY', TRUE);

/* Load Modernizr
------------------------------------------------ */
define('LT3_LOAD_MODERNIZR_LIBRARY', TRUE);

/* Determine the Google jQuery library version number
------------------------------------------------ */
define('LT3_GOOGLE_JQUERY_LIBRARY_VERSION', '1.8.1');

/* Determine the Modernizr version number
------------------------------------------------ */
define('LT3_MODERNIZR_LIBRARY_VERSION', '2.6.2');

/*

  Administration Options

------------------------------------------------ */

/* Set the text title colour
------------------------------------------------ 
Also Set LT3_ENABLE_CUSTOM_BACKGROUNDS to TRUE
------------------------------------------------ */
define('HEADER_TEXTCOLOR', '222222');

/* Set the width of the header image
------------------------------------------------ */
define('HEADER_IMAGE_WIDTH',  980);

/* Set the height of the header image
------------------------------------------------ */
define('HEADER_IMAGE_HEIGHT', 220);

/* Sets the default header image. 
------------------------------------------------ 
Set LT3_ENABLE_CUSTOM_BACKGROUNDS to TRUE
------------------------------------------------ */
define('HEADER_IMAGE', 
  trailingslashit(get_stylesheet_directory_uri())
  .'/library/images/header-banner.jpg'
);

/* Set to hide the text title from the front end
------------------------------------------------ 
Also set HEADER_TEXTCOLOR to '' and the h1 a span 
to 'display:none', Set LT3_ENABLE_CUSTOM_BACKGROUNDS to TRUE
------------------------------------------------ */
define('NO_HEADER_TEXT', FALSE);

/* Enable admin option to change site header image
------------------------------------------------ */
define('LT3_ENABLE_CUSTOM_HEADER', FALSE);

/* Enable admin option to change site background
------------------------------------------------ */
define('LT3_ENABLE_CUSTOM_BACKGROUNDS', FALSE);

/* Enable extra TinyMCE buttons
------------------------------------------------ */
define('LT3_ENABLE_EXTRA_TINYMCE_BUTTONS', TRUE);

/*

  Utility Options

------------------------------------------------ */

/* Enable template files debug mode
------------------------------------------------ */
define('LT3_ENABLE_TEMPLATE_DEBUG', TRUE);

/* Use the custom-editor-style.css file for the TinyMCE
------------------------------------------------ */
define('LT3_USE_CUSTOM_EDITOR_STYLES', TRUE);

/* Use the custom-login-style.css file for the Login screen
------------------------------------------------ */
define('LT3_USE_CUSTOM_LOGIN_STYLES', FALSE);

/* Enable admin tutorial section. TRUE/ FALSE
------------------------------------------------ */
define('LT3_ENABLE_TUTORIAL_SECTION', FALSE);

/* 

  Required Constants

------------------------------------------------ */
define('LT3_FULL_CORE_PATH', get_template_directory() . '/library/core');

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

  Required Core Files

------------------------------------------------ */

/* Site Settings
------------------------------------------------ */
require_once(LT3_FULL_CORE_PATH . '/site-settings.php');

/* Admin Functions
------------------------------------------------ */
require_once(LT3_FULL_CORE_PATH . '/admin-functions.php');

/* Template Functions
------------------------------------------------ */
require_once(LT3_FULL_CORE_PATH . '/template-functions.php');

/* Custom Post Types
------------------------------------------------ */
require_once(LT3_FULL_CORE_PATH . '/custom-post-types.php');

/* Custom Meta Box
------------------------------------------------ */
require_once(LT3_FULL_CORE_PATH . '/custom-meta-fields.php');

/* Loop Functions
------------------------------------------------ */
require_once(LT3_FULL_CORE_PATH . '/loop-functions.php');

/* Template Hooks
------------------------------------------------ */
require_once(LT3_FULL_CORE_PATH . '/template-hooks.php');

/* Theme Widgets
------------------------------------------------ */
require_once(LT3_FULL_CORE_PATH . '/widgets.php');

/* Theme Menus
------------------------------------------------ */
require_once(LT3_FULL_CORE_PATH . '/menus.php');

/* Shortcodes
------------------------------------------------ */
require_once(LT3_FULL_CORE_PATH . '/shortcodes.php');

/* Theme Scripts
------------------------------------------------ */
require_once(LT3_FULL_CORE_PATH . '/scripts.php');

/* Theme Styles
------------------------------------------------ */
require_once(LT3_FULL_CORE_PATH . '/styles.php');

/* 

  Project Extensions

------------------------------------------------ */
// call any project specific files here.