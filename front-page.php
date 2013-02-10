<?php
/*	
  
  Front Page Template
  
------------------------------------------------
  Version: 1.0
  Notes:   Front page and home page template page.
------------------------------------------------ */ ?>

<?php get_header(); ?>

  <?php	lt3_default_sticky_posts(); ?>

  <?php if(have_posts()) : ?>

    <?php get_template_part(LT3_TEMPLATE_PARTS_PATH . '/loop', 'front-page'); ?>

  <?php else : ?>

    <?php lt3_get_message('Not Found'); ?>

  <?php endif; ?>

<?php get_footer(); ?>