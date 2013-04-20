<?php
/**
 * Loop
 * ------------------------------------------------------------------------
 * loop.php
 * @version 2.0 | April 1st 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license GNU http://www.gnu.org/licenses/lgpl.txt
 * ------------------------------------------------------------------------ */ ?>
<?php while(have_posts()) : the_post(); ?>

<?php $output_type = (is_single()) ? 'excerpt' : 'content'; ?>

<article <?php post_class('post-'. get_the_ID() . ' entry ' . $output_type ); ?>>

  <h1 class="article-title">
    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
      <?php the_title(); ?>
    </a>
  </h1>

  <?php lt3_include_post_meta(); ?>

  <?php if(has_post_thumbnail()) : ?>
  <figure class="post-thumbnail">
    <?php the_post_thumbnail('medium'); ?>
	</figure>
	<?php endif; ?>

	<?php (is_single()) ? the_excerpt() : the_content(); ?>

</article>

<?php lt3_get_comments_template(); ?>

<?php endwhile; ?>