<?php
/*

  Attachment Template

------------------------------------------------
  Version: 1.0
  Notes:   Attachment template page for article related media.
------------------------------------------------ */ ?>

<?php get_header(); ?>

  <?php if(have_posts()) : ?>

    <?php get_template_part(LT3_TEMPLATE_PARTS_PATH . '/loop', 'attachment'); ?>

  <?php else : ?>

    <?php lt3_get_message('Not Found'); ?>

  <?php endif; ?>

<?php get_footer(); ?>