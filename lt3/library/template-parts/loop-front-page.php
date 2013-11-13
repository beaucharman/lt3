<?php
/**
 * Loop Front Page
 * ========================================================================
 * loop-front-page.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 */
?>

<?php while (have_posts()) : the_post(); ?>

<article <?php post_class('front-page entry content post-' . get_the_ID()); ?>>

  <?php $article_title = strtoupper(get_the_title());
    if (($article_title != 'HOME') && ($article_title != 'HOME PAGE')) : ?>
    <h2 class="article-title"><?php the_title(); ?></h2>
  <?php endif; ?>

  <?php lt3_include_post_meta(); ?>

  <?php if (has_post_thumbnail()) : ?>
  <figure class="featured-image">
    <?php the_post_thumbnail('medium'); ?>
  </figure>
  <?php endif; ?>

  <?php the_content(); ?>

</article>

<?php lt3_include_page_pagination(); ?>

<?php lt3_get_comments_template(); ?>

<?php endwhile; ?>
