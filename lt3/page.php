<?php
/**
 * Page
 *
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 *
 * Page template.
 *
 * For a different page template for a particular page,
 * save this template page as page-{{slug}}.php
 */

get_header(); ?>

  <?php if (have_posts()) : ?>

    <?php get_template_part(LT3_VIEWS_PATH . '/loop', 'page'); ?>

  <?php else : ?>

    <?php lt3_get_message('not-found'); ?>

  <?php endif; ?>

<?php get_footer(); ?>
