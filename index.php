<?php
/*

  Index Template

------------------------------------------------
  Version: 1.0
  Notes:   Fallback template page.
------------------------------------------------ */ ?>

<?php get_header(); ?>

  <?php if(have_posts()) : ?>

    <?php get_template_part(LT3_TEMPLATE_PARTS_PATH . '/loop'); ?>

    <?php lt3_include_single_navigation(); ?>

  <?php else : ?>

    <?php lt3_get_message('Not Found'); ?>

  <?php endif; ?>

<?php get_footer(); ?>