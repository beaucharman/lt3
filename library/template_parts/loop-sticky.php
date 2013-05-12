<?php
/**
 * Loop Sticky
 * ========================================================================
 * loop-sticky.php
 * @version 2.0 | April 1st 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license MIT license
 * ======================================================================== */ ?>
<?php $sticky_loop = new WP_Query(array(
    'posts_per_page' => LT3_NUMBER_OF_STICKY_POSTS,
    'post__in'  => get_option('sticky_posts'),
    'ignore_sticky_posts' => 1)); ?>

<?php if ($sticky_loop->have_posts()) : ?>

<section class="featured">

<?php while($sticky_loop->have_posts()) : $sticky_loop->the_post(); ?>

<?php if (!is_sticky()) continue; ?>

  <article <?php post_class('sticky entry excerpt post-'. get_the_ID()); ?>>

    <h2 class="sticky-article-title">
      <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
        <?php the_title(); ?>
      </a>
    </h2>

    <?php if (has_post_thumbnail()) : ?>
    <figure class="post-thumbnail">
      <?php the_post_thumbnail('thumbnail'); ?>
    </figure>
    <?php endif; ?>

    <?php the_excerpt(); ?>

    <footer class="article-footer">
      <a class="read-more" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>">
        <?php lt3_read_more_text(); ?>
      </a>
    </footer>

  </article>

<?php endwhile; ?>

</section>

<?php endif; ?>