<?php
/*

  Single Template

------------------------------------------------
  Version: 1.0
  Notes:   Single (Post or other post type) template page.
------------------------------------------------ */ ?>

<?php get_header(); ?>

  <?php if(have_posts()) : ?>

    <?php get_template_part(LT3_TEMPLATE_PARTS_PATH . '/loop', 'single'); ?>

  <?php else : ?>

    <?php lt3_get_message('Not Found'); ?>

  <?php endif; ?>

<?php get_footer(); ?>