<?php
/*

  lt3 Editor Functions

------------------------------------------------
	Version: 1.0
	Notes:   All functionality that effects the
					 admin are post editor
------------------------------------------------ */

/* Add excerpt field to pages
------------------------------------------------ */
add_action('init', 'lt3_add_page_excerpts');
function lt3_add_page_excerpts()
{
	add_post_type_support('page', 'excerpt');
}

/* Add PDFs to the media type filter for posts
------------------------------------------------ */
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

/* Add more buttons to the TinyMCE editor
------------------------------------------------ */
if(LT3_ENABLE_EXTRA_TINYMCE_BUTTONS){

  add_filter('mce_buttons','edit_buttons_for_tinymce_editor_1');
	function edit_buttons_for_tinymce_editor_1($mce_buttons)
	{
		$pos = array_search('wp_more',$mce_buttons,true);
		if($pos !== false)
		{
			$tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
			$tmp_buttons[] = 'wp_page';
			$mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
		}
		$pos = array_search('justifyright',$mce_buttons,true);
		if($pos !== false)
		{
			$tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
			$tmp_buttons[] = 'justifyfull';
			$mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
		}
		$pos = array_search('italic',$mce_buttons,true);
		if($pos !== false)
		{
			$tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
			$tmp_buttons[] = 'underline';
			$mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
		}
		$pos = array_search('unlink',$mce_buttons,true);
		if($pos !== false)
		{
			$tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
			$tmp_buttons[] = 'separator';
			$tmp_buttons[] = 'hr';
			$mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
		}
		return $mce_buttons;
	}

	add_filter('mce_buttons_2','edit_buttons_for_tinymce_editor_2');
	function edit_buttons_for_tinymce_editor_2($mce_buttons)
	{
		$pos = array_search('forecolor',$mce_buttons,true);
		if($pos !== false)
		{
			$tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
			$tmp_buttons[] = 'backcolor';
			$mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
		}
		$pos = array_search('formatselect',$mce_buttons,true);
		if($pos !== false)
		{
			$tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
			$tmp_buttons[] = 'separator';
			$mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
		}
		$pos = array_search('charmap',$mce_buttons,true);
		if($pos !== false)
		{
			$tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
			$tmp_buttons[] = 'sub';
			$tmp_buttons[] = 'sup';
			$mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
		}
		$pos = array_search('pasteword',$mce_buttons,true);
		if($pos !== false)
		{
			$tmp_buttons = array_slice($mce_buttons, 0, $pos-1);
			$tmp_buttons[] = 'cut';
			$tmp_buttons[] = 'copy';
			$tmp_buttons[] = 'paste';
			$mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos-1));
		}
		return $mce_buttons;
	}
}