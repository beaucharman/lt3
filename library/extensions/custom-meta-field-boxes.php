<?php
/*

  lt3 Custom Meta Field Boxes

------------------------------------------------
  custom-meta-field-boxes.php
  @version 2.0 | April 1st 2013
  @package lt3
  @author  Beau Charman | @beaucharman | http://beaucharman.me
  @link    https://github.com/beaucharman/lt3
  @licence GNU http://www.gnu.org/licenses/lgpl.txt

  This file is for the custom meta fields for posts, pages, and custom post types.

  Simply add a new array to the $lt3_custom_meta_fields_array variable.
  Use the following as your key and value pairs:

  array(
    'id'              => '',
    'title'           => '',
    'post_type'       => '', // 'post', 'page', 'link', 'attachment' a custom post type slug, or array
    'context'         => '', // 'normal', 'advanced', or 'side'
    'priority'        => '', // 'high', 'core', 'default' or 'low'
    'fields'          => array(
      array(
        'type'        => '',
        'id'          => '',
        'label'       => ''
      )
    )
  )
------------------------------------------------ */

/*

    Delcare the meta boxes

------------------------------------------------
Field: All require the following parameters: type, id & label
------------------------------------------------ */
$lt3_custom_meta_fields_array = array();
/*

  Create each custom meta field box instance

------------------------------------------------ */
add_action('load-post.php', 'lt3_create_meta_boxes');
function lt3_create_meta_boxes()
{
  global $lt3_custom_meta_fields_array;
  foreach($lt3_custom_meta_fields_array as $cmfb)
  {
    new Custom_Field_Meta_Box($cmfb);
  }
}

/*

  Class structure for a custom meta field box

------------------------------------------------ */
class Custom_Field_Meta_Box
{
  protected $_cmfb;
  function __construct($cmfb)
  {
    $this->_cmfb = $cmfb;
    add_action('add_meta_boxes', array( &$this, 'lt3_add_custom_meta_field_box'));
    add_action('save_post', array( &$this, 'lt3_save_data'));
  }

  /* Add the Meta Box
  ------------------------------------------------ */
  function lt3_add_custom_meta_field_box()
  {
    add_meta_box(
      ($this->_cmfb['id'])        ? $this->_cmfb['id']        : 'custom_meta_field_box',
      ($this->_cmfb['title'])     ? $this->_cmfb['title']     : 'Custom Meta Field Box',
      array( &$this, 'lt3_show_custom_meta_field_box'),
      ($this->_cmfb['post_type']) ? $this->_cmfb['post_type'] : 'post',
      ($this->_cmfb['context'])   ? $this->_cmfb['context']   : 'advanced',
      ($this->_cmfb['priority'])  ? $this->_cmfb['priority']  : 'default'
    );
  }

  /* Show the Meta box
  ------------------------------------------------ */
  function lt3_show_custom_meta_field_box()
  {
    global $post;
    echo '<input type="hidden" name="custom_meta_fields_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
    echo '<ul class="lt3-form-container '. $this->_cmfb['context'] . '">';
    foreach ( $this->_cmfb['fields'] as $field )
    {
      /* Get the field ID, existing value, and set the label & description */
      $field_id = $this->get_field_id($this->_cmfb['id'], $field['id'], $field['label']);
      $value = get_post_meta($post->ID, $field_id, true);
      $value = ($value) ? $value : '';
      echo '<li class="custom-field-container">';
      $label_state = ($field['label'] == null) ? 'empty' : '';
      echo '<p class="label-container '. $label_state .'">';
      echo ($field['label'] != null) ? '<label for="'.$field_id.'"><strong>'.$field['label'].'</strong></label>' : '&nbsp;'; echo '</p>';
      echo '<p class="input-container">';
      /* Render required field */
      switch($field['type'])
      {

        /* textarea
        ------------------------------------------------
        Extra Parameters: description | text
        ------------------------------------------------ */
        case 'textarea':
          echo '<textarea name="'.$field_id.'" id="'.$field_id.'">'.$value.'</textarea>';
          break;

        /* checkbox
        ------------------------------------------------
        Extra Parameters: description | text, options | array
        ------------------------------------------------ */
        case 'checkbox':
          echo '<ul>';
          foreach($field['options'] as $key => $option):
          echo '<li><input type="checkbox" name="'.$field_id.'['.$key.']" id="'.$field_id.'['.$key.']" value="'.$key.'" ', $value[$key] ? ' checked' : '',' />';
          echo '<label for="'.$field_id.'['.$key.']">&nbsp;'.$option.'</label></li>';
          endforeach;
          echo '</ul>';
          break;

        /* post_checkbox_list
        ------------------------------------------------
        Extra Parameters: description | text, post_type | array
        ------------------------------------------------ */
        case 'post_checkbox_list':
          $value = ($value) ? $value : array();
          $items = get_posts(array(
            'post_type' => $field['post_type'],
            'posts_per_page' => -1)
          );
          echo '<ul>';
          foreach($items as $item):
            $is_select = (in_array($item->ID, $value)) ? ' checked' : '';
            $post_type_label = (isset($field['post_type'][1])) ? '<small>('.$item->post_type.')</small>' : '';
            echo '<li>';
            echo '<input type="checkbox" name="'.$field_id.'['. $item->ID .']" id="'.$field_id.'['. $item->ID .']" value="'.$item->ID.'" '. $is_select .'>';
            echo '<label for="'.$field_id.'['. $item->ID .']">&nbsp;'.$item->post_title. ' '.$post_type_label.'</label>';
            echo '</li>';
            endforeach;
          echo '</ul>';
          break;

        /* file
        ------------------------------------------------
        Extra Parameters: description | text
        ------------------------------------------------ */
        case 'file':
          echo '<p><input name="'.$field_id.'" type="text" placeholder="'.$field['placeholder'].'" class="custom_upload_file" value="'.$value.'" size="100" />
                <input class="custom_upload_file_button button" type="button" value="Choose File" />
                <br><small><a href="#" class="custom_clear_file_button">Remove File</a></small></p>';
            ?>
              <script>
              jQuery(function($) {
                $('.custom_upload_file_button').click(function() {
                  $formField = $(this).siblings('.custom_upload_file');
                  tb_show('Select a File', 'media-upload.php?type=image&TB_iframe=true');
                  window.send_to_editor = function($html) {
                   $fileUrl = $($html).attr('href');
                   $formField.val($fileUrl);
                   tb_remove();
                  };
                  return false;
                });
                $('.custom_clear_file_button').click(function() {
                  $(this).parent().siblings('.custom_upload_file').val('');
                  return false;
                });
              });
              </script>
            <?php
          break;

        /* text | default
        ------------------------------------------------
        Extra parameters: description & placeholder
        ------------------------------------------------ */
        default:
          echo '<input type="text" name="'.$field_id.'" id="'.$field_id.'" placeholder="'.$field['placeholder'].'" value="'.$value.'" size="50">';
          break;

      }
      echo '</p>';
      echo ($field['description'] != null) ? '<p class="description">'.$field['description'].'</p>' : '&nbsp;';
      echo '</li>';
    }
    echo '</ul>';
  }

  /* Get the field id
  ------------------------------------------------ */
  function get_field_id($id, $field, $label)
  {
    $actual_id = ($field) ? $field : trim(strtolower(str_replace(' ', '_', $label)));
    return '_' . $id . '_' . $actual_id;
  }

  /* Save the data
  ------------------------------------------------ */
  function lt3_save_data($post_id)
  {
    if (!wp_verify_nonce($_POST['custom_meta_fields_box_nonce'], basename(__FILE__)))
    {
      return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    {
      return $post_id;
    }
    if ('page' == $_POST['post_type']) {
      if (!current_user_can('edit_page', $post_id))
      {
        return $post_id;
      }
    }
    elseif (!current_user_can('edit_post', $post_id))
    {
      return $post_id;
    }
    foreach ($this->_cmfb['fields'] as $field)
    {
      $field_id = $this->get_field_id($this->_cmfb['id'], $field['id'], $field['label']);

      $old = get_post_meta($post_id, $field_id, true);
      $new = $_POST[$field_id];
      if ($new && $new != $old)
      {
        update_post_meta($post_id, $field_id, $new);
      }
      elseif ('' == $new && $old)
      {
        delete_post_meta($post_id, $field_id, $old);
      }
    }
  }
}