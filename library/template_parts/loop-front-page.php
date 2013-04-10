<?php
/*

  lt3 Front Page Loop Template

------------------------------------------------
  loop-front-page.php
  @version 2.0 | April 1st 2013
  @package lt3
  @author  Beau Charman | @beaucharman | http://beaucharman.me
  @link    https://github.com/beaucharman/lt3
  @licence GNU http://www.gnu.org/licenses/lgpl.txt
------------------------------------------------ */ ?>
<?php while(have_posts()) : the_post(); ?>

<article <?php post_class('front-page entry content post-'. get_the_ID()); ?>>

  <?php $article_title = strtoupper(get_the_title()); if(($article_title != 'HOME') && ($article_title != 'HOME PAGE')) : ?>
    <h2 class="article-title"><?php the_title(); ?></h2>
  <?php endif; ?>

  <?php lt3_include_post_meta(); ?>

  <?php if(has_post_thumbnail()) : ?>
  <figure class="post-thumbnail">
    <?php the_post_thumbnail('medium'); ?>
  </figure>
  <?php endif; ?>

  <?php the_content(); ?>

</article>

<?php lt3_include_page_pagination(); ?>

<?php lt3_get_comments_template(); ?>

<?php endwhile; ?>