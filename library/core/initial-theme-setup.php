<?php
/*

  Initial theme Setup

------------------------------------------------
  Version:   1.0
  Notes:
------------------------------------------------ */
add_action('after_setup_theme', 'lt3_initial_theme_setup');
function lt3_initial_theme_setup()
{
  if(get_option('theme_setup_status') !== '1')
  {
    $core_settings = array(
      'avatar_default'    => 'mystery',
      'avatar_rating'     => 'G',
      'default_role'      => 'author',
      'comments_per_page' => '20',
      'use_smilies'       => '0',
      'timezone_string'   => 'Australia/Sydney',
      'posts_per_page'    => '20',
      'large_size_h'      => LT3_PAGE_CONTENT_WIDTH,
      'large_size_w'      => LT3_PAGE_CONTENT_WIDTH * 1.25,
      'medium_size_h'     => LT3_PAGE_CONTENT_WIDTH / 2,
      'medium_size_w'     => LT3_PAGE_CONTENT_WIDTH,
      'thumbnail_crop'    => '1',
      'thumbnail_size_h'  => LT3_PAGE_CONTENT_WIDTH / 4,
      'thumbnail_size_w'  => LT3_PAGE_CONTENT_WIDTH / 4,
      'time_format'       => 'g:i a',
      'date_format'       => 'd/m/Y',
      'gzipcompression'   => '1',
      'blog_public'       => '0',
      'permalink_structure' => '/%postname%/'
    );
    foreach ($core_settings as $key => $value) {
      update_option( $key, $value );
    }
    wp_delete_post(1, true);
    wp_delete_post(2, true);
    wp_delete_comment(1);
    if (file_exists(WP_PLUGIN_DIR.'/hello.php')) {
      require_once(ABSPATH.'wp-admin/includes/plugin.php');
      require_once(ABSPATH.'wp-admin/includes/file.php');
      delete_plugins(array('hello.php'));
    }
    update_option( 'theme_setup_status', '1' );

  }
}