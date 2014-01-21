<?php
/**
 * Index
 *
 * index.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 */

get_header(); ?>

  <?php if (have_posts()) : ?>

    <?php get_template_part(LT3_VIEWS_PATH . '/loop'); ?>

    <?php lt3_include_single_navigation(); ?>

  <?php else : ?>

    <?php lt3_get_message('not-found'); ?>

  <?php endif; ?>

<?php get_footer(); ?>
