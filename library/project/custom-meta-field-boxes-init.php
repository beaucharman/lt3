<?php
/**
 * Custom Meta Field Boxes Init
 * ========================================================================
 * custom-meta-field-boxes-init.php
 * @version    1.0 | May 2nd 2013
 * @package    lt3
 * @subpackage lt3/library/extensions/custom-meta-field-box.php
 * @author     Beau Charman | @beaucharman | http://beaucharman.me
 * @link       https://github.com/beaucharman/lt3
 * @license    MIT license
 *
 * To declare a custom meta field box, simply create a new instance of the
 * LT3_Custom_Meta_Field_Box class.
 *
 * Configuration guide:
 * https://github.com/beaucharman/wordpress-custom-meta-field-boxes
 * ======================================================================== */

$args = array(
  'id'              => 'meta_boxes_test',
  'fields'          => array(
    array(
      'type'        => 'text',
      'id'          => 'text',
      'label'       => 'Text Label',
      'description' => 'This is for text type',
      'placeholder' => 'text&hellip;'
    ),
    array(
      'type'        => 'textarea',
      'id'          => 'textarea',
      'label'       => 'Textarea Label',
      'description' => 'This is for textarea type'
    ),
    array(
      'type'        => 'checkbox',
      'id'          => 'checkbox',
      'options'     => array('foo', 'bar', 'baz', 'qux'),
      'label'       => 'Checkbox Label',
      'description' => 'This is for checkbox type'
    ),
    array(
      'type'        => 'post_checkbox',
      'id'          => 'post_checkbox',
      'post_type'   => array('page', 'post', 'movie'),
      'args'        => array('posts_per_page' => 10),
      'label'       => 'Post Checkbox Label',
      'description' => 'This is for post checkbox type'
    ),
    array(
      'type'        => 'select',
      'id'          => 'select',
      'options'     => array('foo', 'bar', 'baz', 'qux'),
      'label'       => 'Select',
      'description' => 'This is for select type',
      'null_option' => 'NULL'
    ),
    array(
      'type'        => 'post_select',
      'id'          => 'post_select',
      'post_type'   => array('page', 'post', 'movie'),
      'args'        => array('posts_per_page' => 2),
      'label'       => 'Post Select Label',
      'description' => 'This is for post select type',
      'null_option' => 'NULL'
    ),
    array(
      'type'        => 'term_select',
      'id'          => 'term_select',
      'taxonomy'    => array('category', 'genre'),
      'args'        => array('number' => 4),
      'label'       => 'Term Select Label',
      'description' => 'This is for term select type',
      'null_option' => 'NULL'
    ),
    array(
      'type'        => 'radio',
      'id'          => 'radio',
      'options'     => array('foo', 'bar', 'baz', 'qux'),
      'label'       => 'Radio Label',
      'description' => 'This is for radio type'
    ),
    array(
      'type'        => 'file',
      'id'          => 'file',
      'label'       => 'File Label',
      'description' => 'This is for file type',
      'placeholder' => 'text&hellip;'
    )
  )
);
new LT3_Custom_Meta_Field_Box($args);