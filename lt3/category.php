<?php
/**
 * Category
 * ========================================================================
 * category.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 *
 * Category template page.
 * Particular category? Save this template page as category-{{slug}}.php
 */

get_header(); ?>

  <h1 class="content-title"><?php single_cat_title(); ?></h1>

  <?php if (term_description()) : ?>
  <p class="category-description">
    <?php remove_filter('term_description','wpautop'); echo term_description(); ?>
  </p>
  <?php endif; ?>

  <?php if (have_posts()) : ?>

    <?php get_template_part(LT3_TEMPLATE_PARTS_PATH . '/loop', 'category'); ?>

    <?php lt3_include_archive_pagination(); ?>

  <?php else : ?>

    <?php lt3_get_message('No Posts'); ?>

  <?php endif; ?>

<?php get_footer(); ?>
