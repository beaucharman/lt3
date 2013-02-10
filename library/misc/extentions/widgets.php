<?php
/*	
  Name: lt3 Widgets - Extra Functions
	Version: 1.0
	Notes:
	
	Extra functions, ideas and fallbacks for the widgets.php file.

------------------------------------------------ */

/* Widget Classes Function
------------------------------------------------
  Adds an extra text input for adding extra classes to widgets
------------------------------------------------ */
add_filter('widget_form_callback', 'lt3_widget_form_extend_extra_classes', 10, 2);
function lt3_widget_form_extend_extra_classes($instance, $widget) 
{
	if (!isset($instance['classes'])) $instance['classes'] = null;
	$row = "<p>\n";
	$row .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-classes'>Additional Classes <small>(separate with spaces)</small></label>\n";
	$row .= "\t<input type='text' name='widget-{$widget->id_base}[{$widget->number}][classes]' id='widget-{$widget->id_base}-{$widget->number}-classes' class='widefat' value='{$instance['classes']}'>\n";
	$row .= "</p>\n";

	echo $row;
	return $instance;
}

add_filter('widget_update_callback', 'lt3_widget_update_extra_classes', 10, 2);
function lt3_widget_update_extra_classes($instance, $new_instance) 
{
	$instance['classes'] = $new_instance['classes'];
	return $instance;
}

add_filter('dynamic_sidebar_params', 'lt3_dynamic_sidebar_params_extra_classes');
function lt3_dynamic_sidebar_params_extra_classes($params) 
{
	global $wp_registered_widgets;
	$widget_id	= $params[0]['widget_id'];
	$widget_obj	= $wp_registered_widgets[$widget_id];
	$widget_opt	= get_option($widget_obj['callback'][0]->option_name);
	$widget_num	= $widget_obj['params'][0]['number'];

	if (isset($widget_opt[$widget_num]['classes']) && !empty($widget_opt[$widget_num]['classes']))
		$params[0]['before_widget'] = preg_replace('/class="/', "class=\"{$widget_opt[$widget_num]['classes']} ", $params[0]['before_widget'], 1);

	return $params;
}