<?php
/*	
  Name: lt3 Menus - Extra Functions
	Version: 1.0
	Notes:
	
	Extra functions, ideas and fallbacks for the menus.php file.

------------------------------------------------ */

/* Menu Descriotion Walker Function
------------------------------------------------
	Adds functionality for the placement of item descriptions under menu items.
	Add 'walker' => new lt3_description_walker() to the list of arguments in the wp_nav_menu declaration.
	If you are using a child theme, copy this function into the child's menu.php files, rename it, then call that new class.
------------------------------------------------ */
class Lt3_Description_Walker extends Walker_Nav_Menu 
{
	function start_el(&$output, $item, $depth, $args)
	{
		global $wp_query;
		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		$class_names = $value = '';

		$classes = empty($item->classes) ? array() : (array) $item->classes;

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
		$class_names = ' class="'. esc_attr($class_names) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes	= ! empty($item->attr_title) ? ' title="'	 . esc_attr($item->attr_title) .'"' : '';
		$attributes .= ! empty($item->target)		 ? ' target="' . esc_attr($item->target		) .'"' : '';
		$attributes .= ! empty($item->xfn)		   ? ' rel="'	 . esc_attr($item->xfn			) .'"' : '';
		$attributes .= ! empty($item->url)		   ? ' href="'	 . esc_attr($item->url		) .'"' : '';

		$prepend = '<strong>';
		$append = '</strong>';
		$description	 = ! empty($item->description) ? '<span>'.esc_attr($item->description).'</span>' : '';

		if($depth != 0)
		{
			$description = $append = $prepend = "";
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before .$prepend.apply_filters('the_title', $item->title, $item->ID).$append;
		$item_output .= $description.$args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}

/* Dropdown Menu Walker Function
------------------------------------------------
	Adds functionality to turn the selected menu into a dropdown control. 
	The menu and it's items will be contained in a <select> <option> tag.
------------------------------------------------ */
class Lt3_Dropdown_Menu_Walker extends Walker_Nav_Menu
{
	var $to_depth = -1;
  function start_lvl(&$output, $depth)
  {
    $indent = str_repeat("\t", $depth);
  }

  function end_lvl(&$output, $depth)
  {
    $indent = str_repeat("\t", $depth); 
  }

  function start_el(&$output, $item, $depth, $args)
  {
    $item->title = str_repeat("&nbsp;", $depth * 4).$item->title;
    parent::start_el(&$output, $item, $depth, $args);
    $output = str_replace('<li', '<option value="' . $item->url . '"', $output);
  }

  function end_el(&$output, $item, $depth)
  {
    $output .= "</option>\n"; 
  }
}