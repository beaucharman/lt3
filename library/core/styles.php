<?php
/*	
  
  lt3-theme Styles
  
------------------------------------------------
	Version: 1.0
	Notes:

	To include styles correctly, use the wp_register_style, and wp_enqueue_style functions:
	http://codex.wordpress.org/Function_Reference/wp_register_style
	http://codex.wordpress.org/Function_Reference/wp_enqueue_style

	Use wp_deregister_style to unregister an unneeded or troublesome style.
	http://codex.wordpress.org/Function_Reference/wp_deregister_style
------------------------------------------------ */

/* 

  Register and Enqeue local styles

------------------------------------------------ */
function lt3_load_styles()
{

	/* Register styles here:
	------------------------------------------------ */
	wp_register_style('lt3_custom_admin_styles', LT3_FULL_STYLES_PATH .'/custom-admin-styles.css');

	/* Enqueue styles here:
	------------------------------------------------ */
	if(!is_admin())
	{
  	//Theme styles here
	} 
	elseif(is_admin())
	{
  	wp_enqueue_style('lt3_custom_admin_styles');
	}
}
add_action('init', 'lt3_load_styles');

/*

	Styles the visual editor with custom-editor-style.css to match the theme style.

------------------------------------------------ */
if(LT3_USE_CUSTOM_EDITOR_STYLES) add_editor_style(LT3_STYLES_PATH .'/custom-editor-style.css');