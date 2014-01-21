<?php
/**
 * Single
 *
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 *
 * Single (built in Post or other custom post type) template page.
 * Custom post type? Save this template page as single-{{slug}}.php
 */

get_header(); ?>

  <?php if (have_posts()) : ?>

    <?php get_template_part(LT3_VIEWS_PATH . '/loop-single', get_post_type($post->ID)); ?>

  <?php else : ?>

    <?php lt3_get_message('not-found'); ?>

  <?php endif; ?>

<?php get_footer(); ?>
