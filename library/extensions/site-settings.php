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

  To use and view the option:
  global $lt3_site_settings;
  echo $lt3_site_settings['setting_id'])
------------------------------------------------ */

class LT3_Site_Settings
{
  public $_settings_group;
  public $_settings_name;
  public $_settings_fields;
  public $_settings_menu_name;
  public $_settings_title;
  public $_site_settings;

  /* Class constructor
  ------------------------------------------------
    __construct()
    @param  $_site_settings | array
    @return void
  ------------------------------------------------ */
  public function __construct($settings_group, $settings_name, $settings_fields, $settings_menu_name, $settings_title)
  {
    $this->_settings_fields_group  = $this->uglify_words($settings_group);
    $this->_settings_fields_name   = $this->uglify_words($settings_name);
    $this->_settings_fields_fields = $settings_fields;
    $this->_settings_menu_name     = ($settings_menu_name) ? $settings_menu_name : prettify_words($this->_settings_fields_group);
    $this->_settings_title         = ($settings_title) ? $settings_title : get_bloginfo('name') . prettify_words($this->_settings_fields_group);
    $this->_site_settings          = get_option($this->_settings_fields_name);

    /* Initialise the settings page and
      set the $lt3_site_settings global variable.
    ------------------------------------------------ */
    add_action('admin_init', array(&$this, 'site_settings_init'));
    add_action('admin_menu', array(&$this, 'site_settings_add_page'));
  }

  /* Register the LT3 site settings:
  ------------------------------------------------ */
  public function site_settings_init()
  {
    register_setting('lt3_site_settings', 'lt3_settings', array(&$this, 'site_settings_validate'));
  }

  /* Hook the options page with the required settings:
  ------------------------------------------------ */
  public function site_settings_add_page()
  {
    add_theme_page(get_bloginfo('name') . ' Site Settings', 'Site Settings', 'manage_options', 'lt3_site_settings', array(&$this, 'site_settings_render_page'));
  }

  /* Render the settings page:
  ------------------------------------------------ */
  function site_settings_render_page()
  {
    /* Check that the user is allowed to update options */
    if (!current_user_can('manage_options'))
    {
      wp_die('You do not have sufficient permissions to access this page.');
    }

    echo '<div class="wrap">';

    if(isset($_GET['settings-updated']))
    {
      echo '<div id="message" class="updated fade"><p>'. get_bloginfo('name') .' Site Settings Updated.</p></div>';
    }

    /* Show the page settings title */
    screen_icon('themes'); echo '<h2>'. get_bloginfo('name') .' Site Settings</h2>';

    echo '<form method="post" action="options.php">';
    echo '<table class="form-table lt3-form-container">';

    settings_fields('lt3_site_settings');

    foreach($this->_settings_fields as $field)
    {

      /* Get the value for the current setting */
      $value = (isset($this->_site_settings[$field['id']])) ? $this->_site_settings[$field['id']] : '';

      /* Get the label for the current setting */
      $label = (isset($field['label'])) ? $field['label'] : $this->prettify_words($field['id']);

      /* and get the id also */
      $id = $field['id'];

      echo '<tr>';

      if($field['type'] == 'divider')
      {

        /* divider
        ------------------------------------------------
        @param $label | string
        ------------------------------------------------ */
        echo '<td class="divider" colspan="2">'. $field['label'] .'</td>';
      }

      echo '<th>';
      echo '  <label for="lt3_settings[<?php echo $id; ?>]">'. $label .'</label>';
      echo '</th>';

      echo '<td>';

      switch($field['type'])
      {

        /* text
        ------------------------------------------------
        Extra Parameters: label, placeholder, title, divider & description
        ------------------------------------------------ */
        case 'text':
          echo '<input id="lt3_settings['. $field['id'] .']" name="lt3_settings['. $field['id'] .']" type="text"  placeholder="'. $field['placeholder'] .'" value="'. $value .'" size="50">';
          break;

        /* textarea
        ------------------------------------------------
        Extra Parameters: label, title, divider & description
        ------------------------------------------------ */
        case 'textarea':
          echo '<textarea id="lt3_settings['. $field['id'] .']" name="lt3_settings['. $field['id'] .']" cols="52" rows="4">'. $value .'</textarea>';
          break;

        /* checkbox
        ------------------------------------------------
        Extra Parameters: label, title, divider & description
        ------------------------------------------------ */
        case 'checkbox':
          echo '<input type="checkbox" value="true" id="lt3_settings['. $field['id'] .']" name="lt3_settings['. $field['id'] .']"', $value ? ' checked' : '', '>';
        break;

        /* multiple_checkboxes
        ------------------------------------------------
        Extra Parameters: label, title, divider, options & description
        ------------------------------------------------ */
        case 'multiple_checkboxes':
          echo '<ul>';
          foreach($field['options'] as $key => $value)
          {
            echo '<li>';
            echo '<input type="checkbox" value="'. $key .'" id="lt3_settings['. $field['id'] .']" name="lt3_settings['. $field['id'] .']"', $value ? ' checked' : '', '>';
            echo '&nbsp;<label for"lt3_settings['. $field['id'] .']">'. $value . '</label>';
            echo '</li>';
          }
          echo '</ul>';
          break;

        /* post_type_select
        ------------------------------------------------
        Extra Parameters: label, title, divider & description
        ------------------------------------------------ */
        case 'post_type_select':

          $items = get_posts(array ('post_type' => $field['post_type'], 'posts_per_page' => -1));
          echo '<select name="lt3_settings['. $field['id'] .']" id="lt3_settings['. $field['id'] .']">';
          echo '<option value="">Select&hellip;</option>';
          foreach($items as $item)
          {
            $is_select = ($item->ID == $value) ? ' selected' : '';
            echo '  <option id="lt3_settings['. $field['id'] .']" name="lt3_settings['. $field['id'] .']" value="'. $item->ID .'"'.  $is_select .'>'. $item->post_title .'</option>';
          }
          echo '</select>';
          break;

        default:
          echo '<tr><td colspan="2"><span style="color: red;">Sorry, the type allocated for this input is not correct.</span></td></tr>';
          break;

      } // end switch

      /* Render the setting description if possible */
      if(isset($field['description']))
      {
        echo '<p><span class="description">'. $field['description'] .'</span></p>';
      }
      echo '</td>';

    echo '</tr>';

    } // end foreach

    echo '</table>';

    echo '<p class="submit">';
    echo '  <input type="submit" class="button-primary" value="Save Changes">';
    echo '  <a href="./" class="button">Cancel</a>';
    echo '</p>';

    echo '</form>';

    echo '</div>';

  }

  /* Sanitize and validate input. Accepts an array, return a sanitized array.
  ------------------------------------------------ */
  public function site_settings_validate($input)
  {

    /* List the settings to be saved here:
    ------------------------------------------------ */
    foreach($this->_settings_fields as $field)
    {
      $input[$field['id']] =  wp_filter_nohtml_kses($input[$field['id']]);
    }

    return $input;
  }

   /* Prettify words
  ------------------------------------------------
    prettify_words()
    @param  $words | string
    @return string
    Creates a pretty version of a string, like
    a pug version of a dog.
  ------------------------------------------------ */
  public function prettify_words($words)
  {
    return ucwords(str_replace('_', ' ', $words));
  }

  /* Uglify words
  ------------------------------------------------
    uglify_words()
    @param  $words | string
    @return string
    creates a url firendly version of the given string.
  ------------------------------------------------ */
  public function uglify_words($words)
  {
    return strToLower(str_replace(' ', '_', $words));
  }
}