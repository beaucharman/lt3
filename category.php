<?php
/**
 * Category
 * ------------------------------------------------------------------------
 * category.php
 * @version 2.0 | April 1st 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license MIT license
 *
 * Category template page.
 * ------------------------------------------------------------------------ */ ?>
<?php get_header(); ?>

  <h1 class="content-title"><?php single_cat_title(); ?></h1>

  <?php if ( term_description() ) : ?>
  <p class="category-description"><?php echo term_description(); ?></p>
  <?php endif; ?>

  <?php if ( have_posts() ) : ?>

    <?php get_template_part( LT3_TEMPLATE_PARTS_PATH . '/loop', 'category' ); ?>

    <?php lt3_include_archive_pagination(); ?>

  <?php else : ?>

    <?php lt3_get_message( 'No Posts' ); ?>

  <?php endif; ?>

<?php get_footer(); ?>