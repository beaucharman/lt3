<?php
/**
 * Loop Attachment
 * ------------------------------------------------------------------------
 * loop-attachment.php
 * @version 2.0 | April 1st 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license MIT license
 * ------------------------------------------------------------------------ */ ?>
<?php while( have_posts() ) : the_post(); global $post; ?>

<article <?php post_class( 'attachment post-'. get_the_ID() ); ?>>

  <h1 class="article-title"><?php the_title(); ?></h1>

  <?php lt3_include_post_meta(); ?>

  <figure>
    <figcaption><?php echo $post->post_content; ?></figcaption>
    <?php echo wp_get_attachment_image( $post->ID, 'full' ); ?>
  </figure>

  <footer class="article-footer"><?php lt3_back_to_parent_link(); ?></footer>

</article>

<?php endwhile; ?>