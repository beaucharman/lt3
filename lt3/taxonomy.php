<?php
/**
 * Taxonomy Template
 * ========================================================================
 * taxonomy.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 *
 * Taxonomy template page.
 * Custom taxonomy? Save this template page as taxonomy-{{slug}}.php
 */

get_header(); ?>

  <?php $taxonomy_term = $wp_query->get_queried_object(); ?>
  <h1 class="content-title"><?php
    echo $taxonomy_term->name; echo _e(' Archive');
  ?></h1>

  <?php if (term_description()) : ?>
    <p class="taxonomy-description">
      <?php remove_filter('term_description','wpautop'); echo term_description(); ?>
    </p>
  <?php endif; ?>

  <?php if (have_posts()) : ?>

    <?php get_template_part(LT3_TEMPLATE_PARTS_PATH . '/loop', 'taxonomy'); ?>

    <?php lt3_include_archive_pagination(); ?>

  <?php else : ?>

    <?php lt3_get_message('not-found'); ?>

  <?php endif; ?>

<?php get_footer(); ?>
