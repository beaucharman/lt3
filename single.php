<?php
/**
 * Single
 * ========================================================================
 * single.php
 * @version    2.1 | 6th June 2013
 * @package    WordPress
 * @subpackage lt3
 * @author     Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link       https://github.com/beaucharman/lt3
 * @license    MIT license
 *
 * Single (built in Post or other post type) template page.
 * ======================================================================== */ ?>
<?php get_header(); ?>

  <?php if (have_posts()) : ?>

    <?php get_template_part(LT3_TEMPLATE_PARTS_PATH . '/loop', 'single'); ?>

  <?php else : ?>

    <?php lt3_get_message('Not Found'); ?>

  <?php endif; ?>

<?php get_footer(); ?>