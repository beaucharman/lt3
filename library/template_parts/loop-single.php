<?php
/**
 * Loop Single
 * ========================================================================
 * loop-single.php
 * @version    2.1 | 6th June 2013
 * @package    WordPress
 * @subpackage lt3
 * @author     Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link       https://github.com/beaucharman/lt3
 * @license    MIT license
 * ======================================================================== */ ?>
<?php while (have_posts()) : the_post(); ?>

<article <?php post_class('single entry content post-' . get_the_ID()); ?>>

  <h1 class="article-title"><?php the_title(); ?></h1>

  <?php lt3_include_post_meta(); ?>

  <?php if (has_post_thumbnail()) : ?>
  <figure class="featured-image">
    <?php the_post_thumbnail('medium'); ?>
  </figure>
  <?php endif; ?>

  <?php the_content(); ?>

  <footer class="article-footer">
    <?php lt3_include_page_pagination(); ?>
    <?php lt3_back_to_parent_link(); ?>
  </footer>

</article>

<?php lt3_include_archive_pagination(); ?>

<?php lt3_get_comments_template(); ?>

<?php endwhile ; ?>
