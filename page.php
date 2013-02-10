<?php
/*	
  
  Page Template
  
------------------------------------------------
  Version: 1.0
  Notes:   Page template.
------------------------------------------------ */ ?>

<?php get_header(); ?>

  <?php if(have_posts()) : ?>

    <?php get_template_part(LT3_TEMPLATE_PARTS_PATH . '/loop', 'page'); ?>

  <?php else : ?>

    <?php lt3_get_message('Not Found'); ?>

  <?php endif; ?>

<?php get_footer(); ?>