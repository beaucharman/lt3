<?php
/*

  Initial theme Setup

------------------------------------------------
  Version:   1.0
  Notes:

  http://codex.wordpress.org/Plugin_API/Action_Reference/after_setup_theme
------------------------------------------------ */
add_action('after_setup_theme', 'lt3_initial_theme_setup');
function lt3_initial_theme_setup()
{
  /* Only need to run this once */
  if(get_option('theme_setup_status') !== '1')
  {
    /* Set the WordPress options the way you like */
    $core_settings = array(
      'avatar_default'      => 'mystery',
      'avatar_rating'       => 'G',
      'blog_public'         => '0',
      'comments_per_page'   => '20',
      'date_format'         => 'd/m/Y',
      'default_role'        => 'author',
      'gzipcompression'     => '1',
      'large_size_h'        => LT3_PAGE_CONTENT_WIDTH,
      'large_size_w'        => LT3_PAGE_CONTENT_WIDTH * 1.25,
      'medium_size_h'       => LT3_PAGE_CONTENT_WIDTH / 2,
      'medium_size_w'       => LT3_PAGE_CONTENT_WIDTH,
      'permalink_structure' => '/%postname%/',
      'posts_per_page'      => '20',
      'thumbnail_crop'      => '1',
      'thumbnail_size_h'    => LT3_PAGE_CONTENT_WIDTH / 4,
      'thumbnail_size_w'    => LT3_PAGE_CONTENT_WIDTH / 4,
      'time_format'         => 'g:i a',
      'timezone_string'     => 'Australia/Sydney',
      'use_smilies'         => '0'
    );
    foreach ($core_settings as $key => $value) {
      update_option( $key, $value );
    }

    /* Delete the example post, page and comment */
    wp_delete_post(1, true);
    wp_delete_post(2, true);
    wp_delete_comment(1);
    if (file_exists(WP_PLUGIN_DIR.'/hello.php')) {
      require_once(ABSPATH.'wp-admin/includes/plugin.php');
      require_once(ABSPATH.'wp-admin/includes/file.php');
      delete_plugins(array('hello.php'));
    }
    /* Update the status so this dosn't run again */
    update_option( 'theme_setup_status', '1' );

    /* Consider post formats */
    add_theme_support( 'post-formats', array( 'aside' ) );

    /* Lets let the admin know whats going on. */
    $msg = '
    <div class="error">
      <p>The ' . get_option( 'current_theme' ) . 'theme has changed your WordPress default <a href="' . admin_url( 'options-general.php' ) . '" title="See Settings">settings</a> and deleted default posts & comments.</p>
    </div>';
    add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );
  }

  /* Else if we are re-activing the theme */
  elseif ( $the_theme_status === '1' and isset( $_GET['activated'] ) ) {
    $msg = '
    <div class="updated">
      <p>The ' . get_option( 'current_theme' ) . ' theme was successfully re-activated.</p>
    </div>';
    add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );
  }
}