<?php
/**
 * Loop Page
 * ------------------------------------------------------------------------
 * loop-page.php
 * @version 2.0 | April 1st 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license GNU http://www.gnu.org/licenses/lgpl.txt
 * ------------------------------------------------------------------------ */ ?>
<?php while( have_posts() ) : the_post(); ?>

<article <?php post_class( 'page entry content post-'. get_the_ID() ); ?>>

  <h1 class="article-title"><?php the_title(); ?></h1>

  <?php if ( has_post_thumbnail() ) : ?>
  <figure class="post-thumbnail">
    <?php the_post_thumbnail( 'medium' ); ?>
  </figure>
  <?php endif; ?>

  <?php the_content(); ?>

</article>

<?php lt3_include_page_pagination(); ?>

<?php lt3_get_comments_template(); ?>

<?php endwhile; ?>