<?php
/*

  lt3 Widgets

------------------------------------------------
	Version: 1.0
	Notes:

	For more widget areas, use:
		register_sidebar(array('name' => 'Sidebar Widget Name', 'id' => 'sidebar-widget-name', 'description' => __('These are widgets for the sidebar.','lt3')));

	For more info, and variations: http://codex.wordpress.org/Function_Reference/register_sidebar

	To use in a theme template, use:
		dynamic_sidebar('Sidebar Widget Name');

	To unregister a sidebar to clean up the widgets area, as an example use:
		add_action('widgets_init', 'remove_sidebar_function', 11);

	Then create a similar function to this:
		function remove_sidebar_function(){
		 	unregister_sidebar('sidebar-id');
		}
------------------------------------------------ */

/*

	Widget Areas

------------------------------------------------ */
add_action('widgets_init', 'lt3_register_initial_sidebars');
function lt3_register_initial_sidebars()
{

	/* Header Sidebar
	------------------------------------------------ */
	register_sidebar(array(
		'name' => __('Header Sidebar'),
		'id' => 'header-sidebar-widgets',
		'description' => __('These are widgets for the Header Sidebar.'),
		'before_widget' => '<aside class="widget header-sidebar-widget %2$s %1$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	));

	/* Primary Sidebar Widgets
	------------------------------------------------ */
  register_sidebar(array(
		'name' => __('Primary Sidebar Widgets'),
		'id' => 'primary-sidebar-widgets',
		'description' => __('These are widgets for the Primary Sidebar.'),
		'before_widget' => '<aside class="widget primary-sidebar-widget %2$s %1$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
  ));

	/* Footer Sidebar
	------------------------------------------------ */
	register_sidebar(array(
		'name' => __('Footer Sidebar'),
		'id' => 'footer-sidebar-widgets',
		'description' => __('These are widgets for the Footer Sidebar.'),
		'before_widget' => '<aside class="widget footer-sidebar-widget %2$s %1$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	));
}