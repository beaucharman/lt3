<?php
/**
 * Custom Meta Field Box
 * ========================================================================
 * custom-meta-field-box.php
 * @version 2.1 | April 1st 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license MIT license
 *
 * To declare a custom meta field box, simply create a new instance of the
 * LT3_Custom_Meta_Field_Box class.
 *
 * Configuration guide:
 * https://github.com/beaucharman/wordpress-custom-meta-field-boxes
 *
 * For more information about registering custom meta field boxes:
 * http://codex.wordpress.org/Function_Reference/add_meta_box
 */

/* ========================================================================
   Custom Meta Field Box class
   ======================================================================== */
class LT3_Custom_Meta_Field_Box
{
  protected $cmfb;
  protected $id;
  protected $title;
  protected $post_type;
  protected $context;
  protected $priority;
  protected $fields;

  /**
   * Class Constructor
   * ========================================================================
   * __construct()
   * @param {array} $cmfb
   * ======================================================================== */
  function __construct($cmfb)
  {
    /* Set class values */
    $this->cmfb      = $cmfb;
    $this->id        = $this->uglify_words('_cmfb_'. $this->cmfb['id']);
    $this->title     = (isset($this->cmfb['title']))
      ? $this->cmfb['title'] : $this->prettify_words($this->cmfb['id']);
    $this->post_type = (isset($this->cmfb['post_type']))
      ? $this->cmfb['post_type'] : 'post';
    $this->context   = (isset($this->cmfb['context']))
      ? $this->cmfb['context']   : 'advanced';
    $this->priority  = (isset($this->cmfb['priority']))
      ? $this->cmfb['priority']  : 'default';
    $this->fields    = $this->cmfb['fields'];

    /* Magic */
    add_action('add_meta_boxes', array(&$this, 'add_custom_meta_field_box'));
    add_action('save_post', array(&$this, 'save_data'));
  }

  /**
   * Add Custom Meta Field Box
   * ========================================================================
   * add_custom_meta_field_box()
   * ======================================================================== */
  public function add_custom_meta_field_box()
  {
    add_meta_box(
      $this->id,
      $this->title,
      array(&$this, 'show_custom_meta_field_box'),
      $this->post_type,
      $this->context,
      $this->priority
    );
  }

  /**
   * Show Custom Meta Field Box
   * ========================================================================
   * show_custom_meta_field_box()
   * ======================================================================== */
  public function show_custom_meta_field_box()
  {
    global $post;
    echo '<input type="hidden" name="custom_meta_fields_box_nonce" value="'
      . wp_create_nonce(basename(__FILE__)) . '" />';
    echo '<ul class="lt3-form-container ' . $this->context . '">';

    foreach ($this->fields as $field)
    {
      /* Get the field ID */
      $field_id = $this->get_field_id($this->id, $field['id']);

      /* Get the saved value, if there is one */
      $value = get_post_meta($post->ID, $field_id, true);
      $value = ($value) ? $value : '';

      /* Get the label */
      $field_label = (isset($field['label']))
        ? $field['label'] : $this->prettify_words($field['id']);

      echo '<li class="custom-field-container">';

      echo '<p class="label-container">';
      echo '  <label for="' . $field_id . '"><strong>' . $field_label . '</strong></label>';
      echo '</p>';

      echo '<div class="input-container">';

      /* Render required field */
      $field['type'] = (isset($field['type'])) ? $field['type'] : '';

      switch ($field['type'])
      {
        /**
         * text
         * ========================================================================
         * @param {string} type
         * @param {string} id
         * @param {string} label       | optional
         * @param {string} description | optional
         * @param {string} placeholder | optional
         * ======================================================================== */
        case 'text':
          $field_placeholder = (isset($field['placeholder'])) ? $field['placeholder'] : '';
          echo '<input type="text" name="'.$field_id.'" id="'
            .$field_id.'" placeholder="'.$field_placeholder.'" value="'.$value.'" size="50">';
          break;

        /**
         * textarea
         * ========================================================================
         * @param {string} type
         * @param {string} id
         * @param {string} label       | optional
         * @param {string} description | optional
         * ======================================================================== */
        case 'textarea':
          echo '<textarea name="' . $field_id . '" id="' . $field_id . '">' . $value . '</textarea>';
          break;

        /**
         * checkbox
         * ========================================================================
         * @param {string} type
         * @param {string} id
         * @param {array}  options
         * @param {string} label       | optional
         * @param {string} description | optional
         * ======================================================================== */
        case 'checkbox':
          echo '<ul>';
          foreach ($field['options'] as $option => $label):
            echo '<li>';
            echo '  <label for="' . $field_id . '[' . $option . ']">';
            echo '  <input type="checkbox" name="' . $field_id . '[' . $option . ']" id="'
              . $field_id . '[' . $option . ']" value="' . $option . '" ', isset($value[$option])
                ? ' checked' : '', ' />';
            echo '  &nbsp;' . $label . '</label>';
            echo '</li>';
          endforeach ;
          echo '</ul>';
          break;

        /**
         * post_checkbox
         * ========================================================================
         * @param {string}          type
         * @param {string}          id
         * @param {string || array} post_type
         * @param {array}           args
         * @param {string}          label       | optional
         * @param {string}          description | optional
         * ======================================================================== */
        case 'post_checkbox':

          $value = ($value) ? $value : array();

          $field['args'] = (isset($field['args']) && is_array($field['args']))
            ? $field['args'] : array();
          $args = array_merge(
            array(
            'post_type'      => $field['post_type'],
            'posts_per_page' => -1
            ), $field['args']
         );
          $items = get_posts($args);

          if ($items)
          {
            echo '<ul>';
            foreach ($items as $item):
              $is_select = (in_array($item->ID, $value)) ? ' checked' : '';
              $post_type_label = (isset($field['post_type'][1]) && is_array($field['post_type']))
                ? ' <small>(' . $item->post_type . ')</small>' : '';
              echo '<li>';
              echo '  <label for="' . $field_id . '[' . $item->ID . ']">';
              echo '  <input type="checkbox" name="' . $field_id . '[' . $item->ID
                .']" id="'.$field_id.'['. $item->ID .']" value="'.$item->ID.'" '. $is_select .'>';
              echo '  &nbsp;'.$item->post_title . $post_type_label.'</label>';
              echo '</li>';
            endforeach ;
            echo '</ul>';
            echo '<p><small>Manage ' . $this->get_edit_links($field['post_type']) . '</p></small>';
          }
          else
          {
            echo 'Sorry, there are currently no '. lt3_prettify_words($field['post_type'])
              .' items to choose from.';
          }
          break;

        /**
         * select
         * ========================================================================
         * @param {string} type
         * @param {string} id
         * @param {array}  options
         * @param {string} label       | optional
         * @param {string} null_option | optional
         * @param {string} description | optional
         * ======================================================================== */
        case 'select':
          $field_null_label = (isset($field['null_option']))
            ? $field['null_option'] : 'Select';
          echo '<select name="' . $field_id . '" id="' . $field_id . '">';
          echo '  <option value="">' . $field_null_label . '&hellip;</option>';
          foreach ($field['options'] as $option => $label):
          echo '  <option value="' . $option . '" ', $value == $option
            ? ' selected' : '', '>' . $label . '</option>';
          endforeach ;
          echo '</select>';
          break;

        /**
         * post_select
         * ========================================================================
         * @param {string}          type
         * @param {string}          id
         * @param {string || array} post_type
         * @param {array}           args
         * @param {string}          label       | optional
         * @param {string}          null_option | optional
         * @param {string}          description | optional
         * ======================================================================== */
        case 'post_select':
          $field['args'] = (isset($field['args']) && is_array($field['args']))
            ? $field['args'] : array();
          $args = array_merge(
            array(
              'post_type'      => $field['post_type'],
              'posts_per_page' => -1
            ), $field['args']
          );
          $items = get_posts($args);

          if ($items)
          {
            $field_null_label = (isset($field['null_option']))
              ? $field['null_option'] : 'Select';
            echo '<select name="' . $field_id . '" id="' . $field_id . '">';
            echo '  <option value="">' . $field_null_label . '&hellip;</option>';
            foreach ($items as $item) :
              $is_select = (in_array($item->ID, $value)) ? ' checked' : '';
              $post_type_label = (isset($field['post_type'][1]) && is_array($field['post_type']))
                ? ' <small>(' . $item->post_type . ')</small>' : '';
              echo '  <option value="' . $item->ID . '" ', $value == $item->ID
                ? ' selected' : '','>' . $item->post_title . $post_type_label . '</option>';
            endforeach;
            echo '</select>';
            echo '<p><small>Manage ' . $this->get_edit_links($field['post_type']) . '</p></small>';
          }
          else
          {
            echo 'Sorry, there are currently no ' . $field['post_type'] . ' items to choose from.';
          }
          break;

        /**
         * term_select
         * ========================================================================
         * @param {string} type
         * @param {string} id
         * @param {string} taxonomy
         * @param {array}  args
         * @param {string} label       | optional
         * @param {string} null_option | optional
         * @param {string} description | optional
         * ======================================================================== */
        case 'term_select':

          $field['args'] = (isset($field['args']) && is_array($field['args']))
            ? $field['args'] : array();
          $args = array_merge(
            array(
              'orderby'       => 'name',
              'order'         => 'ASC',
              'hide_empty'    => false
            ), $field['args']
          );
          $items = get_terms($field['taxonomy'], $args);

          if ($items)
          {
            $field_null_label = (isset($field['null_option']))
              ? $field['null_option'] : 'Select';
            echo '<select name="' . $field_id . '" id="' . $field_id . '">';
            echo '  <option value="">' . $field_null_label . '&hellip;</option>';
            foreach ($items as $item):
              $is_select = (in_array($item->term_id, $value)) ? ' checked' : '';
              echo '  <option value="' . $item->term_id . '" ', $value == $item->term_id
                ? ' selected' : '','>' . $item->name . '</option>';
            endforeach ;
            echo '</select>';
            echo '<p><small>Manage '
              . $this->get_edit_links($field['taxonomy'], 'edit-tags', 'taxonomy') . '</p></small>';
          }
          else
          {
            echo 'Sorry, there are currently no '
              . lt3_prettify_words($field['post_type'])
              . ' items to choose from.';
          }
          break;

        /**
         * radio
         * ========================================================================
         * @param {string} type
         * @param {string} id
         * @param {array}  options
         * @param {string} label       | optional
         * @param {string} description | optional
         * ======================================================================== */
        case 'radio':
          echo '<ul>';
          foreach ($field['options'] as $option => $label):
            echo '<li>';
            echo '  <label for="' . $option . '">';
            echo '  <input type="radio" name="' . $field_id . '" id="' . $option
              . '" value="' . $option . '" ', $value == $option ? ' checked' : '',' />';
            echo '  &nbsp;' . $label . '</label>';
            echo '</li>';
          endforeach ;
          echo '</ul>';
          break;

        /**
         * file
         * ========================================================================
         * @param {string} type
         * @param {string} id
         * @param {string} label       | optional
         * @param {string} description | optional
         * @param {string} placeholder | optional
         * ======================================================================== */
        case 'file':
          wp_enqueue_style('thickbox');
          wp_enqueue_script('thickbox');
          wp_enqueue_script('media-upload');
          wp_enqueue_script('cmfb-file-upload', LT3_FULL_SCRIPTS_PATH . '/admin/cmfb-file-upload.js'
            , array('thickbox', 'media-upload'));
          $field_placeholder = (isset($field['placeholder'])) ? $field['placeholder'] : '';
          echo '<input name="' . $field_id . '" id="' . $field_id . '" type="text" placeholder="'
            . $field_placeholder . '" class="custom_upload_file" value="' . $value . '" size="100" />'
            . '<input class="custom_upload_file_button button" type="button" value="Choose File" />'
            . '<br><small><a href="#" class="custom_clear_file_button">Remove File</a></small>';
          break;

        /* default */
        default:
          echo '<p><span style="color: red;">Sorry, '
            . 'the type allocated for this input is not valid.</span></p>';
          break;
      }
      echo '</div>';
      /* Display the description */
      if (isset($field['description']))
      {
        echo '<p class="description">' . $field['description'] . '</p>';
      }
      echo '</li>';
    }
    echo '</ul>';
  }

  /**
   * Get Field ID
   * ========================================================================
   * get_field_id()
   * @param  {string} $box_id
   * @param  {string} $field_id
   * @return {string}
   *
   * Get the field id to use throughout class
   * ======================================================================== */
  public function get_field_id($box_id, $field_id)
  {
    return $this->uglify_words($box_id . '_' . $field_id);
  }

  /**
   * Prettify Words
   * ========================================================================
   * prettify_words()
   * @param  {string} $words
   * @return {string}
   *
   * Creates a pretty version of a string, like
   * a pug version of a dog.
   * ======================================================================== */
  public function prettify_words($words)
  {
    return ucwords(str_replace('_', ' ', $words));
  }

  /**
   * Uglify Words
   * ========================================================================
   * uglify_words()
   * @param  {string} $words
   * @return {string}
   *
   * creates a url firendly version of the given string.
   * ======================================================================== */
  public function uglify_words($words)
  {
    return strToLower(str_replace(' ', '_', $words));
  }

  /**
   * Plurify Words
   * ========================================================================
   * plurify_words()
   * @param  $words | string
   * @return $words | string
   *
   * Plurifies most common words. Not currently working proper nouns,
   * or more complex words, for example knife => knives, leaf => leaves.
   * ======================================================================== */
  public function plurify_words($words)
  {
    if (strToLower(substr($words, -1)) == 'y')
    {
      return substr_replace($words, 'ies', -1);
    }
    if (strToLower(substr($words, -1)) == 's')
    {
      return $words . 'es';
    }
    else
    {
      return $words . 's';
    }
  }

  /**
   * Get Edit Links
   * ========================================================================
   * get_edit_links()
   * @param  {string} $names
   * @param  {string} $type
   * @param  {string} $page
   * @return {string}
   * ======================================================================== */
  public function get_edit_links($names = null, $page = 'edit', $type = 'post_type')
  {
    $links = '';
    if (is_array($names))
    {
      foreach ($names as $item)
      {
        $links .= '<a href="./' . $page . '.php?' . $type . '=' . $item . '" title="edit '
          . $this->plurify_words($item) . '">' . $this->plurify_words($item) . '</a>, ';
      }
    }
    else
    {
      $links = '<a href="./' . $page . '.php?' . $type . '=' . $names . '" title="edit '
        . $this->plurify_words($names) . '">' . $this->plurify_words($names) . '</a>';
    }
   return rtrim($links, ", \t\n");
  }

  /**
   * Save Data
   * ========================================================================
   * save_data()
   * @param  {integer} $post_id
   * @return {null}
   * ======================================================================== */
  public function save_data($post_id)
  {
    if (isset($_POST['custom_meta_fields_box_nonce']))
    {
      if (! wp_verify_nonce($_POST['custom_meta_fields_box_nonce'], basename(__FILE__)))
      {
        return $post_id;
      }
      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
      {
        return $post_id;
      }
      if (isset($_POST['post_type']))
      {
        if ('page' == $_POST['post_type'])
        {
          if (!current_user_can('edit_page', $post_id))
          {
            return $post_id;
          }
        }
      }
      elseif (!current_user_can('edit_post', $post_id))
      {
        return $post_id;
      }
      foreach ($this->fields as $field)
      {
        $field_id = $this->get_field_id($this->id, $field['id']);
        if ($field_id && isset($_POST[$field_id]))
        {
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
  }
}
