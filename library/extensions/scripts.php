<?php
/**
 * Scripts
 * ------------------------------------------------------------------------
 * scripts.php
 * @version 2.0 | April 1st 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license GNU http://www.gnu.org/licenses/lgpl.txt
 *
 * To include scripts correctly, use the wp_register_script, and wp_enqueue_script functions:
 * http://codex.wordpress.org/Function_Reference/wp_register_script
 * http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 *
 * Use wp_deregister_script to unregister an unneeded or troublesome script:
 * http://codex.wordpress.org/Function_Reference/wp_deregister_script
 * ------------------------------------------------------------------------ */

/* Enqeue scripts from Google
   ------------------------------------------------------------------------ */
if(LT3_LOAD_GOOGLE_JQUERY_LIBRARY)
{
	add_action('wp_enqueue_scripts', 'lt3_load_google_jquery');
	function lt3_load_google_jquery()
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

/* Register and Enqeue local scripts
   ------------------------------------------------------------------------ */
add_action('wp_enqueue_scripts', 'lt3_load_scripts');
function lt3_load_scripts()
{

	/* Register scripts here */
	wp_register_script('lt3_modernizr',
		LT3_FULL_SCRIPTS_PATH .'/vendors/modernizr.'. LT3_MODERNIZR_LIBRARY_VERSION .'.js',
		false,
		LT3_MODERNIZR_LIBRARY_VERSION,
		false
	);
	wp_register_script('lt3_plugins', LT3_FULL_SCRIPTS_PATH .'/plugins.js', array(), '1.0', true);
	wp_register_script('lt3_main', LT3_FULL_SCRIPTS_PATH .'/main.js', array(), '1.0', true);

	/* Enqueue scripts here */
	if(!is_admin())
	{
		if(is_singular() && get_option('thread_comments') && LT3_ENABLE_GLOBAL_COMMENTS)
		{
			wp_enqueue_script('comment-reply');
		}

		if(LT3_LOAD_MODERNIZR_LIBRARY)
		{
			wp_enqueue_script('lt3_modernizr');
		}

		/**
		 * Load in separate scripts for development,
		 * change this to a concatenated file for deployment
		 */
		if(LT3_DEVELOPMENT_MODE)
		{
			wp_enqueue_script('lt3_plugins');
			// Enqueue other theme template scripts here
		}

		wp_enqueue_script('lt3_main');
	}
}