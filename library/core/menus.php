<?php
/*

  lt3-theme Menus

------------------------------------------------
	Version: 1.0
	Notes:

	For more menu locations, use:

		register_nav_menu('menu_name_location', 'Description of Navigation Menu');

	For more info: http://codex.wordpress.org/Function_Reference/register_nav_menus

	To use in a theme template, use:

		wp_nav_menu(array('menu' => 'Menu Name'));

	For more info, and variations: http://codex.wordpress.org/Function_Reference/wp_nav_menu

------------------------------------------------ */

/*

	Menu Locations

------------------------------------------------ */
if(function_exists('register_nav_menu')){

	/* Main Navigation Menu
	------------------------------------------------ */
	register_nav_menu('main_navigation_menu', 'Main Navigation Menu');

	/* Footer Menu
	------------------------------------------------ */
	register_nav_menu('footer_menu', 'Footer Menu');
}

/*

	Menu Declarations

------------------------------------------------ */

/* Main Navigation Menu
------------------------------------------------ */
function lt3_page_header_menu()
{
	wp_nav_menu(
		array(
			'theme_location' 	=> 'main_navigation_menu',
			'container' 		  => 'nav',
			'container_class'	=> 'main-navigation',
			'fallback_cb' 		=> false,
			'menu_class' 		  => 'menu'
		)
	);
}

/* Footer Menu
------------------------------------------------ */
function lt3_page_footer_menu()
{
	wp_nav_menu(
		array(
			'theme_location' 	 => 'footer_menu',
			'container' 		   => 'nav',
			'container_class ' => 'footer-navigation',
			'fallback_cb' 	   => false,
			'menu_class' 		   => 'menu'
		)
	);
}