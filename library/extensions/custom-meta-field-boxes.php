<?php
/*

  lt3 Custom Meta Field Boxes

------------------------------------------------
  custom-meta-field-boxes.php 2.0
  Sunday, 3rd February 2013
  Beau Charman | @beaucharman | http://beaucharman.me

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
add_action('load-post.php', 'create_meta_boxes');
function create_meta_boxes()
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
    add_action('add_meta_boxes', array( &$this, 'add_custom_meta_field_box'));
    add_action('save_post', array( &$this, 'save_data'));
  }

  /* Add the Meta Box
  ------------------------------------------------ */
  function add_custom_meta_field_box()
  {
    add_meta_box(
      ($this->_cmfb['id'])        ? $this->_cmfb['id']        : 'custom_meta_field_box',
      ($this->_cmfb['title'])     ? $this->_cmfb['title']     : 'Custom Meta Field Box',
      array( &$this, 'show_custom_meta_field_box'),
      ($this->_cmfb['post_type']) ? $this->_cmfb['post_type'] : 'post',
      ($this->_cmfb['context'])   ? $this->_cmfb['context']   : 'advanced',
      ($this->_cmfb['priority'])  ? $this->_cmfb['priority']  : 'default'
    );
  }

  /* Show the Meta box
  ------------------------------------------------ */
  function show_custom_meta_field_box()
  {
    global $post;
    $context = $this->_cmfb['context'];
    echo '<input type="hidden" name="custom_meta_fields_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
    echo '<div class="lt3-form-container '. $this->_cmfb['context'] . '">';
    foreach ( $this->_cmfb['fields'] as $field )
    {
      /* Get the field ID, existing value, and set the label & description */
      $field_id = '_' . $this->_cmfb['id'] . '_' . $field['id'];
      $value = get_post_meta($post->ID, $field_id, true);
      $value = ($value) ? $value : '';
      echo '<section class="custom-field-container">';
      $label_state = ($field['label'] == null) ? 'empty' : '';
      echo '<p class="label-container '. $label_state .'">';
      echo ($field['label'] != null) ? '<label for="'.$field_id.'"><strong>'.$field['label'].'</strong></label>' : '&nbsp;'; echo '</p>';
      echo ($field['description'] != null) ? '<p class="description">'.$field['description'].'</p>' : '&nbsp;';
      echo '<p class="input-container">';
      /* Render required field */
      switch($field['type'])
      {

        /* textarea
        ------------------------------------------------
        Extra Parameters: description
        ------------------------------------------------ */
        case 'textarea':
          echo '<textarea name="'.$field_id.'" id="'.$field_id.'">'.$value.'</textarea>';
          break;

        /* checkbox
        ------------------------------------------------
        Extra Parameters: description
        ------------------------------------------------ */
        case 'checkbox':
          foreach($field['options'] as $value => $key):
          echo '<input type="checkbox" name="'.$field_id.'" id="'.$field_id.'" ', $value ? ' checked' : '',' />';
          endforeach;
          break;

        /* post_list
        ------------------------------------------------
        Extra Parameters: description & post_type
        ------------------------------------------------ */
        case 'post_list':
          $value = ($value) ? $value : array();
          $items = get_posts(array(
            'post_type' => $field['post_type'],
            'posts_per_page' => -1)
          );
          echo '<ul>';
          foreach($items as $item):
            $is_select = (in_array($item->ID, $value)) ? ' checked' : '';
            echo '<li>';
            echo '<input type="checkbox" name="'.$field_id.'['. $item->ID .']" id="'.$field_id.'['. $item->ID .']" value="'.$item->ID.'" '. $is_select .'>';
            echo '&nbsp;<label for="'.$field_id.'['. $item->ID .']">'.$item->post_title.'</label>';
            echo '</li>';
            endforeach;
          echo '</ul>';
          break;

        /* file
        ------------------------------------------------
        Extra Parameters: description & post_type
        ------------------------------------------------ */
        case 'file':
          echo '<p><input name="'.$field_id.'" type="text" placeholder="'.$field['placeholder'].'" class="custom_upload_file" value="'.$value.'" size="50" />
                <input class="custom_upload_file_button button" type="button" value="Choose File" />
                <small> <a href="#" class="custom_clear_file_button">Remove File</a></small></p>';
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
      echo '</section>';
    }
    echo '</div>';
  }

  /* Save the data
  ------------------------------------------------ */
  function save_data($post_id)
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
      $field_id = '_' . $this->_cmfb['id'] . '_' . $field['id'];
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