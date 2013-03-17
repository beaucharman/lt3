<?php
/*

  lt3 JavaScripts

------------------------------------------------
	Version: 1.0
	Notes:

	To include scripts correctly, use the wp_register_script, and wp_enqueue_script functions:
	http://codex.wordpress.org/Function_Reference/wp_register_script
	http://codex.wordpress.org/Function_Reference/wp_enqueue_script

	Use wp_deregister_script to unregister an unneeded or troublesome script:
	http://codex.wordpress.org/Function_Reference/wp_deregister_script
------------------------------------------------ */

/*

	Enqeue scripts from Google

------------------------------------------------ */
if(LT3_LOAD_GOOGLE_JQUERY_LIBRARY)
{
	add_action('wp_enqueue_scripts', 'lt3_load_script_libraries');
	function lt3_load_script_libraries()
	{
		if(!is_admin())
		{
			wp_deregister_script('jquery');
			wp_register_script('jquery',
		    'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js',
			  false,
			  '1',
			  true
		  );
		  wp_enqueue_script('jquery');
		}
	}
}

/*

	Register and Enqeue local scripts

------------------------------------------------ */
add_action('wp_enqueue_scripts', 'lt3_load_scripts');
function lt3_load_scripts()
{

	/* Register scripts here:
	------------------------------------------------ */
	wp_register_script('lt3_modernizr', LT3_FULL_SCRIPTS_PATH .'/vendors/modernizr.'. LT3_MODERNIZR_LIBRARY_VERSION .'.js', false, LT3_MODERNIZR_LIBRARY_VERSION, false);
	wp_register_script('lt3_main', LT3_FULL_SCRIPTS_PATH .'/main.js', array(), '1.0', true);
	wp_register_script('lt3_shortcodes', LT3_FULL_SCRIPTS_PATH .'/shortcode.js', array(), '1.0', true);

	/* Enqueue scripts here:
	------------------------------------------------ */
	if(!is_admin())
	{
		if(is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply');
		if(LT3_LOAD_MODERNIZR_LIBRARY) wp_enqueue_script('lt3_modernizr');
		wp_enqueue_script('lt3_main');
		// wp_enqueue_script('lt3_shortcodes'); uncomment if using shortcodes that require this script
	}
}