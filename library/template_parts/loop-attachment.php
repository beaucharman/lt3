<?php
/**
 * Loop Attachment
 * ========================================================================
 * loop-attachment.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 * ======================================================================== */ ?>
<?php while (have_posts()) : the_post(); global $post; ?>

<article <?php post_class('attachment post-' . get_the_ID()); ?>>

  <h1 class="article-title"><?php the_title(); ?></h1>

  <?php lt3_include_post_meta(); ?>

  <?php if ($post->post_content) : ?>
  <p class="attachment-description"><?php echo $post->post_content; ?><p>
  <?php endif; ?>

  <figure class="attachment-figure">
    <?php echo wp_get_attachment_image($post->ID, 'full'); ?>
    <?php if ($post->post_excerpt) : ?>
    <figcaption class="attachment-figcaption"><?php echo $post->post_excerpt; ?></figcaption>
    <?php endif; ?>
  </figure>

  <footer class="article-footer"><?php lt3_back_to_parent_link(); ?></footer>

</article>

<?php endwhile; ?>
