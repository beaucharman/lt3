<?php
/**
 * Archive
 *
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 *
 * Custom post type? Save this template page as archive-{{slug}}.php
 */

get_header(); ?>

  <?php global $post; global $wp_query; $post = $posts[0]; ?>

  <h1 class="archive__heading content-heading"><?php lt3_get_archive_title(); ?></h1>

  <?php if (term_description()) : ?>

  <p class="archive__description term-description">
    <?php echo term_description(); ?>
  </p>

  <?php endif; ?>

  <?php if (have_posts()) : ?>

    <?php get_template_part(LT3_VIEWS_PATH . '/loop-archive', get_post_type($post->ID)); ?>

    <?php lt3_Pagination::include_archive_pagination(); ?>

  <?php else : ?>

    <?php lt3_get_message('no-posts'); ?>

  <?php endif; ?>

<?php get_footer(); ?>
