<?php
/*

  lt3 Shortcodes

------------------------------------------------
	Version: 1.0
	Notes:

	function register_shortcode_shortcode_name($atts, $content = null){
		extract(shortcode_atts(array(
			'variable_name' => 'default_value',
		), $atts));
		return // somthing using $atts and or $content, use $variable_name and $content ;
	}
	add_shortcode('shortcode_name', 'register_shortcode_shortcode_name');

	Example:
	function register_shortcode_hello($atts, $content = null){
		extract(shortcode_atts(array(
			'color' => 'black',
		), $atts));
		return '<div style="color:' . $color . ';">Hello ' . $content . '</div>';
	}
	add_shortcode('hello', 'register_shortcode_hello');

	To use in editor:
	[hello color="red"]World[/hello]

	To use in theme template:
	echo do_shortcode('[hello color="red"]World[/hello]');

	Both will output:
	<div style="color:red;">World</div>

	More information http://codex.wordpress.org/Shortcode_API

------------------------------------------------ */

/*

	[lt3_home_url]

------------------------------------------------ */
add_shortcode('lt3_home_url', 'lt3_register_shortcode_home_url');
function lt3_register_shortcode_home_url($atts, $content = null)
{
	return home_url();
}

/*

	[lt3_base_media_url]

------------------------------------------------ */
add_shortcode('lt3_base_media_url', 'lt3_register_shortcode_base_media_url');
function lt3_register_shortcode_base_media_url($atts, $content = null)
{
	$uploads = wp_upload_dir();
	return $uploads['baseurl'];
}

/*

	[lt3_full_media_url]

------------------------------------------------ */
add_shortcode('lt3_full_media_url', 'lt3_register_shortcode_full_media_url');
function lt3_register_shortcode_full_media_url($atts, $content = null)
{
	$uploads = wp_upload_dir();
	return $uploads['url'];
}

/*

	[lt3_parent_theme_url]

------------------------------------------------ */
add_shortcode('lt3_parent_theme_url', 'lt3_register_shortcode_parent_theme_url');
function lt3_register_shortcode_parent_theme_url($atts, $content = null)
{
	return get_template_directory_uri();
}

/*

	[lt3_child_theme_url]

------------------------------------------------ */
add_shortcode('lt3_child_theme_url', 'lt3_register_shortcode_child_theme_url');
function lt3_register_shortcode_child_theme_url($atts, $content = null)
{
	return get_stylesheet_directory_uri();
}

/*

	[lt3_replace_with_content]

------------------------------------------------ */
add_shortcode('lt3_replace_with_content', 'lt3_register_shortcode_replace_with_content');
function lt3_register_shortcode_replace_with_content($atts, $content = null)
{
	$return_string = '<p>Content coming soon&hellip;</p>';
	if(is_user_logged_in())
	{
		$return_string .= '<p>We see that you are logged in, <a title="Log in" href="'. get_edit_post_link() .	'">why not add some content now?</a></p>';
	}
	return $return_string;
}

/*

	[lt3_clear]

------------------------------------------------ */
add_shortcode('lt3_clear', 'lt3_register_shortcode_clear');
function lt3_register_shortcode_clear($atts, $content = null)
{
  return '<div style="clear:both;">&nbsp;</div>';
}

/*

	[lt3_divider class=""]

------------------------------------------------ */
add_shortcode('lt3_divider', 'lt3_register_shortcode_divider');
function lt3_register_shortcode_divider($atts, $content = null)
{
	extract(shortcode_atts(array(
		'class' => ''
 	), $atts));

	return '<hr class="divider '. $class .'">';
}

/*

	[lt3_float_right]content[/lt3_float_right]

------------------------------------------------ */
add_shortcode('lt3_float_right', 'lt3_register_shortcode_float_right');
function lt3_register_shortcode_float_right($atts, $content = null)
{
	return '<div style="float:right;">'. do_shortcode($content) .'</div>';
}

/*

	[lt3_float_left]content[/lt3_float_left]

------------------------------------------------ */
add_shortcode('lt3_float_left', 'lt3_register_shortcode_float_left');
function lt3_register_shortcode_float_left($atts, $content = null)
{
	return '<div style="float:left;">'. do_shortcode($content) .'</div>';
}

/*

	[lt3_button class=""]content[/lt3_button]

------------------------------------------------ */
add_shortcode('lt3_button', 'lt3_register_shortcode_button');
function lt3_register_shortcode_button($atts, $content = null)
{
	extract(shortcode_atts(array(
		'class' => ''
 	), $atts));

	$content = '<button class="'. $class .'">' . $content	. '</button>';
	return $content;
}

/*

	[lt3_link class="" rel=""]content[/lt3_link]

------------------------------------------------ */
add_shortcode('lt3_link', 'lt3_register_shortcode_link');
function lt3_register_shortcode_link($atts, $content = null)
{
	extract(shortcode_atts(array(
		'class' => '',
		'rel' => 'external'
 	), $atts));

	$content = str_replace('<a', '<a class="link-'. $rel .' '. $class .'" rel="'. $rel .'" ', $content);
	return $content;
}

/*

	[lt3_toggle_content class="" title=""]content[/lt3_toggle_content]

------------------------------------------------ */
add_shortcode('lt3_toggle_content', 'lt3_register_shortcode_toggle_content');
function lt3_register_shortcode_toggle_content($atts, $content = null)
{
	extract(shortcode_atts(array(
		'class' => '',
		'title' => 'Toggle'
 	), $atts));

	return '<dl class="toggle-container '. $class .'">'."\n"
	.'<dt class="toggle-handle"><a href="javascript: void(0)">'. $title .'</a></dt>' ."\n"
	.'<dd class="toggle-content">'. do_shortcode($content) .'</dd>'."\n"
	.'</dl>';
}

/*

	[lt3_tabbed_content class=""]content[/lt3_tabbed_content]

------------------------------------------------ */
add_shortcode('lt3_tabbed_content', 'lt3_register_shortcode_tabbed_content');
function lt3_register_shortcode_tabbed_content($atts, $content = null)
{
	extract(shortcode_atts(array(
		'class' => ''
	), $atts));

	$GLOBALS['tab_count'] = 0;
	do_shortcode($content);
	if(is_array($GLOBALS['tabs']))
	{
		foreach($GLOBALS['tabs'] as $tab)
		{
			$tabs[] = '<li><a href="javascript: void(0)">'.$tab['title'].'</a></li>';
			$panes[] = '<div class="pane"><h3>'.$tab['title'].'</h3><p>'.$tab['content'].'</p></div>';
		}
		$return = '<section class="tabbed-content-container '. $class .'">'
		."\n".'<ul class="tabs">'.implode("\n", $tabs).'</ul>'
		."\n".'<div class="panes">'.implode("\n", $panes).'</div>'."\n"
		.'</section>'."\n";
	}
	return do_shortcode($return);
}

/*

	[lt3_tab class="" title=""]content[/lt3_tab]

------------------------------------------------ */
add_shortcode('lt3_tab', 'lt3_register_shortcode_tab');
function lt3_register_shortcode_tab($atts, $content = null)
{
	extract(shortcode_atts(array(
		'title' => 'Tab %d'
	), $atts));

	$tab_count = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$tab_count] = array('title' => sprintf($title, $GLOBALS['tab_count']), 'content' =>  $content);
	$GLOBALS['tab_count']++;
}

/*

	[lt3_section class=""]content[/lt3_section]

------------------------------------------------ */
add_shortcode('lt3_section', 'lt3_register_shortcode_section');
function lt3_register_shortcode_section($atts, $content = null)
{
	extract(shortcode_atts(array(
		'class' => ''
 	), $atts));

	return '<section class="section '. $class .'">'. do_shortcode($content) .'</section>';
}

/*

	[lt3_dynamic_sidebar sidebar_id="id"]

------------------------------------------------ */
add_shortcode('lt3_dynamic_sidebar', 'lt3_register_shortcode_dynamic_sidebar');
if(!function_exists('lt3_get_dynamic_sidebar'))
{
	function lt3_get_dynamic_sidebar($index = 1)
	{
		$sidebar_contents = "";
		ob_start();
		dynamic_sidebar($index);
		$sidebar_contents = ob_get_clean();
		return $sidebar_contents;
	}
}
function lt3_register_shortcode_dynamic_sidebar($atts, $content = null)
{
	extract(shortcode_atts(array(
		'sidebar_id' => ''
 	), $atts));

	return lt3_get_dynamic_sidebar($sidebar_id);
}

/*

	[lt3_get_template_part_content primary_part="" secondary_part=""]

------------------------------------------------ */
add_shortcode('lt3_get_template_part_content', 'lt3_register_shortcode_get_template_part_content');
function lt3_get_template_part_content($template_part_primary, $template_part_secondary)
{
	$template_part_content = "";
	ob_start();
	get_template_part(LT3_TEMPLATE_PARTS_PATH . '/' . $template_part_primary, $template_part_secondary);
	$template_part_content = ob_get_clean();
	wp_reset_query();
	return $template_part_content;
}

function lt3_register_shortcode_get_template_part_content($atts, $content = null)
{
 		extract(shortcode_atts(array(
		  'primary_part' => 'loop' ,
		  'secondary_part' => 'sticky'
 		), $atts));

 		return lt3_get_template_part_content($primary_part, $secondary_part);
}

/*

	[lt3_hidden_content private_message="" public_message=""]content[/lt3_hidden_content]

------------------------------------------------ */
add_shortcode("lt3_hidden_content", "lt3_register_shortcode_hidden_content");
function lt3_register_shortcode_hidden_content($atts, $content = null)
{
	extract(shortcode_atts(array(
		'private_message' => '',
		'public_message'  => '',
		'login_request'   => false
	), $atts));

	$return_string = '';
	if(!is_user_logged_in())
	{
	  if($public_message)
	  {
		  $return_string .= '<p class="warning message public hidden-content">'. $public_message .'</p>'. "\n";
		}
		$return_string .= '<p>THIS: <a href="'. wp_login_url(get_permalink()).' ?>" title="Login">Login</a></p>';
	}
	else
	{
		if($private_message)
		{
			$return_string .= '<p class="success message private hidden-content">'. $private_message .'</p>'. "\n";
		}
	    $return_string .= $content;
	}
	return do_shortcode($return_string);
}

/*

	[lt3_raw]content[/lt3_raw] Remove formatting from around Shorcodes in the editor

------------------------------------------------ */
add_shortcode('lt3_raw', 'lt3_register_shortcode_shortcode_raw');
function lt3_register_shortcode_shortcode_raw($atts, $content = null)
{
	$content = trim(do_shortcode(shortcode_unautop($content)));

	/* Remove '' from the start of the string. */
	if (substr($content, 0, 4) == '')
    	$content = substr($content, 4);

	/* Remove '' from the end of the string. */
	if (substr($content, -3, 3) == '')
    	$content = substr($content, 0, -3);

	/* Remove any instances of ''. */
	$content = str_replace(array('<p>', '</p>', '<br />','<br>'), '', $content);

	return $content;
}

/*

	[lt3_iframe class="" scrolling="auto|yes|no" width="%|px|int" height="%|px|int" ]src[/lt3_iframe]

------------------------------------------------ */
add_shortcode('lt3_iframe', 'lt3_register_shortcode_iframe');
function lt3_register_shortcode_iframe($atts, $content = null)
{
	extract(shortcode_atts(array(
		'class' => '',
		'fallback' => 'Sorry, you require a
			<a href="http://browsehappy.com" target="_blank"
			title="Click here to update you browser" browser that supports</a>
			iframes to view this content',
		'height' => '400',
		'scrolling' => 'auto',
		'width' => '100%'
	), $atts));

	return '<iframe src="'. $content
	.'" class="iframe '. $class
	.'" scrolling="'. $scrolling
	.'" width="'. $width
	.'" height="'. $height
	.'">'. $fallback
	.'</iframe>';
}

/*

	[lt3_google_map width="%|px|int" height="%|px|int" class="" ]src[/lt3_google_map]

------------------------------------------------ */
add_shortcode("lt3_google_map", "lt3_register_shortcode_google_map");
function lt3_register_shortcode_google_map($atts, $content = null)
{
	extract(shortcode_atts(array(
		'width' => '100%',
    'height' => '430',
    'fallback' => 'Sorry, you require a
			<a href="http://browsehappy.com" target="_blank"
			title="Click here to update you browser">browser that supports
			iframes</a> to view this content',
    'class' => ''
 	), $atts));

	return '<iframe width="'. $width
	.'" height="'. $height
	.'" class="google-map '. $class
	.'" frameborder="0"'
	.' scrolling="no"'
	.' src="'. $content
	.'&amp;output=embed">'
	. $fallback
	.'</iframe>';
}

/*

	[lt3_youtube id="" width="%|px|int" height="%|px|int" class="" name="" hd="1|0" rel="1|0" controls="1|0" showinfo="1|0"]

------------------------------------------------
  Accepts the actual YouTube clip id or the http://youtu.be/xxx link

  Todo:
  Implement 	allowFullScreen="true|false"
	            allowScriptAccess="always|never"
------------------------------------------------ */
add_shortcode('lt3_youtube', 'lt3_register_shortcode_youtube');
function lt3_register_shortcode_youtube($atts, $content = null)
{
	extract(shortcode_atts(array(
		'id'       => '',
		'width'    => '100%',
		'height'   => '430',
		'name'     => 'movie',
		'controls' => '1',
		'hd'       => '1',
		'rel'      => '1',
		'class'    => '',
		'fallback' => 'Sorry, you require a
			<a href="http://browsehappy.com" target="_blank"
			title="Click here to update you browser">browser that supports
			iframes</a> to view this content',
		'showinfo' =>'1'
	), $atts));

	$id = str_replace('http://youtu.be/', '', $id);
	return '<iframe src="http://www.youtube.com/embed/'. $id
 		.'?wmode=transparent'
 		.'&rel='. $rel
		.'&HD='. $hd
 		.'&showinfo='. $showinfo
 		.'&controls='. $controls
 		.'&name='. $name
 		.'" wmode="transparent"'
 		.' width="'. $width
 		.'" height="'. $height
 		.'" class="youtube '. $class
 		.'">'
 		. $fallback
 		.'</iframe>';
}

/*

	[lt3_follow_on_twitter username="username"]

------------------------------------------------ */
add_shortcode('lt3_follow_on_twitter', 'lt3_register_shortcode_follow_on_twitter');
function lt3_register_shortcode_follow_on_twitter($atts, $content = '')
{
	extract(shortcode_atts(array('username' => get_bloginfo('name')), $atts));
	$twitter_follow_content = '<a href="https://twitter.com/'. $username .'" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @'. $username .'</a>';
	$twitter_follow_content .= '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.';
	$twitter_follow_content .= 'src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
	return $twitter_follow_content;
}

/*

	Column Shortcode [lt3_fraction] / [lt3_fraction_last]

------------------------------------------------ */
add_shortcode('lt3_one_half', 'lt3_register_shortcode_one_half_column');
function lt3_register_shortcode_one_half_column($atts, $content = null)
{
	return '<div class="article-column one-half">'. do_shortcode($content) .'</div>';
}

add_shortcode('lt3_one_third', 'lt3_register_shortcode_one_third_column');
function lt3_register_shortcode_one_third_column($atts, $content = null)
{
	return '<div class="article-column one-third">'. do_shortcode($content) .'</div>';
}

add_shortcode('lt3_two_thirds', 'lt3_register_shortcode_two_thirds_column');
function lt3_register_shortcode_two_thirds_column($atts, $content = null)
{
	return '<div class="article-column two-thirds">'. do_shortcode($content) .'</div>';
}

add_shortcode('lt3_one_fourth', 'lt3_register_shortcode_one_fourth_column');
function lt3_register_shortcode_one_fourth_column($atts, $content = null)
{
	return '<div class="article-column one-fourth">'. do_shortcode($content) .'</div>';
}

add_shortcode('lt3_one_half_last', 'lt3_register_shortcode_one_half_last_column');
function lt3_register_shortcode_one_half_last_column($atts, $content = null)
{
	return '<div class="article-column one-half last-column">'. do_shortcode($content) .'</div>';
}

add_shortcode('lt3_one_third_last', 'lt3_register_shortcode_one_third_last_column');
function lt3_register_shortcode_one_third_last_column($atts, $content = null)
{
	return '<div class="article-column one-third last-column">'. do_shortcode($content) .'</div>';
}

add_shortcode('lt3_two_thirds_last', 'lt3_register_shortcode_two_thirds_last_column');
function lt3_register_shortcode_two_thirds_last_column($atts, $content = null)
{
	return '<div class="article-column two-thirds last-column">'. do_shortcode($content) .'</div>';
}

add_shortcode('lt3_one_fourth_last', 'lt3_register_shortcode_one_fourth_last_column');
function lt3_register_shortcode_one_fourth_last_column($atts, $content = null)
{
	return '<div class="article-column one-fourth last-column">'. do_shortcode($content) .'</div>';
}