<?php
/*

  lt3-theme Site Settings
  
------------------------------------------------
	Version: 1.0
	Notes:

	To use and view the option:
  global $lt3_site_settings;
  echo $lt3_site_settings['setting_id'])
------------------------------------------------ */

/* Declare the settings array
------------------------------------------------
All accept id & tpye
------------------------------------------------ */
$site_settings = array(
  array(
    'id'             => 'google_analytics',
    'type'           => 'text',
    'label'          => 'Google Analytics Code',
    'description'    => 'Define the Google Analytics tracking code for the site here.',
    'placeholder'    => 'UA-XXXXX-X'
  )
);

/* Initialise the settings page
------------------------------------------------ */
add_action('admin_init', 'lt3_site_settings_init');
add_action('admin_menu', 'lt3_site_settings_add_page');
$lt3_site_settings = get_option('lt3_settings');

/* Register the LT3 site settings:
------------------------------------------------ */
function lt3_site_settings_init()
{
	register_setting('lt3_site_settings', 'lt3_settings', 'lt3_site_settings_validate');
}

/* Hook the options page with the required settings:
------------------------------------------------ */
function lt3_site_settings_add_page() 
{
	add_theme_page(get_bloginfo('name') . ' Site Settings', 'Site Settings', 'manage_options', 'lt3_site_settings', 'lt3_site_settings_do_page');
}

/* Render the settings page:
------------------------------------------------ */
function lt3_site_settings_do_page() 
{
	/* Check that the user is allowed to update options */
	if (!current_user_can('manage_options')) 
	{
    wp_die('You do not have sufficient permissions to access this page.');
	} ?>

	<div class="wrap">

		<?php if($_GET['settings-updated']): ?>
		<div id="message" class="updated fade"><p><?php bloginfo('name'); ?> Site Settings Updated.</p></div>
		<?php endif; ?>

		<?php screen_icon('themes'); ?> <h2><?php bloginfo('name'); ?> Site Settings</h2>

		<form method="post" action="options.php">

			<table class="form-table lt3-form-container">

  		<?php settings_fields('lt3_site_settings'); global $site_settings, $lt3_site_settings; ?>

      <?php foreach($site_settings as $site_setting): ?>
      
          <tr>
            	<th>
            	   <label for="lt3_settings[<?php echo $site_setting['id']; ?>]"><?php echo $site_setting['label']; ?></label>
            	   <span class="description"><?php echo $site_setting['description']; ?></span>
            	</th>

      	<?php switch($site_setting['type']) :

        	/* Divider
        	------------------------------------------------
        	Extra Parameters: content
        	------------------------------------------------ */
        	 case 'divider': ?>

        	   <td colspan="2"><?php echo $site_setting['content']; ?></td>

          <?php break;

        	/* Text Input
        	------------------------------------------------
        	Extra Parameters: label, placeholder, title, divider & description
        	------------------------------------------------ */
        	 case 'text': ?>
              <td>
                <input id="lt3_settings[<?php echo $site_setting['id']; ?>]" name="lt3_settings[<?php echo $site_setting['id']; ?>]" type="text"  placeholder="<?php echo $site_setting['placeholder']; ?>" value="<?php echo $lt3_site_settings[$site_setting['id']]; ?>" size="50">
              </td>
          <?php break;

          /* Textarea Input
          ------------------------------------------------
          Extra Parameters: label, title, divider & description
        	------------------------------------------------ */
        	case 'textarea': ?>
              <td>
                <textarea id="lt3_settings[<?php echo $site_setting['id']; ?>]" name="lt3_settings[<?php echo $site_setting['id']; ?>]" cols="52" rows="4"><?php echo $lt3_site_settings[$site_setting['id']]; ?></textarea>
              </td>
          <?php break;

          /* Single Checkbox Input
          ------------------------------------------------
          Extra Parameters: label, title, divider & description
          ------------------------------------------------ */
          case 'single_checkbox': ?>
              <td>
                <input type="checkbox" id="lt3_settings[<?php echo $site_setting['id']; ?>]" name="lt3_settings[<?php echo $site_setting['id']; ?>]"<?php if($lt3_site_settings[$site_setting['id']]) echo ' checked'; ?>>&nbsp;
              </td>
				  <?php break;

  				/* Post Type Drop Down
          ------------------------------------------------
          Extra Parameters: label, title, divider & description
          ------------------------------------------------ */
          case 'post_type_select':
            $items = get_posts(array ('post_type' => $site_setting['post_type'], 'posts_per_page' => -1)); ?>
              <td>
                <select name="lt3_settings[<?php echo $site_setting['id']; ?>]" id="lt3_settings[<?php echo $site_setting['id']; ?>]">
                  <option value="">Please choose&hellip;</option>
                  <?php foreach($items as $item): $is_select = ($item->ID == $lt3_site_settings[$site_setting['id']]) ? ' selected' : ''; ?>
                  <option id="lt3_settings[<?php echo $site_setting['id']; ?>]" name="lt3_settings[<?php echo $site_setting['id']; ?>]" value="<?php echo $item->ID; ?>"<?php echo $is_select; ?>><?php echo $item->post_title; ?></option>
                  <?php endforeach; ?>
                </select>
              </td>
            

				  <?php break; ?>

				  <?php default: echo '<tr><td colspan="2"><span style="color: red;">Sorry, the type allocated for this input is not correct.</span></td></tr>'; break;?>

        <?php endswitch; ?>
        
        </tr>

		  <?php endforeach; ?>

		  </table>

		  <p class="submit">
			  <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>">
			</p>

		</form>

	</div>

<?php }

/* Sanitize and validate input. Accepts an array, return a sanitized array.
------------------------------------------------ */
function lt3_site_settings_validate($input) 
{

	/* List the settings to be saved here:
	------------------------------------------------ */
	global $site_settings;

	foreach($site_settings as $site_setting)
	{
	  $input[$site_setting['id']] =  wp_filter_nohtml_kses($input[$site_setting['id']]);
  }

	return $input;
}
