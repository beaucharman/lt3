<?php
/*

  lt3 Admin Functions

------------------------------------------------
	Version: 1.0
	Notes:

	This files contains the functions and file references that are used to alter and enhance the general administration area.

	The admin files which the admin function file refers to can be found in the library/admin/ directory
------------------------------------------------ */

/*

	Dashboard and login functions

------------------------------------------------*/

/* Customise footer
------------------------------------------------ */
add_filter('admin_footer_text', 'lt3_replace_admin_footer');
function lt3_replace_admin_footer()
{
	if(function_exists('lt3_get_data_with_curl')) $admin_footer = lt3_get_data_with_curl(LT3_FULL_DASHBOARD_PATH . '/admin.footer.php');
	return $admin_footer;
}

/* Add custom widgets to admin dashboard
------------------------------------------------ */
add_action('wp_dashboard_setup', 'lt3_custom_dashboard_widgets');
function lt3_custom_dashboard_widgets()
{
	global $wp_meta_boxes;
	wp_add_dashboard_widget('custom_admin_widget', 'Website Information', 'lt3_create_website_support_widget_function');
}

function lt3_create_website_support_widget_function()
{
	if(function_exists('lt3_get_data_with_curl')) $admin_widget = lt3_get_data_with_curl(LT3_FULL_DASHBOARD_PATH . '/admin.widget.php');
	echo $admin_widget;
}

/* Create Tutorial Pages
------------------------------------------------ */
if(LT3_ENABLE_TUTORIAL_SECTION)
{
  add_action('admin_menu', 'lt3_create_tutorial_menu');
	function lt3_create_tutorial_menu()
	{
		add_menu_page('User Guide', 'User Guide', 'manage_options', 'user-guide', 'lt3_user_guide');
		function lt3_user_guide()
		{
			$admin_file = (function_exists('lt3_get_data_with_curl')) ? lt3_get_data_with_curl(get_template_directory_uri() . '/library/admin/admin.user-guide.php') : 'Sorry, could not find the file.';
			echo $admin_file;
		}
	}
}

/* Remove Widgets from Admin
------------------------------------------------ */
function lt3_remove_dashboard_widgets()
{
	remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
	remove_meta_box('yoast_db_widget', 'dashboard', 'side');
	remove_meta_box('dashboardb_xavisys', 'dashboard', 'normal');
	remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
	remove_meta_box('bbp-dashboard-right-now', 'dashboard', 'normal');
	remove_meta_box('dashboard_primary', 'dashboard', 'side');
	remove_meta_box('dashboard_secondary', 'dashboard', 'side');
}
add_action('wp_dashboard_setup', 'lt3_remove_dashboard_widgets');

/* Add Custom Post Types to right now
------------------------------------------------ */
add_action('right_now_content_table_end' , 'lt3_add_custom_post_type_to_right_now');
function lt3_add_custom_post_type_to_right_now()
{
	$args = array('public' => true, '_builtin' => false);
	$output = 'object';
	$operator = 'and';
	$post_types = get_post_types($args , $output , $operator);
	foreach($post_types as $post_type)
	{
		$num_posts = wp_count_posts($post_type->name);
		$num = number_format_i18n($num_posts->publish);
		$text = _n($post_type->labels->singular_name, $post_type->labels->name , intval($num_posts->publish));
		if(current_user_can('edit_posts'))
		{
			$num = "<a href='edit.php?post_type=$post_type->name'>$num</a>";
			$text = "<a href='edit.php?post_type=$post_type->name'>$text</a>";
		}
		echo '<tr><td class="first b b-' . $post_type->name . '">' . $num . '</td>';
		echo '<td class="t ' . $post_type->name . '">' . $text . '</td></tr>';
	}
	$taxonomies = get_taxonomies($args , $output , $operator);
	foreach($taxonomies as $taxonomy)
	{
		$num_terms	= wp_count_terms($taxonomy->name);
		$num = number_format_i18n($num_terms);
		$text = _n($taxonomy->labels->singular_name, $taxonomy->labels->name , intval($num_terms));
		if(current_user_can('manage_categories'))
		{
			$num = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$num</a>";
			$text = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$text</a>";
		}
		echo '<tr><td class="first b b-' . $taxonomy->name . '">' . $num . '</td>';
		echo '<td class="t ' . $taxonomy->name . '">' . $text . '</td></tr>';
	}
}

/*

	Theme customisation settings

------------------------------------------------*/

/* Enable custom backgrounds
------------------------------------------------ */
if(LT3_ENABLE_CUSTOM_BACKGROUND)
{
	$defaults = array(
		'default-color'          => LT3_CUSTOM_BACKGROUND_DEFAULT_COLOR,
		'default-image'          => get_template_directory_uri() . '/library/images/background.jpg',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	);
	add_theme_support( 'custom-background', $defaults );
}

/* Enable custom headers
------------------------------------------------ */
if(LT3_ENABLE_CUSTOM_HEADER)
{
	/* Include the header image in the admin preview. */
	add_custom_image_header('lt3_header_style', 'lt3_admin_header_style');
	function lt3_admin_header_style()
	{ ?>
		<style type="text/css">
			#headimg {
				width: <?= HEADER_IMAGE_WIDTH; ?>px;
				height: <?= HEADER_IMAGE_HEIGHT; ?>px;
				background: no-repeat;
			}
		</style>
	<?php }

	/* Include the header image in the template. */
	function lt3_header_style()
	{ ?>
		<style type="text/css">
			.page-header { background:url(<?php header_image(); ?>) no-repeat; }
			.page-header h1 a { color:#<?php header_textcolor(); ?>; }
			<?php if(get_header_textcolor() == 'blank')
			{ ?>
				.page-header h1 a span { text-indent:-9999px; white-space: nowrap; }
				.page-header .site-description	{ text-indent:-9999px; white-space: nowrap; }
			<?php }
			else
			{ ?>
				.page-header .site-description	{ color:#<?php header_textcolor(); ?>; }
			<?php } ?>
			<?php if(NO_HEADER_TEXT)
			{ ?>
				.page-header h1 a span { text-indent:-9999px; white-space: nowrap; display:none; }
				.page-header .site-description	{ text-indent:-9999px; white-space: nowrap; }
			<?php } ?>

		</style>
	<?php }
}

/*

	User related functions

------------------------------------------------*/

/* Add custom user fields
------------------------------------------------ */
function lt3_custom_userfields($contactmethods)
{
	/* Set user info fields */
	$contactmethods['contact_twitter'] = 'Twitter';
	$contactmethods['contact_linkedin'] = 'LinkedIn';
	$contactmethods['contact_phone_office'] = 'Work Phone Number';
	$contactmethods['contact_phone_mobile']	= 'Mobile Phone Number';
	/* Unset user info fields */
	unset($contactmethods['aim']);
	unset($contactmethods['jabber']);
	unset($contactmethods['yim']);
	return $contactmethods;
}
add_filter('user_contactmethods','lt3_custom_userfields',10,1);

/*

	Security measures

------------------------------------------------*/

/* Add no follow meta tag to admin
------------------------------------------------ */
add_action('admin_head', 'lt3_add_admin_meta_tags');
function lt3_add_admin_meta_tags()
{
	if(is_admin()) : ?>
		<meta name="robots" content="noindex, nofollow">
	<?php endif;
}

/* Remove WP Version
------------------------------------------------ */
remove_action('wp_head', 'wp_generator');

/* Obscure login screen error messages
------------------------------------------------ */
add_filter('login_errors', 'lt3_alternate_login_error_message');
function lt3_alternate_login_error_message()
{
	return '<strong>Sorry</strong>, it seems that <strong>username</strong> and <strong>password</strong> combination is incorrect!';
}