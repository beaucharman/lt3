<?php
/*	
  
  lt3-theme Meta Fields
  
------------------------------------------------
	Version: 1.0
	Notes:
	
	This file is for the custom meta fields for posts, pages, and custom post types.
	
	array(
    'id'              => '', 
    'title'           => '',              
    'post_type'       => '', // 'post', 'page', 'link', 'attachment' or 'custom_post_type'             
    'context'         => '', // 'normal', 'advanced', or 'side'         
    'priority'        => '', // 'high', 'core', 'default' or 'low'
    'fields'          => array(
      array(
        'type'        => '',
        'id' 	        => '',
      	'label'       => '',
      )
    )  
  )

------------------------------------------------ */

/* Delcare the meta boxes
------------------------------------------------
Field: All require the following parameters: type, id & label
------------------------------------------------ */
$custom_meta_fields_array = array(	array(
    'id'              => 'This', 
    'title'           => 'Hi',              
    'post_type'       => '', // 'post', 'page', 'link', 'attachment' or 'custom_post_type'             
    'context'         => 'side', // 'normal', 'advanced', or 'side'         
    'priority'        => '', // 'high', 'core', 'default' or 'low'
    'fields'          => array(
      array(
        'type'        => 'text',
        'id' 	        => 'rrty',
      	'label'       => 'This is some text yo!',
      	
      	'description' => 'This is a description'
      ),
      array(
        'type'        => 'textarea',
        'id' 	        => 'qwe',
      	'label'       => '',
      	),
      array(
        'type'        => 'post_list',
        'id' 	        => 's',
        'post_type'   => 'page',
      	'label'       => 'This is some text yo!',
      )
    )  
  ));

/* Create each custom meta field box instance
------------------------------------------------ */
add_action('load-post.php', 'create_meta_boxes');
function create_meta_boxes()
{
  global $custom_meta_fields_array;
  foreach($custom_meta_fields_array as $cmfb)
  {
    new Custom_Field_Meta_Box($cmfb);
  }
}

/* Class structure for a custom meta field box
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
    echo '<table class="form-table lt3-form-container '. $this->_cmfb['context'] . '"><tbody>';
    foreach ( $this->_cmfb['fields'] as $field )
    {
      $field_id = '_' . $this->_cmfb['id'] . '_' . $field['id'];
      $meta = get_post_meta($post->ID, $field_id, true);
      $meta = ($meta) ? $meta : '';
      echo '<tr><th class="label-container">';
      echo ($field['label'] != null) ? '<label for="'.$field_id.'">'.$field['label'].'</label>' : '&nbsp;';
      echo '<span class="description">'.$field['description'].'</span>';
      echo '</th>';
      echo '<td class="input-container">';
      switch($field['type']) 
      {
      
        /* text
        ------------------------------------------------
        Extra parameters: description & placeholder
        ------------------------------------------------ */
        case 'text':
          echo '<input type="text" name="'.$field_id.'" id="'.$field_id.'" placeholder="'.$field['placeholder'].'" value="'.$meta.'"><br>';
        break;
        
        /* textarea
        ------------------------------------------------
        Extra Parameters: description
        ------------------------------------------------ */
        case 'textarea':
          echo '<textarea name="'.$field_id.'" id="'.$field_id.'">'.$meta.'</textarea><br>';
        break;
        
        /* post_list
        ------------------------------------------------
        Extra Parameters: description & post_type
        ------------------------------------------------ */
        case 'post_list':
          $meta = ($meta) ? $meta : array(); 
          $items = get_posts(array(
            'post_type'	=> $field['post_type'], 
            'posts_per_page' => -1)
          );
          echo '<ul>';
          foreach($items as $item):
            $is_select = (in_array($item->ID, $meta)) ? ' checked' : '';
            echo '<li>';
            echo '<input type="checkbox" name="'.$field_id.'['. $item->ID .']" id="'.$field_id.'['. $item->ID .']" value="'.$item->ID.'" '. $is_select .'>';
            echo '&nbsp;<label for="'.$field_id.'['. $item->ID .']">'.$item->post_title.'</label>';
            echo '</li>';
            endforeach;
          echo '</ul>';
        break;	
      }
      echo '</td></tr>';
    }
    echo '</tbody></table>';
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