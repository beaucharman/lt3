<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

/**
 * Set up server and deployment credentials
 */

/* Get the current server name */
$current_server_name = $_SERVER['SERVER_NAME'];

/* Set the production server Name */
$production_server_name = '';

/* Set the staging server Name */
$staging_server_name = '';

/* MySQL settings - You can get this info from your web host */
if (strpos($current_server_name, $production_server_name) !== false)
{
  /**
   * Production environment
   */

  /** The name of the database for WordPress */
  define('DB_NAME', '');

  /** MySQL database username */
  define('DB_USER', '');

  /** MySQL database password */
  define('DB_PASSWORD', '');

  /** MySQL hostname */
  define('DB_HOST', 'localhost');

  /**
   * Set WordPress debug mode, and script debug
   */
  define('WP_DEBUG', false);
  define('SCRIPT_DEBUG', false);
  
  /**
   * Set the environment
   */
  define('ENVIRONMENT_TYPE', 'production');

  /**
   * Set up paths
   */
  define('WP_HOME','');
  define('WP_SITEURL','');

}
elseif (strpos($current_server_name, $staging_server_name) !== false)
{
  /**
   * Staging environment
   */

  /** The name of the database for WordPress */
  define('DB_NAME', '');

  /** MySQL database username */
  define('DB_USER', '');

  /** MySQL database password */
  define('DB_PASSWORD', '');

  /** MySQL hostname */
  define('DB_HOST', 'localhost');

  /**
   * Set WordPress debug mode, and script debug
   */
  define('WP_DEBUG', false);
  define('SCRIPT_DEBUG', false);
  
  /**
   * Set the environment
   */
  define('ENVIRONMENT_TYPE', 'staging');

  /**
   * Set up paths
   */
  define('WP_HOME','http://');
  define('WP_SITEURL','http://');
}
else
{
  /**
   * Local development environment
   */

  /** The name of the database for WordPress */
  define('DB_NAME', '');

  /** MySQL database username */
  define('DB_USER', '');

  /** MySQL database password */
  define('DB_PASSWORD', '');

  /** MySQL hostname */
  define('DB_HOST', 'localhost');


  /**
   * Set WordPress debug mode, and script debug
   */
  define('WP_DEBUG', false);
  define('SCRIPT_DEBUG', false);
  
  /**
   * Set the environment
   */
  define('ENVIRONMENT_TYPE', 'development');

  /**
   * Set up paths
   */
  define('WP_HOME','http://');
  define('WP_SITEURL','http://');
}

/* End of server and deployment credentials */

/**
 * Set revisions amount
 */
define('WP_POST_REVISIONS', 2);

/**
 * Take out the trash
 */
define('EMPTY_TRASH_DAYS', 2);

/**
 * Disallow administration plugin and template editing
 */
define('DISALLOW_FILE_EDIT', true);

/**
 * Database Charset to use in creating database tables.
 */
define('DB_CHARSET', 'utf8');

/**
 * The Database Collate type. Don't change this if in doubt.
 */
define('DB_COLLATE', '');

/**
 * Increase the WP Memory Limit is needed
 */
// define('WP_MEMORY_LIMIT', '64M');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * This is set in deployment environments
 */

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
