<?php
/**
 * Front Page
 * ========================================================================
 * front-page.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 *
 * Front page and home page template.
 * If using a blogroll as your home page, rename this template page to
 * home.php
 * ======================================================================== */

get_header(); ?>

  <?php lt3_show_sticky_posts(); ?>

  <?php if (have_posts()) : ?>

    <?php get_template_part(LT3_TEMPLATE_PARTS_PATH . '/loop', 'front-page'); ?>

  <?php else : ?>

    <?php lt3_get_message('Not Found'); ?>

  <?php endif; ?>

<?php get_footer(); ?>
