<?php
/**
 * Search
 *
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 *
 * Search results template.
 */

get_header(); ?>

<?php if (LT3_ENABLE_SITE_SEARCH) : ?>

  <?php global $wp_query; $total_results = $wp_query->found_posts; ?>

  <h1 class="search__heading content-title">Search Results</h1>

  <p class="search__query">
    <?php echo $total_results ?> result<?php if ($total_results != 1) echo 's'; ?>
    found for the search term: <span><?php echo esc_html($s, 1); ?></span>
  </p>

  <?php if (have_posts()) : ?>

    <?php get_template_part(LT3_VIEWS_PATH . '/loop', 'search'); ?>

    <?php lt3_include_archive_pagination(); ?>

    <p class="search__follow-up">
      <?php echo _e('Still not what you are looking for?'); ?>
    </p>

    <?php get_search_form(); ?>

  <?php else : ?>

    <?php lt3_get_message('no-results'); ?>

  <?php endif; ?>

<?php else : ?>

  <?php lt3_get_message('not-found'); ?>

<?php endif; ?>

<?php get_footer(); ?>
