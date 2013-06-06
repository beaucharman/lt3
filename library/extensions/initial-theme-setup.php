<?php
/**
 * Initial Theme Setup
 * ========================================================================
 * initial-theme-setup.php
 * @version    2.1 | 6th June 2013
 * @package    WordPress
 * @subpackage lt3
 * @author     Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link       https://github.com/beaucharman/lt3
 * @license    MIT license
 *
 * For more information:
 * http://codex.wordpress.org/Plugin_API/Action_Reference/after_setup_theme
 * ======================================================================== */
add_action('after_setup_theme', 'lt3_initial_theme_setup');
function lt3_initial_theme_setup()
{
  /* Only need to run this once */
  if (get_option('theme_setup_status') !== '1')
  {
    /* Set the WordPress options the way you like */
    $core_settings = array(
      'avatar_default'    => 'mystery',
      'avatar_rating'     => 'G',
      'blog_public'       => '0',
      'blogdescription'   => '',
      'comments_per_page' => '20',
      'date_format'       => 'd/m/Y',
      'default_role'      => 'author',
      'large_size_h'      => LT3_PAGE_CONTENT_WIDTH / 2,
      'large_size_w'      => LT3_PAGE_CONTENT_WIDTH,
      'medium_size_h'     => LT3_PAGE_CONTENT_WIDTH / 3,
      'medium_size_w'     => LT3_PAGE_CONTENT_WIDTH / 2,
      'posts_per_page'    => '20',
      'thumbnail_crop'    => '1',
      'thumbnail_size_h'  => LT3_PAGE_CONTENT_WIDTH / 4,
      'thumbnail_size_w'  => LT3_PAGE_CONTENT_WIDTH / 4,
      'time_format'       => 'g:i a',
      'timezone_string'   => 'Australia/Sydney',
      'use_smilies'       => '0'
    );

    foreach ($core_settings as $key => $value)
    {
      update_option($key, $value);
    }

    /* Add RSS links to <head> section */
    add_theme_support('automatic-feed-links');

    /**
     * Delete the example post, page and comment
     * ========================================================================
     * Set the booleans to false if this is not a fresh
     * install, true will delete the post and pages for realz
     */
    wp_delete_post(1, true);
    wp_delete_post(2, true);
    wp_delete_comment(1);

    /**
     * Goodbye Dolly
     * ========================================================================
     * feel free to add Akismet to this block of code
     */
    if (file_exists(WP_PLUGIN_DIR.'/hello.php'))
    {
      require_once(ABSPATH . 'wp-admin/includes/plugin.php');
      require_once(ABSPATH . 'wp-admin/includes/file.php');
      delete_plugins(array('hello.php'));
    }

    /* Update the status so this dosn't run again */
    update_option('theme_setup_status', '1');

    /* Lets let the admin know whats going on with a status message */
    $msg = '<div class="updated">'
      . '<p>The ' . get_option('current_theme') . ' theme has changed your WordPress default'
      . '<a href="'. admin_url('options-general.php') . '" title="See Settings">settings</a>,'
      . 'discouraged search engines and deleted default posts & comments.</p></div>';
    add_action('admin_notices', $c = create_function('', 'echo "'. addcslashes($msg, '"') . '";'));
  }
}
