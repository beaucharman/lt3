<?php
/*	
  
  lt3-theme Template Hooks
  
------------------------------------------------
	Version: 1.0
	Notes:

	All action and filter hook declarations and functions for the theme.

	To remove parnet hooks and filter, it is recomended to use an action tied to the init hook, for example:

	add_action('init', 'remove_parent_actions');
	function remove_parent_actions(){
		// remove_action functions
	}
------------------------------------------------ */

/* 

	Template Hook Declaration

------------------------------------------------ */
function lt3_hook($hook_name)
{
	do_action($hook_name);
}

/*

	Head Tag Action Hook Functions

------------------------------------------------ */

/* 

	Page Header Action Hook Functions

------------------------------------------------ */

/*

	Page Content Layout Action Hook Functions

------------------------------------------------ */

/*

	Page Content Tools Action Hook Functions

------------------------------------------------ */

/* 

	Page Footer Action Hook Functions

------------------------------------------------ */