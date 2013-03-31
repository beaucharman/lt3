<?php
/*

  Taxonomy Template

------------------------------------------------
  Version: 1.0
  Notes:   Taxonomy template page.
------------------------------------------------ */ ?>

<?php get_header(); ?>

  <?php $taxonomy_term = $wp_query->get_queried_object(); ?>
  <h1 class="content-title"><?php echo $taxonomy_term->name; ?> <?php echo _e('Archive'); ?></h1>

  <?php if(term_description()) : ?>
    <p class="taxonomy-description"><?php echo term_description(); ?></p>
  <?php endif; ?>

  <?php if(have_posts()) : ?>

    <?php get_template_part(LT3_TEMPLATE_PARTS_PATH . '/loop', 'taxonomy'); ?>

    <?php lt3_include_archive_pagination(); ?>

  <?php else : ?>

    <?php lt3_get_message('No Posts'); ?>

  <?php endif; ?>

<?php get_footer(); ?>