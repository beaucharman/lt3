<?php
/**
 * Editor
 * ========================================================================
 * editor.php
 * @version    2.1 | 6th June 2013
 * @package    WordPress
 * @subpackage lt3
 * @author     Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link       https://github.com/beaucharman/lt3
 * @license    MIT license
 *
 * All extra functionality that effects the admin and post editor.
 * ======================================================================== */

/**
 * Modify Post Mine Types
 * ========================================================================
 * lt3_modify_post_mime_types()
 * post_mime_types filter to add PDFs to the media type filter for posts
 * ======================================================================== */
add_filter('post_mime_types', 'lt3_modify_post_mime_types');
function lt3_modify_post_mime_types($post_mime_types)
{
  $post_mime_types['application/pdf'] = array(
    __('PDFs'),
    __('Manage PDFs'),
    _n_noop('PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>')
  );
  return $post_mime_types;
}

/**
 * Enable Extra TinyMCE Buttons and Style Select
 * ========================================================================
 * various filters to add more buttons to the TinyMCE editor
 * and a select style drop down
 * ======================================================================== */
if (LT3_ENABLE_EXTRA_TINYMCE_BUTTONS)
{

  /* Level 1 buttons
     ======================================================================== */
  add_filter('mce_buttons','edit_buttons_for_tinymce_editor_1');
  function edit_buttons_for_tinymce_editor_1($mce_buttons)
  {
    $pos = array_search('wp_more',$mce_buttons,true);
    if ($pos !== false)
    {
      $tmp_buttons = array_slice($mce_buttons, 0, $pos + 1);
      $tmp_buttons[] = 'wp_page';
      $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos + 1));
    }
    $pos = array_search('justifyright',$mce_buttons,true);
    if ($pos !== false)
    {
      $tmp_buttons = array_slice($mce_buttons, 0, $pos + 1);
      $tmp_buttons[] = 'justifyfull';
      $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos + 1));
    }
    $pos = array_search('italic',$mce_buttons,true);
    if ($pos !== false)
    {
      $tmp_buttons = array_slice($mce_buttons, 0, $pos + 1);
      $tmp_buttons[] = 'underline';
      $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos + 1));
    }
    $pos = array_search('unlink',$mce_buttons,true);
    if ($pos !== false)
    {
      $tmp_buttons = array_slice($mce_buttons, 0, $pos + 1);
      $tmp_buttons[] = 'separator';
      $tmp_buttons[] = 'hr';
      $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos + 1));
    }
    return $mce_buttons;
  }

  /* Level 2 buttons
     ======================================================================== */
  add_filter('mce_buttons_2','edit_buttons_for_tinymce_editor_2');
  function edit_buttons_for_tinymce_editor_2($mce_buttons)
  {
    $pos = array_search('forecolor',$mce_buttons,true);
    if ($pos !== false)
    {
      $tmp_buttons = array_slice($mce_buttons, 0, $pos + 1);
      $tmp_buttons[] = 'backcolor';
      $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos + 1));
    }
    $pos = array_search('formatselect',$mce_buttons,true);
    if ($pos !== false)
    {
      $tmp_buttons = array_slice($mce_buttons, 0, $pos + 1);
      $tmp_buttons[] = 'separator';
      $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos + 1));
    }
    $pos = array_search('charmap',$mce_buttons,true);
    if ($pos !== false)
    {
      $tmp_buttons = array_slice($mce_buttons, 0, $pos + 1);
      $tmp_buttons[] = 'sub';
      $tmp_buttons[] = 'sup';
      $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos + 1));
    }
    $pos = array_search('pasteword',$mce_buttons,true);
    if ($pos !== false)
    {
      $tmp_buttons = array_slice($mce_buttons, 0, $pos-1);
      $tmp_buttons[] = 'cut';
      $tmp_buttons[] = 'copy';
      $tmp_buttons[] = 'paste';
      $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos-1));
    }
    return $mce_buttons;
  }

  /* Adds style select to the TinyMCE Editor
     ======================================================================== */
  add_filter('mce_buttons_2', 'lt3_mce_styleselect_editor_buttons');
  function lt3_mce_styleselect_editor_buttons($buttons)
  {
    array_unshift($buttons, 'styleselect');
    return $buttons;
  }

  /* Allocate styles for the TinyMCE Editor style select
     ======================================================================== */
  add_filter('tiny_mce_before_init', 'lt3_mce_styleselect_editor_settings');
  function lt3_mce_styleselect_editor_settings($settings)
  {
    if (! empty($settings['theme_advanced_styles']))
    {
      $settings['theme_advanced_styles'] .= ';';
    }
    else
    {
      $settings['theme_advanced_styles'] = '';
    }

    $classes = array(
      __('Lead')       => 'lead',
      __('Disclaimer') => 'disclaimer',
      __('Warning')    => 'warning',
      __('Notice')     => 'notice',
      __('Muted')      => 'muted'
    );

    $class_settings = '';
    foreach ($classes as $name => $value )
    {
      $class_settings .= "{$name}={$value};";
    }

    $settings['theme_advanced_styles'] .= trim($class_settings, '; ');
    return $settings;
  }
}
