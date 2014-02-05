<?php



class Samurai_Route
{

	function __construct()
	{

		add_action('send_headers', array(&$this, 'get'));

	}

	function get() {

		global $route, $wp_query, $window_title;

		$bits = explode("/", $_SERVER['REQUEST_URI']);
		$route->class = $bits[1];
		$route->method = $bits[2];
		$route->prop1 = $bits[3];
		$route->prop2 = $bits[4];
		$route->prop3 = $bits[5];
		$route->prop4 = $bits[6];

		if ($wp_query->is_404)
		{
			$wp_query->is_404 = false;
			include(get_template_directory() . path_to_classes . $route->class . ".php" );
			// replace path_to_classes with the actual directory where you keep your class files
			//
			/* at the end of your classfile include, you can create the object as $myObject = new Class */

			$myObject->$route->method($route->prop1); // after calling the method, you can set a property in the object for the template
			$template = locate_template($myObject->template);
			$window_title = $myObject->window_title;

			if ($template)
			{
				load_template($template);
				die;
			}
		}

	}

	public static function get_view($base = '', $modifier = '') {

		get_template_part(SAMURAI_VIEWS_PATH . '/' .  Samurai_Helper::urify_words($base), Samurai_Helper::urify_words($modifier));

	}

}

new Samurai_Route;