<?php
/**
 * Front Page
 *
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   samurai
 *
 * Front page and home page template.
 * If using a blogroll as your home page, rename this template page to
 * home.php
 */

get_header(); ?>

  <?php if (have_posts()) : ?>

    <?php get_template_part(SAMURAI_VIEWS_PATH . '/loop', 'front-page'); ?>

  <?php else : ?>

    <?php Samurai_Snippet::get_message('not-found'); ?>

  <?php endif; ?>

<?php get_footer(); ?>
