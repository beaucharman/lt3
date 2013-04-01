<?php
/*

  lt3 Site Settings

------------------------------------------------
  site-settings.php
  @version 2.0 | April 1st 2013
  @package lt3
  @author  Beau Charman | @beaucharman | http://beaucharman.me
  @link    https://github.com/beaucharman/lt3
  @licence GNU http://www.gnu.org/licenses/lgpl.txt

  Version: 1.0
  Notes:

  To use and view the option:
  global $lt3_site_settings;
  echo $lt3_site_settings['setting_id'])
------------------------------------------------ */

/*

  Declare the settings array

------------------------------------------------
All accept id & type
------------------------------------------------ */
$lt3_site_settings_array = array(
  array(
    'id'             => 'google_analytics',
    'type'           => 'text',
    'label'          => 'Google Analytics Code',
    'description'    => 'Define the Google Analytics tracking code for the site here.',
    'placeholder'    => 'UA-XXXXX-X'
  )
);

/* Initialise the settings page and
  set the $lt3_site_settings global variable.
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

        <?php settings_fields('lt3_site_settings'); global $lt3_site_settings_array, $lt3_site_settings; ?>

        <?php foreach($lt3_site_settings_array as $site_setting): ?>

        <tr>

          <?php if($site_setting['type'] == 'divider') :

          /* divider
          ------------------------------------------------
          Extra Parameters: content
          ------------------------------------------------ */ ?>

          <td class="divider" colspan="2"><?php echo $site_setting['label']; ?></td>

          <?php else: ?>

          <th>
             <label for="lt3_settings[<?php echo $site_setting['id']; ?>]">
                <?php echo $site_setting['label']; ?>
              </label>

          </th>
          <td>

            <?php switch($site_setting['type']) :

              /* text
              ------------------------------------------------
              Extra Parameters: label, placeholder, title, divider & description
              ------------------------------------------------ */
               case 'text': ?>

                <input id="lt3_settings[<?php echo $site_setting['id']; ?>]" name="lt3_settings[<?php echo $site_setting['id']; ?>]" type="text"  placeholder="<?php echo $site_setting['placeholder']; ?>" value="<?php echo $lt3_site_settings[$site_setting['id']]; ?>" size="50">

              <?php break;

              /* textarea
              ------------------------------------------------
              Extra Parameters: label, title, divider & description
              ------------------------------------------------ */
              case 'textarea': ?>

                <textarea id="lt3_settings[<?php echo $site_setting['id']; ?>]" name="lt3_settings[<?php echo $site_setting['id']; ?>]" cols="52" rows="4"><?php echo $lt3_site_settings[$site_setting['id']]; ?></textarea>

              <?php break;

              /* single_checkbox
              ------------------------------------------------
              Extra Parameters: label, title, divider & description
              ------------------------------------------------ */
              case 'single_checkbox': ?>

                <input type="checkbox" value="true" id="lt3_settings[<?php echo $site_setting['id']; ?>]" name="lt3_settings[<?php echo $site_setting['id']; ?>]"<?php if($lt3_site_settings[$site_setting['id']]) echo ' checked'; ?>>&nbsp;

              <?php break;

              /* multiple_checkboxes
              ------------------------------------------------
              Extra Parameters: label, title, divider, options & description
              ------------------------------------------------ */
              case 'multiple_checkboxes': ?>

                <ul>
                <?php foreach($site_setting['options'] as $key => $value): ?>
                  <li>
                    <input type="checkbox" value="<?= $key; ?>" id="lt3_settings[<?php echo $site_setting['id']; ?>]" name="lt3_settings[<?php echo $site_setting['id']; ?>]"<?php if($lt3_site_settings[$site_setting['id']]) echo ' checked'; ?>>&nbsp;<?= $value; ?>
                  </li>
                <?php endforeach;  ?>
                </ul>

              <?php break;

              /* post_type_select
              ------------------------------------------------
              Extra Parameters: label, title, divider & description
              ------------------------------------------------ */
              case 'post_type_select':

                $items = get_posts(array ('post_type' => $site_setting['post_type'], 'posts_per_page' => -1)); ?>

                <select name="lt3_settings[<?php echo $site_setting['id']; ?>]" id="lt3_settings[<?php echo $site_setting['id']; ?>]">
                  <option value="">Please choose&hellip;</option>
                  <?php foreach($items as $item): $is_select = ($item->ID == $lt3_site_settings[$site_setting['id']]) ? ' selected' : ''; ?>
                  <option id="lt3_settings[<?php echo $site_setting['id']; ?>]" name="lt3_settings[<?php echo $site_setting['id']; ?>]" value="<?php echo $item->ID; ?>"<?php echo $is_select; ?>><?php echo $item->post_title; ?></option>
                  <?php endforeach; ?>
                </select>

              <?php break; ?>

              <?php default: echo '<tr><td colspan="2"><span style="color: red;">Sorry, the type allocated for this input is not correct.</span></td></tr>'; break;?>

            <?php endswitch; ?>

            <p><span class="description"><?php echo $site_setting['description']; ?></span></p>

          </td>

          <?php endif; ?>

        </tr>

        <?php endforeach; ?>

      </table>

      <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>">
        <a href="./" class="button">Cancel</a>
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
  global $lt3_site_settings_array;

  foreach($lt3_site_settings_array as $site_setting)
  {
    $input[$site_setting['id']] =  wp_filter_nohtml_kses($input[$site_setting['id']]);
  }

  return $input;
}