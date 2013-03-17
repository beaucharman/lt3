<?php
/*

  Category Template

------------------------------------------------
  Version: 1.0
  Notes:   Category template page.
------------------------------------------------ */ ?>

<?php get_header(); ?>

  <h2 class="content-title"><?php single_cat_title(); ?></h2>

  <?php if(term_description()) : ?>
    <p class="category-description"><?php echo term_description(); ?></p>
  <?php endif; ?>

  <?php if(have_posts()) : ?>

    <?php get_template_part(LT3_TEMPLATE_PARTS_PATH . '/loop', 'category'); ?>

    <?php lt3_include_archive_pagination();; ?>

  <?php else : ?>

    <?php lt3_get_message('No Posts'); ?>

  <?php endif; ?>

<?php get_footer(); ?>