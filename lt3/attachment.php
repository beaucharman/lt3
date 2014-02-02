<?php
/**
 * Attachment
 *
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   samurai
 *
 * Attachment template page for article related media.
 */

get_header(); ?>

  <?php if (have_posts()) : ?>

    <?php get_template_part(SAMURAI_VIEWS_PATH . '/loop', 'attachment'); ?>

  <?php else : ?>

    <?php Samurai_Snippet::get_message('not-found'); ?>

  <?php endif; ?>

<?php get_footer(); ?>
